<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List account</title>
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
            <h1>List account</h1>
            @if($accounts->count() > 0)
            <div class="list-book">
                <table class="table table-striped table-class" id="table-id">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Status</td>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                        <tr>
                            <td>{{$account->id}}</td>
                            <td>{{$account->email}}</td>
                            <td>{{$account->name}}</td>
                            <td>{{$account->phone}}</td>
                            <td>{{$account->status}}</td>
                            <td><a href="/admin/account/detail/id={{$account->id}}">Detail</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $accounts->onEachSide(1)->links() }}
            @else
            <p>No accounts found.</p>
            @endif
        </div>
    </section>

</body>
</html>
