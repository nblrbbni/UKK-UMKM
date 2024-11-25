<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('owner.dashboard') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">{{ Auth()->user()->roles }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Home</span>
        </li>

        <li class="menu-item {{ Request::routeIs('owner.dashboard') ? 'active' : '' }}">
            <a href="{{ route('owner.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-home"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Categories</span>
        </li>

        <li class="menu-item {{ Request::routeIs('owner.discountCategories.index') ? 'active' : '' }}">
            <a href="{{ route('owner.discountCategories.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-coupon"></i>
                <div>Discount Categories</div>
            </a>
        </li>

        <li class="menu-item {{ Request::routeIs('owner.productCategories.index') ? 'active' : '' }}">
            <a href="{{ route('owner.productCategories.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-shopping-bags"></i>
                <div>Product Categories</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Shop</span>
        </li>

        <li class="menu-item {{ Request::routeIs('owner.discounts.index') ? 'active' : '' }}">
            <a href="{{ route('owner.discounts.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-discount"></i>
                <div>Discounts</div>
            </a>
        </li>

        <li class="menu-item {{ Request::routeIs('owner.products.index') ? 'active' : '' }}">
            <a href="{{ route('owner.products.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-store"></i>
                <div>Products</div>
            </a>
        </li>

        <li class="menu-item {{ Request::routeIs('owner.orders.*') ? 'active' : '' }}">
            <a href="{{ route('owner.orders.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-cart"></i>
                <div>Orders</div>
            </a>
        </li>

        <li class="menu-item {{ Request::routeIs('owner.wishlists.*') ? 'active' : '' }}">
            <a href="{{ route('owner.wishlists.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-heart"></i>
                <div>Wishlists</div>
            </a>
        </li>
    </ul>
</aside>
<!-- / Menu -->
