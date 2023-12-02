@extends('layouts.admin')

@section('main-content')
<div id="app">
    @dd($products)
    <product :products={{$products}}></product>
</div>
@endsection

@section('head')
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endsection
