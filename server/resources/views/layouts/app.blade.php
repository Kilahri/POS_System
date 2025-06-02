<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'POS System') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        .navbar-brand {
            font-weight: 600;
        }
        .main-content {
            padding: 2rem 0;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'POS System') }}
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/products') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/categories') }}">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/transactions') }}">Transactions</a>
                        </li>
                        @auth
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/reports') }}">Reports</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                    
                    <ul class="navbar-nav">
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ url('/profile') }}">Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ url('/logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/login') }}">Login</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-light mt-5 py-4">
            <div class="container text-center">
                <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'POS System') }}. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>