@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Sự Kiện') }}</h1>
    <!-- Main Content -->

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- DataTales Example -->
        <button type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-primary btn-icon-split mb-2">
            <span class="icon text-white-50">
                <i class="fas fa-flag"></i>
            </span>
            <span class="text">Tạo sự kiện mới</span>
        </button>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách sự kiện</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tên sự kiện</th>
                                <th>Club</th>
                                <th>Thời gian bắt đầu</th>
                                <th>Thời gian kết thúc</th>
                                <th>Thumnail</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        {{-- <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </tfoot> --}}
                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->name }}</td>
                                    <td>{{ $event->description }}</td>
                                    <td>{{ $event->time_start }}</td>
                                    <td>{{ $event->time_end }}</td>
                                    <td><img src="{{  $event->thumnail }}" class="col" alt="" style="width: 5vw; max-width: 100px;"></td>
                                    <td>
                                        <!-- Call to action buttons -->
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <button class="btn btn-primary btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Add"><i class="fa fa-table"></i></button>
                                            </li>
                                            <li class="list-inline-item">
                                                <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                                            </li>
                                            <li class="list-inline-item">
                                                <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                            </li>
                                        </ul>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
    <!-- Large modal -->


    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('event.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Tạo sự kiện mới: </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label font-weight-bold">Tên sự kiện: </label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div id="nameHelp" class="form-text">We'll never share your name with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label font-weight-bold">Mô tả: </label>
                                <textarea class="form-control" aria-label="With textarea" id="description" name="description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label font-weight-bold" for="clubId">Club: </label>
                                <select class="custom-select" id='clubId' name='clubId' required>
                                    <option value="" selected>Chọn club tổ chức sự kiện</option>
                                    @foreach ($clubs as $club)
                                        <option value="{{ $club->id }}">{{ $club->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label font-weight-bold" for="time_start">Thời gian bắt đầu: </label>
                                <div>
                                    <input type="datetime-local" id="time_start" name="time_start" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label font-weight-bold" for="time_start">Thời gian kết thúc: </label>
                                <div>
                                    <input type="datetime-local" id="time_start" name="time_end" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label font-weight-bold" for="thumnail">Ảnh Thumnail: </label>
                                <div>
                                    <input type="file" id="thumnail" name="thumnail" required>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tạo</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection
