<!-- Start Header/Navigation -->
<link href="{{asset('css/navbar.css')}}" rel="stylesheet">
<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

	<div class="container nav">
		<a class="navbar-brand" href="index.html">Furni<span>.</span></a>

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsFurni">
			<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
				<li class="nav-item tag-home">
					<a class="nav-link" href="/home">Home</a>
				</li>
				<li class="tag-book"><a class="nav-link" href="/buyer/books">Shop</a></li>
				<li><a class="nav-link" href="about.html">About us</a></li>
				<li><a class="nav-link" href="services.html">Services</a></li>
				<li><a class="nav-link" href="contact.html">Contact us</a></li>
			</ul>

			<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                      <div class="dropdown-account">
                        <div style="background-color: #3B5D50; border : solid black 1px;" class="account"> 
                            @if(session('name'))
                                {{ session('name') }}
                            @endif
                        </div>
                        <div class="dropdown-content">
                            <div class="button-option">
                                <a href="/buyer/account" style="text-align : center;">Profile</a>
                                <a href="/buyer/orders" style="text-align : center">My Order</a>
                                <form method="POST" action="{{route('logout')}}">
                                    @csrf
                                    <button class="btn-account" >Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>           
				<li><a href="/cart"><button class="button-cart"><img src="{{asset('images/cart.svg')}}"></button></a>
            </li>
            <li>@include('customer.component.chat')</li>
			</ul>
		</div>
	</div>

</nav>
<script>
    // Get the dropdown elements
const account = document.querySelector('.account');
const dropdownContent = document.querySelector('.dropdown-content');

// Toggle the dropdown content visibility when clicking on the account element
account.addEventListener('click', () => {
    dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
});

// Close the dropdown if the user clicks outside of it
window.addEventListener('click', (event) => {
    if (!event.target.matches('.account')) {
        if (dropdownContent.style.display === 'block') {
            dropdownContent.style.display = 'none';
        }
    }
});

</script>

