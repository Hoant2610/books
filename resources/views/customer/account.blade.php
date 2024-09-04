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
    <link href="{{ asset('css/customer-account.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <title>Book shop</title>
</head>

<body>
    @include('customer.navbar')
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span id="avatar-name" class="font-weight-bold">{{$user->name}}</span><span class="text-black-50">{{$user->email}}</span><span> </span></div>
            </div>
            <div class="col-md-4 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Name</label><input id="name" type="text" class="form-control" placeholder="first name" value="{{$user->name}}"></div>
                        <div class="col-md-12"><label class="labels">Email</label><input readonly type="text" class="form-control" value="{{$user->email}}"></div>
                        <div class="col-md-12"><label class="labels">Phone</label><input id="phone" type="text" class="form-control" placeholder="enter the phone" value="{{$user->phone}}"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6"><button onclick="openChangePassForm()">Change Password</button></div>
                    </div>
                    <div class="mt-5 text-center"><button onclick="saveProfile()" class="btn btn-primary profile-button" type="button">Save Profile</button></div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center experience"><span>Address</span><span onclick="addNewAddress()" class="border px-3 p-1 add-experience"><i class="fa fa-plus"></i>&nbsp;Add new address</span></div><br>
                    <div id="newAddress">
                        @if(count($user->addresses) != 0)
                        <table id="addresses" class="addresses" style="width : 100%;">
                            <tbody>
                                @if(count($user->addresses))
                                @foreach($user->addresses as $address)
                                <tr>
                                    <td>
                                        @if($address->default == 1)
                                        <i class="fa-solid fa-check"></i>
                                        @else
                                        @endif
                                    </td>
                                    <td>
                                        <span id="{{$address->id}}_city">{{$address->city}}, </span>
                                        <span id="{{$address->id}}_district">{{$address->district}}, </span>
                                        <span id="{{$address->id}}_ward">{{$address->ward}}</span><br>
                                        <span id="{{$address->id}}_detail">({{$address->detail}})</span>
                                    </td>
                                    <td>
                                        <div><i onclick="editAddress({{$address->id}})" style="cursor: pointer;border : solid black 1px;padding : 2px;" class="fa-solid fa-pen"></i></div>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        @else
                        <p>No address found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div id="modal-overlay" class="modal-overlay"></div>

    <!-- Modal form -->
    <div id="address-form" class="form-address">
        <h4>New address</h4>
        <label for="city">City</label><br>
        <select id="city" name="city">
            <option value="">Select a city</option>
        </select><br>
        <label for="district">District</label><br>
        <select id="district" name="district">
            <option value="">Select a district</option>
        </select><br>
        <label for="ward">Ward</label><br>
        <select id="ward" name="ward">
            <option value="">Select a ward</option>
        </select><br>
        <label>Detail</label><br>
        <input id="detail" type="text"><br>
        <button onclick="closeAddressForm()">Close</button>
        <button onclick="createAddress()">Confirm</button>
    </div>

    {{-- Modal form edit --}}
    <div id="edit-address-form" class="form-edit-address">
        <h4>Edit adrress</h4>
        <label for="city">City</label><br>
        <select id="city-edit" name="city">
        </select><br>
        <label for="district">District</label><br>
        <select id="district-edit" name="district">
        </select><br>
        <label for="ward">Ward</label><br>
        <select id="ward-edit" name="ward">
        </select><br>
        <label>Detail</label><br>
        <input id="detail-edit" type="text"><br>
        <div  class="setDefault" style="display: none">
            <label>Set default</label>
            <input id="default-edit" type="checkbox"><br>
        </div>
        <button onclick="closeEditAddressForm()">Close</button>
        <button onclick="confirmEditAddress()">Confirm</button>
        <button class="btn-delete" style="display: none" onclick="deleteAddress()">Delete</button>
    </div>
    <div id="change-pass" class="change-pass">
        <h4>Change Password</h4>
        <label >Old password</label><br>
        <input type="password" id="oldPass" placeholder="Old password"><br>
        <label >New password</label><br>
        <input type="password" id="newPass" placeholder="New password"><br>
        <div style="color: red" id="error"></div>
        <button onclick="closeChangePassForm()">Close</button>
        <button onclick="confirmPass()">Confirm</button>
        
    </div>
    @include('home.footer')

    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/tiny-slider.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/format.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
