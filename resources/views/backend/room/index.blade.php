@extends('backend.layouts.master')
@section('title','Floormasters || Room Page')
@section('main-content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Room List</h6>
        <a href="{{route('room.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
            data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Room</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($rooms)>0)
            <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Is Parent</th>
                        <th>Parent Room</th>
                        <th>Photo</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Is Parent</th>
                        <th>Parent Room</th>
                        <th>Photo</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach($rooms as $Room)
                    @php
                    @endphp
                    <tr>
                        <td>{{$Room->id}}</td>
                        <td>{{$Room->title}}</td>
                        <td>{{$Room->slug}}</td>
                        <td>{{(($Room->is_parent==1)? 'Yes': 'No')}}</td>
                        <td>
                            {{$Room->parent_info->title ?? ''}}
                        </td>
                        <td>
                            @if($Room->photo)
                            <img src="{{$Room->photo}}" class="img-fluid" style="max-width:80px" alt="{{$Room->photo}}">
                            @else
                            <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid"
                                style="max-width:80px" alt="avatar.png">
                            @endif
                        </td>
                        <td>
                            @if($Room->status=='active')
                            <span class="badge badge-success">{{$Room->status}}</span>
                            @else
                            <span class="badge badge-warning">{{$Room->status}}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('room.edit',$Room->id)}}" class="btn btn-primary btn-sm float-left mr-1"
                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                data-placement="bottom"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{route('room.destroy',[$Room->id])}}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$Room->id}}
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                    data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <span style="float:right">{{$rooms->links()}}</span>
            @else
            <h6 class="text-center">No rooms found!!! Please create Room</h6>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
div.dataTables_wrapper div.dataTables_paginate {
    display: none;
}
</style>
@endpush

@push('scripts')

<!-- Page level plugins -->
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
$('#banner-dataTable').DataTable({
    "columnDefs": [{
        "orderable": false,
        "targets": [3, 4, 5]
    }]
});

// Sweet alert

function deleteData(id) {

}
</script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.dltBtn').click(function(e) {
        var form = $(this).closest('form');
        var dataID = $(this).data('id');
        // alert(dataID);
        e.preventDefault();
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                } else {
                    swal("Your data is safe!");
                }
            });
    })
})
</script>
@endpush