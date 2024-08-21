<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/admin-category.css') }}">
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
            <h1>List Category</h1>
            @include('admin.component.search-book')
            @if($categories->count() > 0)
            <div class="list-category">
                <table class="table table-striped table-class" id="table-id">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Number of book</th>
                            <th></th>
                        </tr>

                    </thead>
                    <tbody class="tbody">
                        @foreach($categories as $category)
                        <tr>
                            <td class="id">{{$category->id}}</td>
                            <td id="category-name-{{$category->id}}" class="name">{{$category->name}}</td>
                            <td>{{count($category->products)}}</td>
                            <td>
                                <button onclick="openEditForm({{$category->id}})">Edit</button>
                            </td>
                        </tr>
                        <tr class="edit-form-{{$category->id}}" style="display: none">
                            <td class="id"></td>
                            <td class="name">
                                <input id="new-category-{{$category->id}}" value="{{$category->name}}">
                            </td>
                            <td>
                                <button onclick="updateCategory({{$category->id}})">Update</button>
                                <button onclick="closeEditForm({{$category->id}})">Cancel</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button onclick="openNewCategoryForm()">Add new category</button>
                <div class="new-category-form" style="display: none">
                    <input id="category" placeholder="Enter name of category">
                    <button onclick="addNewCategory()">Add</button>
                    <button onclick="closeNewCategoryForm()">Close</button>
                </div>
            </div>
            @else
            <p>No categories found.</p>
            @endif
        </div>
    </section>
</body>
<script>
    function openEditForm(id) {
        $('tr[class^="edit-form-"]').hide();
        $('.edit-form-' + id).show();
    }

    function closeEditForm(id) {
        $('.edit-form-' + id).hide()
    }

    function openNewCategoryForm() {
        $('.new-category-form').show()
    }

    function closeNewCategoryForm() {
        $('.new-category-form').hide()
    }

    function addNewCategory() {
        var category = $('#category').val()
        if (!category) {
            toastr.warning("This field is required!")
        } else {
            $.ajax({
                url: '/admin/category'
                , type: 'POST'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , 'name': category
                }
                , success: function(response) {
                    var id = response.category.id
                    var name = response.category.name
                    $('.tbody').append(`
                        <tr>
                            <td class="id">${id}</td>
                            <td id="category-name-${id}" class="name">${name}</td>
                            <td>
                                <button onclick="openEditForm(${id})">Edit</button>
                            </td>
                        </tr>
                        <tr class="edit-form-${id}" style="display: none">
                            <td class="id"></td>
                            <td class="name">
                                <input id="new-category-${id}" value="${name}">
                            </td>
                            <td>
                                <button onclick="updateCategory(${id})">Update</button>
                                <button onclick="closeEditForm(${id})">Cancel</button>
                            </td>
                        </tr>
                    `);

                }
                , error: function(response) {
                    console.log(response)
                }
            })
        }
    }

    function updateCategory(category_id) {
        var newName = $('#new-category-' + category_id).val()
        console.log(category_id)
        if (!newName) {
            toastr.warning("This field is required!")
        } else {
            $.ajax({
                url: '/admin/category'
                , type: 'PUT'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , 'category_id': category_id
                    , 'newName': newName
                }
                , success: function(response) {
                    $('#category-name-' + category_id).text(response.category.name)
                }
                , error: function(response) {
                    console.log(response)
                }
            })
        }
    }

</script>
</html>
