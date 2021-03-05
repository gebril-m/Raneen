@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Priroty</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Priroty</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Module Content -->
        <!-- ============================================================== -->
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="customSwitch1" onchange="toggole_priroty()" {{$priorty_setting->enable==1 ?'checked':''}}>
                          <label class="custom-control-label" for="customSwitch1">Enable Priroty</label>
                        </div>
                        <div class="table-responsive m-t-10">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    
                                    <th>Name</th>
                                    
                                    
                                    <th>Edit</th>
                                </tr>
                                </thead>
                                <tbody id="tbody-id">
                                @foreach($rows as $row)
                                <tr id="{{$row->id}}">
                                    
                                    <td>{{$row->name}}</td>

                                    
                                    <td>
                                        <a href="{{ route('admin.priorty.edit', $row->id ) }}" class="btn btn-outline-primary"><i class="ti-pencil"></i> Edit </a>
                                    </td>
                                </tr>
                                @endforeach
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

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.10.2/Sortable.min.js"></script> -->
    <script src="{{asset('admin-asset/assets/sortable.js')}}"></script>
    <script>

        $(function() {
            var sorting = new Sortable(document.getElementById('tbody-id'), {
                animation: 150,
                ghostClass: 'blue-background-class',
                onEnd: function (/**Event*/evt) {
                    var ids= new Array();
                    //var order_ids= new Array();
                    $('#tbody-id').find('tr').each(function(){
                        ids.push($(this).attr('id'));
                        //order_ids.push($(this).attr('id'));
                    });
                    $.ajax({
                        url: '{{ route('admin.priorty.updateall') }}',
                        data: {
                            ids: ids
                        },
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function () {
                            //console.log('hahahahahahahahahahah');
                        }
                    })
                }
            }); 
        });

        function toggole_priroty()
        {
            $.ajax({
                url: '{{ route('admin.priorty.toggole') }}',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (data) {
                    console.log(data);
                }
            })
        }

    </script>

    @endsection
