<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-account.css') }}">
    <style>
        .page-link{
            height: 30px;;
        }
    </style>
</head>
<body>
    <section class="container">
        <div>
            @include('admin.component.slidebar')
        </div>
        <div class="content">
            <h1>Account detail</h1>
            <label>Name : </label>
            <span>{{$account->name}}</span><br>
            <label>Email : </label>
            <span>{{$account->email}}</span><br>
            <label>Phone : </label>
            <span>{{$account->phone}}</span><br>
            <label>Addresses : </label><br>
            @foreach($account->addresses as $address)
                <span>{{$address->toString()}}</span><br>
            @endforeach
        </div>
    </section>

</body>
</html>
