@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Landing Page') }}</h1>

    <div class="row">

        <div class="col-lg-6">

            <!-- Circle Buttons -->
            @foreach ($landingConfigs as $key => $item)
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <img src="{{ $item->value }}" class="col" alt="">
                        <form method="POST" class="col" action="{{ route('landing.update-banner') }}" enctype="multipart/form-data">
                            @csrf
                            <input hidden value={{ $key + 1 }} name="banner" >
                            <input class='mt-4' type="file" id="file" name="file">
                            <button type="submit" class="btn btn-success btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">Cập nhật Banner</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach


        </div>
    </div>

@endsection
