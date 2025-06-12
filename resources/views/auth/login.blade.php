@extends('layouts.guest')
@section('title','INICIAR SESIÓN')
@section('content')
@auth
<div class="d-flex justify-content-center align-items-center vh-100">
  <div class="card p-4  text-white" style="background: #00000080; max-width: 600px; border-radius: 15px;">
    <div class="text-center mt-3 mb-4">
      <img src="{{asset('Imagenes2/Focus.png')}}" alt="FOCUS" class="img-fluid" style="max-width: 375px;">
    </div>
      <div>
        <a href="{{route('admin.dashboard')}}" class="btn btn-warning btn-lg w-100">REGRESAR AL PANEL ADMINISTATIVO</a>
      </div>
  </div>
</div>
@endauth
@guest
<div class="d-flex justify-content-center align-items-center vh-100">
  <div class="card p-4  text-white" style="background: #00000080; max-width: 600px; border-radius: 15px;">
    <div class="text-center mt-3 mb-4">
      <img src="{{asset('Imagenes2/Focus.png')}}" alt="FOCUS" class="img-fluid" style="max-width: 375px;">
    </div>
    <form action="{{route('login')}}" method="post">
      @csrf
      @if (session('status'))
        <div class="alert alert-info">
          {{ session('status') }}
        </div>
      @endif
      <div class="mb-3">
        <input type="email" name="email" class="form-control form-control-lg bg-light text-dark" id="form3Example3" placeholder="CORREO" required>
        @error('email')
          <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control form-control-lg bg-light text-dark" id="form3Example4" placeholder="CONTRASEÑA" required>
      </div>
      <div>
        <button type="submit" class="btn btn-warning btn-lg w-100">INGRESAR</button>
      </div>
    </form>
  </div>
</div>
@endguest
@endsection
