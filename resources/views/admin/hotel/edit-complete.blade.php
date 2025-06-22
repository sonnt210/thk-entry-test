@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/hotel-form.scss')
@endsection

@section('main_contents')
<div class="page-wrapper">
    <h2 class="title">Edit Complete</h2>
    <hr>
    <div class="completion-message">
        <p>Hotel information has been updated successfully.</p>
        <a href="{{ route('adminHotelSearchPage') }}" class="btn btn-primary">Back to Search Screen</a>
    </div>
</div>

<style>
    .completion-message {
        text-align: center;
        padding: 2rem;
    }
</style>
@endsection 