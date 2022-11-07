@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Bài viêt') }}</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>
    <!-- Main Content -->

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- DataTales Example -->
        <button type="button" data-toggle="modal" data-target=".bd-example-modal-xl" class="btn btn-primary btn-icon-split mb-2">
            <span class="icon text-white-50">
                <i class="fas fa-flag"></i>
            </span>
            <span class="text">Tạo bài viết mới</span>
        </button>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách bài viết</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tên bài viết</th>
                                <th>Nội dung</th>
                                <th>Thời gian tạo</th>
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
                            @foreach ($articles as $article)
                                <tr>
                                    <td>{{ $article->title }}</td>
                                    <td>
                                        <div class="badge badge-primary text-wrap" style="width: 6rem;">
                                            This text should wrap.
                                        </div>
                                    </td>
                                    <td>{{ $article->created_at }}</td>
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


    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form method="POST" action="{{ route('article.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-header">
                    <h5 class="modal-title">Tạo bài viết mới: </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Tên bài viết: </label>
                                <input type="text" class="form-control" id="title" name="title">
                                <div id="nameHelp" class="form-text">We'll never share your name with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả: </label>
                                <textarea class="form-control" aria-label="With textarea" id="editor" name="html" rows="50"></textarea>

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
    <script>
        ClassicEditor
                .create( document.querySelector( '#editor' ), {
                    ckfinder: {
                        uploadUrl: '{{route('image.upload').'?_token='.csrf_token()}}',
                    }
                })
                .then( editor => {

                        console.log( editor );
                } )
                .catch( error => {
                        console.error( error );
                } );
    </script>
@endsection
