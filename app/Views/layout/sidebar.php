<!-- app/Views/layout/sidebar.php -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-wpforms"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Form Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/admin">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Manajemen -->
    <div class="sidebar-heading">
        Manajemen
    </div>

    <li class="nav-item">
        <a class="nav-link" href="/admin/forms">
            <i class="fas fa-fw fa-list"></i>
            <span>Form</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="/logout">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>
