@extends('adminlte::auth.login')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const html = document.documentElement;
        const savedDark = localStorage.getItem('adminlte_dark_mode') === 'true';
        html.classList.toggle('dark-mode', savedDark);
    });
</script>