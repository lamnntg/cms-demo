@extends('layouts.admin')

@section('main-content')
<div id="app">
    <product></product>
</div>
@endsection

@section('head')
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endsection