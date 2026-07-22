@extends('layouts.admin')

@section('title', 'إضافة مشروع وقفي')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 max-w-3xl">
    <form action="{{ route('admin.donation-projects.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.donation-projects._form')
    </form>
</div>
@endsection
