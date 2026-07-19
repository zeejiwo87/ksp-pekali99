<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Pinjaman</title>

    <style>
        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        table {
            border-collapse: collapse;
        }

        .header {
            width: 100%;
        }

        .header td {
            border: none;
            vertical-align: middle;
        }

        .logo {
            text-align: center;
        }

        .logo img {
            width: 75px;
        }

        .kop {
            text-align: center;
        }

        .kop h2 {
            margin: 0;
            font-size: 18px;
        }

        .kop h3 {
            margin: 2px 0;
            font-size: 16px;
        }

        .kop p {
            margin: 2px 0;
        }

        .garis1 {
            border: 2px solid #000;
            margin-top: 8px;
        }

        .garis2 {
            border: .5px solid #000;
            margin-top: 2px;
            margin-bottom: 20px;
        }

        .judul {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .info td {
            border: none;
            padding: 2px;
        }

        .tabel {
            width: 100%;
        }

        .tabel th,
        .tabel td {
            border: 1px solid #000;
            padding: 5px;
        }

        .tabel th {
            background: #d9d9d9;
            text-align: center;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        thead {
            display: table-header-group;
        }

        .footer {
            margin-top: 30px;
        }

        .ttd-table {
            width: 100%;
        }

        .ttd-table td {
            border: none;
            text-align: center;
            vertical-align: top;
        }
    </style>

</head>

<body>

    <table class="header" width="100%">

        <tr>

            <td width="15%" class="logo">
                <img src="{{ public_path('assets/img/logo-koperasi.png') }}">
            </td>

            <td width="70%" class="kop">

                <h2>KOPERASI SIMPAN PINJAM</h2>
                <h3>PEKALI 99 KAS 4</h3>

                <p>Jl. ....................................</p>
                <p>Kabupaten Situbondo</p>

            </td>

            <td width="15%">
                &nbsp;
            </td>

        </tr>

    </table>

    <hr class="garis1">
    <hr class="garis2">

    <div class="judul">
        LAPORAN DATA PELUNASAN PINJAMAN
    </div>

    <table class="info">

        <tr>
            <td width="20%">Tanggal Cetak</td>
            <td width="2%">:</td>
            <td>{{ date('d F Y') }}</td>
        </tr>

        <tr>
            <td>Jumlah Data</td>
            <td>:</td>
            <td>{{ $data->count() }} Pinjaman Lunas</td>
        </tr>

    </table>

    <br>

    <table class="tabel">

        <thead>

            <tr>

                <th width="5%">No</th>
                <th>Kode Pinjaman</th>
                <th>Nasabah</th>
                <th>Tanggal Pinjam</th>
                <th>Jumlah Pinjaman</th>
                <th>Tenor</th>
                <th>Bunga</th>
                <th>Total Pinjaman</th>
                <th>Status</th>

            </tr>

        </thead>

        <tbody>

            @forelse($data as $item)
                <tr>

                    <td class="center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->kode_pinjaman }}
                    </td>

                    <td>
                        {{ $item->nasabah->nama }}
                    </td>

                    <td class="center">
                        {{ date('d-m-Y', strtotime($item->tanggal_pinjam)) }}
                    </td>

                    <td class="right">
                        Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}
                    </td>

                    <td class="center">
                        {{ $item->tenor }}
                        {{ $item->tenor_satuan }}
                    </td>

                    <td class="center">
                        {{ $item->bunga_persen }} %
                    </td>

                    <td class="right">
                        Rp {{ number_format($item->total_pinjaman, 0, ',', '.') }}
                    </td>

                    <td class="center">
                        Lunas
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="9" class="center">
                        Tidak ada data pelunasan.
                    </td>
                </tr>
            @endforelse

        </tbody>

    </table>

    <div class="footer">

        <table width="100%" class="ttd-table">

            <tr>

                <td width="60%"></td>

                <td width="40%">

                    Situbondo, {{ date('d F Y') }}

                    <br><br>

                    Pimpinan KSP Pekali 99 Kas 4

                    <br><br><br><br><br>

                    <strong>(...................................)</strong>

                </td>

            </tr>

        </table>

    </div>

</body>

</html>
