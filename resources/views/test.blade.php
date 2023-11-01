<?php
// if(isset($_GET['tahun'])){
//     $menu= json_decode(file_get_contents("http://tes-web.landa.id/intermediate/menu"));
//     $transaksi= json_decode(file_get_contents("http://tes-web.landa.id/intermediate/transaksi?tahun=".$_GET['tahun']));
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        td,
        th {
            font-size: 11px;
        }
    </style>


    <title>TES - Venturo Camp Tahap 2</title>
</head>

<body>
    <div class="container-fluid">
        <div class="card" style="margin: 2rem 0rem;">
            <div class="card-header">
                Venturo - Laporan penjualan tahunan per menu
            </div>
            <div class="card-body">
                <form action="{{ route('menu') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select id="my-select" class="form-control" name="tahun">
                                    <option value="">Pilihan Tampil</option>
                                    <option value="2021" {{ ($tahun == '2021') ? 'selected' : '' }}>2021</option>
                                    <option value="2022" {{ ($tahun == '2022') ? 'selected' : '' }}>2022</option>
                                </select>                               
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary">
                                Tampilkan
                            </button>
                            <a href="http://tes-web.landa.id/intermediate/menu" target="_blank" rel="Array Menu" class="btn btn-secondary">
                                Json Menu
                            </a>
                            <a href="http://tes-web.landa.id/intermediate/transaksi?tahun=2021" target="_blank" rel="Array Transaksi" class="btn btn-secondary">
                                Json Transaksi
                            </a>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    @if (isset($menu))    
                    <table class="table table-hover table-bordered overflow-hidden"  style="margin: 0;">
                        <thead>
                            <tr class="table-dark">
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width: 250px;">Menu</th>
                                <th colspan="12" style="text-align: center;">Periode Pada 2021
                                </th>
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width:75px">Total</th>
                            </tr>
                            <tr class="table-dark">
                                <th style="text-align: center;width: 75px;">Jan</th>
                                <th style="text-align: center;width: 75px;">Feb</th>
                                <th style="text-align: center;width: 75px;">Mar</th>
                                <th style="text-align: center;width: 75px;">Apr</th>
                                <th style="text-align: center;width: 75px;">Mei</th>
                                <th style="text-align: center;width: 75px;">Jun</th>
                                <th style="text-align: center;width: 75px;">Jul</th>
                                <th style="text-align: center;width: 75px;">Ags</th>
                                <th style="text-align: center;width: 75px;">Sep</th>
                                <th style="text-align: center;width: 75px;">Okt</th>
                                <th style="text-align: center;width: 75px;">Nov</th>
                                <th style="text-align: center;width: 75px;">Des</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="table-secondary" colspan="14"><b>Makanan</b></td>
                            </tr>                                                  
                            @foreach ($menu as $item)
                                @if ($item['kategori'] == 'makanan')
                                <?php $total = 0;?>       
                                <tr>
                                    <td>{{ $item['menu'] }}</td>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <?php $subtotal = 0;?>
                                        @foreach ($penjualan as $p)
                                            @if (date("m", strtotime($p['tanggal'])) == str_pad($i, 2, '0', STR_PAD_LEFT) && $p['menu'] == $item['menu'])
                                            <?php $subtotal += $p['total']?>
                                            @endif
                                        @endforeach
                                        <?php $total += $subtotal?>
                                        <td class="text-end">{{ number_format($subtotal) }}</td>
                                    @endfor
                                    <td style="text-align: right;"><b>{{ number_format($total) }}</b></td>
                                </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td class="table-secondary" colspan="14"><b>Minuman</b></td>
                            </tr>
                            @foreach ($menu as $item)
                            @if ($item['kategori'] == 'minuman')
                            <?php $total = 0;?>       
                            <tr>
                                <td>{{ $item['menu'] }}</td>
                                @for ($i = 1; $i <= 12; $i++)
                                    <?php $subtotal = 0;?>
                                    @foreach ($penjualan as $p)
                                        @if (date("m", strtotime($p['tanggal'])) == str_pad($i, 2, '0', STR_PAD_LEFT) && $p['menu'] == $item['menu'])
                                        <?php $subtotal += $p['total']?>
                                        @endif
                                    @endforeach
                                    <?php $total += $subtotal?>
                                    <td class="text-end">{{ number_format($subtotal) }}</td>
                                @endfor
                                <td style="text-align: right;"><b>{{ number_format($total) }}</b></td>
                            </tr>
                            @endif
                        @endforeach
                            <tr class="table-dark">
                                <td><b>Total</b></td>
                                <?php $total = 0;?>       
                                    @for ($i = 1; $i <= 12; $i++)
                                        <?php $subtotal = 0;?>
                                        @foreach ($penjualan as $p)
                                            @if (date("m", strtotime($p['tanggal'])) == str_pad($i, 2, '0', STR_PAD_LEFT))
                                            <?php $subtotal += $p['total']?>
                                            @endif
                                        @endforeach
                                        <?php $total += $subtotal?>
                                        <td class="text-end">{{ number_format($subtotal) }}</td>
                                    @endfor
                                    <td style="text-align: right;"><b>{{ number_format($total) }}</b></td>
                            </tr>
                            <tr>
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>

</html>