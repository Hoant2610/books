<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <!-- Bootstrap CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{asset('css/tiny-slider.css')}}" rel="stylesheet">
    <link href="{{ asset('css/customer-order.css') }}" rel="stylesheet">
    <title>Book shop</title>
</head>

<body>
    @include('customer.navbar')
    <div style="margin-top : 20px;"></div>
    <div class="container">
        <h1>Orders</h1>
        <div class="container-box">
            <div class="customer-info">
                <div class="customer-account">
                    <div class="customer-icon">
                        <i class="fa-solid fa-user" style="color: #8AC6A6;font-size: 40px;"></i>
                    </div>
                    <div class="customer-email">
                        {{$email}}
                    </div>
                    <button>Edit profile</button>
                </div>
                <hr>
                <div class="customer-link">
                    <a href="/vourchers">Voucher</a><br>
                    <a href="/vourchers">Voucher</a><br>
                    <a href="/vourchers">Voucher</a>
                </div>
                <hr>
            </div>
            <div class="order-list">
                <!-- Tabs cho các mục đơn hàng -->
                <div class="tabs">
                    <div class="tab active" data-tab="all">All</div>
                    <div class="tab" onclick="showOrderByStatus()" data-tab="waiting-for-confirmation">To Pay</div>
                    <div class="tab" data-tab="waiting-for-delivery">To Ship</div>
                    <div class="tab" data-tab="delivered">To Receive</div>
                    <div class="tab" data-tab="completed">Completed</div>
                    <div class="tab" data-tab="returned">Return Refund</div>
                    <div class="tab" data-tab="cancelled">Canceled</div>
                </div>

                <!-- Phần All -->
                <div class="order-section active" id="all">
                    <ul class="order-list">
                        @if($orders->count() == 0)
                        <p style="padding: 20px">No order...</p>
                        @endif
                        @foreach($orders as $order)
                        @foreach($order->order_details as $order_detail)
                        <li>
                            <div class="book-info">
                                <div class="book-image">
                                    <img width="125px" src="{{asset($order_detail->book->thumbnail)}}">
                                </div>
                                <div class="book-info-detail">
                                    <div class="book-name">
                                        {{$order_detail->book->name}}
                                    </div>
                                    <div class="book-category">
                                        <label>Category : </label>
                                        <span>{{$order_detail->book->category->name}}</span>
                                    </div>
                                    <div class="book-price">
                                        <span>Price : </span>
                                        <span><b>{{number_format($order_detail->current_sale_price, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                        <span style="opacity: 0.5;"><s>{{number_format($order_detail->current_original_price, 0, ',', '.')}}</s> ₫</span>
                                    </div>
                                </div>
                                <div class="book-quantity">
                                    x{{$order_detail->quantity}}
                                </div>
                                <div class="order-status">
                                    <label>Status : </label>
                                    <span>{{$order->status}}</span>
                                </div>
                            </div>
                            <div class="order-detail">
                                <div class="order-time">
                                    <label>Order placed : </label>
                                    <span>{{$order_detail->created_at->format('d-m-Y H:i:s')}}</span>
                                </div>
                                <div class="totalPrice">
                                    <label>Order Total : </label>
                                    <span><b>{{number_format($order_detail->current_sale_price * $order_detail->quantity, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
                        </li>
                        @endforeach
                        @endforeach
                    </ul>
                </div>

                <!-- Phần Chờ xác nhận -->
                <div class="order-section" id="waiting-for-confirmation">
                    <ul class="order-list wait-confirm">
                        @foreach($orders as $order)
                        <div class="order-details">
                            @foreach($order->order_details as $order_detail)
                            @if($order_detail->status == 1)
                            <li>
                                <div class="book-info">
                                    <div class="book-image">
                                        <img width="125px" src="{{asset($order_detail->book->thumbnail)}}">
                                    </div>
                                    <div class="book-info-detail">
                                        <div class="book-name">
                                            {{$order_detail->book->name}}
                                        </div>
                                        <div class="book-category">
                                            <label>Category : </label>
                                            <span>{{$order_detail->book->category->name}}</span>
                                        </div>
                                        <div class="book-price">
                                            <span>Price : </span>
                                            <span><b>{{number_format($order_detail->current_sale_price, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                            <span style="opacity: 0.5;"><s>{{number_format($order_detail->current_original_price, 0, ',', '.')}}</s> ₫</span>
                                        </div>
                                    </div>
                                    <div class="book-quantity">
                                        x{{$order_detail->quantity}}
                                    </div>
                                    <div class="order-status">
                                        <label>Status : </label>
                                        <span>{{$order_detail->status}}</span>
                                    </div>        
                                </div>

                                <div style="display: flex;justify-content : space-between">
                                    <div class="order-detail">
                                        <div class="order-time">
                                            <label>Order placed : </label>
                                            <span>{{$order_detail->created_at->format('d-m-Y H:i:s')}}</span>
                                        </div>
                                        <div class="totalPrice">
                                            <label>Order Total : </label>
                                            <span><b>{{number_format($order_detail->current_sale_price * $order_detail->quantity, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </div>
                                    <div class="cancel">
                                        <button onclick="cancelOrder({{$order_detail->id}})">Cancel</button>
                                    </div>
                                </div>
                                
                            </li>
                            @endif
                            @endforeach
                        </div>
                        @endforeach
                    </ul>
                </div>

                <!-- Phần Chờ giao hàng -->
                <div class="order-section" id="waiting-for-delivery">
                    <ul class="order-list">
                        @foreach($orders as $order)
                        @foreach($order->order_details as $order_detail)
                        @if($order_detail->status == 2)
                        <li>
                            <div class="book-info">
                                <div class="book-image">
                                    <img width="125px" src="{{asset($order_detail->book->thumbnail)}}">
                                </div>
                                <div class="book-info-detail">
                                    <div class="book-name">
                                        {{$order_detail->book->name}}
                                    </div>
                                    <div class="book-category">
                                        <label>Category : </label>
                                        <span>{{$order_detail->book->category->name}}</span>
                                    </div>
                                    <div class="book-price">
                                        <span>Price : </span>
                                        <span><b>{{number_format($order_detail->current_sale_price, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                        <span style="opacity: 0.5;"><s>{{number_format($order_detail->current_original_price, 0, ',', '.')}}</s> ₫</span>
                                    </div>
                                </div>
                                <div class="book-quantity">
                                    x{{$order_detail->quantity}}
                                </div>
                                <div class="order-status">
                                    <label>Status : </label>
                                    <span>{{$order_detail->status}}</span>
                                </div>
                            </div>
                            <div class="order-detail">
                                <div class="order-time">
                                    <label>Order placed : </label>
                                    <span>{{$order_detail->created_at->format('d-m-Y H:i:s')}}</span>
                                </div>
                                <div class="totalPrice">
                                    <label>Order Total : </label>
                                    <span><b>{{number_format($order_detail->current_sale_price * $order_detail->quantity, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
                        </li>
                        @endif
                        @endforeach
                        @endforeach
                    </ul>
                </div>

                <!-- Phần Đã nhận -->
                <div class="order-section" id="delivered">
                    <ul class="order-list">
                        @foreach($orders as $order)
                        @foreach($order->order_details as $order_detail)
                        @if($order_detail->status == 3)
                        <li>
                            <div class="book-info">
                                <div class="book-image">
                                    <img width="125px" src="{{asset($order_detail->book->thumbnail)}}">
                                </div>
                                <div class="book-info-detail">
                                    <div class="book-name">
                                        {{$order_detail->book->name}}
                                    </div>
                                    <div class="book-category">
                                        <label>Category : </label>
                                        <span>{{$order_detail->book->category->name}}</span>
                                    </div>
                                    <div class="book-price">
                                        <span>Price : </span>
                                        <span><b>{{number_format($order_detail->current_sale_price, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                        <span style="opacity: 0.5;"><s>{{number_format($order_detail->current_original_price, 0, ',', '.')}}</s> ₫</span>
                                    </div>
                                </div>
                                <div class="book-quantity">
                                    x{{$order_detail->quantity}}
                                </div>
                                <div class="order-status">
                                    <label>Status : </label>
                                    <span>{{$order_detail->status}}</span>
                                </div>
                            </div>
                            <div class="order-detail">
                                <div class="order-time">
                                    <label>Order placed : </label>
                                    <span>{{$order_detail->created_at->format('d-m-Y H:i:s')}}</span>
                                </div>
                                <div class="totalPrice">
                                    <label>Order Total : </label>
                                    <span><b>{{number_format($order_detail->current_sale_price * $order_detail->quantity, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
                        </li>
                        @endif
                        @endforeach
                        @endforeach
                    </ul>
                </div>

                <!-- Phần Đã giao xong -->
                <div class="order-section" id="completed">
                    <ul class="order-list">
                        @foreach($orders as $order)
                        @foreach($order->order_details as $order_detail)
                        @if($order_detail->status == 4)
                        <li>
                            <div class="book-info">
                                <div class="book-image">
                                    <img width="125px" src="{{asset($order_detail->book->thumbnail)}}">
                                </div>
                                <div class="book-info-detail">
                                    <div class="book-name">
                                        {{$order_detail->book->name}}
                                    </div>
                                    <div class="book-category">
                                        <label>Category : </label>
                                        <span>{{$order_detail->book->category->name}}</span>
                                    </div>
                                    <div class="book-price">
                                        <span>Price : </span>
                                        <span><b>{{number_format($order_detail->current_sale_price, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                        <span style="opacity: 0.5;"><s>{{number_format($order_detail->current_original_price, 0, ',', '.')}}</s> ₫</span>
                                    </div>
                                </div>
                                <div class="book-quantity">
                                    x{{$order_detail->quantity}}
                                </div>
                                <div class="order-status">
                                    <label>Status : </label>
                                    <span>{{$order_detail->status}}</span>
                                </div>
                            </div>
                            <div class="order-detail">
                                <div class="order-time">
                                    <label>Order placed : </label>
                                    <span>{{$order_detail->created_at->format('d-m-Y H:i:s')}}</span>
                                </div>
                                <div class="totalPrice">
                                    <label>Order Total : </label>
                                    <span><b>{{number_format($order_detail->current_sale_price * $order_detail->quantity, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
                        </li>
                        @endif
                        @endforeach
                        @endforeach
                    </ul>
                </div>

                <!-- Phần Trả hàng -->
                <div class="order-section" id="returned">
                    <ul class="order-list">
                        @foreach($orders as $order)
                        @foreach($order->order_details as $order_detail)
                        @if($order_detail->status == 5)
                        <li>
                            <div class="book-info">
                                <div class="book-image">
                                    <img width="125px" src="{{asset($order_detail->book->thumbnail)}}">
                                </div>
                                <div class="book-info-detail">
                                    <div class="book-name">
                                        {{$order_detail->book->name}}
                                    </div>
                                    <div class="book-category">
                                        <label>Category : </label>
                                        <span>{{$order_detail->book->category->name}}</span>
                                    </div>
                                    <div class="book-price">
                                        <span>Price : </span>
                                        <span><b>{{number_format($order_detail->current_sale_price, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                        <span style="opacity: 0.5;"><s>{{number_format($order_detail->current_original_price, 0, ',', '.')}}</s> ₫</span>
                                    </div>
                                </div>
                                <div class="book-quantity">
                                    x{{$order_detail->quantity}}
                                </div>
                                <div class="order-status">
                                    <label>Status : </label>
                                    <span>{{$order_detail->status}}</span>
                                </div>
                            </div>
                            <div class="order-detail">
                                <div class="order-time">
                                    <label>Order placed : </label>
                                    <span>{{$order_detail->created_at->format('d-m-Y H:i:s')}}</span>
                                </div>
                                <div class="totalPrice">
                                    <label>Order Total : </label>
                                    <span><b>{{number_format($order_detail->current_sale_price * $order_detail->quantity, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
                        </li>
                        @endif
                        @endforeach
                        @endforeach
                    </ul>
                </div>

                <!-- Phần Đã hủy -->
                <div class="order-section" id="cancelled">
                    <ul class="order-list">
                        @foreach($orders as $order)
                        @foreach($order->order_details as $order_detail)
                        @if($order_detail->status == 6)
                        <li>
                            <div class="book-info">
                                <div class="book-image">
                                    <img width="125px" src="{{asset($order_detail->book->thumbnail)}}">
                                </div>
                                <div class="book-info-detail">
                                    <div class="book-name">
                                        {{$order_detail->book->name}}
                                    </div>
                                    <div class="book-category">
                                        <label>Category : </label>
                                        <span>{{$order_detail->book->category->name}}</span>
                                    </div>
                                    <div class="book-price">
                                        <span>Price : </span>
                                        <span><b>{{number_format($order_detail->current_sale_price, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                        <span style="opacity: 0.5;"><s>{{number_format($order_detail->current_original_price, 0, ',', '.')}}</s> ₫</span>
                                    </div>
                                </div>
                                <div class="book-quantity">
                                    x{{$order_detail->quantity}}
                                </div>
                                <div class="order-status">
                                    <label>Status : </label>
                                    <span>{{$order_detail->status}}</span>
                                </div>
                            </div>
                            <div class="order-detail">
                                <div class="order-time">
                                    <label>Order placed : </label>
                                    <span>{{$order_detail->created_at->format('d-m-Y H:i:s')}}</span>
                                </div>
                                <div class="totalPrice">
                                    <label>Order Total : </label>
                                    <span><b>{{number_format($order_detail->current_sale_price * $order_detail->quantity, 0, ',', '.')}} ₫</b></span>&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
                        </li>
                        @endif
                        @endforeach
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('home.footer')

    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/tiny-slider.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/format.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
<script>
    // Lấy tất cả các tab và phần nội dung đơn hàng
    const tabs = document.querySelectorAll('.tab');
    const orderSections = document.querySelectorAll('.order-section');

    // Thêm sự kiện click cho mỗi tab
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Xóa lớp active của tất cả các tab và phần nội dung
            tabs.forEach(t => t.classList.remove('active'));
            orderSections.forEach(section => section.classList.remove('active'));

            // Thêm lớp active cho tab hiện tại và phần nội dung tương ứng
            tab.classList.add('active');
            const activeSection = document.getElementById(tab.getAttribute('data-tab'));
            activeSection.classList.add('active');
        });
    });

    function showOrderByStatus() {
        var orders = @json($orders);
        console.log(orders)
    }

    function cancelOrder(order_detail_id){
        
    }

</script>
</html>
