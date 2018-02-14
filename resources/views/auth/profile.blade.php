@extends("layouts.app")

@section('content')
    <section class="content">


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
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle hide" id="preview" alt="User profile picture">
                        <img class="profile-user-img img-responsive img-circle" id="image" src="/images/profile/{{$user->image}}" alt="User profile picture">

                        <h3 class="profile-username text-center">{{$user->name}}</h3>

                        <p class="text-muted text-center">{{$user->getRole()->first()->name}}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="pull-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Following</b> <a class="pull-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Friends</b> <a class="pull-right">13,287</a>
                            </li>
                        </ul>

                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Settings</a></li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="settings">
                            @if(Auth::user()->role_id == "4" && $user->id != Auth::user()->id)
                                <form class="form-horizontal" action="/update/profile/admin" method="POST" enctype="multipart/form-data">
                            @else
                                <form class="form-horizontal" action="/update/profile" method="POST" enctype="multipart/form-data">
                            @endif
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="name" class="form-control" name="name" placeholder="Name" value="{{$user->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{$user->email}}">
                                    </div>
                                </div>
                                @if(Auth::user()->role_id == "4")
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Position</label>

                                    <div class="col-sm-10">
                                        <select name="position" id="" class="form-control">
                                            @foreach($positions as $position)
                                                <option value="{{$position->id}}" @if($position->id == $user->role_id) selected @endif>{{$position->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="inputSkills" class="col-sm-2 control-label">Photo</label>

                                    <div class="col-sm-10">
                                        <input type='file' onchange="readURL(this);" class="form-control" name="photo" placeholder="Photo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Password</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputExperience" class="col-sm-2 control-label">Re-Password</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="re-password" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
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