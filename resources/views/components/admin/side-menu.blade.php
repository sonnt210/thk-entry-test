<div class="admin-menu">
    <div class="menu-block">
        <h3 class="title">サイト管理</h3>
        <ul>
            <li>
                <a class="link {{ request()->routeIs('adminHotelSearchPage', 'adminHotelSearchResult') ? 'active' : '' }}" href="{{ route('adminHotelSearchPage') }}">ホテル検索</a>
            </li>
            <li>
                <a class="link {{ request()->routeIs('adminHotelCreatePage') ? 'active' : '' }}" href="{{ route('adminHotelCreatePage') }}">ホテル追加</a>
            </li>
        </ul>
    </div>
</div>