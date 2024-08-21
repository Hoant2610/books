<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List book</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-book.css') }}">
</head>
<body>
    <section class="container">
        <div>
            @include('admin.component.slidebar')
        </div>
        <div class="content">
            <h1>List book</h1>
            @include('admin.component.search-book')
            @if($books->count() > 0)
            <div class="list-book">
                <table class="table table-striped table-class" id="table-id">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Inventory</th>
                            <th>Status</td>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                        <tr>
                            <td><img src="{{$book->getBook()->thumbnail}}"></td>
                            <td>{{$book->getBook()->id}}</td>
                            <td>{{$book->getBook()->category->name}}</td>
                            <td>{{$book->getBook()->name}}</td>
                            <td>{{$book->getBook()->quantity}}</td>
                            <td>{{$book->getBook()->status}}</td>
                            <td>
                                <a style="text-decoration: none;cursor: pointer;color: inherit;" href="/admin/books/{{$book->getBook()->slug}}"><button>Detail</button></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $books->appends(['key' => request('key')])->onEachSide(1)->links() }}
            @else
            <p>No books found.</p>
            @endif
        </div>
    </section>

</body>
</html>
