@extends('admin.hotel.search')

@section('search_results')
<div class="result-wrapper hotel-result-wrapper">
    @if(isset($hotelList) && count($hotelList) > 0)
        <p>{{ count($hotelList) }} hotels found.</p>
        <table class="result-table">
            <thead>
                <tr>
                    <th>Hotel ID</th>
                    <th>Hotel Name</th>
                    <th>Prefecture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hotelList as $hotel)
                    <tr>
                        <td>{{ $hotel->hotel_id }}</td>
                        <td>{{ $hotel->hotel_name }}</td>
                        <td>{{ $hotel->prefecture->prefecture_name }}</td>
                        <td class="actions">
                            <a href="{{ route('adminHotelEditPage', ['id' => $hotel->hotel_id]) }}" class="btn btn-sm btn-edit">Edit</a>
                            <form action="{{ route('adminHotelDeleteProcess', ['id' => $hotel->hotel_id]) }}" method="post" class="delete-form">
                                @csrf
                                <input type="hidden" name="hotel_name" value="{{ $input['hotel_name'] ?? '' }}">
                                <input type="hidden" name="prefecture_id" value="{{ $input['prefecture_id'] ?? '' }}">
                                <button type="submit" class="btn btn-sm btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No matching hotels found.</p>
    @endif
</div>
@endsection

@section('page_js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                if (confirm('Are you sure you want to delete this hotel?')) {
                    this.submit();
                }
            });
        });
    });
</script>
@endsection