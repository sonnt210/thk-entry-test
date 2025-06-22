<div class="admin-menu">
    <div class="menu-block">
        <h3 class="title">Site Management</h3>
        <ul>
            <li>
                <a class="link {{ request()->routeIs('adminHotelSearchPage', 'adminHotelSearchResult') ? 'active' : '' }}" href="{{ route('adminHotelSearchPage') }}">Hotel Search</a>
            </li>
            <li>
                <a class="link {{ request()->routeIs('adminHotelCreatePage') ? 'active' : '' }}" href="{{ route('adminHotelCreatePage') }}">Add Hotel</a>
            </li>
            <li>
                <a class="link {{ request()->routeIs('adminBookingSearchPage') ? 'active' : '' }}" href="{{ route('adminBookingSearchPage') }}">Booking Search</a>
            </li>
        </ul>
    </div>
</div>