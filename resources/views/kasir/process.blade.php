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
                    <!-- form start -->
                    <div class="form-horizontal">
                        <div class="box-body">
                            <div class="col-md-12 my-data-detail">
                                <div class="col-md-2 bold">
                                    No Bon
                                </div>
                                <div class="col-md-10">
                                    : {{$suratJalan->id}}
                                </div>
                            </div>
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
                                            <th>Harga</th>
                                            <th style="width: 150px">Jumlah</th>
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
                                            <td>
                                                <input class="form-control harga-satuan form-input-khusus" type="number" value="{{$detail->harga_satuan}}"
                                                isFixed="{{$detail->jenisCetakan()->first()->is_fixed}}"
                                                @if(!$edit)disabled="disabled"@endif>
                                            </td>
                                            <td class="sum text-right">{{$detail->harga_jumlah}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="background: #f39c12;">
                                            <td colspan="5" class="text-right bold">Total</td>
                                            <td id="sumTotal" class="text-right">{{$suratJalan->total1}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right bold">Biaya Seting</td>
                                            <td id="biayaSeting" class="text-right">{{$suratJalan->biaya_setting}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right bold">Biaya Edit</td>
                                            <td id="biayaEdit" class="text-right">{{$suratJalan->biaya_edit}}</td>
                                        </tr>
                                        <tr style="background: #f39c12;">
                                            <td colspan="5" class="text-right bold">Total</td>
                                            <td id="sumTotal2" class="text-right">{{$suratJalan->total2}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right bold">Uang Muka</td>
                                            <td >
                                                <input id="uang_muka" class="form-control text-right form-input-khusus" type="text" value="{{$suratJalan->uang_muka}}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right bold">Sisa</td>
                                            <td id="sumSisa" class="text-right">{{$suratJalan->sisa}}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>


                        </div>
                        <!-- box footer -->

                        <div class="box-footer">
                            <a href="/kasir/data" class="btn btn-default">Back</a>
                            <button type="button" class="btn btn-success pull-right" id="btn-simpan-cetak">Simpan dan Cetak</button>
                            <button type="button" class="btn btn-info pull-right" id="btn-simpan">Simpan</button>
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
    {!! Html::script('/js/pages/kasir/process.js') !!}
@endpush