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
                                                <button onclick="updateUsers()" type="button" class="btn btn-info">
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
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    var pusher = new Pusher('c3f52ecef8384878cf2f', {
    cluster: 'ap1'
    });
    var channel = pusher.subscribe('admin');
    channel.bind('send-to-admin', function(data) {
        // console.log(data.message)
        var newChat = `
                    <div class="chat-left">
                        <div style="display : flex; flex-direction: column;width:100%">
                            <div  class="chat-text-left">
                                <div style="text-align : left">${data.message.message}    </div>
                            </div>
                            <div style="align-self: flex-start;" class="chat-time">${formatDate(data.message.created_at)}</div>    
                        </div>
                    </div>
        `;
        $('.chat-box').append(newChat)
        $('.chat-box').scrollTop($('.chat-box')[0].scrollHeight);
    });
</script>
<script>
    var id 
    function autoGrow(el) {
        el.style.height = 'auto'; // Reset height to auto to measure new content
        el.style.height = `${Math.min(Math.max(el.scrollHeight, 10), 150)}px`;
    }
    $('.person').on('click', function() {
        // Xóa class "active" khỏi tất cả các thẻ <li>
        $('.person').removeClass('active-user');

        // Thêm class "active" vào thẻ <li> được nhấn
        $(this).addClass('active-user');

        // Gọi hàm print() sau khi thẻ <li> được nhấn
        var userId = $(this).data('user-id');
        var userName = $(this).data('user-name');
        id = userId;
        getConversation(userId, userName)
    });

    function formatDate(dateUTC) {
        var date = new Date(dateUTC);
        var now = new Date(); // Lấy thời gian hiện tại

        var hours = date.getHours().toString().padStart(2, '0'); // Lấy giờ và thêm 0 nếu cần
        var minutes = date.getMinutes().toString().padStart(2, '0'); // Lấy phút và thêm 0 nếu cần
        var formattedTime = `${hours}:${minutes}`; // Format thành hh:mm

        // Kiểm tra xem có phải cùng năm hay không
        var sameYear = date.getFullYear() === now.getFullYear();
        // Kiểm tra xem có phải cùng tháng và cùng ngày hay không
        var sameMonthAndDay = date.getMonth() === now.getMonth() && date.getDate() === now.getDate();

        if (sameMonthAndDay) {
            // Nếu là cùng ngày, chỉ hiển thị giờ và phút
            return formattedTime;
        } else if (sameYear) {
            // Nếu là trong năm hiện tại, hiển thị giờ, phút, ngày và tháng
            var day = date.getDate().toString().padStart(2, '0'); // Lấy ngày
            var month = (date.getMonth() + 1).toString().padStart(2, '0'); // Lấy tháng (cần +1 vì getMonth() trả về 0-11)
            return `${formattedTime} ${day}/${month}`;
        } else {
            // Nếu là của năm trước, hiển thị giờ, phút, ngày, tháng và năm
            var day = date.getDate().toString().padStart(2, '0'); // Lấy ngày
            var month = (date.getMonth() + 1).toString().padStart(2, '0'); // Lấy tháng
            var year = date.getFullYear(); // Lấy năm
            return `${formattedTime} ${day}/${month}/${year}`;
        }
    }

    function getConversation(userId, userName) {
        $.ajax({
            url: '/admin/conversation'
            , type: 'GET'
            , data: {
                _token: "{{ csrf_token() }}"
                , 'user_id': userId
            }
            , success: function(response) {
                var conversation = `
                    <div class="selected-user">
                        <span>To: <span class="name">${userName}</span></span>
                    </div>
                    <div class="chat-container">
                        <ul class="chat-box chatContainerScroll">
                `
                if (response) {
                    response.forEach(function(item) {
                        if (item.sender_id == 0) {
                            // Tạo một thẻ HTML mới và chèn nội dung từ item
                            conversation += `
                            <div class="chat-right">
                                <div style="display : flex; flex-direction: column;width:100%">
                                    <div class="chat-text-right">
                                        <div style="text-align : left">${item.message}    </div>
                                    </div>
                                    <div style="align-self: flex-end;" class="chat-time">${formatDate(item.created_at)}</div>    
                                </div>
                            </div>
                        `;
                        } else {
                            // Tạo một thẻ HTML mới và chèn nội dung từ item
                            conversation += `
                                    <div class="chat-left">
                                        <div style="display : flex; flex-direction: column;width:100%">
                                            <div  class="chat-text-left">
                                                <div style="text-align : left">${item.message}    </div>
                                            </div>
                                            <div style="align-self: flex-start;" class="chat-time">${formatDate(item.created_at)}</div>    
                                        </div>
                                    </div>
    
                        `;
                        }
                    });
                }
                conversation += `
                                </ul>
                            <div class="form-group mt-3 mb-0">
                                <textarea id="message" oninput="autoGrow(this)" class="form-control" rows="3" placeholder="Type your message here..."></textarea>
                                <button onclick="sendMessage(${userId})">Send</button>
                            </div>
                            
                        </div>
                    `
                $('#conversation').html(conversation)
                $('.chat-box').scrollTop($('.chat-box')[0].scrollHeight);
            }
            , error: function(response) {
                console.log(response)
            }
        })
    }
    function sendMessage(userId){
        var message = $("#message").val().trim()
        $("#message").val('')
        $.ajax({
            url :'/admin/chat',
            type : "POST",
            data : {
                _token: "{{ csrf_token() }}"
                , 'user_id': userId,
                'message' : message
            },
            success : function(response){
                var newMessage = `
                    <div class="chat-right">
                        <div style="display : flex; flex-direction: column;width:100%">
                            <div class="chat-text-right">
                                <div style="text-align : left">${response.message.message}    </div>
                            </div>
                            <div style="align-self: flex-end;" class="chat-time">${formatDate(response.message.created_at)}</div>    
                        </div>
                    </div>
                `
                $('.chat-box').append(newMessage);
                $('.chat-box').scrollTop($('.chat-box')[0].scrollHeight);
                // Xóa class "active" khỏi tất cả các thẻ <li>
                $('.person').removeClass('active-user');
                $('.person[data-user-id="' + userId + '"]').addClass('active-user');
            },
            error : function(response){
                console.log(response)
            }
        })
    }
    function updateUsers(){
        $.ajax({
            url : '/admin/conversations',
            type : 'GET',
            success : function(response){
                // console.log(response)
                newUsers = ``
                response.customers.forEach(function(customer) {
                    newUsers += `
                        <li class="person" data-chat="person1" data-user-id="${customer.user_id}" data-user-name="${customer.name}">
                            <div class="user">
                                <img width="20px;" src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
                            </div>
                            <div class="user-message">
                                <div class="user-name">${customer.name}</div>
                                <div class="last-message">
                                    <div>
                                        <span style="opacity: 0.5;" class="text-muted">${customer.sender_name}</span>
                                        <span style="opacity: 0.5;" class="text-muted">${customer.message_nearest}</span>
                                    </div>
                                    <span class="last-time">${formatDate(customer.last_time)}</span>
                                </div>
                            </div>
                        </li>
                    `

                })
                $('.users').html(newUsers)
                // Xóa class "active" khỏi tất cả các thẻ <li>
                    $('.person').removeClass('active-user');
                $('.person[data-user-id="' + id + '"]').addClass('active-user');
            },
            error : function(response){
                console.log(response)
            }
        })
    }
</script>
</html>
