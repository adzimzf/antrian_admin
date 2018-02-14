<body style="width: 1000px; height: 700px">
<div>
    <!-- for image -->
    <div style="display: inline-block; width: 34%">
        <img src="test.jpg">
    </div>
    <!-- nomer nota -->
    <div style="display: inline-block; width: 30%; text-align: center;">
        <h2>NOTA PESANAN</h2>
        <p>No. {{$suratJalan->id}}</p>
    </div>
    <!-- customer name -->
    <div  style="display: inline-block; width: 33%;">
        <p style="display: inline-block; width: 49%; margin: 10px 0 10px;">Customer</p>
        <p style="display: inline-block; width: 49%; margin: 10px 0 10px;"> : {{$suratJalan->nama}}</p>
        <p style="display: inline-block; width: 49%; margin: 10px 0 10px;">Telp</p>
        <p style="display: inline-block; width: 49%; margin: 10px 0 10px;"> : {{$suratJalan->no_telepon}}</p>
    </div>
</div>
<div>
    <span>Jl Baru saribena II No.17 kebayoran lama Jaksel Telp. 727 864 55 - 739 6548</span>
</div>
<table style="border-collapse: collapse; border: 1px solid black; width: 100%">
    <!-- header -->
    <tr>
        <th style="border: 1px solid black;">NAMA BARANG<br>& UKURAN</th>
        <th style="border: 1px solid black;">BANYAK<br>NYA</th>
        <th style="border: 1px solid black;">JENIS<br>BAHAN</th>
        <th style="border: 1px solid black;">HARGA<br>@Rp</th>
        <th style="border: 1px solid black;">JUMLAH<br>HARGA</th>
        <th style="border: 1px solid black;">KETERANGAN</th>
    </tr>
    <!-- body -->
    @php
    $i = 1;
    @endphp
    @foreach($suratJalanDetail as $suratJalanDetail)
        <tr style="height: 26px">
            <td style="border: 1px solid black;">{{$suratJalanDetail->jenisCetakan()->first()->nama}} {{$suratJalanDetail->peper_size}}cm</td>
            <td style="border: 1px solid black; text-align: center;">
                {{--jenis cetakan adalah kartu nama--}}
                @if($suratJalanDetail->jenisCetakan()->first()->id == 2 )
                    <span class="qty">{{$suratJalanDetail->quantity}}</span><span> Box</span>
                @else
                    <span class="qty">{{$suratJalanDetail->quantity}}</span>
                @endif
            </td>
            <td style="border: 1px solid black; text-align: center;">{{$suratJalanDetail->jenisKertas()->first()->nama}}</td>
            <td style="border: 1px solid black; text-align: right;">{{number_format($suratJalanDetail->harga_satuan, 0, ",", ".")}}</td>
            <td style="border: 1px solid black; text-align: right;">{{number_format($suratJalanDetail->harga_jumlah, 0, ",", ".")}}</td>
            @if($i == 1)
            <td style="border: 1px solid black;" rowspan="7">
                <ul>
                    <li>
                        Mohon cek / periksa dulu pada saat mengambil barang<br>Pesanan.
                    </li>
                    <li>
                        Kesalahan/kerusakan barang yang sudah<br>diambil diluar tanggung jawab kami.
                    </li>
                    <li>
                        Barang bisa diambil setalah pembayaran LUNAS.
                    </li>
                </ul>
            </td>
            @endif
        </tr>
        @php
        $i++;
        @endphp
    @endforeach

    @if($suratJalan->biaya_edit != null)
        <tr style="height: 26px">
            <td style="border: 1px solid black;">Biaya Edit</td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black; text-align: right;">{{number_format($suratJalan->biaya_edit, 0, ",", ".")}}</td>
        </tr>
        @php
            $i++;
        @endphp
    @endif

    @if($suratJalan->biaya_setting != null)
        <tr style="height: 26px">
            <td style="border: 1px solid black;">Biaya Setting</td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black;"></td>
            <td style="border: 1px solid black; text-align: right;">{{number_format($suratJalan->biaya_setting, 0, ",", ".")}}</td>
        </tr>
        @php
            $i++;
        @endphp
    @endif

    @for($j=$i; $j <= 7; $j++)
        <tr style="height: 26px">
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        </tr>
    @endfor

    <!-- footer -->
    <tr>
        <td style="border: 1px solid white;" colspan="2">
            @php
            $tanggal = new DateTime($suratJalan->tanggal);
            function getHari($eH){
                switch ($eH){
                    case "Mon" : return "Senin"; break;
                    case "Tue" : return "Selasa"; break;
                    case "Wed" : return "Rabu"; break;
                    case "Thu" : return "Kamis"; break;
                    case "Fri" : return "Jumat"; break;
                    case "Sat" : return "Sabtu"; break;
                    case "Sun" : return "Minggu"; break;
                }
            }
            @endphp
            Tanggal Pesan : {{$tanggal->format("d-m-Y")}}
        </td>
        <td style="border: 1px solid white; border-right: 1px solid black; text-align: right;" colspan="2">TOTAL</td>
        <td style="border: 1px solid black; text-align: right;">{{number_format($suratJalan->total2, 0, ",", ".")}}</td>
        <!-- tempat ttd -->
        <td rowspan="3" style="border: 1px solid white; text-align: center;">
            Hormat Kami,
            <br>
            <br>
            <br>
            <br>
            ({{Auth::user()->name}})
        </td>
    </tr>
    <tr>
        <td style="border: 1px solid white;" colspan="2">
            Hari :{{getHari($tanggal->format("D"))}}
        </td>
        <td style="border: 1px solid white; border-right: 1px solid black; text-align: right;" colspan="2">UANG MUKA</td>
        <td style="border: 1px solid black; text-align: right;">{{number_format($suratJalan->uang_muka, 0, ",", ".")}}</td>
    </tr>
    <tr>
        <td style="border: 1px solid white; border-right: 1px solid black; text-align: right;" colspan="4">SISA</td>
        <td style="border: 1px solid black; text-align: right;">{{number_format($suratJalan->sisa, 0, ",", ".")}}</td>
    </tr>
</table>
</body>