<link rel="stylesheet" href="{{ asset('css/admin-slidebar.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- include libraries(jQuery, bootstrap) -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <div class="area"></div>
    <nav class="main-menu">
        <ul>
            <li class="tag-home">
                <a href="/admin/dashboard">
                    <i class="fa fa-home fa-2x"></i>
                    <span class="nav-text">
                        Home
                    </span>
                </a>

            </li>
            <li class="tag-account">
                <a href="/admin/accounts">
                    <i class="fa fa-2x fa-solid fa-user"></i>
                    <span class="nav-text">
                        Account
                    </span>
                </a>

            </li>
            <li class="tag-category">
                <a href="/admin/categories">
                    <i class="fa-solid fa-layer-group fa fa-2x"></i>
                    <span class="nav-text">
                        Category
                    </span>
                </a>

            </li>
            <li class="tag-book">
                <a href="/admin/books">
                    <i class="fa-solid fa-book-open fa fa-2x"></i>
                    <span class="nav-text">
                        Book
                    </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="/admin/order">
                    <i class="fa-solid fa-clipboard-list fa fa-2x"></i>
                    <span class="nav-text">
                        Order
                    </span>
                </a>

            </li>
            <li>
                <a href="/admin/voucher">
                    <i class="fa-solid fa-ticket fa fa-2x"></i>
                    <span class="nav-text">
                        Voucher
                    </span>
                </a>
            </li>
            <li>
                <a href="/admin/statistic">
                    <i class="fa-solid fa-chart-column fa fa-2x"></i>
                    <span class="nav-text">
                        Statistic
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-cogs fa-2x"></i>
                    <span class="nav-text">
                        Tools & Resources
                    </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-map-marker fa-2x"></i>
                    <span class="nav-text">
                        Member Map
                    </span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{route('logout')}}">
                    @csrf
                    <button style="background-color : #fff; display : flex;align-item : center;" class="btn btn-logout">
                        <i class="fa-sharp fa-solid fa-right-from-bracket fa-2x"></i>
                        <span class="nav-text">
                            Logout
                        </span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
