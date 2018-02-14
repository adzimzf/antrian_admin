@extends("layouts.app")

@section('content')
    {{csrf_field()}}
    <input type="hidden" id="surat-jalan-id" value="{{$suratJalan->id}}">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div id="alert-field"></div>
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <div class="pull-right">
                            <div class="pull-right">
                                <input class="form-control datepicker" id="inputPassword3" placeholder="text" type="text">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="col-md-12 my-data-detail">
                                <div class="col-md-2 bold">
                                    Nama
                                </div>
                                <div class="col-md-10">
                                    : {{$suratJalan->nama}}
                                </div>
                            </div>
                            <div class="col-md-12 my-data-detail">
                                <div class="col-md-2 bold">
                                    Nomer Telepon/ Email
                                </div>
                                <div class="col-md-10">
                                    : {{$suratJalan->no_telepon}}
                                </div>
                            </div>

                            <div class="col-md-12 my-data-detail">
                                <div class="col-md-2 bold">
                                    Detail
                                </div>
                            </div>

                            <div class="col-md-12 col-off">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Nama</th>
                                        <th>Banyaknya</th>
                                        <th>Jenis Bahan</th>
                                        <th>File</th>
                                        <th>Duplex</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($suratJalanDetail as $indexKey => $detail)
                                        <tr class="rows">
                                            <input class="detail_id" type="hidden" value="{{$detail->id}}">
                                            <td>{{$indexKey+1}}</td>
                                            <td>{{$detail->jenisCetakan()->first()->nama}} {{$detail->peper_size}}cm</td>
                                            <td>
                                                {{--jenis cetakan adalah kartu nama--}}
                                                @if($detail->jenisCetakan()->first()->id == 2 )
                                                    <span class="qty">{{$detail->quantity}}</span><span> Box</span>
                                                @else
                                                    <span class="qty">{{$detail->quantity}}</span>
                                                @endif
                                            </td>
                                            <td>{{$detail->jenisKertas()->get()[0]->nama}}</td>
                                            <td class="text-center">
                                                <a href="/images/surat_jalan/{{$detail->file_address}}" download=""><li class="fa fa-download"></li>
                                                </a>
                                            </td>
                                            <td class="text-center">{{$detail->duplex}}</td>
                                            <td>
                                                <button class="btn btn-success btn-process" id="{{$detail->id}}"
                                                @if($detail->done == 1)
                                                    disabled
                                                @endif
                                                >Done</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>


                        </div>
                        <!-- box footer -->

                        <div class="box-footer">
                            <a href="/operator/data" class="btn btn-default">Back</a>
                        </div>
                        <!-- ./box-footer -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection

@push('css')
    {!! Html::style('/css/pages/kasir/process.css') !!}
    {!! Html::style('/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') !!}
@endpush

@push('scripts')
    {!! Html::script('/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}
    {!! Html::script('/js/pages/operator/process.js') !!}
@endpush