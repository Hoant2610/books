<!-- Start Header/Navigation -->
<link href="{{asset('css/navbar.css')}}" rel="stylesheet">
<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

	<div class="container">
		<a class="navbar-brand" href="index.html">BookShop<span>.</span></a>

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsFurni">
			<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
				<li class="nav-item tag-home">
					<a class="nav-link" href="/">Home</a>
				</li>
				<li class="tag-book"><a class="nav-link" href="/book">Book</a></li>
				<li><a class="nav-link" href="about.html">About us</a></li>
				<li><a class="nav-link" href="services.html">Services</a></li>
				<li><a class="nav-link" href="contact.html">Contact us</a></li>
			</ul>

			<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
				<li><a href="/login"><button class="button-account"><img src="images/user.svg"></button></a>
				</li>
				<!-- Modal -->
				{{-- <div id="loginModal" class="modal-login">
					<div class="modal-content">
						<button class="button-close" onclick="closeLoginForm()" class="close">Close</button >
						<div class="login-register">
							<button onclick="selectLoginForm()">Login</button>
							<button onclick="selectRegisterForm()">Register</button>
						</div>
						<form method="POST" action="{{route('login')}}">
							@csrf
							<div class="form-login">
								<h2>Login</h2>
								<img class="image-label" width="30px;" src="{{ asset('images/email.svg') }}" alt="User Icon" width="46" height="46">
								<input class="input-login" name="email" type="text" id="emailLogin" placeholder="Email"><br>
								<img width="30px" src="{{ asset('images/password.svg') }}" alt="User Icon" width="46" height="46">
								<input class="input-login" name="password" type="password" id="passwordLogin" placeholder="Password"><br>
								<button type="submit">Login</button><br>
								<a href="/forgot-password">Forgot password? Click here</a><br>
							</div>
						</form>
						<form class="form-register">
							@csrf
							<h2>Register</h2>
							<img class="image-label" width="30px;" src="{{ asset('images/email.svg') }}" alt="User Icon" width="46" height="46">
							<input type="text" id="email" name="email" placeholder="Email"><br>
							<img class="image-label" width="30px;" src="{{ asset('images/password.svg') }}" alt="User Icon" width="46" height="46">
							<input type="password" id="password" name="password" placeholder="Password"><br>
							<img class="image-label" width="30px;" src="{{ asset('images/password.svg') }}" alt="User Icon" width="46" height="46">
							<input type="password" id="password" name="password" placeholder="Retype password"><br>
							<input type="button" onclick="submitForm()" value="Register">
						</form>
					</div>
				</div> --}}
				<li><button class="button-cart"><img src="{{asset('images/cart.svg')}}"></button></li>
			</ul>
		</div>
	</div>

</nav>
<!-- End Header/Navigation -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
	function login(){
		var email = $("#emailLogin").val()
		var password = $("#passwordLogin").val()
		if(!email){
			toastr.warning('Email cannot be empty!');
			return;
		}
		if(!password){
			toastr.warning('Password cannot be empty!');
			return;
		}
		else{
			$.ajax({
				url : '/api/login',
				method : "POST",
				data : {
					'email' : email,
					'password' : password
				},
				success : function(response){
					console.log(response)
					toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "1000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
					toastr.success("OK")
					$('.modal-login').hide()

				},
				error : function(response){
					console.log(response)
					toastr.error("false")
				}
			});
		}
	}
	function selectLoginForm(){
		
		$('.form-login').show()
		$('.form-register').hide()
	}
	function selectRegisterForm(){
		
		$('.form-register').show()
		$('.form-login').hide()
	}
</script>
