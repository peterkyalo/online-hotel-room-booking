<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('customer_home') }}">Customer Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('customer_home') }}"></a>
        </div>

        <ul class="sidebar-menu">

            <li class="{{ Request::is('customer/home') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('customer_home') }}"><i class="fa fa-hand-o-right"></i>
                    <span>Dashboard</span></a></li>

            <li class="{{ Request::is('customer/order/*') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('customer_order_view') }}">
                    <i class="fa fa-hand-o-right"></i>
                    <span>Orders</span></a></li>

            {{-- Hotel Section Dropdown --}}
            {{-- <li
                class="nav-item dropdown {{ Request::is('customer/amenity/view') || Request::is('customer/room/view') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-hand-o-right"></i><span>
                        Hotel Section</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('customer/amenity/view') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('customer_amenity_view') }}"><i class="fa fa-angle-right"></i>
                            Amenities</a></li>
                    <li class="{{ Request::is('customer/room/view') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('customer_room_view') }}"><i class="fa fa-angle-right"></i>
                            Rooms</a></li>
                </ul>
            </li> --}}

            {{-- <li class="{{ Request::is('customer/faq/*') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('customer_faq_view') }}">
                    <i class="fa fa-hand-o-right"></i>
                    <span>FAQ</span></a></li> --}}

        </ul>
    </aside>
</div>
