<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Zie Rules</title>

        {{--  jquery  --}}
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <style>
            body {
                min-height: 100vh;
                background-image: linear-gradient(135deg, #4C53F8, #4C53F830);
            }

            .image-logo {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                left: 50%;
                top: -50px;
                transform: translateX(-50%);
            }

            .wrapper {
                width: clamp(350px, 100%, 400px);
                padding: 70px 30px 50px;
            }

            .btn.btn-login {
                background: linear-gradient(135deg, #4C53F8, #4C53F830);
                transition: .7s;
                border: none;
            }

            .btn.btn-login:hover {
                transform: scale(.96);
            }
            
            .shape-1 {
                width: 400px;
                height: 400px;
                transform: rotate(45deg);
                background: #FFFFFF10;
                backdrop-filter: blur(50px);
                position: absolute;
            }
            
            .shape-2 {
                width: 500px;
                height: 500px;
                transform: rotate(45deg);
                background: #FFFFFF10;
                backdrop-filter: blur(50px);
                position: absolute;
            }
            
        </style>
       
    </head>
    <body class="antialised d-flex align-items-center justify-content-center position-relative overflow-hidden">
    <div class="shape-2 rounded"></div>
    <div class="shape-1 rounded"></div>
        <div class="wrapper rounded shadow bg-white position-relative">
            <img src="{{ asset('image') }}/logo.png" class="position-absolute bg-white shadow image-logo">

              <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-12 col-form-label">{{ __('Email Address') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-12 col-form-label">{{ __('Password') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-login d-inline-block w-100 text-white fw-bold">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
        </div>

        {{--  scripts  --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
