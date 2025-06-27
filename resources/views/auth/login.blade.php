@extends('adminlte::auth.login')

@push('css')
<link rel="stylesheet" href="{{ asset('css/custom-login.css') }}">
@endpush

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const html = document.documentElement;
        const savedDark = localStorage.getItem('adminlte_dark_mode') === 'true';
        html.classList.toggle('dark-mode', savedDark);
    }); 
    
</script>
<style>
  /* Adiciona um overlay escuro (opcional, mas recomendado para legibilidade) */
        .login-page::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Overlay preto com 50% de opacidade */
            z-index: -1; /* Coloca o overlay atrás do conteúdo do formulário */
        }
 </style>           