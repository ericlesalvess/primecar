@extends('adminlte::auth.login')
@push('css')
<style>
   body.login-page {
    background: url('{{ asset('img/bg.jpg') }}') no-repeat center center fixed;
    background-size: 100% 100%;
    width: 100vw;
    height: 100vh;
}
</style>
@endpush