@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Combo Products</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                    <a href="{{route('admin.products.import.show')}}" class="btn btn-cyan d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Import Products</a>
                    <a href="{{route('admin.products.export')}}" class="btn btn-success d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Export</a>
                    <a href="{{route('admin.products.create')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</a>
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
                            <div class="col-md-3">
                                <label for="brand">Brand</label>
                                <select name="brand" id="brand" class="form-control">
                                    <option value="">All</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="manufacturer">Manufacturer</label>
                                <select name="manufacturer" id="manufacturer" class="form-control">
                                    <option value="">All</option>
                                    @foreach($manufacturers as $manufacturer)
                                        <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="brand">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">All</option>
                                    @foreach($categories as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <a href="#" id="filter" class="m-t-30 btn btn-success btn-block">Filter</a>
                            </div>
                        </div>

                        <div class="table-responsive m-t-10">
                            <table id="myTable" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name / Category</th>
                                        <th>Active</th>
                                        
                                        <th>Price</th>
                                        
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
        $(document).ready(function() {
            const dataTable = $('#myTable').DataTable({
                "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "processing": true,
                "serverSide": true,
                // "deferLoading": $('#datatable').attr("data-total"),
                "ajax": {
                    url: '{{ route('admin.products.data','is_combo') }}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                },
                "columns": [
                    { "data": "id"},
                    { "data": "product_translations.name", width: "25%", "class": "text-left"},
                    { "data": "is_active", width: "10%", searchable: false},
                    
                    { "data": "price", width: "15%"},
                    
                    { "data": "options", searchable: false, orderable: false, "class": "text-center" }
                ],
                "order" : [
                    [0, "desc"]
                ],
                "drawCallback": function( settings ) {
                    $("[data-toggle=tooltip],.tooltips").tooltip();
                }
            });

            $('#filter').click(function () {
                let url = '{{ route('admin.products.data') }}?';
                if ($('#brand').val()) {
                    url += '&brand=' + $('#brand').val()
                }
                if ($('#manufacturer').val()) {
                    url += '&manufacturer=' + $('#manufacturer').val()
                }
                if ($('#category').val()) {
                    url += '&category=' + $('#category').val()
                }
                url +='&kind=is_hot'
                dataTable.ajax.url(url).load();
                return false;
            })

        } );
    </script>

@endsection
