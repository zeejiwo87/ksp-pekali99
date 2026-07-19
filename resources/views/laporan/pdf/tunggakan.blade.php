<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Tunggakan</title>

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
        LAPORAN DATA TUNGGAKAN
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
            <td>{{ $data->count() }} Tunggakan</td>
        </tr>

    </table>

    <br>

    <table class="tabel">

        <thead>

            <tr>

                <th width="5%">No</th>
                <th>Kode Pinjaman</th>
                <th>Nasabah</th>
                <th>Angsuran Ke</th>
                <th>Jatuh Tempo</th>
                <th>Jumlah Tagihan</th>
                {{-- <th>Denda</th> --}}
                <th>Total Tagihan</th>
                {{-- <th>Terlambat</th> --}}
                <th>Status</th>

            </tr>

        </thead>

        <tbody>

            @forelse($data as $item)
                @php
                    $hari = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->diffInDays(now());
                @endphp

                <tr>

                    <td class="center">{{ $loop->iteration }}</td>

                    <td>{{ $item->pinjaman->kode_pinjaman }}</td>

                    <td>{{ $item->pinjaman->nasabah->nama }}</td>

                    <td class="center">
                        {{ $item->angsuran_ke }}
                    </td>

                    <td class="center">
                        {{ date('d-m-Y', strtotime($item->tanggal_jatuh_tempo)) }}
                    </td>

                    <td class="right">
                        Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}
                    </td>

                    {{-- <td class="right">
                        Rp {{ number_format($item->denda, 0, ',', '.') }}
                    </td> --}}

                    <td class="right">
                        Rp {{ number_format($item->jumlah_tagihan + $item->denda, 0, ',', '.') }}
                    </td>

                    {{-- <td class="center">
                        {{ $hari }} Hari
                    </td> --}}

                    <td class="center">
                        Belum Bayar
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="10" class="center">
                        Tidak ada data tunggakan.
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
