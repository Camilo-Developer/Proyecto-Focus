@extends('layouts.guest')
@section('title','NO AUTORIZADO')
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
    margin-bottom: 40px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
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
    <div class="error-code">401</div>
    <div class="error-message">NO AUTORIZADO</div>
    <a href="{{ route('login') }}" class="btn-regresar">REGRESAR</a>
</div>
@endsection

