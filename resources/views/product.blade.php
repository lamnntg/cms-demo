@extends('layouts.admin')

@section('main-content')
<div id="app">
    <product :products="{{json_encode($products)}}" :categories="{{json_encode($categories)}}"></product>
</div>
@endsection

@section('head')
@endsection

@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection
