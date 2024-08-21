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
    <link href="{{ asset('css/customer-book.css') }}" rel="stylesheet">
    <title>Book shop</title>
</head>

<body>
    @include('customer.navbar')
    <div style="margin-top : 20px;"></div>
    <div class="container book-container">
        <div class="filter-box">
            Filter
        </div>
        <div class="book-box">
            <div class="search-box">
                @include('customer.component.search-book')
            </div>
            <div class="book-list">
                @foreach($bookDTOs as $bookDTO)
                <div class="book-item">
                    <a href="/buyer/books/{{$bookDTO->getBook()->slug}}"><img width="100px" height="100px" src="{{asset($bookDTO->getBook()->thumbnail)}}" alt="Sản phẩm 1"></a>
                    <div style="color: rgb(0, 0, 0)">{{$bookDTO->getBook()->name}}</div>
                    <div class="book-author">
                        <label>Author : </label>
                        <span>{{$bookDTO->getBook()->author}}</span>
                        <div class="book-price">
                            <div class="book-sale_price">
                                <p>{{ number_format($bookDTO->getBook()->sale_price, 0, ',', '.') }} đ</p>
                            </div>
                            <div class="book-original_price">
                                <s>
                                    <p>{{ number_format($bookDTO->getBook()->original_price, 0, ',', '.') }} đ</p>
                                </s>
                            </div>
                        </div>
                        <div class="book-performance">
                            <div class="book-star">
                                @for($i=0;$i<$bookDTO->getStar();$i++)
                                    <i class="fa-solid fa-star" style="color: #f7f145;"></i>
                                @endfor
                            </div>
                            <div class="book-sold">
                                <label>Sold : </label>
                                <span>{{$bookDTO->getSold()}}</span>
                            </div>
                        </div><br>
                    </div>
                    <button>Buy now</button>
                </div>
                @endforeach
            </div>
            {{$bookDTOs->links()}}
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
    function addToCart() {

    }

</script>
</html>
