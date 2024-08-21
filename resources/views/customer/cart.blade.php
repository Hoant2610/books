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
    <link href="{{ asset('css/customer-cart.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <title>Book shop</title>
</head>

<body>
    @include('customer.navbar')
    <div style="margin-top : 20px;"></div>
    <div class="container">
        <h1>Cart</h1>
        @if (is_array($bookCartDTO) && count($bookCartDTO) != 0)
        Total products : {{ count($bookCartDTO) }}
        Total quantities : {{ count($bookCartDTO) }}<br><br>
        @foreach($bookCartDTO as $item)
            <div class="item">
                <input type="checkbox" class="item-checkbox" data-sale_price="{{$item->getBook()->sale_price}}" data-id="{{$item->getBook()->id}}" data-quantity="{{$item->getQuantity()}}">
                <div class="book-info1">
                    <a href="/buyer/books/{{$item->getBook()->slug}}"><img width="100px" src="{{asset($item->getBook()->thumbnail)}}" alt="Sản phẩm 1"></a>
                </div>
                <div class="book-info2">
                    <label>Name : </label>
                    <a href="/buyer/books/{{$item->getBook()->slug}}"><span>{{$item->getBook()->name}}</span></a><br>
                    <label>Category : </label>
                    <span>{{$item->getBook()->category->name}}</span><br>
                    <label>Price : </label>
                    <span id="book_{{$item->getBook()->id}}_sale_price">{{ number_format($item->getBook()->sale_price, 0, ',', '.') }} ₫ </span><br>
                </div>
                <div class="book-info3">
                    <label>Quantity : </label>
                    <button onclick="decreaseQuantity({{$item->getBook()->id}})">-</button>
                    <span id="book_{{$item->getBook()->id}}_quantity">{{$item->getQuantity()}}</span>
                    <button onclick="increaseQuantity({{$item->getBook()->id}})">+</button><br>
                </div>
                <div class="total-price">
                    <label>Total price : </label>
                    <span id="total_price_{{$item->getBook()->id}}">{{ number_format($item->getQuantity() * $item->getBook()->sale_price, 0, ',', '.') }} ₫ </span><br>
                </div>
            </div>
        <hr>
        @endforeach
        <div class="">
            <label>Voucher : </label>
            <input id=voucher>
            <button>Check</button>
        </div>
        <div class="total-payment">
            <label>Total payment : </label>
            <span id=total-payment>0 ₫</span>
        </div>
            <button onclick="checkout()">Checkout</button>
        @elseif ($bookCartDTO instanceof \Illuminate\Support\Collection)
        {{ $bookCartDTO->count() }}
        @else
            <p>Nothing in your cart...</p>
            <a href="/buyer/books">Back to shop</a>
        @endif

    </div>
    @include('home.footer')

    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/tiny-slider.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
<script>
    $(document).ready(function() {
    // Khi checkbox được click
    $('.item-checkbox').on('click', function() {
        updateTotalPayment();
    });

    function updateTotalPayment() {
        let total = 0;
        // Lặp qua tất cả các checkbox và tính tổng giá trị nếu checkbox được chọn
        $('.item-checkbox:checked').each(function() {
                let book_id = $(this).data('id');
                var book_quantity = parseFloat($('#book_'+book_id+'_quantity').text())
                var book_sale_price = parseFloat($('#book_'+book_id+'_sale_price').text().replace(/[.,\s]/g, ''))
                total += book_quantity * book_sale_price;
            });
        // Định dạng giá trị tiền tệ
        let formattedTotal = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total);
        // Hiển thị tổng giá trị trong phần tử với id="total-payment"
        $('#total-payment').text(formattedTotal);
        }
    });

    function increaseQuantity(book_id){
        $.ajax({
            url: '/cart/increase', 
            type: 'PUT'
            , contentType: 'application/json'
            , data: JSON.stringify({_token: "{{ csrf_token() }}",book_id : book_id})
            , success: function(response) {
                if(response.message == 'successfully'){
                    var book_sale_price = parseFloat($('#book_'+book_id+'_sale_price').text().replace(/[.,\s]/g, ''))
                    var book_quantity = parseFloat($('#book_'+book_id+'_quantity').text()) + 1
                    $('#book_'+book_id+'_quantity').text(book_quantity)
                    var formattedTotal = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(book_quantity * book_sale_price);
                    $('#total_price_' + book_id ).text(formattedTotal)
                }
                else{
                    toastr.warning(response.message)
                }
            }
            , error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
    
    function decreaseQuantity(book_id){
        if($('#book_'+book_id+'_quantity').text() == 1){
            if (confirm('Are you sure you want to remove it?')) {
                $.ajax({
                url: '/cart/decrease', 
                type: 'PUT'
                , contentType: 'application/json'
                , data: JSON.stringify({_token: "{{ csrf_token() }}",book_id : book_id})
                , success: function(response) {
                    location.reload()
                }
                , error: function(xhr, status, error) {
                    console.error(error);
                }
            });
            }
        }
        else{
            $.ajax({
                url: '/cart/decrease', 
                type: 'PUT'
                , contentType: 'application/json'
                , data: JSON.stringify({_token: "{{ csrf_token() }}",book_id : book_id})
                , success: function(response) {
                    if(response.message == 'successfully'){
                        var book_sale_price = parseFloat($('#book_'+book_id+'_sale_price').text().replace(/[.,\s]/g, ''))
                        var book_quantity = parseFloat($('#book_'+book_id+'_quantity').text()) - 1
                        $('#book_'+book_id+'_quantity').text(book_quantity)
                        var formattedTotal = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(book_quantity * book_sale_price);
                        $('#total_price_' + book_id ).text(formattedTotal)
                    }
                }
                , error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
        
    }
    function checkout() {
        var selectedItems = [];
        $('.item-checkbox:checked').each(function() {
            var item = {
                book_id: $(this).data('id')
                , quantity: $(this).data('quantity')
            };
            selectedItems.push(item);
        });
        if (selectedItems == '') {
            toastr.warning("You have not selected any items for checkout")
            return
        }
        $.ajax({
            url: '/checkout', // Thay thế bằng URL API của bạn
            type: 'POST'
            , contentType: 'application/json'
            , data: JSON.stringify(selectedItems),
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
            , success: function(response) {
                window.location.href = "/checkout";
            }
            , error: function(xhr, status, error) {
            }
        });
    }
</script>
</html>
