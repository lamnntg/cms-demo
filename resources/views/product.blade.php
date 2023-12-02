@extends('layouts.admin')

@section('main-content')
<div id="app">
    <product :products={{json_encode($products)}}></product>
</div>
@endsection

@section('head')
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endsection
