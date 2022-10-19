@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Landing Page') }}</h1>

    <div class="row">

        <div class="col-lg-6">

            <!-- Circle Buttons -->
            @foreach ($landingConfigs as $item)
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <img src="{{ $item->value }}" alt="">
                        <form action="/action_page.php">
                            <input type="file" id="file" name="filename">
                            <input type="submit">
                        </form>
                    </div>
                </div>
            @endforeach


        </div>
    </div>

@endsection
