<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle text-uppercase">{{ Auth()->user()->roles }}</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Home
            </li>

            <li class="sidebar-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('owner.dashboard') }}">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">
                Categories List
            </li>

            <li class="sidebar-item {{ request()->routeIs('owner.productCategories.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('owner.productCategories.index') }}">
                    <i class="align-middle" data-feather="list"></i> <span class="align-middle">Product
                        Categories</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('owner.discountCategories.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Discount Categories
                </a>
            </li>

            <li class="sidebar-header">
                Product List
            </li>

            <li class="sidebar-item {{ request()->routeIs('owner.product.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="pages-sign-up.html">
                    <i class="align-middle" data-feather="percent"></i> <span class="align-middle">Discount</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('owner.product.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="pages-profile.html">
                    <i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">Product</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('owner.productReviews.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="pages-sign-up.html">
                    <i class="align-middle" data-feather="star"></i> <span class="align-middle">Product Reviews</span>
                </a>
            </li>

            <li class="sidebar-header">
                Orders List
            </li>

            <li class="sidebar-item {{ request()->routeIs('owner.orders.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="ui-buttons.html">
                    <i class="align-middle" data-feather="shopping-cart"></i> <span class="align-middle">Orders</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('owner.orders.details') ? 'active' : '' }}">
                <a class="sidebar-link" href="ui-forms.html">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Order Details</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('owner.deliveries.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="ui-cards.html">
                    <i class="align-middle" data-feather="box"></i> <span class="align-middle">Deliveries</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('owner.payments.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="ui-typography.html">
                    <i class="align-middle" data-feather="credit-card"></i> <span class="align-middle">Payments</span>
                </a>
            </li>

            <li class="sidebar-header">
                Data
            </li>

            <li class="sidebar-item {{ request()->routeIs('owner.customers.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="ui-typography.html">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Customers</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
