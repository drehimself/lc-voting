<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ route('home') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                
                <div class="sb-sidenav-menu-heading">Business Tools</div>
                <a class="nav-link" href="{{ route('tasks.index',['view' => 'kanban']) }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Tasks
                </a>
                <a class="nav-link" href="{{ route('leads.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Sales Leads
                </a>
                <a class="nav-link" href="{{ route('customers.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Customers
                </a>
                <a class="nav-link" href="{{ route('ledger.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Ledger
                </a>
                <a class="nav-link" href="{{ route('subscriptions.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Subscriptions
                </a>
            </div>
        </div>
        @auth
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                {{ auth()->user()->name }}
            </div>
        @endauth
    </nav>
</div>