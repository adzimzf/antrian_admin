@extends("layouts.app")

@section('content')
    <section class="content">

        <div class="row">
            <div class="col-md-9">
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Settings</a></li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal" action="/user/insert" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="name" class="form-control" name="name" placeholder="Name" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" placeholder="Email" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Position</label>

                                    <div class="col-sm-10">
                                        <select name="position" id="" class="form-control">
                                            @foreach($positions as $position)
                                                <option value="{{$position->id}}">{{$position->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Password</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <a href="/user/list" class="btn btn-warning">Back</a>
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection

@push('scripts')
    {!! Html::script('/js/pages/profile/index.js') !!}
@endpush