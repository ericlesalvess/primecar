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
    </ul>
    @push('js')
    <script>
        
        document.addEventListener('DOMContentLoaded', function () {
            const html = document.documentElement;
            const toggle = document.getElementById('toggle-dark-mode');
            const icon = document.getElementById('dark-mode-icon');
            const navbar = document.querySelector('.main-header.navbar');
            const sidebar = document.querySelector('.main-sidebar');
            const sidebarLight = 'sidebar-light-primary';
            const sidebarDark = 'sidebar-dark-primary';
    
            // Classes para dark e light mode
            const lightClasses = ['navbar-white', 'navbar-light'];
            const darkClasses = ['navbar-dark', 'bg-dark'];
    
            // Função para aplicar classes conforme o tema
            function updateNavbarTheme(isDark) {
                if (isDark) {
                    navbar.classList.remove(...lightClasses);
                    navbar.classList.add(...darkClasses);
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                } else {
                    navbar.classList.remove(...darkClasses);
                    navbar.classList.add(...lightClasses);
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                }
            }
    
            function updateSidebarTheme(isDark) {
                if (!sidebar) return;
                if (isDark) {
                    sidebar.classList.remove(sidebarLight);
                    sidebar.classList.add(sidebarDark);
                } else {
                    sidebar.classList.remove(sidebarDark);
                    sidebar.classList.add(sidebarLight);
                }
            }
    
            // Verifica a preferência salva
            const savedDark = localStorage.getItem('adminlte_dark_mode') === 'true';
            html.classList.toggle('dark-mode', savedDark);
            updateNavbarTheme(savedDark);
            updateSidebarTheme(savedDark);
    
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

<style>
.main-sidebar,.main-header.navbar, body,
html {
    transition: background-color 0.3s, color 0.4s;
}
</style>
