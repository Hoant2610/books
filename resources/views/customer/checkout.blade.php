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
    <link href="{{ asset('css/customer-checkout.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <title>Checkout</title>
</head>

<body>
    @include('customer.navbar')
    <div style="margin-top : 20px;"></div>
    <div class="container">
        <h1>Checkout</h1><hr>
        @empty($bookCheckoutDTO)
            <span>No thing to checkout</span>
        @else
            <div class="customer-info">
                <div class="user-name">
                    <span>{{$bookCheckoutDTO->getUser()->name}}</span>
                </div>
                <div class="user-phone">
                    {{-- <span>{{$bookCheckoutDTO->getUser()->phone}}</span> --}}
                    <input id="user-phone" value="{{$bookCheckoutDTO->getUser()->phone}}">
                </div>
                @if($bookCheckoutDTO->getAddressDefault()->exists)
                <div class="address-current">
                    <div class="address-selected">
                        <span>{{$bookCheckoutDTO->getAddressDefault()->city}}</span>, 
                        <span>{{$bookCheckoutDTO->getAddressDefault()->district}}</span>, 
                        <span>{{$bookCheckoutDTO->getAddressDefault()->ward}}</span><br>
                        <span>Detail : </span>
                        <span>{{$bookCheckoutDTO->getAddressDefault()->detail}}</span>
                    </div>
                    <div class="address-box">
                        <div class="address-list">
                            @foreach($bookCheckoutDTO->getUser()->addresses as $address)
                                <input type="radio" name="address_id" value="{{$address->id}}" @if($address->default == 1) class="default-address" checked @endif>
                                <span>{{$address->city}}</span>, 
                                <span>{{$address->district}}</span>, 
                                <span>{{$address->ward}}</span>
                                @if($address->default == 1) 
                                    <span style="color: red">(Default)</span>
                                @endif
                                <br>
                                <span>Detail : </span>
                                <span>{{$address->detail}}</span>
                                @if(!$address->detail)
                                    <span>(none)</span>
                                @endif
                                <button>Edit</button>
                                <hr>
                            @endforeach
                            <button onclick="closeAddressBox()">Cancel</button>
                            <button onclick="confirmAddress()">Confirm</button>
                        </div>
                        {{-- <div class="btn-address">
                            <button onclick="closeAddressBox()">Cancel</button>
                            <button onclick="confirmAddress()">Confirm</button>
                        </div> --}}
                    </div>
                </div>
                <button onclick="openAddressBox()">Change</button>
                @else
                <p>No address found.</p>
                <button>Add new address</button>
                @endif
            </div><hr>
            <div class="books">
                @foreach($bookCheckoutDTO->getBookCartDTOs() as $item)
                    <div class="item">
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
                            <span id="book_{{$item->getBook()->id}}_quantity">{{$item->getQuantity()}}</span><br>
                        </div>
                        <div class="total-price">
                            <label>Total price : </label>
                            <span id="total_price_{{$item->getBook()->id}}">{{ number_format($item->getQuantity() * $item->getBook()->sale_price, 0, ',', '.') }} ₫ </span><br>
                        </div>
                    </div><hr>
                @endforeach
            </div>
        @endempty
        <div class="shipment">
            <label>Shipping option : </label>
            <label>
                <input type="radio" name="ship" value="Fast" checked>
                Nhanh
            </label>
            <label>
                <input type="radio" name="ship" value="Saver">
                Tiết kiệm
            </label>
            <label>
                <input type="radio" name="ship" value="Express">
                Hỏa tốc
            </label><br>
        </div>
        <div class="payment">
            <label>Payment option : </label>
            <label>
                <input type="radio" name="payment" value="Cash on delivery" checked>
                Cash on delivery
            </label>
            <label>
                <input type="radio" name="payment" value="Credit Cart">
                Credit Cart
            </label>
            <label>
                <input type="radio" name="payment" value="Banking">
                Banking
            </label><br>
        </div>

        <div class="voucher">
            <label>Voucher </label>
            <input type="text" placeholder="Enter code...">
            <button>Apply</button>
        </div>
        <div class="summary">
            <div class="merchandise-subtotal">
                <label>Merchandise Subtotal : </label>
                @empty($bookCheckoutDTO)
                <span></span>
                @else
                <span>{{ number_format($bookCheckoutDTO->getTotalPrice(), 0, ',', '.') }} ₫ </span>
                @endempty
            </div>
            <div class="shipping-total">
                <label>Shipping Total : </label>
                <span>100000</span>
            </div>
            <div class="total-payment">
                <label>Total Payment : </label>
                <span>0 ₫</span>
            </div>
            <div class="note">
                <label>Note : </label>
                <input id="note">
            </div>
        </div><br>
        <button onclick="placeOrder()">Place Order</button>
    </div>
    
    @include('home.footer')
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/tiny-slider.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
<script>
    var address_id_selected = $('input.default-address').val();
    var shipment;
    var payment;
    var phone;
    var note;
    var defaultAddressValue = $('input.default-address').val();
    function openAddressBox(){
        $('.address-box').show();
    }
    function closeAddressBox(){
        $('input[name="address_id"]').prop('checked', false); // Bỏ chọn tất cả các radio buttons
        if (defaultAddressValue) {
            $('input[name="address_id"][value="' + defaultAddressValue + '"]').prop('checked', true); // Chọn lại radio button mặc định
        }
        $('.address-box').hide();
    }
    function confirmAddress(){
        address_id_selected = $('input[name="address_id"]:checked').val() 
        defaultAddressValue = address_id_selected
        $('input[name="address_id"][value="' + address_id_selected + '"]').prop('checked', true);
        $('.address-box').hide(); 
    }
    function placeOrder(){
        shipment = $('input[name="ship"]:checked').val();
        payment = $('input[name="payment"]:checked').val();
        phone = $('#user-phone').val()
        note = $('#note').val()
        console.log(shipment)
        console.log(payment)
        console.log(phone)
        console.log(note)
        console.log(address_id_selected)
        if(!shipment || !payment || !address_id_selected || !phone){
            toastr.warning("chua dien day du")
            return
        }
        else{
            req={
                address_id_selected : address_id_selected,
                shipment : shipment,
                payment : payment,
                phone : phone,
                note : note
            }
            $.ajax({
                url : '/order',
                type : 'POST',
                data : req,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success : function(response){
                    window.location.href = '/buyer/orders';

                },
                error : function(response){
                    alert("false")
                    console.log(response)
                }
            })
        }
    }
</script>
</html>
