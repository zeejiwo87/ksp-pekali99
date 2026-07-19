<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Nasabah</title>

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
            border: 2px solid black;
            margin-top: 8px;
        }

        .garis2 {
            border: 0.5px solid black;
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
            border: 1px solid black;
            padding: 6px;
        }

        .tabel th {
            background: #d9d9d9;
            text-align: center;
        }

        .center {
            text-align: center;
        }

        .footer {
            width: 100%;
            margin-top: 30px;
        }

        .ttd-table {
            width: 100%;
            border: none;
        }

        .ttd-table td {
            border: none;
            text-align: center;
            vertical-align: top;
        }

        .nama {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }

        .tabel {
            page-break-inside: auto;
        }

        .tabel tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
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
        LAPORAN DATA NASABAH
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
            <td>{{ $data->count() }} Nasabah</td>
        </tr>

    </table>

    <br>

    <table class="tabel">

        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="10%">Foto</th>
                <th width="10%">Kode</th>
                <th width="15%">NIK</th>
                <th width="15%">Nama</th>
                <th width="10%">Jenis Kelamin</th>
                <th width="20%">Alamat</th>
                <th width="10%">No. HP</th>
                <th width="6%">Status</th>
            </tr>
        </thead>

        <tbody>

            @forelse($data as $item)
                <tr>

                    <td class="center">{{ $loop->iteration }}</td>

                    <td class="center">
                        @if ($item->foto && file_exists(public_path('anggota/foto/' . $item->foto)))
                            <img src="{{ public_path('anggota/foto/' . $item->foto) }}" width="40" height="40">
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $item->kode_nasabah }}</td>

                    <td>{{ $item->nik }}</td>

                    <td>{{ $item->nama }}</td>

                    <td class="center">
                        {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </td>

                    <td>{{ $item->alamat }}</td>

                    <td>{{ $item->no_hp }}</td>

                    <td class="center">
                        {{ ucfirst($item->status) }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="9" class="center">
                        Tidak ada data.
                    </td>
                </tr>
            @endforelse

        </tbody>

    </table>

    <div class="footer">

        <table class="ttd-table">

            <tr>

                <td width="60%"></td>

                <td width="40%">

                    Situbondo, {{ date('d F Y') }}<br>
                    Pimpinan KSP Pekali 99 Kas 4

                    <br><br><br><br><br>

                    <span class="nama">
                        (...................................)
                    </span>

                </td>

            </tr>

        </table>

    </div>

</body>

</html>
