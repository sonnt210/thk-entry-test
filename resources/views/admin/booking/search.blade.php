@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/search.scss')
@endsection

@section('main_contents')
<div class="page-wrapper search-page-wrapper">
    <h2 class="title">Booking Search</h2>
    <hr>

    {{-- Search Form --}}
    <div class="search-form">
        <form action="{{ route('adminBookingSearchPage') }}" method="get">
            <div class="form-group">
                <label for="customer_name">顧客名</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ $input['customer_name'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="customer_contact">顧客連絡先</label>
                <input type="text" id="customer_contact" name="customer_contact" value="{{ $input['customer_contact'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="checkin_time">チェックイン日時</label>
                <input type="date" id="checkin_time" name="checkin_time" value="{{ $input['checkin_time'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="checkout_time">チェックアウト日時</label>
                <input type="date" id="checkout_time" name="checkout_time" value="{{ $input['checkout_time'] ?? '' }}">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">検索</button>
                 <a href="{{ route('adminBookingSearchPage') }}" class="btn btn-secondary">クリア</a>
            </div>
        </form>
    </div>
    <hr>

    {{-- Results --}}
    <div class="result-wrapper">
        @if(isset($bookings) && $bookings->count() > 0)
            <p>{{ $bookings->total() }} bookings found.</p>
            <table class="result-table">
                <thead>
                    <tr>
                        <th>Hotel Name</th>
                        <th>顧客名</th>
                        <th>顧客連絡先</th>
                        <th>チェックイン日時</th>
                        <th>チェックアウト日時</th>
                        <th>予約日時</th>
                        <th>情報更新日時</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->hotel->hotel_name }}</td>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->customer_contact }}</td>
                            <td>{{ $booking->checkin_time }}</td>
                            <td>{{ $booking->checkout_time }}</td>
                            <td>{{ $booking->created_at }}</td>
                            <td>{{ $booking->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{-- Pagination Links --}}
            <div class="pagination-links" style="margin-top: 2rem;">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        @else
            <p>No matching bookings found.</p>
        @endif
    </div>
</div>
@endsection 