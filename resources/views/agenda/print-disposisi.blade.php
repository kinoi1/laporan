<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Lembar Disposisi</title>

    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background: white;
        }

        .container {
            border: 1px solid #000;
            min-height: 100vh;
        }

        .header {
            display: flex;
            padding: 15px;
            border-bottom: 1px solid #000;
        }

        .logo {
            width: 100px;
        }

        .logo img {
            width: 80px;
        }

        h3 {
            margin: 10px 0px;
        }

        .company {
            flex: 1;
            text-align: center;
        }

        .company h1,
        .company h2,
        .company h3,
        .company p {
            margin: 4px 0;
        }

        .company h2 {
            font-size: 18px;
        }

        .company h1 {
            font-size: 32px;
        }

        .company h3 {
            font-size: 20px;
        }

        .title {
            text-align: center;
            border-bottom: 1px solid #000;
            padding: 0px 15px 15px 15px;
        }

        .title h2 {
            margin: 0 0 20px 0;
        }

        .checkbox-row {
            display: flex;
            justify-content: space-evenly;
        }

        .section {
            border-bottom: 1px solid #000;
            padding: 16px;
        }

        .info-table {
            width: 100%;
            font-size: 20px;
        }

        .info-table td {
            padding: 5px;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 220px;
            font-weight: bold;
        }

        .forward {
            min-height: 100px;
            text-align: center;
        }

        .disposisi {
            min-height: 200px;
        }

        .signature {
            margin-top: 150px;
            margin-right: 32px;
            text-align: right;
        }

        .signature-name {
            margin-top: 120px;
            font-weight: bold;
            font-size: 16;
        }

        td {
            font-size: 14px;
        }

        .info-wrapper {
            display: flex;
            justify-content: center;
        }

        .info-table {
            width: auto;
            font-size: 20px;
        }

        .info-table td {
            padding: 5px 10px;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 180px;
            font-weight: bold;
        }

        .info-table td:nth-child(2) {
            width: 20px;
            text-align: center;
        }

        .info-table td:last-child {
            font-weight: bold;
        }

        @media print {
            body {
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <div class="logo">
                <img src="{{ asset('logo/logo-polban.png') }}" alt="">
            </div>

            <div class="company">
                <h2>Kementerian Pendidikan Tinggi, Sains, dan Teknologi</h2>
                <h1>Politeknik Negeri Bandung</h1>
                <h3>Tim Kerja Bidang Kepegawaian</h3>

                <p>
                    Jln. Gegerkalong Hilir, Ds. Ciwaruga, Bandung 40012, kotak pos 1234, Telp (022) 2013789, Fax (022)
                    2013889
                </p>

                <p>
                    Home page: www.polban.ac.id | Email: polban@polban.ac.id
                </p>
            </div>
        </div>

        <!-- JUDUL -->
        <div class="title">
            <h3>Lembar Disposisi</h2>

                <div class="checkbox-row">
                    <label><input type="checkbox"> Rahasia</label>
                    <label><input type="checkbox"> Batas</label>
                    <label><input type="checkbox"> Biasa</label>
                    <label><input type="checkbox"> Segera</label>
                    <label><input type="checkbox"> Sangat Segera</label>
                </div>
        </div>

        <!-- DATA SURAT -->
        <div class="section">
            <div class="info-wrapper">
                <table class="info-table">
                    <tr>
                        <td>No. Agenda</td>
                        <td>:</td>
                        <td>{{ $agenda->id }}</td>
                    </tr>

                    <tr>
                        <td>Tgl. Diterima</td>
                        <td>:</td>
                        <td>{{ $agenda->tanggal_diterima }}</td>
                    </tr>

                    <tr>
                        <td>No. Surat</td>
                        <td>:</td>
                        <td>{{ $agenda->nomor_surat }}</td>
                    </tr>

                    <tr>
                        <td>Tanggal Surat</td>
                        <td>:</td>
                        <td>{{ $agenda->tanggal_surat }}</td>
                    </tr>

                    <tr>
                        <td>Asal Surat</td>
                        <td>:</td>
                        <td>{{ $agenda->asal_surat }}</td>
                    </tr>

                    <tr>
                        <td>Perihal Surat</td>
                        <td>:</td>
                        <td>{{ $agenda->perihal }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- DITERUSKAN -->
        <div class="section forward">
            <strong>
                <input type="checkbox">
                Diteruskan Kepada :
            </strong>

            <br><br>

            □ ..............................................

            <br><br>

            □ ..............................................

            <br><br>

            □ ..............................................
        </div>

        <!-- ISI DISPOSISI -->
        <div class="section disposisi">
            <strong>Isi Disposisi :</strong>

            <p style="margin-top:20px">
                {{ $agenda->disposisi }}
            </p>
            <!-- TANDA TANGAN -->
            <div class="signature">
                Bandung, ......................................

                <div class="signature-name">
                    Yanny Christiany, S.H., M.Kn.
                    <br>
                    NIP 198101172010122002
                </div>
            </div>
        </div>
    </div>

</body>

</html>
