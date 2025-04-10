<style>
:root {
    --primary-color: #4361ee;
    --navbar-bg: rgba(7, 31, 59, 0.95);
    --navbar-text: #ffffff;
    --navbar-hover: rgba(255, 255, 255, 0.1);
    --navbar-active: var(--primary-color);
    --transition-speed: 0.3s;
}

.navbar {
    background-color: var(--navbar-bg);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    padding: 0.5rem 1rem;
    transition: all var(--transition-speed) ease;
}

.navbar-brand img {
    transition: transform 0.3s ease;
    height: 50px;
}

.navbar-brand:hover img {
    transform: scale(1.05);
}

.navbar-nav {
    width: 100%;
    justify-content: center;
    gap: 1rem;
}

.nav-link {
    color: var(--navbar-text);
    font-weight: 500;
    padding: 0.5rem 1rem;
    position: relative;
    transition: all var(--transition-speed) ease;
    border-radius: 4px;
}

.nav-link:hover {
    color: var(--navbar-text);
    background-color: var(--navbar-hover);
    text-shadow: 0 0 8px rgba(255, 255, 255, 0.3);
}

.nav-link.active {
    color: white;
    font-weight: 600;
}

.nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 30px;
    height: 3px;
    background-color: var(--navbar-active);
    border-radius: 2px;
}

.dropdown-menu {
    background-color: var(--navbar-bg);
    border: none;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.dropdown-item {
    color: var(--navbar-text);
    transition: all var(--transition-speed) ease;
}

.dropdown-item:hover {
    background-color: var(--navbar-hover);
    color: var(--navbar-text);
}

.avatar img {
    border: 2px solid rgba(255, 255, 255, 0.2);
    transition: all var(--transition-speed) ease;
}

.avatar:hover img {
    border-color: var(--navbar-active);
}

.navbar-toggler {
    border: none;
    color: var(--navbar-text);
    padding: 0.5rem;
}

.navbar-toggler:focus {
    box-shadow: none;
}

@media (max-width: 991.98px) {
    .navbar-collapse {
        background-color: var(--navbar-bg);
        padding: 1rem;
        margin-top: 0.5rem;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .nav-link {
        margin: 0.25rem 0;
    }
    
    .nav-link.active::after {
        display: none;
    }
}
</style>
<nav class="navbar navbar-expand-lg navbar-dark 
    @unless(request()->is('dashboard*', 'orders*'))fixed-top @endunless"
    data-bs-theme="dark">
    <div class="container">
        <!-- Brand/Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="/storage/images/logo_white.png" alt="Book Store Logo">
        </a>
        
        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" 
                data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('/'))active @endif" 
                       href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                
                @auth
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('orders*'))active @endif" 
                       href="{{ route('borrowed_books') }}">
                        <i class="fas fa-book-open me-1"></i> Borrowed Books
                    </a>
                </li>
                
                @role('Administrator')
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('dashboard*'))active @endif" 
                       href="{{ route('admin_books') }}">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </a>
                </li>
                @endrole
                @endauth

                <!-- Authors Section -->
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('authors*'))active @endif" 
                       href="{{ route('authors') }}">
                        <i class="fas fa-users me-1"></i> Authors
                    </a>
                </li>

            </ul>
            
            <!-- User Section -->
            <div class="d-flex align-items-center">
                @auth
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" 
                       id="userDropdown" data-bs-toggle="dropdown">
                        <img src="{{ Auth::user()->avatar_url ?? 'https://mdbcdn.b-cdn.net/img/new/avatars/2.webp' }}" 
                             class="rounded-circle me-2" width="32" height="32">
                        <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                      
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }} ">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
