<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/admin-order.css') }}">
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
                            <th>Status</td>
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
                                <select>
                                    <option value="1">To Pay</option>
                                    <option value="2">To ship</option>
                                    <option value="3">To receive</option>
                                    <option value="4">Completed</option>
                                    <option value="5">Canceled</option>
                                    <option value="6">Return refund</option>
                                </select>
                            </td>
                            <td>{{$orderDetail->created_at}}</td>
                            <td>
                                <a style="text-decoration: none;cursor: pointer;color: inherit;" href=""><button>Detail</button></a>
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
</html>