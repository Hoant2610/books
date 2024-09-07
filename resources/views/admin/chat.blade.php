<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin-chat.css') }}">
    <title>Document</title>
</head>
<body>
    <div>
        @include('admin.component.slidebar')
    </div>
    <div class="container-1">
        <!-- Page header end -->
        <div style="height: 15px;"></div>
        <span>Chat</span>
        <!-- Content wrapper start -->
        <div class="content-wrapper">

            <!-- Row start -->
            <div class="row gutters">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="card m-0">

                        <!-- Row start -->
                        <div class="row no-gutters">
                            <div style="padding: 0px;" class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-3">
                                <div class="users-container">
                                    <div class="chat-search-box">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-info">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="users">
                                        @foreach($customers as $customer)
                                        <li class="person" data-chat="person1" data-user-id="{{$customer->getUserId()}}" data-user-name="{{$customer->getName()}}">
                                            <div class="user">
                                                <img width="20px;" src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
                                            </div>
                                            <div class="user-message">
                                                <div class="user-name">{{$customer->getName()}}</div>
                                                <div class="last-message">
                                                    <div>
                                                        <span style="opacity: 0.5;" class="text-muted">{{$customer->getSenderName()}}</span>
                                                        <span style="opacity: 0.5;" class="text-muted">{{$customer->getMessageNearest()}}</span>
                                                    </div>
                                                    <span class="last-time">{{$customer->getLastTimeString()}}</span>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div style="background-color: rgb(220, 220, 220);" class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-9">
                                <div id="conversation" class="conversation">
                                </div>
                            </div>
                        </div>
                        <!-- Row end -->
                    </div>

                </div>

            </div>
            <!-- Row end -->

        </div>
        <!-- Content wrapper end -->

    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    function autoGrow(el) {
        el.style.height = 'auto'; // Reset height to auto to measure new content
        el.style.height = `${Math.min(Math.max(el.scrollHeight, 50), 150)}px`;
    }
    $('.person').on('click', function() {
        // Xóa class "active" khỏi tất cả các thẻ <li>
        $('.person').removeClass('active-user');

        // Thêm class "active" vào thẻ <li> được nhấn
        $(this).addClass('active-user');

        // Gọi hàm print() sau khi thẻ <li> được nhấn
        var userId = $(this).data('user-id');
        var userName = $(this).data('user-name');
        getConversation(userId,userName)
    });

    function getConversation(userId,userName) {
        $.ajax({
            url: '/admin/conversation'
            , type: 'GET'
            , data: {
                _token: "{{ csrf_token() }}"
                , 'user_id': userId
            }
            , success: function(response) {
                console.log(response)
                var conversation = `
                    <div class="selected-user">
                        <span>To: <span class="name">${userName}</span></span>
                    </div>
                    <div class="chat-container">
                        <ul class="chat-box chatContainerScroll">
                `
                if(response){
                    response.forEach(function(item) {
                    if (item.sender_id == 0) {
                        // Tạo một thẻ HTML mới và chèn nội dung từ item
                        conversation += `
                            <div class="chat-left">
                                <div class="chat-text">
                                    ${item.message}    
                                </div>
                            </div>
                        `;
                    } else {
                        // Tạo một thẻ HTML mới và chèn nội dung từ item
                        conversation += `
                                    <div class="chat-right">
                                        <div class="chat-text">
                                            ${item.message}    
                                        </div>
                                    </div>
    
                        `;
                    }
                });
                }
                conversation += `
                                </ul>
                            <div class="form-group mt-3 mb-0">
                                <textarea oninput="autoGrow(this)" class="form-control" rows="3" placeholder="Type your message here..."></textarea>
                            </div>
                        </div>
                    `
                $('#conversation').html(conversation)
            }
            , error: function(response) {
                console.log(response)
            }
        })
    }

</script>
</html>
