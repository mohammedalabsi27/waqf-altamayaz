@extends('layouts.admin')

@section('title', 'تعديل مشروع وقفي')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 max-w-3xl">
    <form action="{{ route('admin.donation-projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.donation-projects._form')
    </form>
</div>
@endsection
