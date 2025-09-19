@extends('layouts.guest')
@section('title','ERROR INTERNO DEL SERVIDOR')
@section('content')
<style>
  .content-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column; 
    height: 100%;
    text-align: center;
    padding: 20px;
  }
  .error-code {
    font-size: clamp(90px, 18vw, 200px);
    font-weight: bold;
    margin-bottom: 20px;
    color: #000;
  }
  .error-message {
    display: inline-block;
    background: #fff;
    color: #e67e22;
    font-size: clamp(20px, 4vw, 36px);
    font-weight: bold;
    padding: 10px 30px;
    border-radius: 50px;
    margin-bottom: 30px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
  }
  .error-details {
    background: #f9f9f9;
    border-left: 5px solid #e67e22;
    padding: 15px;
    margin-bottom: 30px;
    max-width: 700px;
    width: 100%;
    text-align: left;
    font-size: 16px;
  }
  .btn-regresar {
    background: #000;
    color: #fff;
    padding: clamp(14px, 2.5vw, 20px) clamp(40px, 6vw, 60px);
    border: none;
    border-radius: 10px;
    font-size: clamp(18px, 2.2vw, 24px);
    font-weight: bold;
    text-decoration: none;
    transition: 0.3s;
  }
  .btn-regresar:hover {
    background: #333;
    color: #fff;
  }

  @media (max-width: 480px) {
    .error-code {
        font-size: 26vw;
    }
    .error-message {
        font-size: 6vw;
    }
  }
</style>

<div class="content-wrapper">
    <div class="error-code">500</div>
    <div class="error-message">ERROR INTERNO DEL SERVIDOR</div>

    <div class="error-details">
        <p><strong>FECHA Y HORA:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>ERROR:</strong> {{ $exception->getMessage() ?? 'Se produjo un error inesperado en el servidor.' }}</p>
        <p><strong>INSTRUCCIONES:</strong> POR FAVOR REALICE CAPTURA DE PANTALLA Y ENVIE AL ADMINISTRADOR DEL SISTEMA LO ANTES POSIBLE.</p>
    </div>

    <a href="{{ route('login') }}" class="btn-regresar">REGRESAR</a>
</div>
@endsection
