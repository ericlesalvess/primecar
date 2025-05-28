@extends('adminlte::auth.register')
@push('css')
<style>
  body.register-page {
    background: url('{{ asset('img/bg.jpg') }}') no-repeat center center fixed;
    background-size: cover;
    width: 100vw;
    height: 100vh;
  }
</style>
@endpush
