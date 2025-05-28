<nav class="navbar navbar-expand-lg" style="padding: 0; position: relative; background: transparent;">
    <div class="container-fluid" style="padding: 0;">
        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center w-100" style="padding: 0;">
            <button type="button" id="sidebarCollapse" class="btn btn-primary me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; padding: 0; position: relative; z-index: 2;">
                <i class="bi bi-list" style="font-size: 1.5rem;"></i>
            </button>
            <h1 class="m-0 text-center w-100 mb-0 mb-lg-0 mt-1" style="position: absolute; left: 50%; transform: translateX(-50%); pointer-events: none; top: 0;">@yield('header', 'Welcome to BGDS')</h1>
            <div class="ms-auto user-profile d-none d-lg-flex align-items-center" style="padding: 0; position: relative; z-index: 2;">
                <div class="d-flex align-items-center" style="padding: 0;">
                    <i class="bi bi-person-circle" style="font-size: 2rem;"></i>
                    <span class="fw-bold ms-2">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </div>
    </div>
</nav> 

<style>
    @media (max-width: 768px) {
        .navbar h1 {
            position: relative !important;
            left: 0 !important;
            transform: none !important;
            margin-top: 0.5rem !important;
        }
    }
</style> 