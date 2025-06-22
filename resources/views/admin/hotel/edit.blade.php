@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/hotel-form.scss')
@endsection

@section('main_contents')
    <div class="page-wrapper">
        <h2 class="title">ホテル情報編集</h2>
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

        <form action="{{ route('adminHotelEditConfirmation', ['id' => $hotel->hotel_id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="hotel_name">ホテル名</label>
                <input type="text" id="hotel_name" name="hotel_name" value="{{ old('hotel_name', $hotel->hotel_name) }}" required>
            </div>

            <div class="form-group">
                <label for="prefecture_id">都道府県</label>
                <select id="prefecture_id" name="prefecture_id" required>
                    <option value="">選択してください</option>
                    @foreach ($prefectures as $prefecture)
                        <option value="{{ $prefecture->prefecture_id }}" {{ old('prefecture_id', $hotel->prefecture_id) == $prefecture->prefecture_id ? 'selected' : '' }}>
                            {{ $prefecture->prefecture_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="file_path">ホテル画像</label>
                @if ($hotel->file_path)
                    <div class="current-image">
                        <p>現在の画像:</p>
                        <img src="{{ asset('storage/' . $hotel->file_path) }}" alt="Hotel Image" style="max-width: 200px; margin-bottom: 10px;">
                    </div>
                @endif
                <input type="file" id="file_path" name="file_path">
                <small>新しい画像をアップロードすると、現在の画像が上書きされます。</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">更新</button>
                <a href="{{ route('adminHotelSearchPage') }}" class="btn btn-secondary">キャンセル</a>
            </div>
        </form>
    </div>
@endsection
