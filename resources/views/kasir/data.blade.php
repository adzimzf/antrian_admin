@extends("layouts.app")

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <div class="col-md-4">
                            <div class=" form-group">
                                <label class="col-md-3 control-label" for="" style="margin-top: 5px;">No Bon</label>
                                <div class="col-md-8">
                                    <input class="form-control" id="no-bon" placeholder="Nomer Bon" type="text">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class=" form-group">
                                <label class="col-md-3 control-label" for="" style="margin-top: 5px;">Nama</label>
                                <div class="col-md-8">
                                    <input class="form-control" id="nama" placeholder="Nama Pemesan" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal">
                        <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Nomer Bon</th>
                                        <th>Nama</th>
                                        <th>Process</th>
                                        <th>Pembayaran</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                @php
                                $i = 1;
                                @endphp
                                @foreach($data as $data)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$data->id}}</td>
                                        <td>{{$data->nama}}</td>
                                        @php
                                        $all = $data->getSuratJalanDetail()->count();
                                        $done = $data->getSuratJalanDetail()->where(["done"=>1])->count();
                                        $barPersen = ($done/$all*100);
                                        //eachoperator
                                        @endphp
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="progress-bar progress-bar-success" style="width: {{$barPersen}}%"></div>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                            if ($data->total2 != 0) {
                                                $persen = round(($data->uang_muka/$data->total2)*100);
                                                if ($persen < 30) {
                                                    echo "<span class=\"badge bg-red\">$persen%</span></td>";
                                                }elseif ($persen < 70) {
                                                    echo "<span class=\"badge bg-orange\">$persen%</span></td>";
                                                }elseif ($persen < 90) {
                                                    echo "<span class=\"badge bg-blue\">$persen%</span></td>";
                                                }elseif ($persen == 100) {
                                                    echo "<span class=\"badge bg-green\">$persen%</span></td>"    ;
                                                }
                                            }else{
                                                echo "<span class=\"badge bg-red\">0%</span></td>"    ;
                                            }
                                            @endphp
                                        <td>
                                            <a href="{{url('/kasir/process/'.$data->id)}}" class="btn btn-primary">Process</a>
                                            <a href="{{url('/kasir/detail/'.$data->id)}}" class="btn btn-primary">Detail</a>
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