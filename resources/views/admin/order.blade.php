<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/admin-order.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- include libraries(jQuery, bootstrap) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <style>
        .toast {
            font-size: 14px;
            /* Kích thước chữ của thông báo */
        }

    </style>
</head>
<body>
    <section class="container">
        <div>
            @include('admin.component.slidebar')
        </div>
        <div class="content">
            <h1>List order</h1>
            @if($orderDetails->count() > 0)
            <div class="list-order">
                <table class="table table-striped table-class" id="table-id">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Book name</th>
                            <th>Quantity</th>
                            <th>Customer name</th>
                            <th>Status</th>
                            <th>Status update</th>
                            <th>Created_at</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderDetails as $orderDetail)
                        <tr>
                            <td>{{$orderDetail->id}}</td>
                            <td>{{$orderDetail->book->name}}</td>
                            <td>{{$orderDetail->quantity}}</td>
                            <td>{{$orderDetail->order->user->name}}</td>
                            <td>
                                @switch($orderDetail->status)
                                @case(1)
                                To Pay
                                @break

                                @case(2)
                                To Ship
                                @break

                                @case(3)
                                To Receive
                                @break

                                @case(4)
                                Completed
                                @break

                                @case(5)
                                Canceled
                                @break

                                @case(6)
                                Return Refund
                                @break

                                @default
                                Unknown Status
                                @endswitch
                            </td>
                            <td>
                                <select class="order-status" data-id="{{ $orderDetail->id }}">
                                    <option value="1" {{ $orderDetail->status == 1 ? 'selected' : '' }} {{ $orderDetail->status > 1 ? 'disabled' : '' }}>To Pay</option>
                                    <option value="2" {{ $orderDetail->status == 2 ? 'selected' : '' }} {{ $orderDetail->status > 2 ? 'disabled' : '' }}>To Ship</option>
                                    <option value="3" {{ $orderDetail->status == 3 ? 'selected' : '' }} {{ $orderDetail->status > 3 ? 'disabled' : '' }}>To Receive</option>
                                    <option value="4" {{ $orderDetail->status == 4 ? 'selected' : '' }} {{ $orderDetail->status > 4 ? 'disabled' : '' }}>Completed</option>
                                    <option value="5" {{ $orderDetail->status == 5 ? 'selected' : '' }} {{ $orderDetail->status > 5 ? 'disabled' : '' }}>Canceled</option>
                                    <option value="6" {{ $orderDetail->status == 6 ? 'selected' : '' }} {{ $orderDetail->status > 6 ? 'disabled' : '' }}>Return refund</option>
                                </select>
                            </td>
                            <td>{{$orderDetail->created_at}}</td>
                            <td>
                                <a style="text-decoration: none;cursor: pointer;color: inherit;" href=""><button>Detail</button></a>
                                <button onclick="updateStatusOrder({{ $orderDetail->id }})">Update Status</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $orderDetails->onEachSide(1)->links() }}
            @else
            <p>No orders found.</p>
            @endif
        </div>
    </section>

</body>
<script>
    function updateStatusOrder(orderId) {
        var specificSelect = $('select.order-status[data-id="' + orderId + '"]').val();
        $.ajax({
            url: '/admin/order'
            , type: 'PUT'
            , data: {
                _token: "{{ csrf_token() }}"
                , 'orderDetail_id': orderId
                , 'status': specificSelect
            }
            , success: function(response) {
                toastr.success("Successfully!")
                console.log(response)
            }
            , error: function(response) {
                console.log(response)
            }
        })

    }

</script>
</html>
