<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$book->getBook()->name}}</title>
    <link rel="stylesheet" href="{{ asset('css/admin-book-detail.css') }}">
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

    </style>
</head>
<body>
    <section class="container">
        <div>
            @include('admin.component.slidebar')
        </div>
        <div class="content">
            <h1>Book detail</h1>
            @include('admin.component.search-book')
        </div>
        <div class="book-detail">
            <div class="book-top">
                <div class="book-image">
                    <div class="thumbnail-box">
                        <img id="thumbnail" width="200px" height="200px" class="thumbnail" src="{{ asset($book->getBook()->thumbnail) }}" alt="Thumbnail">
                        <button onclick="changeThumbnail()">Change thumbnail</button><br><br>
                        <div id="thumbnailModal" style="display:none;">
                            <div style="display: flex;float : right;">
                                {{-- <img id="thumbnail" width="150px" height="150px" class="thumbnail" src="{{ asset($book->getBook()->thumbnail) }}" alt="Thumbnail"> --}}
                                <button style="height: 30px;" onclick="closeModalThumbnail()">Close</button>
                            </div>
                            <div id="imgs">

                            </div>
                            <!-- Input để thêm ảnh mới -->
                            <input type="file" id="newImageInput" multiple>
                            <button onclick="confirmThumbnail()">Confirm</button>

                            <button onclick="closeModalThumbnail()">Close</button>
                        </div>
                    </div>
                    <div class="gallery-box">
                        {{-- {{($book->getBook()->images->count())}} --}}
                        @foreach($book->getBook()->images as $image)
                        <img class="gallery" src="{{ asset($image->image) }}" alt="Book Image">
                        @endforeach
                        
                    </div>
                    <button onclick="openModalImages()">Edit</button>
                </div>
                <div class="book-info">
                    <div class="book-id">
                        <label>Id</label><br>
                        <input style="max-width : 150px;" value="{{$book->getBook()->id}}" disabled>
                    </div>
                    <div class="book-category">
                        <label>Category</label><br>
                        {{-- <input id="" value="{{$book->category->name}}"> --}}
                        <select id="category">
                            <option value="{{$book->getBook()->category->id}}">{{$book->getBook()->category->name}}</option>
                            @foreach($categories as $category)
                                @if($category->name != $book->getBook()->category->name)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="book-name">
                        <label>Name</label><br>
                        {{-- <textarea id="" value="{{$book->name}}"> --}}
                        <textarea id="name">{{$book->getBook()->name}}</textarea>
                    </div>
                    <div class="book-quantity">
                        <label>Inventory</label><br>
                        <input style="max-width : 100px;" id="quantity" value="{{$book->getBook()->quantity}}">
                    </div>
                    <div class="book-price">
                        <div class="book-sale_price">
                            <label>Sale Price</label><br>
                            <input id="sale_price" class="sale-price" value="{{$book->getBook()->sale_price}}">
                            <span>VND</span>
                        </div>
                        <div class="book-original_price">
                            <label>Original Price</label><br>
                            <input id="original_price" class="original-price" value="{{$book->getBook()->original_price}}">
                            <span>VND</span>
                        </div>
                    </div>
                    <div class="book-status">
                        <label>Status</label><br>
                        <input style="max-width : 50px;" id="status" value="{{$book->getBook()->status}}">
                    </div>
                    <div class="book-timestamp">
                        <div class="book-created_at">
                            <label>Created_at : </label>
                            <span>{{$book->getBook()->created_at->format('d/m/y h:m:s')}}</span>
                        </div>
                        <div class="book-updated_at">
                            <label>Created_at : </label>
                            <span>{{$book->getBook()->updated_at->format('d/m/y h:m:s')}}</span>
                        </div>
                    </div>
                    <button style="height : 30px;margin : 20px;" onclick="updateBook()">Update</button>
                    <div class="book-description">
                        <div id="summernote">{!!$book->getBook()->description!!}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div style="height : 200px;"></div>
</body>

