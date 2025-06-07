<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Resmi</title>
    <link rel="stylesheet" href="dashboard/css/pdf.css">
</head>

<body>

    <div class="kop-surat">
        <img src="img/logo-smk.png" alt="Logo" class="logo-kop">
        <div class="judul-instansi">
            <strong>SMKS NASIONAL DEPOK</strong><br>
            <strong>Jl. Raya Grogol No.2, Grogol, Kec. Limo, Kota Depok, Jawa Barat 16512</strong>
        </div>
    </div>
    <hr class="garis-bawah">

    <div class="content">
        <table class="tabel-laporan">
            <tr>
                <td>Nama Pelaku</td>
                <td class="titik-dua">:</td>
                <td>{{ $laporan->nama }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td class="titik-dua">:</td>
                <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('l, d F Y') }}</td>
            </tr>
            <tr>
                <td>Status Laporan</td>
                <td class="titik-dua">:</td>
                <td>{{ $laporan->status }}</td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td class="titik-dua">:</td>
                <td>{{ $laporan->deskripsi }}</td>
            </tr>
        </table>

        @if ($laporan->foto)
            <div class="lampiran">
                <strong>Lampiran:</strong><br>
                <img src="{{ public_path('storage/' . $laporan->foto) }}" alt="Lampiran">
            </div>
        @endif
    </div>


</body>

</html>
