@extends('common.admin.base')

@section('custom_css')
    {{-- Reusing hotel search styles for consistency --}}
    @vite('resources/scss/admin/search.scss')
@endsection

@section('main_contents')
<div class="page-wrapper search-page-wrapper">
    <h2 class="title">予約情報検索</h2>
    <hr>

    {{-- Search Form --}}
    <div class="search-form">
        <form action="{{ route('adminBookingSearchPage') }}" method="get">
            <div class="form-group">
                <label for="customer_name">顧客名</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ $input['customer_name'] ?? '' }}" placeholder="顧客名">
            </div>
            <div class="form-group">
                <label for="customer_contact">顧客連絡先</label>
                <input type="text" id="customer_contact" name="customer_contact" value="{{ $input['customer_contact'] ?? '' }}" placeholder="顧客連絡先">
            </div>
            <div class="form-group">
                <label for="checkin_time">チェックイン日 (以降)</label>
                <input type="date" id="checkin_time" name="checkin_time" value="{{ $input['checkin_time'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="checkout_time">チェックアウト日 (以前)</label>
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
            <p>{{ $bookings->total() }}件の予約が見つかりました。</p>
            <table class="result-table">
                <thead>
                    <tr>
                        <th>予約ID</th>
                        <th>ホテル名</th>
                        <th>顧客名</th>
                        <th>顧客連絡先</th>
                        <th>チェックイン</th>
                        <th>チェックアウト</th>
                        <th>予約日時</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->booking_id }}</td>
                            <td>{{ $booking->hotel->hotel_name }}</td>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->customer_contact }}</td>
                            <td>{{ $booking->checkin_time }}</td>
                            <td>{{ $booking->checkout_time }}</td>
                            <td>{{ $booking->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{-- Pagination Links --}}
            <div class="pagination-links" style="margin-top: 2rem;">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        @else
            <p>該当する予約が見つかりませんでした。</p>
        @endif
    </div>
</div>
@endsection 