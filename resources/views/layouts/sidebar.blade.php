<style>
    :root {
        --primary-color: #007bff;
        --sidebar-width: 250px;
        --transition-timing: 0.3s;
    }

    .sidebar-container {
        position: relative;
        z-index: 1000;
    }

    .sidebar {
        position: fixed;
        top: 100px;
        left: calc(-1 * var(--sidebar-width));
        width: var(--sidebar-width);
        height: calc(100vh - 120px);
        background: #ffffff;
        box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
        transition: transform var(--transition-timing) ease-in-out;
        z-index: 1000;
        padding: 1rem 0;
        overflow-y: auto;
    }

    .sidebar.open {
        transform: translateX(var(--sidebar-width));
    }

    .sidebar .list-group-item {
        border: none;
        border-radius: 8px;
        margin: 0.5rem 1rem;
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
        color: #2d3748;
        transition: all 0.2s ease;
    }

    .sidebar .list-group-item-action {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .sidebar .list-group-item-action:hover {
        background: #f8f9fa;
        transform: translateX(5px);
    }

    .sidebar .list-group-item-action.active {
        background: var(--primary-color);
        color: white !important;
        font-weight: 500;
    }

    .sidebar-toggle {
        position: fixed;
        top: 110px;
        left: 20px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        z-index: 1100;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
    }

    .sidebar-toggle:hover {
        transform: scale(1.05);
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .sidebar {
            top: 70px;
            height: calc(100vh - 80px);
        }

        .sidebar-toggle {
            top: 80px;
            left: 10px;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 999;
            display: none;
        }

        .sidebar.open + .sidebar-overlay {
            display: block;
        }
    }
</style>

<div class="sidebar-container">
    <button class="sidebar-toggle" id="sidebar-toggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <div class="sidebar">
        <div class="list-group list-group-flush">
            <a href="{{ route('admin_authors') }}" 
               class="list-group-item list-group-item-action {{ request()->routeIs('admin_authors') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Authors Management</span>
            </a>
            
            <a href="{{ route('admin_books') }}" 
               class="list-group-item list-group-item-action {{ request()->routeIs('admin_books') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                <span>Books Management</span>
            </a>
        </div>
    </div>
    
    <div class="sidebar-overlay"></div>
</div>

<script>
    const toggleBtn = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('open');
        }
    });
</script>