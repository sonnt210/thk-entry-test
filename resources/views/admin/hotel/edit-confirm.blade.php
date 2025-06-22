@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/hotel-form.scss')
@endsection

@section('main_contents')
<div class="page-wrapper">
    <h2 class="title">確認画面</h2>
    <hr>
    <p>以下の内容で更新します。よろしいですか？</p>

    <form action="{{ route('adminHotelEditProcess', ['id' => $hotel->hotel_id]) }}" method="post">
        @csrf
        <div class="confirmation-data">
            <div class="form-group">
                <strong>ホテル名:</strong>
                <p>{{ $input['hotel_name'] }}</p>
                <input type="hidden" name="hotel_name" value="{{ $input['hotel_name'] }}">
            </div>

            <div class="form-group">
                <strong>都道府県:</strong>
                <p>{{ $prefecture->prefecture_name }}</p>
                <input type="hidden" name="prefecture_id" value="{{ $input['prefecture_id'] }}">
            </div>

            <div class="form-group">
                <strong>ホテル画像:</strong>
                @if(isset($input['new_image_path']))
                    <p>新しい画像:</p>
                    <img src="{{ asset('storage/' . $input['new_image_path']) }}" alt="New Hotel Image" style="max-width: 200px;">
                    <input type="hidden" name="new_image_path" value="{{ $input['new_image_path'] }}">
                @else
                    <p>画像は変更されません。</p>
                @endif
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">はい</button>
            <a href="{{ route('adminHotelEditPage', ['id' => $hotel->hotel_id]) }}" class="btn btn-secondary">いいえ</a>
        </div>
    </form>
</div>
@endsection 