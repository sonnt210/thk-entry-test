@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Create Hotel</h2>
        <form action="{{ route('adminHotelCreateProcess') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div>
                <label>Hotel Name:</label>
                <input type="text" name="hotel_name" required>
            </div>

            <div>
                <label>Prefecture:</label>
                <select name="prefecture_id" required>
                    @foreach($prefectures as $prefecture)
                        <option value="{{ $prefecture->prefecture_id }}">{{ $prefecture->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Image:</label>
                <input type="file" name="file_path">
            </div>

            <button type="submit">Create</button>
        </form>
    </div>
@endsection
