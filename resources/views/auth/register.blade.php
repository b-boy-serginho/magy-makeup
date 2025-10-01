@extends('layouts.guest')

@section('content')
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" 
         style="background: linear-gradient(rgba(204, 92, 184, 0.8), rgba(56, 20, 50, 0.9)), position: relative;">
        <!-- url('{{ asset('images/fondo1.jpg') }}') center/cover no-repeat;  -->
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: none; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #CC5CB8, #381432); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                <svg class="icon" style="color: white; width: 40px; height: 40px;">
                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-star') }}"></use>
                                </svg>
                            </div>
                            <h1 style="color: #212529; font-weight: 700; margin-bottom: 0.5rem;">{{ __('MAGY MAKEUP') }}</h1>
                            <p style="color: #6c757d; font-size: 1.1rem;">{{ __('Crear Cuenta') }}</p>
                        </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- NOMBRE --}}
                    <div class="mb-3">
                        <label for="name" class="form-label" style="color: #212529; font-weight: 600;">Nombre</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: linear-gradient(135deg, #CC5CB8, #381432); color: white; border: none; border-radius: 12px 0 0 12px;">
                                <svg class="icon">
                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                                </svg>
                            </span>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" 
                                   id="name" placeholder="{{ __('Ingresa tu nombre') }}" required
                                   autocomplete="name" autofocus
                                   style="border: 2px solid #e9ecef; border-radius: 0 12px 12px 0; padding: 0.75rem; background: rgba(255, 255, 255, 0.9);">
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block" style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label for="email" class="form-label" style="color: #212529; font-weight: 600;">Email</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: linear-gradient(135deg, #CC5CB8, #381432); color: white; border: none; border-radius: 12px 0 0 12px;">
                                <svg class="icon">
                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-envelope-open') }}"></use>
                                </svg>
                            </span>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" 
                                   id="email" placeholder="{{ __('Ingresa tu email') }}" required
                                   autocomplete="email"
                                   style="border: 2px solid #e9ecef; border-radius: 0 12px 12px 0; padding: 0.75rem; background: rgba(255, 255, 255, 0.9);">
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block" style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CONTRASEÑA --}}
                    <div class="mb-3">
                        <label for="password" class="form-label" style="color: #212529; font-weight: 600;">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: linear-gradient(135deg, #CC5CB8, #381432); color: white; border: none; border-radius: 12px 0 0 12px;">
                                <svg class="icon">
                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-lock-locked') }}"></use>
                                </svg>
                            </span>
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                   name="password" id="password" placeholder="{{ __('Ingresa tu contraseña') }}" 
                                   required autocomplete="new-password"
                                   style="border: 2px solid #e9ecef; border-radius: 0; padding: 0.75rem; background: rgba(255, 255, 255, 0.9);">
                                   <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                👁️
                                </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block" style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CONFIRMAR CONTRASEÑA --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label" style="color: #212529; font-weight: 600;">Confirmar Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: linear-gradient(135deg, #CC5CB8, #381432); color: white; border: none; border-radius: 12px 0 0 12px;">
                                <svg class="icon">
                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-lock-locked') }}"></use>
                                </svg>
                            </span>
                            <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password"
                                   name="password_confirmation" id="password_confirmation" placeholder="{{ __('Confirma tu contraseña') }}" 
                                   required autocomplete="new-password"
                                   style="border: 2px solid #e9ecef; border-radius: 0 12px 12px 0; padding: 0.75rem; background: rgba(255, 255, 255, 0.9);">
                                   <button type="button" class="btn btn-outline-secondary" id="togglePassword2">
                                👁️
                                </button>
                                </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block" style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- BOTÓN REGISTRO --}}
                    <div class="d-grid gap-2">
                        <button class="btn btn-lg" type="submit"
                                style="background: linear-gradient(135deg, #CC5CB8, #381432); color: white; border: none; border-radius: 12px; padding: 0.75rem; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease;"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(204, 92, 184, 0.3)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            {{ __('Crear Cuenta') }}
                        </button>
                    </div>

                    {{-- ENLACE LOGIN --}}
                    <div class="text-center mt-4">
                        <p style="color: #6c757d; margin-bottom: 0.5rem;">{{ __('¿Ya tienes cuenta?') }}</p>
                        <a href="{{ route('login') }}" 
                           style="color: #CC5CB8; text-decoration: none; font-weight: 600; font-size: 1rem;"
                           onmouseover="this.style.color='#381432'"
                           onmouseout="this.style.color='#CC5CB8'">
                            {{ __('Iniciar sesión aquí') }}
                        </a>
                    </div>

                </form>
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

        // Mostrar/ocultar contraseña para el campo "Confirmar Contraseña"
    document.getElementById('togglePassword2').addEventListener('click', function () {
        const passwordInput2 = document.getElementById('password_confirmation');
        const type2 = passwordInput2.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput2.setAttribute('type', type2);

        // Cambiar icono
        this.textContent = type2 === 'password' ? '👁️' : '🙈';
    });
    </script>

@endsection