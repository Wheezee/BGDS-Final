<!-- Sidebar -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h3>BGDS</h3>
    </div>

    <ul class="list-unstyled">
        <li>
            <a href="/dashboard" class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="/residents" class="sidebar-link {{ request()->is('residents*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Residents
            </a>
        </li>
        @if(in_array(auth()->user()->role, ['superadmin', 'admin', 'barangay_chairman', 'barangay_secretary']))
        <li>
            <a href="#" class="sidebar-link {{ request()->is('projects*') ? 'active' : '' }}" data-bs-toggle="collapse" data-bs-target="#projectsSubmenu">
                <i class="bi bi-kanban"></i> Plans and Projects
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul class="collapse list-unstyled {{ request()->is('projects*') ? 'show' : '' }}" id="projectsSubmenu">
                <li>
                    <a href="{{ route('projects.index', ['type' => 'BDP']) }}" class="sidebar-link">
                        <i class="bi bi-building"></i> BDP Projects
                    </a>
                </li>
                <li>
                    <a href="{{ route('projects.index', ['type' => 'Calamity']) }}" class="sidebar-link">
                        <i class="bi bi-exclamation-triangle"></i> Calamity Projects
                    </a>
                </li>
            </ul>
        </li>
        @endif
        @if(in_array(auth()->user()->role, ['superadmin', 'admin', 'barangay_chairman', 'barangay_secretary']))
        <li>
            <a href="/meetings" class="sidebar-link {{ request()->is('meetings*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i> Meetings
            </a>
        </li>
        @endif
        @if(in_array(auth()->user()->role, ['superadmin', 'admin', 'barangay_chairman', 'barangay_secretary', 'barangay_treasurer']))
        <li>
            <a href="/finance" class="sidebar-link {{ request()->is('finance*') ? 'active' : '' }}">
                <i class="bi bi-cash-coin"></i> Financial Records
            </a>
        </li>
        @endif
        @if(in_array(auth()->user()->role, ['superadmin']))
        <li>
            <a href="/users" class="sidebar-link {{ request()->is('users*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> User Management
            </a>
        </li>
        @endif
        <li>
            <a href="/userProfile" class="sidebar-link {{ request()->is('userProfile*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> User Profile
            </a>
        </li>
        <li>
            <button id="darkModeToggle" class="sidebar-link w-100 text-start border-0 bg-transparent" style="color: inherit;">
                <i class="bi bi-moon-fill"></i> Dark Mode
            </button>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-100 text-start border-0 bg-transparent" style="color: inherit;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</nav> 