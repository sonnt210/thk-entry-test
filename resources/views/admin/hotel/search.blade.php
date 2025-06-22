<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/search.scss')
@endsection

<!-- main containts -->
@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <h2 class="title">検索画面</h2>
        <hr>
        @if (isset($successMessage))
            <div class="alert alert-success">
                {{ $successMessage }}
            </div>
        @endif
        <div class="search-form">
            <form action="{{ route('adminHotelSearchResult') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="hotel_name">ホテル名</label>
                    <input type="text" id="hotel_name" name="hotel_name" value="{{ $input['hotel_name'] ?? '' }}" placeholder="ホテル名">
                </div>
                <div class="form-group">
                    <label for="prefecture_id">都道府県</label>
                    <select id="prefecture_id" name="prefecture_id">
                        <option value="">すべて</option>
                        @foreach ($prefectures as $prefecture)
                            <option value="{{ $prefecture->prefecture_id }}" 
                                {{ (isset($input['prefecture_id']) && $input['prefecture_id'] == $prefecture->prefecture_id) ? 'selected' : '' }}>
                                {{ $prefecture->prefecture_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">検索</button>
                </div>
            </form>
            @error('search')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <hr>
    </div>
    @yield('search_results')
@endsection