

<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap');

    .icon-chat {
        position: fixed;
        bottom: 100px;
        /* Khoảng cách từ dưới lên */
        right: 50px;
    }

    .box-chat {
        position: fixed;
        bottom: 100px;
        /* Khoảng cách từ dưới lên */
        right: 45px;
    }

    .card {
        width: 500px;
        border: none;
        border-radius: 15px;
        background-color: #cccccc;
        height: 500px;
        overflow: auto;
    }

    .adiv {
        background: #04CB28;
        border-radius: 15px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        font-size: 12px;
        height: 46px;
    }

    .chat {
        display: flex;
        flex-direction: column;
        border: none;
        background: #E2FFE8;
        font-size: 13px;
        border-radius: 10px;
        padding:4px 10px;
        max-width: 70%;
    }
    .chat > * {
        line-height: 1.5;
    }

    .content {
        overflow: auto; /* Cho phép cuộn */
        scrollbar-width: none; /* Ẩn thanh cuộn trên Firefox */
        -ms-overflow-style: none; /* Ẩn thanh cuộn trên Internet Explorer và Edge */
    }

    .content::-webkit-scrollbar {
        display: none; /* Ẩn thanh cuộn trên Chrome, Safari và Opera */
    }
    .d-flex{
        padding: 3px 0px;
    }
    .bg-white {
        border: 1px solid #E7E7E9;
        font-size: 13px;
        border-radius: 20px;
    }

    .myvideo img {
        border-radius: 20px
    }

    .dot {
        font-weight: bold;
    }

    .form-control-chat {
        border-radius: 12px;
        border: 1px solid #F0F0F0;
        font-size: 13px;
        height: 40px;
        margin-bottom: 20px;
        color: black;
        margin-top: 20px;
    }

    .form-control-chat:focus {
        box-shadow: none;
    }

    .form-control-chat::placeholder {
        font-size: 13px;
        color: #4f4f4f79;
    }

    .fas:hover {
        cursor: pointer;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        /* Đẩy phần tử con xuống dưới cùng */
        margin-top: auto;
        /* Tạo khoảng cách tự động để đẩy phần tử xuống dưới cùng */
        background-color: #e7e7e7;
    }

    .input-container {
        position: relative;
        /* Để định vị chính xác icon mũi tên */
        display: flex;
        /* Đặt các phần tử con nằm cạnh nhau */
    }

    .form-control-chat {
        width: 100%;
        /* Chiếm toàn bộ chiều rộng của container */
        padding-right: 40px;
        /* Khoảng trống bên phải để tránh văn bản bị che khuất */
        box-sizing: border-box;
        /* Đảm bảo padding không làm tăng kích thước thẻ */
    }

    .arrow-icon {
        position: absolute;
        /* Định vị icon mũi tên chính xác */
        right: 10px;
        /* Khoảng cách từ bên phải vào */
        top: 50%;
        /* Đặt vị trí icon ở giữa theo chiều dọc */
        transform: translateY(-50%);
        /* Căn giữa icon theo chiều dọc */
        color: #04CB28;
        /* Màu sắc của icon */
        font-size: 30px;
        /* Kích thước của icon */
        cursor: pointer;
        /* Hiệu ứng con trỏ chuột khi di chuột qua */
        z-index: 1;
        /* Đảm bảo icon nằm trên thẻ input */
    }
    .content {
        /* Tùy chỉnh nội dung bên trong .content */
        flex-grow: 1; /* Giúp phần này chiếm không gian còn lại nếu có */
        overflow: auto; /* Cuộn nếu nội dung quá dài */
    }
    .time ,.name{
        font-size: 10px;
        height: 10px;
        /* background-color: red */
    }
</style>
<div class="icon-chat"><button onclick="openBoxChat()">Icon chat</button></div>
<!-- resources/views/your-view.blade.php -->
<input type="hidden" id="user-id" value="{{ session('user_id') }}">

