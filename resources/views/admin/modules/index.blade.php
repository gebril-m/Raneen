@extends('admin.layouts.app')
@section('container')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Modules</h4>
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Modules</li>
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


                        <div id="example1" class="list-group col">
                            @foreach($rows as $row)
                            <div class="list-group-item" data-id="{{ $row->id }}">
                                {{$row->place}}
                                <div class="float-right">
                                    <a @if($row->is_active) style="display: none" @endif href="{{ route('admin.modules.active', [$row->id, 1] ) }}" class="btn btn-outline-success set-active btn-sm"><i class="ti-check"></i> Active </a>
                                    <a @if(!$row->is_active) style="display: none" @endif href="{{ route('admin.modules.active', [$row->id, 0] ) }}" class="btn btn-outline-danger set-disable btn-sm"><i class="ti-na"></i> Disable </a>
                                    <a href="{{ route('admin.modules.edit', $row->id ) }}" class="btn btn-outline-primary btn-sm"><i class="ti-pencil"></i> Edit </a>
                                </div>
                            </div>
                            @endforeach
                        </div>

{{--                        <div class="table-responsive m-t-10">--}}
{{--                            <table id="myTable" class="table table-bordered table-striped">--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th>id</th>--}}
{{--                                    <th>Place</th>--}}
{{--                                    <th>Active</th>--}}
{{--                                    <th>Order</th>--}}
{{--                                    <th>Edit</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @foreach($rows as $row)--}}
{{--                                <tr>--}}
{{--                                    <td>{{$row->id}}</td>--}}
{{--                                    <td>{{$row->place}}</td>--}}
{{--                                    <td>{{$row->is_active ? 'Active' : 'Disabled'}}</td>--}}
{{--                                    <td>{{$row->order_id}}</td>--}}
{{--                                    <td>--}}
{{--                                        <a href="{{ route('admin.modules.edit', $row->id ) }}" class="btn btn-outline-primary"><i class="ti-pencil"></i> Edit </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
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

    <script src="https://sortablejs.github.io/Sortable/Sortable.js"></script>
    <script>
        $(function() {

            var sorting = new Sortable(document.getElementById('example1'), {
                animation: 150,
                ghostClass: 'blue-background-class',
                onEnd: function (/**Event*/evt) {
                    $.ajax({
                        url: '{{ route('admin.modules.order') }}',
                        data: {
                            ids: sorting.toArray(),
                        },
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function () {

                        }
                    })
                    // console.log(sorting.toArray());
                    // var itemEl = evt.item;  // dragged HTMLElement
                    // evt.to;    // target list
                    // evt.from;  // previous list
                    // evt.oldIndex;  // element's old index within old parent
                    // evt.newIndex;  // element's new index within new parent
                    // evt.oldDraggableIndex; // element's old index within old parent, only counting draggable elements
                    // evt.newDraggableIndex; // element's new index within new parent, only counting draggable elements
                    // evt.clone // the clone element
                    // evt.pullMode;  // when item is in another sortable: `"clone"` if cloning, `true` if moving
                }
            });

           $('.set-disable, .set-active').click(function () {

               var that = this;
               var isDisabled = $(this).hasClass('set-active');

               $.ajax({
                   url: $(this).attr('href'),
                   success: function (res) {
                       if (isDisabled) {
                           $(that).parent().find('.set-disable').show();
                           $(that).parent().find('.set-active').hide();
                       } else {
                           $(that).parent().find('.set-disable').hide();
                           $(that).parent().find('.set-active').show();
                       }
                   }
               })
               return false;
           })
        });
    </script>

    @endsection
