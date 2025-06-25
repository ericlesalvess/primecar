@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

<nav class="main-header navbar navbar-expand">
  

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        <!-- Botão para alternar o modo escuro -->
    <li class="nav-item">
     <a class="nav-link" href="#" id="toggle-dark-mode" title="Alternar tema">
    <i class="fas fa-moon" id="dark-mode-icon"></i>
    </a>
</li>
        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
 @push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const html = document.documentElement;
        const toggle = document.getElementById('toggle-dark-mode');
        const icon = document.getElementById('dark-mode-icon');
        const navbar = document.querySelector('.main-header.navbar');
        const sidebar = document.getElementById('main-sidebar');

        // Classes para navbar
        const lightNavbar = ['navbar-white', 'navbar-light'];
        const darkNavbar = ['navbar-dark', 'bg-dark'];

    
        // Aplica/remover classes do tema
        function updateNavbarTheme(isDark) {
            navbar.classList.remove(...(isDark ? lightNavbar : darkNavbar));
            navbar.classList.add(...(isDark ? darkNavbar : lightNavbar));
            icon.classList.toggle('fa-moon', !isDark);
            icon.classList.toggle('fa-sun', isDark);
        }

        function updateSidebarTheme(isDark) {
            if (!sidebar) return;

            // Remove classes antigas
            sidebar.classList.forEach(cls => {
                if (cls.startsWith('sidebar-')) {
                    sidebar.classList.remove(cls);
                }
            });

            // Adiciona a classe nova
            sidebar.classList.add(isDark ? 'sidebar-dark-primary' : 'sidebar-light-primary');
        }

        // Lê modo salvo
        const savedDark = localStorage.getItem('adminlte_dark_mode') === 'true';

        // Aplica no HTML e componentes
        html.classList.toggle('dark-mode', savedDark);
        updateNavbarTheme(savedDark);
        updateSidebarTheme(savedDark);

        // Botão de alternância
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            html.classList.toggle('dark-mode');
            const isDark = html.classList.contains('dark-mode');
            localStorage.setItem('adminlte_dark_mode', isDark);
            updateNavbarTheme(isDark);
            updateSidebarTheme(isDark);
        });
    });
</script>
@endpush
</nav>
