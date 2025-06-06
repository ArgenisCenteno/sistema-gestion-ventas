@extends('layouts.app')

@section('content')
<section class="vh-100"
  style="background-image: url('https://images.pexels.com/photos/135620/pexels-photo-135620.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'); background-repeat: no-repeat; background-size: cover;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-6">
        <div class="card" style="border-radius: 1rem;">
          <div class="d-flex align-items-center">
            <div class="card-body p-4 p-lg-5 text-black">

              <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="d-flex justify-content-center align-items-center mb-3 pb-1">
               {{--  <img src="{{ asset('iconos/logo-final.png') }}" alt="logo" width="200px"> --}}  
                </div>

                <h3 class="fw-bold mb-3 pb-3 text-center" style="letter-spacing: 1px;">Ingresar al sistema</h5>

                <!-- Email -->
                <div class="form-outline mb-4">
                  <label class="form-label fw-bold" for="email">Email</label>
                  <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" placeholder="Ingresar email" required>
                  @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Contraseña -->
                <div class="form-outline mb-4">
                  <label class="form-label fw-bold" for="password">Contraseña</label>
                  <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" placeholder="Ingresar contraseña" required>
                  @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Botón de Ingreso -->
                <div class="pt-1 mb-4">
                  <button class="btn btn-dark btn-lg  w-100" type="submit">Acceder</button>
                </div>

                <!-- Enlaces adicionales -->
             {{-- 
             
              <div class="text-center">
                  <a class="text-decoration-none" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                </div>
                <div class="text-center mt-2">
                  <span>¿No tienes una cuenta? <a class="fw-bold text-decoration-none" href="{{ route('register') }}">Regístrate</a></span>
                </div>
             --}}  

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
