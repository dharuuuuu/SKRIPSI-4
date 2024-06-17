<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kegiatan (Semua) List - {{ now() }}</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">

    <h1 style="color: #800000; text-align: center; padding: 20px">Riwayat Kegiatan (Semua) List - {{ now() }}</h1>
    
    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center;">
                    ID
                </th>
                <th style="padding: 10px; text-align: center;">
                    Kegiatan
                </th>
                <th style="padding: 10px; text-align: center;">
                    Nama Pegawai
                </th>
                <th style="padding: 10px; text-align: center;">
                    Jumlah
                </th>
                <th style="padding: 10px; text-align: center;">
                    Status Kegiatan
                </th>
                <th style="padding: 10px; text-align: center;">
                    Catatan
                </th>
                <th style="padding: 10px; text-align: center;">
                    Tanggal Selesai
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($kegiatans as $kegiatan)
                <tr>
                    <td style="padding: 10px; text-align:center">
                        {{ $kegiatan->id }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $kegiatan->item->nama_item }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $kegiatan->user->nama }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $kegiatan->jumlah_kegiatan }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $kegiatan->status_kegiatan }}
                    </td>
                    <td style="padding: 10px; text-align: justify;">
                        {{ $kegiatan->catatan }}
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        {{ $kegiatan->tanggal_selesai }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