<script>
    toastr.options = {
        "timeOut": "500", 
    }
    new Cleave('.sale-price', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '',
            // suffix: ' VND',
            numeralDecimalMark: '.',
            delimiter: ','
        });
        new Cleave('.original-price', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '',
            // suffix: ' VND',
            numeralDecimalMark: '.',
            delimiter: ','
        });
    $(document).ready(function() {
        $('#summernote').summernote();
        $.ajax({
            url: "/admin/imgs"
            , type: "GET"
            , data: {
                _token: "{{ csrf_token() }}"
            }
            , success: function(response) {
                // Lấy phần tử có id là 'imgs'
                var imgsContainer = $('#imgs');

                // Xóa nội dung cũ (nếu có)
                imgsContainer.empty();

                // Lặp qua mảng imgs
                response.imgs.forEach(function(imgPath) {
                    // Tạo thẻ img mới với đường dẫn ảnh
                    var imgElement = $('<img>').attr('src', imgPath).attr('height', '100px')
                        .attr('class', 'item')
                        .attr('id', imgPath);

                    // Tạo thẻ xóa
                    var deleteBtn = $('<button>').addClass('delete-btn').text('×');

                    // Tạo thẻ div bao quanh ảnh và nút xóa
                    var imgContainer = $('<div>').addClass('img-container').append(imgElement).append(deleteBtn);

                    // Thêm thẻ img vào trong thẻ div có id="imgs"
                    $('#imgs').append(imgContainer);
                });
            }
            , error: function(response) {
                console.log(response);
            }
        })
    });
    var selectedImgPath

    function changeThumbnail() {
        $('#thumbnailModal').show();
        $('#imageModal').hide();
        // Xử lý sự kiện click trên ảnh
        $('#imgs').on('click', 'img.item', function(event) {
            // Ngăn không cho sự kiện click nổi lên lên tài liệu
            event.stopPropagation();
            // Xóa lớp active từ tất cả các ảnh
            $('#imgs img.item').removeClass('active');
            // Thêm lớp active cho ảnh được chọn
            $(this).addClass('active');
            // Lấy giá trị imgPath từ thuộc tính id
            selectedImgPath = $(this).attr('id');
        });
        // Xử lý sự kiện click trên toàn bộ tài liệu
        $(document).on('click', function(event) {
            // Kiểm tra xem sự kiện click có phải là vào ảnh không
            if (!$(event.target).closest('#imgs img.item').length) {
                // Nếu không phải, xóa lớp active từ tất cả các ảnh
                $('#imgs img.item').removeClass('active');
                selectedImgPath = null; // Bạn có thể đặt lại selectedImgPath nếu cần
            }
        });
    }

    function confirmThumbnail() {
        if (selectedImgPath) {
            req = {
                _token: "{{ csrf_token() }}"
                , 'slug': "{{$book->getBook()->slug}}"
                , 'selectedImgPath': selectedImgPath.substring(1)
            }
            $.ajax({
                url : '/admin/change-thumbnail',
                type : "POST",
                data : req ,
                success : function(response){
                    $('#thumbnail').attr('src', response.newThumbnail);
                    $('#thumbnailModal').hide();
                    toastr.success("Update successfully!")
                },
                error : function(response){
                    console.log(response)
                }
            })
        } else {
            toastr.warning("Choose a image!")
        }
    }
    $(document).ready(function() {
        $('#newImageInput').on('change', function() {
            var files = $(this)[0].files; // Đảm bảo $(this) là phần tử input đúng
            if (files.length === 0) {
                alert('Please select files to upload.');
                return;
            }

            var formData = new FormData();

            // Thêm từng file vào FormData
            $.each(files, function(i, file) {
                formData.append('images[]', file);
            });

            // Gửi file qua AJAX
            $.ajax({
                url: '/admin/upload-image', // URL đến server của bạn
                type: 'POST'
                , data: formData
                , contentType: false
                , processData: false
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                }
                , success: function(response) {
                    toastr.success("Upload successfully!")
                    // Lấy phần tử có id là 'imgs'
                    var imgsContainer = $('#imgs');
                    // Lặp qua mảng imgs
                    response.imageNews.forEach(function(imgPath) {
                        // Tạo thẻ img mới với đường dẫn ảnh
                        var imgElement = $('<img>').attr('src', imgPath).attr('height', '100px')
                            .attr('class', 'item')
                            .attr('id', imgPath);

                        // Tạo thẻ xóa
                        var deleteBtn = $('<button>').addClass('delete-btn').text('×');

                        // Tạo thẻ div bao quanh ảnh và nút xóa
                        var imgContainer = $('<div>').addClass('img-container').append(imgElement).append(deleteBtn);

                        // Thêm thẻ img vào trong thẻ div có id="imgs"
                        $('#imgs').prepend(imgContainer);
                    });
                    $('#newImageInput').val('');
                }
                , error: function(response) {
                    console.log(response)
                }
            });
        });
    });
    function closeModalThumbnail() {
        $('#thumbnailModal').hide()
    }
    function openModalImages() {
        toastr.success("djsgkj")
    }
    function updateBook(){
        var category = $('#category').val();
        var name = $('#name').val();
        var quantity = $('#quantity').val();
        var sale_price = $('#sale_price').val().replace(/[^0-9.]/g, '');
        var original_price = $('#original_price').val().replace(/[^0-9.]/g, '');
        var status = $('#status').val();
        var description = $('#summernote').summernote('code');
        var slug = "{{$book->getBook()->slug}}";
        req = {
            _token: "{{ csrf_token() }}",
            'name' : name,
            'category' : category,
            'quantity' : quantity,
            'sale_price' : sale_price,
            'original_price' : original_price,
            'status' : status,
            'description' : description
        }
        if(!name || !quantity || !sale_price || !original_price ||!status){
            toastr.warning("Fill fully!")
        }
        else{
            $.ajax({
                url : '/admin/books/' + slug,
                type : 'POST',
                data : req,
                success : function(response){
                    // console.log(response)
                    window.location.href = '/admin/books/' + response.newSlug;
                },
                error : function(response){
                    console.log(response)
                }
            })
        }
    }

</script>
</html>
