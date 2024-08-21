<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create book</title>
    <link rel="stylesheet" href="{{ asset('css/admin-book-create.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- include libraries(jQuery, bootstrap) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>
    <style>
        .toast {
            font-size: 14px;
            /* Kích thước chữ của thông báo */
        }

        .create-book {
            display: none;
        }

    </style>
</head>
<body>
    <section class="container">
        <div>
            @include('admin.component.slidebar')
        </div>
        <div class="content">
            <h1>Create new book</h1>
            @include('admin.component.search-book')
        </div>
        <div class="book-detail">
            <div class="book-top">
                <div class="book-image">
                    <div class="gallery-box">
                        <label>Thumbnail</label>
                        <div class="thumbnail-preview"></div>
                        <input type="file" id="fileInput">

                    </div>
                </div>
                <div class="book-info">
                    <div class="book-category">
                        <label>Category</label><br>
                        <select id="category">
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="book-name">
                        <label>Name</label><br>
                        <textarea id="name"></textarea>
                    </div>
                    <div class="book-author">
                        <label>Author</label><br>
                        <input id="author" type="text">
                    </div>
                    <div class="book-quantity">
                        <label>Inventory</label><br>
                        <input type="number" style="max-width : 100px;" id="quantity">
                    </div>
                    <div class="book-price">
                        <div class="book-sale_price">
                            <label>Sale Price</label><br>
                            <input id="sale_price" class="sale-price" value="0">
                            <span>VND</span>
                        </div>
                        <div class="book-original_price">
                            <label>Original Price</label><br>
                            <input id="original_price" class="original-price" value="0">
                            <span>VND</span>
                        </div>
                    </div>
                    <div class="book-status">
                        <label>Status</label><br>
                        <input style="max-width : 50px;" id="status" value="1">
                    </div>
                    <div class="book-description">
                        <label>Description</label>
                        <div id="summernote"></div>
                    </div>
                    <button style="height : 30px;" onclick="createBook()">Create</button>

                </div>
            </div>
        </div>
    </section>
    <div style="height : 200px;"></div>
</body>

<script>
    toastr.options = {
        "timeOut": "500"
    , }
    new Cleave('.sale-price', {
        numeral: true
        , numeralThousandsGroupStyle: 'thousand'
        , prefix: '',
        // suffix: ' VND',
        numeralDecimalMark: '.'
        , delimiter: ','
    });
    new Cleave('.original-price', {
        numeral: true
        , numeralThousandsGroupStyle: 'thousand'
        , prefix: '',
        // suffix: ' VND',
        numeralDecimalMark: '.'
        , delimiter: ','
    });
    $('#fileInput').on('change', function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            var imgPath = e.target.result;
            var imgElement = $('<img>')
                .attr('src', imgPath)
                .attr('height', '100px') // Bạn có thể tùy chỉnh giá trị này
                .attr('class', 'item')
                .attr('id', imgPath);

            $('.thumbnail-preview').html(imgElement);
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });
    $(document).ready(function() {
        $('#summernote').summernote();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    function createBook() {
            var formData = new FormData();
            var category_id = $('#category').val();
            var name = $('#name').val();
            var author = $('#author').val();
            var quantity = $('#quantity').val();
            var salePrice = $('#sale_price').val().replace(/[^0-9.]/g, '');
            var originalPrice = $('#original_price').val().replace(/[^0-9.]/g, '');
            var status = $('#status').val();
            var description = $('#description').summernote('code');
            var fileInput = $('#fileInput')[0];
            if (!name || !quantity || !salePrice || !originalPrice || !status || fileInput.files.length <= 0) {
                toastr.warning("Fill fully!")
                return
            }
            if (fileInput.files.length > 0) {
                formData.append('thumbnail', fileInput.files[0]);
            }
            // Add non-file data
            formData.append('category_id', $('#category').val());
            formData.append('name', $('#name').val());
            formData.append('author', $('#author').val());
            formData.append('quantity', $('#quantity').val());
            formData.append('salePrice', $('#sale_price').val().replace(/[^0-9.]/g, ''));
            formData.append('originalPrice', $('#original_price').val().replace(/[^0-9.]/g, ''));
            formData.append('status', $('#status').val());
            formData.append('description', $('#description').summernote('code'));
            $.ajax({
                url: '/admin/book'
                , type: 'POST'
                , data: formData
                , contentType: false
                , processData: false
                , success: function(response) {
                    window.location.href = '/admin/books/' + response.slug;
                }
                , error: function(response) {
                    console.error(response);
                }
            });
        }

</script>
</html>