<script>
    address_id_edit  = 0
    $(document).ready(function() {
        // Gọi API lấy danh sách tỉnh/thành phố
        $.ajax({
            url: 'https://provinces.open-api.vn/api/p/'
            , method: 'GET'
            , success: function(data) {
                $.each(data, function(index, province) {
                    $('#city').append($('<option>', {
                        value: province.code, // Dùng mã tỉnh để gọi API quận/huyện
                        text: province.name
                    }));
                });
            }
            , error: function(error) {
                console.error('Error fetching provinces:', error);
            }
        });

        // Khi người dùng chọn một thành phố
        $('#city').change(function() {
            var cityCode = $(this).val();

            // Xóa các tùy chọn cũ của quận/huyện và xã/phường
            $('#district').empty().append('<option disabled value="">Select a district</option>');
            $('#ward').empty().append('<option disabled value="">Select a ward</option>');

            if (cityCode) {
                // Gọi API lấy danh sách quận/huyện
                $.ajax({
                    url: `https://provinces.open-api.vn/api/p/${cityCode}?depth=2`
                    , method: 'GET'
                    , success: function(data) {
                        $.each(data.districts, function(index, district) {
                            $('#district').append($('<option>', {
                                value: district.code, // Dùng mã quận/huyện để gọi API xã/phường
                                text: district.name
                            }));
                        });
                    }
                    , error: function(error) {
                        console.error('Error fetching districts:', error);
                    }
                });
            }
        });

        // Khi người dùng chọn một quận/huyện
        $('#district').change(function() {
            var districtCode = $(this).val();

            // Xóa các tùy chọn cũ của xã/phường
            $('#ward').empty().append('<option value="">Select a ward</option>');

            if (districtCode) {
                // Gọi API lấy danh sách xã/phường
                $.ajax({
                    url: `https://provinces.open-api.vn/api/d/${districtCode}?depth=2`
                    , method: 'GET'
                    , success: function(data) {
                        $.each(data.wards, function(index, ward) {
                            $('#ward').append($('<option>', {
                                value: ward.code
                                , text: ward.name
                            }));
                        });
                    }
                    , error: function(error) {
                        console.error('Error fetching wards:', error);
                    }
                });
            }
        });

    });
    $(document).ready(function() {
                    // Hàm để nạp các tỉnh/thành phố vào dropdown
                    function loadCities() {
                        $.ajax({
                            url: 'https://provinces.open-api.vn/api/p'
                            , method: 'GET'
                            , success: function(data) {
                                $.each(data, function(index, city) {
                                    $('#city-edit').append($('<option>', {
                                        value: city.code
                                        , text: city.name
                                    }));
                                });
                            }
                            , error: function(error) {
                                console.error('Error fetching cities:', error);
                            }
                        });
                    }

                    // Hàm để nạp các quận/huyện vào dropdown
                    function loadDistricts(cityCode) {
                        $('#district-edit').empty().append('<option disabled value="">Select a district</option>');
                        $('#ward-edit').empty().append('<option disabled value="">Select a ward</option>');

                        if (cityCode) {
                            $.ajax({
                                url: `https://provinces.open-api.vn/api/p/${cityCode}?depth=2`
                                , method: 'GET'
                                , success: function(data) {
                                    $.each(data.districts, function(index, district) {
                                        $('#district-edit').append($('<option>', {
                                            value: district.code
                                            , text: district.name
                                        }));
                                    });
                                }
                                , error: function(error) {
                                    console.error('Error fetching districts:', error);
                                }
                            });
                        }
                    }

                    // Hàm để nạp các xã/phường vào dropdown
                    function loadWards(districtCode) {
                        $('#ward-edit').empty().append('<option disabled value="">Select a ward</option>');

                        if (districtCode) {
                            $.ajax({
                                url: `https://provinces.open-api.vn/api/d/${districtCode}?depth=2`
                                , method: 'GET'
                                , success: function(data) {
                                    $.each(data.wards, function(index, ward) {
                                        $('#ward-edit').append($('<option>', {
                                            value: ward.code
                                            , text: ward.name
                                        }));
                                    });
                                }
                                , error: function(error) {
                                    console.error('Error fetching wards:', error);
                                }
                            });
                        }
                    }

                    // Nạp dữ liệu cho dropdown thành phố khi trang được tải
                    loadCities();

                    // Xử lý sự kiện khi chọn thành phố
                    $('#city-edit').change(function() {
                        var cityCode = $(this).val();
                        loadDistricts(cityCode);
                    });

                    // Xử lý sự kiện khi chọn quận/huyện
                    $('#district-edit').change(function() {
                        var districtCode = $(this).val();
                        loadWards(districtCode);
                    });
                    
                });
    toastr.options = {
        "timeOut": "500"
    , }

    function addNewAddress() {
        document.getElementById('address-form').style.display = 'block';
        document.getElementById('modal-overlay').style.display = 'block';
    }
    // Hàm ẩn form
    function closeAddressForm() {
        document.getElementById('address-form').style.display = 'none';
        document.getElementById('modal-overlay').style.display = 'none';
    }
    // Function to update the addresses table with new HTML content
    function updateAddresses(newAddresses) {
        // Remove the old table
        // $('#addresses').remove();

        // Start creating the new table HTML structure
        var newContent = `
        <table id="addresses" class="addresses" style="width : 100%;">
        <tbody>`;

        // Loop through each address in the newAddresses array
        newAddresses.forEach(function(address) {
            newContent += `
            <tr>
                <td>`;
            if (address.default == 1) {
                newContent += `<i class="fa-solid fa-check"></i>`;
            }
            newContent += `</td>
                <td>
                    <div>${address.city}, ${address.district}, ${address.ward}</div>
                    <span>(${address.detail})</span>
                </td>
                <td>
                    <div><i onclick="editAddress(${address.id})" style="cursor: pointer;border : solid black 1px;padding : 2px;" class="fa-solid fa-pen"></i></div>
                </td>
            </tr>`;
        });

        // Close the table structure
        newContent += `
        </tbody></table>`;

        // Append the new HTML content to the DOM
        $('#newAddress').html(newContent);
    }

    function createAddress() {
        var user_id = {{$user->id}}
        var city = $('#city option:selected').text()
        var district = $('#district option:selected').text()
        var ward = $('#ward option:selected').text()
        var city_code = $('#city option:selected').val()
        var district_code = $('#district option:selected').val()
        var ward_code = $('#ward option:selected').val()
        var detail = $('#detail').val()
        if (!city || !district || !ward || !detail) {
            toastr.warning("Please fill in all fields.")
        } else {
            $.ajax({
                url: '/buyer/address'
                , type: 'POST'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , 'user_id': user_id
                    , 'city': city
                    , 'district': district
                    , 'ward': ward
                    , 'city_code': city_code
                    , 'district_code': district_code
                    , 'ward_code': ward_code
                    , 'detail': detail
                }
                , success: function(response) {
                    console.log(response)
                    closeAddressForm()
                    $('#city').val('');
                    $('#district').val('');
                    $('#ward').val('');
                    $('#detail').val('');
                    updateAddresses(response.newAddress);
                }
                , error: function(response) {
                    console.log(response)
                }
            })
        }
    }

    function editAddress(address_id) {
        address_id_edit = address_id
        $.ajax({
            url: '/buyer/address'
            , type: 'GET'
            , data: {
                _token: "{{ csrf_token() }}"
                , 'address_id': address_id
                , 'user_id': {{$user->id}}
            }
            , success: function(response) {
                
                // Sau khi tải thành phố, hãy chọn giá trị mặc định nếu có
                if (response.address.city_code) {
                    $('#city-edit').val(response.address.city_code).trigger('change');
                }
                // Sau khi tải quận/huyện, hãy chọn giá trị mặc định nếu có
                if (response.address.district_code) {
                    $('#district-edit').val(response.address.district_code).trigger('change');
                }
                // Sau khi tải xã/phường, hãy chọn giá trị mặc định nếu có
                if (response.address.ward_code) {
                    $('#ward-edit').val(response.address.ward_code).trigger('change');
                }
                $('#detail-edit').val(response.address.detail)
                if (response.address.default == 0) {
                    $('.setDefault').show()
                    $('.btn-delete').show()
                }
                document.getElementById('edit-address-form').style.display = 'block';
                document.getElementById('modal-overlay').style.display = 'block';
            }
            , error: function(response) {
                console.log(response)
            }
        })
        

    }

    function closeEditAddressForm() {
        document.getElementById('edit-address-form').style.display = 'none';
        document.getElementById('modal-overlay').style.display = 'none';
        $('.setDefault').hide()
        $('.btn-delete').hide()
    }

    function confirmEditAddress() {
        // document.getElementById('edit-address-form').style.display = 'none';
        // document.getElementById('modal-overlay').style.display = 'none';
        var address_id = address_id_edit
        var user_id = {{$user->id}}
        var city = $('#city-edit option:selected').text()
        var district = $('#district-edit option:selected').text()
        var ward = $('#ward-edit option:selected').text()
        var city_code = $('#city-edit option:selected').val()
        var district_code = $('#district-edit option:selected').val()
        var ward_code = $('#ward-edit option:selected').val()
        var detail = $('#detail-edit').val()
        var default_edit  = $('#default-edit').is(':checked') ? 1 : 0;
        if (!city || !district || !ward || !detail) {
            toastr.warning("Please fill in all fields.")
        } else {
            $.ajax({
                url: '/buyer/address'
                , type: 'PUT'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , 'user_id': user_id
                    , 'address_id': address_id
                    , 'city': city
                    , 'district': district
                    , 'ward': ward
                    , 'city_code': city_code
                    , 'district_code': district_code
                    , 'ward_code': ward_code
                    , 'detail': detail
                    , 'default' : default_edit
                }
                , success: function(response) {
                    console.log(response)
                    closeEditAddressForm()
                    $('#city').val('');
                    $('#district').val('');
                    $('#ward').val('');
                    $('#detail').val('');
                    updateAddresses(response.newAddress);
                }
                , error: function(response) {
                    console.log(response)
                }
            })
        }
    }
    function deleteAddress(){
        var address_id = address_id_edit
        var user_id = {{$user->id}}
        $.ajax({
            url : '/buyer/address',
            type : 'DELETE',
            data : {
                 _token: "{{ csrf_token() }}",
                'user_id' : user_id,
                'address_id' : address_id
            },
            success : function(response){
                closeEditAddressForm()
                updateAddresses(response.addresses);
            },  
            error : function(response){
                console.log(response)
            }
        })
    }
    function saveProfile(){
        var user_id = {{$user->id}}
        var name = $('#name').val()
        var phone = $('#phone').val()
        if(!name || !phone){
            toastr.warning("Please fill in all fields.")
        }
        else{
            $.ajax({
                url : '/buyer/account',
                type : 'PUT',
                data : {
                    _token: "{{ csrf_token() }}",
                    'user_id' : user_id,
                    'phone' : phone,
                    'name' : name
                },
                success : function(response){
                    var name = $('#name').val(response.user.name)
                    var phone = $('#phone').val(response.user.phone)   
                    $('#avatar-name').text(response.user.name)
                    toastr.success("Change profile successfully!")
                },
                error : function(response){
                    console.log(response)
                }
            })
        }
    }
    function openChangePassForm(){
        $('#change-pass').show()
        $('#modal-overlay').show()
    }
    function closeChangePassForm(){
        $('#change-pass').hide()
        $('#modal-overlay').hide()
        $('#error').hide()
        $('#oldPass').val('')
        $('#newPass').val('')
    }
    function confirmPass(){
        var user_id = {{$user->id}};
        var oldPass = $('#oldPass').val();
        var newPass = $('#newPass').val();
        $.ajax({
            url : '/buyer/password',
            type : 'PUT',
            data : {
                _token: "{{ csrf_token() }}",
                'user_id' : user_id,
                'newPass' : newPass,
                'oldPass' : oldPass
            },
            success : function(response){
                toastr.success("Change password successfully!")
            },
            error : function(response){
                $('#error').html(`Invalid password`);
            }
        })
    }
</script>
</html>
