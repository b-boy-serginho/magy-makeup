@extends('layouts.guest')

@section('content')
    <div class="col-lg-8">
        <div class="card-group d-block d-md-flex row">
            <div class="card col-md-7 p-4 mb-0">
                <div class="card-body">
                    <h1>{{ __('Iniciar sesión') }}</h1>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        {{-- EMAIL --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <svg class="icon">
                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-envelope-open') }}"></use>
                                </svg>
                            </span>
                            <input class="form-control @error('email') is-invalid @enderror"
                                   type="text"
                                   name="email"
                                   placeholder="{{ __('Email') }}"
                                   required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="input-group mb-4">
                            <span class="input-group-text">
                                <svg class="icon">
                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-lock-locked') }}"></use>
                                </svg>
                            </span>
                            <input id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   type="password"
                                   name="password"
                                   placeholder="{{ __('Password') }}"
                                   required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                👁️
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- BOTÓN LOGIN --}}
                        <div class="row">
                            <button class="px-4 btn" type="submit"
                                    style="background-color:#e83e8c; color:white;">
                                {{ __('Ingresar') }}
                            </button>

                            @if (Route::has('password.request'))
                                {{-- <div class="mt-2">
                                    <a href="{{ route('password.request') }}" class="btn btn-link px-0">
                                        {{ __('¿Olvidaste tu contraseña?') }}
                                    </a>
                                </div> --}}
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- TARJETA DERECHA --}}
            <div class="card col-md-5 text-white py-5" style="background-color:#e83e8c;">
                <div class="card-body text-center">
                    <div>
                        <h2>{{ __('Crear Cuenta') }}</h2>
                        <a href="{{ route('register') }}"
                           class="btn btn-lg btn-outline-light mt-3">
                            {{ __('Aqui') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT para mostrar/ocultar contraseña --}}
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Cambiar icono (opcional)
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    </script>
@endsection