<div id="box-chat" class="box-chat" style="display: ;">
    <div class="container d-flex justify-content-center">
        <div class="card mt-5">
            <div class="d-flex flex-row justify-content-between p-3 adiv text-white">
                <i class="fas fa-chevron-left"></i>
                <span style="font-size: 22px;" class="pb-3">Live chat</span>
                <i onclick="closeBoxChat()" class="fas fa-times"></i>
            </div>
            <div class="content">
            </div>
            <div class="form-group px-3">
                <div class="input-container">
                    <input style="padding-left: 10px;" id="message" class="form-control-chat" placeholder="Type your message" onkeydown="if (event.key === 'Enter') sendMessage()">
                    <i onclick="sendMessage()" class="fa-solid fa-circle-arrow-right arrow-icon"></i>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    function formatTime(dateString) {
        // Tạo đối tượng Date từ chuỗi ngày giờ
        let date = new Date(dateString);

        // Lấy giờ và phút
        let hours = date.getHours().toString().padStart(2, '0');
        let minutes = date.getMinutes().toString().padStart(2, '0');

        // Trả về định dạng hh:mm
        return `${hours}:${minutes}`;
    }

    const userId = {{session('user_id')}}; // Thay bằng user ID của bạn

    // Pusher.logToConsole = true;

    var pusher = new Pusher('c3f52ecef8384878cf2f', {
        cluster: 'ap1',
        authEndpoint: `/broadcasting/auth`
    });
    var channel = pusher.subscribe('private-customer.' + userId);
    // console.log(channel)
    channel.bind('send-to-customer', function(data) {
        console.log(data.message);
        var newChat = `
                    <div class="d-flex flex-row ">
                        <img src="https://img.icons8.com/color/48/000000/circled-user-female-skin-type-7.png" width="40" height="40">
                        <div class="chat">
                            <div class="message-text">${data.message.message}</div>
                            <div class="time">${formatTime(data.message.created_at)}</div>
                        </div>
                    </div>
        `
        $('.content').append(newChat)
        $('.content').scrollTop($('.content')[0].scrollHeight);
    });


</script>
<script>
    function formatTime(dateString) {
        // Tạo đối tượng Date từ chuỗi ngày giờ
        let date = new Date(dateString);

        // Lấy giờ và phút
        let hours = date.getHours().toString().padStart(2, '0');
        let minutes = date.getMinutes().toString().padStart(2, '0');

        // Trả về định dạng hh:mm
        return `${hours}:${minutes}`;
    }

    $(document).ready(function(){
        $.ajax({
            url : '/buyer/chat',
            type : 'GET',
            success : function(response){
                response.forEach(function(item) {
                if(item.sender_id == 0){
                    // Tạo một thẻ HTML mới và chèn nội dung từ item
                    let newElement = `
                        <div class="d-flex flex-row ">
                            <img src="https://img.icons8.com/color/48/000000/circled-user-female-skin-type-7.png" width="40" height="40">
                            <div class="chat">
                                <div class="message-text">${item.message}</div>
                                <div class="time">${formatTime(item.created_at)}</div>
                            </div>
                        </div>
                        `;
                    // Thêm thẻ mới vào thẻ có class "content"
                    $('.content').append(newElement);
                }
                else{
                    // Tạo một thẻ HTML mới và chèn nội dung từ item
                    let newElement = `
                        <div style="display : flex; justify-content: flex-end;" class="d-flex flex-row ">
                            <div class="chat" class="bg-white">
                                <div class="message-text">${item.message}</div>
                                <div class="time">${formatTime(item.created_at)}</div>    
                            </div>
                            <img src="https://img.icons8.com/color/48/000000/circled-user-male-skin-type-7.png" width="40" height="40">
                        </div>
                        `;
                    // Thêm thẻ mới vào thẻ có class "content"
                    $('.content').append(newElement);
                }
                
            });
            $('.content').scrollTop($('.content')[0].scrollHeight);

            },
            error : function(response){
                console.log(response)
            }
        })
    })
    function openBoxChat() {
        $('#box-chat').show()
        $('.content').scrollTop($('.content')[0].scrollHeight);
    }

    function closeBoxChat() {
        $('#box-chat').hide()
    }
    function sendMessage(){
        var message = $('#message').val().trim()
        $('#message').val('');
        if(!message){
            return;
        }
        $.ajax({
            url : '/buyer/chat',
            type : 'POST',
            data : {
                _token: "{{ csrf_token() }}",
                'message' : message
            },
            success : function(response){
                // Tạo một thẻ HTML mới và chèn nội dung từ item
                let newElement = `
                        <div style="display : flex; justify-content: flex-end;" class="d-flex flex-row ">
                            <div class="chat" class="bg-white">
                                <div class="message-text">${response.message.message}</div>
                                <div class="time">${formatTime(response.message.created_at)}</div>    
                            </div>
                            <img src="https://img.icons8.com/color/48/000000/circled-user-male-skin-type-7.png" width="40" height="40">
                        </div>
                        `;
                    // Thêm thẻ mới vào thẻ có class "content"
                $('.content').append(newElement);
                $('.content').scrollTop($('.content')[0].scrollHeight);
            },
            error : function(response){
                console.log(response)
            }
        })
    }
</script>
