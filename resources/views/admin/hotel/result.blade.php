@extends('admin.hotel.search')

@section('search_results')
<div class="result-wrapper">
    @if(isset($hotelList) && count($hotelList) > 0)
        <p>{{ count($hotelList) }}件のホテルが見つかりました。</p>
        <table class="result-table">
            <thead>
                <tr>
                    <th>ホテルID</th>
                    <th>ホテル名</th>
                    <th>都道府県</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hotelList as $hotel)
                    <tr>
                        <td>{{ $hotel->hotel_id }}</td>
                        <td>{{ $hotel->hotel_name }}</td>
                        <td>{{ $hotel->prefecture->prefecture_name }}</td>
                        <td class="actions">
                            <a href="{{ route('adminHotelEditPage', ['id' => $hotel->hotel_id]) }}" class="btn btn-sm btn-edit">編集</a>
                            <form action="{{ route('adminHotelDeleteProcess', ['id' => $hotel->hotel_id]) }}" method="post" class="delete-form">
                                @csrf
                                <input type="hidden" name="hotel_name" value="{{ $input['hotel_name'] ?? '' }}">
                                <input type="hidden" name="prefecture_id" value="{{ $input['prefecture_id'] ?? '' }}">
                                <button type="submit" class="btn btn-sm btn-delete">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>該当するホテルが見つかりませんでした。</p>
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
                if (confirm('このホテル情報を本当に削除しますか？')) {
                    this.submit();
                }
            });
        });
    });
</script>
@endsection