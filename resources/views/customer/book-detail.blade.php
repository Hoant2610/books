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
    <link href="{{ asset('css/customer-book-detail.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <title>Book shop</title>
</head>

<body>
    @include('customer.navbar')
    <div style="margin-top : 20px;"></div>
    <div class="container book-container">
        <div class="book-box">
            <div class="search-box">
                @include('customer.component.search-book')
            </div>
            <div class="book-item">
                <img width="200px" height="200px" src="{{asset($bookDTO->getBook()->thumbnail)}}" alt="Sản phẩm 1">
                <div style="color: rgb(0, 0, 0)">{{$bookDTO->getBook()->name}}</div>
                <div class="book-author">
                    <label>Author : </label>
                    <span>{{$bookDTO->getBook()->author}}</span>
                </div>
                <div class="book-description">
                    <label>Description : </label>
                    <span>{!!$bookDTO->getBook()->description!!}</span>
                </div>
                <div class="book-price">
                    <div class="book-sale_price">
                        <label>Sale price : </label>
                        <span>{{ number_format($bookDTO->getBook()->sale_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="book-original_price">
                        <label>Original price : </label>
                        <s>
                            <span>{{ number_format($bookDTO->getBook()->original_price, 0, ',', '.') }}</span>
                        </s>
                    </div>
                </div>
                <div class="inventory">
                    <label>Inventory : </label>
                    <span>{{$bookDTO->getBook()->quantity}}</span>
                </div>

            </div>
            <div class="quantity">
                <label>Quantity : </label>
                <input type="number" id="quantity" value="1" required>
            </div>
            <button>Buy now</button>
            <button onclick="addToCart()">Add to cart</button>
        </div>

    </div>
    @include('home.footer')

    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/tiny-slider.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>

<script>
    toastr.options = {
        "timeOut": "500",
        }
    $(document).ready(function() {
        $('#quantity').on('input', function() {
            var value = $(this).val();
            if (value > {{$bookDTO->getBook()-> quantity}}) {
                $(this).val({{$bookDTO->getBook()-> quantity}});
            }
        });
    });

    function addToCart() {
        if ($('#quantity').val() == '') {
            toastr.warning("Enter quantity");
        }
        req = {
            _token: "{{ csrf_token() }}"
            , book_id: {{$bookDTO->getBook()-> id}}
            , quantity: $('#quantity').val()
        }
        $.ajax({
            url: '/cart'
            , type: 'POST'
            , data: req
            , success: function(response) {
                if(response.message == 'successfully'){
                    toastr.success('Product added to cart successfully')
                }
                else{
                    alert(response.message);
                }
            }
            , error: function(response) {
                console.log(response)
            }
        })
    }

</script>
</html>
