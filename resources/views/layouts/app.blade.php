<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('/assets/img/life-48.png') }}" type="image/x-icon">
    <title> Flixy </title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.rawgit.com/lcdsantos/jQuery-Selectric/master/public/selectric.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/app-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
</head>

<body class="theme-dark">
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex">
                        <div class="logo">
                            <a href="{{ url('/index') }}" class="d-flex align-items-center">
                                <span class="logo-name">Flixy</span>
                            </a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i
                                    class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-item">
                            <a href="{{ url('/index') }}"
                                class="sidebar-link {{ request()->is('/index') ? 'active' : '' }}">
                                <i data-feather="home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('contentList') }}"
                                class="sidebar-link {{ request()->is('contentList') ? 'active' : '' }}">
                                <i data-feather="layers"></i>
                                <span>Content</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('language') }}"
                                class="sidebar-link {{ request()->is('language') ? 'active' : '' }}">
                                <i data-feather="type"></i>
                                <span>Language</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('genre') }}"
                                class="sidebar-link {{ request()->is('genre') ? 'active' : '' }}">
                                <i data-feather="tag"></i>
                                <span>Genre</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('actors') }}"
                                class="sidebar-link {{ request()->is('actors') ? 'active' : '' }}">
                                <i data-feather="users"></i>
                                <span>Actors</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('tvCategory') }}"
                                class="sidebar-link {{ request()->is('tvCategory') ? 'active' : '' }}">
                                <i data-feather="box"></i>
                                <span>Live TV Category</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('tvChannel') }}"
                                class="sidebar-link {{ request()->is('tvChannel') ? 'active' : '' }}">
                                <i data-feather="tv"></i>
                                <span>Live TV Channel</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('user') }}"
                                class="sidebar-link {{ request()->is('user') ? 'active' : '' }}">
                                <i data-feather="users"></i>
                                <span>Users</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x">
                    <i data-feather="x"></i>
                </button>
            </div>
        </div>
        <div id="main">
            <header class="d-flex align-items-center justify-content-between">
                <a href="#" class="burger-btn d-block ">
                    <i class="bi bi-list fs-3"></i>
                </a>
                <div class="btn-group me-1 mb-1">
                    <div class="dropdown">


                        <button type="button" class="btn btn-success border-0 green px-4 d-flex align-items-center"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Logout

                            <i class="bi bi-door-open-fill ms-2"></i>

                        </button>

                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="logout">
                                Log Out
                            </a>

                        </div>
                    </div>
                </div>
            </header>
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- selectric --}}
    <script src="https://cdn.rawgit.com/lcdsantos/jQuery-Selectric/master/public/jquery.selectric.js"></script>
    <script>
        feather.replace();
        $(document).ready(function() {
            // $('.select2').select2();
            $('select').selectric();
        });
    </script>
    @yield('scripts')
</body>

</html>
