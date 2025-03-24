<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/">WebSecService</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('purchases.index') }}">My Purchases</a>
                </li>
                @can('create-employees')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employees.create') }}">Create Employee</a>
                    </li>
                @endcan
                @can('view-customers')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employees.customers') }}">Customers</a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.profile') }}">Profile</a>
                </li>
                @if (auth()->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('do_logout') }}">Logout</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>