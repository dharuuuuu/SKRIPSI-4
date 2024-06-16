<!-- resources/views/customers/pdf.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List - {{ now() }}</title>
</head>
<body>
    <img src="{{ public_path('images/header.png') }}" style="max-width:100%">

    <h1 style="color: #800000; text-align: center; padding: 20px">Customer List - {{ now() }}</h1>
    
    <table border="1" style="border-collapse: collapse;">
        <thead style="color: #800000">
            <tr>
                <th style="padding: 10px; text-align: center">
                    ID
                </th>
                <th style="padding: 10px; text-align: center">
                    Nama
                </th>
                <th style="padding: 10px; text-align: center">
                    Email
                </th>
                <th style="padding: 10px; text-align: center">
                    No Telepon
                </th>
                <th style="padding: 10px; text-align: center">
                    Alamat
                </th>
                <th style="padding: 10px; text-align: center">
                    Tagihan
                </th>
                <th style="padding: 10px; text-align: center">
                    Created At
                </th>
                <th style="padding: 10px; text-align: center">
                    Updated At
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td style="padding: 10px; text-align:center">
                        {{ $customer->id }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $customer->nama }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $customer->email }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $customer->no_telepon }}
                    </td>
                    <td style="padding: 10px;">
                        {{ $customer->alamat }}
                    </td>
                    <td style="padding: 10px;">
                        {{ IDR($customer->tagihan) }}
                    </td>
                    <td style="padding: 10px; text-align: center">
                        {{ $customer->created_at }}
                    </td>
                    <td style="padding: 10px; text-align: center">
                        {{ $customer->updated_at }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
