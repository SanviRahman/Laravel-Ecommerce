<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dark Bootstrap Admin</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{ asset('admin/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="{{ asset('admin/css/font.css') }}">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('admin/css/style.default.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">
    
    <!-- Add this line for push styles -->
    @stack('styles')
    
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('admin/img/favicon.ico') }}">
    
    <!-- Tweaks for older IEs-->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    @php
        $currentRoute = Route::currentRouteName();
    @endphp
    
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="search-panel">
                <div class="search-inner d-flex align-items-center justify-content-center">
                    <div class="close-btn">Close <i class="fa fa-close"></i></div>
                    <form id="searchForm" action="#">
                        <div class="form-group">
                            <input type="search" name="search" placeholder="What are you searching for...">
                            <button type="submit" class="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <div class="navbar-header">
                    <!-- Navbar Header-->
                    <a href="{{ route('dashboard') }}" class="navbar-brand">
                        <div class="brand-text brand-big visible text-uppercase">
                            <strong class="text-primary">Dark</strong><strong>Admin</strong>
                        </div>
                        <div class="brand-text brand-sm">
                            <strong class="text-primary">D</strong><strong>A</strong>
                        </div>
                    </a>
                    <!-- Sidebar Toggle Btn-->
                    <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
                </div>
                <div class="right-menu list-inline no-margin-bottom">
                    <div class="list-inline-item">
                        <a href="#" class="search-open nav-link">
                            <i class="icon-magnifying-glass-browser"></i>
                        </a>
                    </div>
                    
                    <!-- Log out -->
                    <div class="list-inline-item logout">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();" 
                                class="nav-link">
                                Logout <i class="icon-logout"></i>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <div class="d-flex align-items-stretch">
        <!-- Sidebar Navigation-->
        <nav id="sidebar">
            <!-- Sidebar Header-->
            <div class="sidebar-header d-flex align-items-center">
                <div class="avatar">
                    <img src="{{ asset('admin/img/avatar-6.jpg') }}" alt="..." class="img-fluid rounded-circle">
                </div>
                <div class="title">
                    <h1 class="h5">Admin</h1>
                    <p>E-Commerce</p>
                </div>
            </div>
            
            <!-- Sidebar Navidation Menus-->
            <ul class="list-unstyled">
                <!-- Dashboard Menu -->
                <li class="{{ $currentRoute == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}"> 
                        <i class="icon-home"></i>Home 
                    </a>
                </li>

                <!-- Category Menu -->
                <li class="{{ 
                    str_contains($currentRoute, 'categories') || 
                    str_contains($currentRoute, 'category') ? 'active' : '' 
                }}">
                    <a href="#categoryDropdown" aria-expanded="{{ 
                        str_contains($currentRoute, 'categories') || 
                        str_contains($currentRoute, 'category') ? 'true' : 'false' 
                    }}" 
                    data-toggle="collapse"
                    class="{{ 
                        str_contains($currentRoute, 'categories') || 
                        str_contains($currentRoute, 'category') ? '' : 'collapsed' 
                    }}">
                        <i class="icon-windows"></i>Category
                    </a>
                    <ul id="categoryDropdown" class="collapse list-unstyled {{ 
                        str_contains($currentRoute, 'categories') || 
                        str_contains($currentRoute, 'category') ? 'show' : '' 
                    }}">
                        <li><a href="{{ route('categories.index') }}" 
                              class="{{ $currentRoute == 'categories.index' ? 'active' : '' }}">
                              All Categories
                          </a></li>
                        <li><a href="{{ route('categories.create') }}" 
                              class="{{ $currentRoute == 'categories.create' ? 'active' : '' }}">
                              Add Category
                          </a></li>
                    </ul>
                </li>

                <!-- Example dropdown -->
                <li>
                    <a href="#exampleDropdown" aria-expanded="false" 
                       data-toggle="collapse" class="collapsed">
                        <i class="icon-windows"></i>Example dropdown
                    </a>
                    <ul id="exampleDropdown" class="collapse list-unstyled">
                        <li><a href="#">Page</a></li>
                        <li><a href="#">Page</a></li>
                        <li><a href="#">Page</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- Sidebar Navigation end-->
        
        <div class="page-content">
            <!-- Dynamic Page Header -->
            @hasSection('page-header')
                @yield('page-header')
            @endif
            
            <!-- Content Area -->
            @yield('content')
            
            <!-- footer -->
            <footer class="footer">
                <div class="footer__block block no-margin-bottom">
                    <div class="container-fluid text-center">
                        <p class="no-margin-bottom">
                            {{ date('Y') }} &copy; Your company. 
                            Download From <a target="_blank" href="https://templateshub.net">Templates Hub</a>.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- JavaScript files-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery.cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admin/js/charts-home.js') }}"></script>
    <script src="{{ asset('admin/js/front.js') }}"></script>
    
    <!-- Add this line for push scripts -->
    @stack('scripts')
</body>

</html>