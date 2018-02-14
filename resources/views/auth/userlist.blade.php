@extends("layouts.app")

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box box-header">
                    <a href="/user/add" class="btn btn-primary pull-right">Add</a>
                </div>
                <!-- form start -->
                <form class="form-horizontal">
                    <div class="box-body">

                        @if (Session::has('message_profile_update_success'))
                            <div class="alert alert-info alert-dismissable text-center ">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong> {{ Session::get('message_profile_update_success') }} </strong>
                            </div>
                        @endif
                        @if (Session::has('message_profile_update_error'))
                            <div class="alert alert-error alert-dismissable text-center ">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong> {{ Session::get('message_profile_update_error') }} </strong>
                            </div>
                        @endif

                        <table class="table table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                            $i = 1;
                            @endphp
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->getRole()->first()->name}}</td>
                                        <td>
                                            <a href="/profile/{{$user->id}}" class="btn btn-warning">Edit</a>
                                            <a href="/user/delete/{{$user->id}}" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection

@push('css')
{!! Html::style('/css/pages/designer/form.css') !!}
{!! Html::style('/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') !!}
@endpush

@push('scripts')
{!! Html::script('/js/pages/kasir/data.js') !!}
@endpush