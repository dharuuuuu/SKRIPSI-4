<!-- resources/views/items/pdf.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item List - {{ now() }}</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">

    <h1 style="color: #800000; text-align: center; padding: 20px">Item List - {{ now() }}</h1>
    
    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center">
                    ID
                </th>
                <th style="padding: 10px; min-width:150px; text-align: center">
                    Nama
                </th>
                <th style="padding: 10px; min-width:100px; text-align: center">
                    Gaji Per Item
                </th>
                <th style="padding: 10px; text-align: center">
                    Deskripsi
                </th>
                <th style="padding: 10px; min-width:100px; text-align: center">
                    Created At
                </th>
                <th style="padding: 10px; min-width:100px; text-align: center">
                    Updated At
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td style="padding: 10px; text-align:center">
                        {{ $item->id }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $item->nama_item }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ IDR($item->gaji_per_item) }}
                    </td>
                    <td style="padding: 10px; text-align:justify">
                        {{ $item->deskripsi_item }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ $item->created_at }}
                    </td>
                    <td style="padding: 10px; text-align:center">
                        {{ $item->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
