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
                        <h6 class="heading-small text-muted mb-4">Banner {{ $key + 1 }}</h6>

                        <img src="{{ $item->value }}" class="col" alt="">

                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4 font-weight-bold">Chỉnh sửa text Banner</h6>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="email">Text Banner:<span class="small text-danger">*</span></label>
                                <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="PQ">
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                  Tắt text
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Bật text
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Cập nhật text</span>
                    </button>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4 font-weight-bold">Chỉnh sửa ảnh Banner</h6>
                    <form method="POST" class="col" action="{{ route('landing.update-banner') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="banner">Banner: </label>
                                    <select class="custom-select" id='banner' name='banner' required="required">
                                        <option value="">Chọn Banner muốn thay đổi</option>
                                        <option value="1">Banner 1</option>
                                        <option value="2">Banner 2</option>
                                        <option value="3">Banner 3</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="file">Chọn file Banner:<span class="small text-danger">*</span></label>
                                    <input class='mt-4 ml-3' type="file" id="file" name="file" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Cập nhật Banner</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
