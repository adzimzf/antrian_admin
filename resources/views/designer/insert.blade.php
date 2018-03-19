@extends("layouts.app")

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @if (Session::has('message_designer_add_spk'))
                    <div class="alert alert-info alert-dismissable text-center ">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong> {{ Session::get('message_designer_add_spk') }} </strong>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Horizontal Form -->
                <form action="{{url('/designer/insert')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nomer Bon : {{$nomerBon}}</h3>
                        <input type="hidden" name="nomer-bon" value="{{$nomerBon}}">
                        <div class="pull-right">
                            <div class="pull-right">
                                <input class="form-control datepicker" id="inputPassword3" name="tanggal-bon" required="required" placeholder="text" type="text" value="{{date("Y-m-d")}}">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="form-horizontal" action="">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Nama</label>

                                <div class="col-sm-10">
                                    <input class="form-control" id="inputEmail3" placeholder="Nama Customer" name="nama-customer" required="required" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">No Telp/Hp/Email</label>

                                <div class="col-sm-10">
                                    <input class="form-control" id="inputPassword3" placeholder="Nomer Telepon" name="nomer-telp-customer" required="required" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Biaya Edit</label>

                                <div class="col-sm-10">
                                    <input class="form-control" id="inputPassword3" placeholder="Satuan Rp" name="biaya-edit" type="number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Biaya Setting</label>

                                <div class="col-sm-10">
                                    <input class="form-control" id="inputPassword3" placeholder="Satuan Rp" name="biaya-setting" type="number">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Data Print</label>

                                <div class="col-sm-10 no-padding">
                                    <div class="row" id="wrap-data-print">
                                        <div class="col-md-12 div-data-print">
                                            <div class="col-md-11">
                                                <div class="col-sm-2 no-padding">
                                                    <div class="form-group cuz-form-group">
                                                        <label for="exampleInputEmail1">Jenis</label>
                                                        <select name="detail-sumber[]" id="" class="form-control flat jenis-cetakan">
                                                           @foreach($jenisCetakan as $jenisCetakan)
                                                                <option value="{{$jenisCetakan->id}}">{{$jenisCetakan->nama}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 no-padding">
                                                    <div class="form-group cuz-form-group">
                                                        <label for="exampleInputEmail1">File</label>
                                                        <input class="form-control" id="exampleInputEmail1" name="detail-file[]" placeholder="Pilih File" type="file">
                                                    </div>
                                                </div>
                                                <div class="col-sm-1 no-padding">
                                                    <div class="form-group cuz-form-group">
                                                        <label for="exampleInputEmail1">Hal</label>
                                                        <input class="form-control" id="exampleInputEmail1" name="detail-halaman[]" placeholder="Jumlah Halaman" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-1 no-padding">
                                                    <div class="form-group cuz-form-group">
                                                        <label for="exampleInputEmail1" class="label-banyaknya">@print</label>
                                                        <input class="form-control" id="exampleInputEmail1" name="detail-banyaknya[]" placeholder="" type="number">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 no-padding">
                                                    <div class="form-group cuz-form-group">
                                                        <label for="exampleInputEmail1">Jenis Kertas</label>
                                                        <select name="detail-jenis-kertas[]" id="" class="form-control jenis-kertas">
                                                            <option value="">-</option>
                                                            @foreach($jenisKertas as $data)
                                                                <option value="{{$data->id}}" size="{{$data->size}}">{{$data->nama}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 no-padding ukuran-kertas-input" id="">
                                                    <div class="form-group cuz-form-group">
                                                        <label for="exampleInputEmail1">Ukuran Kertas(cm)</label>
                                                        <input name="detail-ukuran-kertas[]" type="text" class="form-control inp-ukuran-kertas" placeholder="P x L" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-1 no-padding">
                                                    <div class="form-group cuz-form-group">
                                                        <label for="exampleInputEmail1">Duplex</label>
                                                        <select name="detail-duplex[]" id="" class="form-control">
                                                            <option value="none">None</option>
                                                            <option value="Short">Short</option>
                                                            <option value="Long">Long</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 no-padding hide">
                                                    <div class="form-group cuz-form-group">
                                                        <label for="exampleInputEmail1">Box</label>
                                                        <input name="detail-box[]" type="number" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1 div-delete">
                                                <div class="form-group cuz-form-group form-delete">
                                                    <button class="btn btn-danger btn-delete">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <!-- ./data print -->
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label"></label>

                                <div class="col-sm-12">
                                    <input type="button" class="btn btn-primary pull-right" id="add-data-print" value="Tambah">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-info pull-right">Simpan</button>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                </div>
                </form>
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
    {!! Html::script('/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}
    {!! Html::script('/js/pages/designer/form.js') !!}
@endpush