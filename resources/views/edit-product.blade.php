@extends('layouts.admin')

@section('main-content')
<div id="app">
    <create-product is-edit :product={{$product}} :categories="{{$categories}}"></create-product>
</div>
@endsection

@section('head')
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endsection
