@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Edit Hotel</h2>
        <form action="{{ route('adminHotelEditProcess', $hotel->hotel_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div>
                <label>Hotel Name:</label>
                <input type="text" name="hotel_name" value="{{ $hotel->hotel_name }}" required>
            </div>

            <div>
                <label>Prefecture:</label>
                <select name="prefecture_id" required>
                    @foreach($prefectures as $prefecture)
                        <option value="{{ $prefecture->prefecture_id }}"
                            {{ $hotel->prefecture_id == $prefecture->prefecture_id ? 'selected' : '' }}>
                            {{ $prefecture->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Image:</label>
                <input type="file" name="file_path">
                @if($hotel->file_path)
                    <img src="{{ asset('storage/' . $hotel->file_path) }}" width="100">
                @endif
            </div>

            <button type="submit">Update</button>
        </form>
    </div>
@endsection
