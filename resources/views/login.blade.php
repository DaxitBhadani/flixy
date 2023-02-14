<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('/assets/img/life-48.png') }}" type="image/x-icon">
    <title>Flixy - Login </title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
   
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            max-width: 330px;
            padding: 15px;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin label {
            margin-bottom: 10px;
        }
    </style>
</head>

<body class="theme-dark" style="background-color: #171923">
    <main class="form-signin w-100 m-auto">
        @if (Session::has('message'))
            <div class="center-h alert-err fixed-alert mb-4 ">
                <div class="d-flex ">
                    <div class="px-2 m-0 center ">
                        <iconify-icon icon="ep:warning-filled" class="font-alert"></iconify-icon>
                    </div>
                    <div class="center">
                        <span class="m-0 alert-title-salon gil-reg font-16">{{ Session::get('message') }}</span>
                    </div>
                </div>
            </div>
        @endif
        <form method="POST" action="doLogin">
            <div class="form-signin-title">
                <h2 class="mb-3 text-white fw-normal">Log in</h2>
            </div>
            @csrf
            <div class="form-group">
                <label for="floatingInput">User name</label>
                <input name="username" type="text" class="form-control" id="floatingInput" placeholder="User Name"
                    required>
            </div>
            <div class="form-group">
                <label for="floatingPassword">Password</label>
                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password"
                    required>
            </div>
            <button class="w-100 btn btn-lg btn-primary theme-bg mt-4" type="submit">Log in</button>
        </form>
    </main>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
