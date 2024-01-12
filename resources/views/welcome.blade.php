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
                padding: 20px;
            }

            .parent {
                min-height: calc(100vh - 20px);
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
                background: #4C53F8;
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
    <body class="antialised">
    <div class="d-flex align-items-center justify-content-center position-relative overflow-hidden w-100 parent">
        <div class="shape-2 rounded"></div>
    <div class="shape-1 rounded"></div>
        <div class="wrapper rounded shadow bg-white position-relative">
            <img src="{{ asset('image') }}/logo.png" class="position-absolute bg-white shadow image-logo">

              <form method="POST" action="{{ route('parent.auth') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="nis" class="col-md-12 col-form-label">{{ __('NIS Siswa') }}</label>

                            <div class="col-md-12">
                                <input id="nis" type="number" class="form-control @error('nis') is-invalid @enderror" name="nis" value="{{ old('nis') }}" required autocomplete="off" autofocus>

                                @error('nis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-12 col-form-label">{{ __('Password') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-login d-inline-block w-100 text-white fw-bold">
                                    {{ __('Masuk') }}
                                </button>
                            </div>
                        </div>
                    </form>
        </div>
    </div>
    

        {{--  scripts  --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
