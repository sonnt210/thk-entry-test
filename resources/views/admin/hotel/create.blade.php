@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/hotel-form.scss')
@endsection

@section('main_contents')
    <div class="page-wrapper">
        <h2 class="title">ホテル新規作成</h2>
        <hr>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('adminHotelCreateProcess') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="hotel_name">ホテル名</label>
                <input type="text" id="hotel_name" name="hotel_name" value="{{ old('hotel_name') }}" required>
            </div>

            <div class="form-group">
                <label for="prefecture_id">都道府県</label>
                <select id="prefecture_id" name="prefecture_id" required>
                    <option value="">選択してください</option>
                    @foreach ($prefectures as $prefecture)
                        <option value="{{ $prefecture->prefecture_id }}" {{ old('prefecture_id') == $prefecture->prefecture_id ? 'selected' : '' }}>
                            {{ $prefecture->prefecture_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="file_path">ホテル画像</label>
                <input type="file" id="file_path" name="file_path">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">作成</button>
                <a href="{{ route('adminHotelSearchPage') }}" class="btn btn-secondary">キャンセル</a>
            </div>
        </form>
    </div>
@endsection
