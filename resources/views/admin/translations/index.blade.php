@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Translations</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Translations</li>
                    </ol>
                    <a href="{{route('admin.translations.create')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-3">
                                <select name="group" id="group" class="form-control">
                                    <option value="all">All</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group }}">{{ $group }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <select name="locale" id="locale" class="form-control">
                                    <option value="all">All</option>
                                    @foreach(\App\Language::all() as $local)
                                        <option value="{{ $local->locale }}">{{ $local->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                               <button class="btn btn-success" id="filter">Filter</button>
                            </div>
                        </div>

                        <div class="table-responsive m-t-10">
                            <table id="myTable" class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Group</th>
                                    <th>Translation</th>
                                    <th>Language</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
@endsection
@section('style')
    <link href="{{asset('admin-asset/assets/node_modules/datatables/media/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{asset('admin-asset/assets/node_modules/datatables/datatables.min.js')}}"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

    <script>
        var dataTables;
        $(document).ready(function() {
            dataTables = $('#myTable').DataTable({
                "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "processing": true,
                "serverSide": true,
                // "deferLoading": $('#datatable').attr("data-total"),
                "ajax": {
                    url: '{{ route('admin.translations.data') }}?locale=' + $('#locale').val() + '&group=' + $('#group').val(),
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                },
                "columns": [
                    { "data": "id"},
                    { "data": "item", width: "30%"},
                    { "data": "group", width: "30%"},
                    { "data": "text", width: "30%"},
                    { "data": "locale", width: "10%"},
                    { "data": "options", searchable: false, orderable: false, "class": "text-center" }
                ],
                "order" : [
                    [0, "desc"]
                ],
                "drawCallback": function( settings ) {
                    $("[data-toggle=tooltip],.tooltips").tooltip();
                }
            });

            $('#filter').on('click', function () {
                dataTables.ajax.url('{{ route('admin.translations.data') }}?locale=' + $('#locale').val() + '&group=' + $('#group').val());
                dataTables.ajax.reload();
            })

        } );
    </script>

@endsection
