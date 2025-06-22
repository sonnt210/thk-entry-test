@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/hotel-form.scss')
@endsection

@section('main_contents')
<div class="page-wrapper">
    <h2 class="title">編集完了</h2>
    <hr>
    <div class="completion-message">
        <p>ホテル情報が正常に更新されました。</p>
        <a href="{{ route('adminHotelSearchPage') }}" class="btn btn-primary">検索画面に戻る</a>
    </div>
</div>

<style>
    .completion-message {
        text-align: center;
        padding: 2rem;
    }
</style>
@endsection 