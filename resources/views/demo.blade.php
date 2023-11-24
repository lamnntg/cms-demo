@extends('layouts.admin')

@section('main-content')
<div id="app">
    <test-component></test-component>
</div>
@endsection

@section('head')
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endsection