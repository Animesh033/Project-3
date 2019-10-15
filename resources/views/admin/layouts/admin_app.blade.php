@extends('layouts.app')
@section('navbar')
@include('admin.inc.navbar_dashboard')
@endsection
@section('content')

<div class="container">
    {{-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">Admin</li>
            <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
    </nav> --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
        {{-- @include('inc.status.err_success') --}}
        </div>
    </div>
        @yield('audit_content')
        @yield('role_content')
    
</div>
@endsection
