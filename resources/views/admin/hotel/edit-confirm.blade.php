@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/hotel-form.scss')
@endsection

@section('main_contents')
<div class="page-wrapper">
    <h2 class="title">Confirmation Screen</h2>
    <hr>
    <p>The following content will be updated. Is this correct?</p>

    <form action="{{ route('adminHotelEditProcess', ['id' => $hotel->hotel_id]) }}" method="post">
        @csrf
        <div class="confirmation-data">
            <div class="form-group">
                <strong>Hotel Name:</strong>
                <p>{{ $input['hotel_name'] }}</p>
                <input type="hidden" name="hotel_name" value="{{ $input['hotel_name'] }}">
            </div>

            <div class="form-group">
                <strong>Prefecture:</strong>
                <p>{{ $prefecture->prefecture_name }}</p>
                <input type="hidden" name="prefecture_id" value="{{ $input['prefecture_id'] }}">
            </div>

            <div class="form-group">
                <strong>Hotel Image:</strong>
                @if(isset($input['new_image_path']))
                    <p>New Image:</p>
                    <img src="{{ asset($input['new_image_path']) }}" alt="New Hotel Image" style="max-width: 200px;">
                    <input type="hidden" name="new_image_path" value="{{ $input['new_image_path'] }}">
                @else
                    <p>Image will not be changed.</p>
                @endif
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Yes</button>
            <a href="{{ route('adminHotelEditPage', ['id' => $hotel->hotel_id]) }}" class="btn btn-secondary">No</a>
        </div>
    </form>
</div>
@endsection 