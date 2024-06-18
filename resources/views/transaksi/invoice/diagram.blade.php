<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Diagram Pesanan
        </h2>
    </x-slot>

    <style>
        th {
            font-size: 20px; 
            padding: 0 0 20px 0; 
            text-align:center;
        }

        td {
            width: 50%; 
            background-color: rgb(241, 241, 241); 
            padding: 30px;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card style="padding: 50px;"> 
                <table style="width: 100%;">
                    <tr>
                        <th>Chart Pemasukan</th>
                    </tr>
                    <tr>
                        <td style="border-radius: 10px 0 0 10px;">
                            <div class="container">
                                <div class="p-6 m-20 bg-white rounded shadow">
                                    {!! $pemasukan->container() !!}
                                </div>
                            </div>
                            
                            <script src="{{ $pemasukan->cdn() }}"></script>
                            
                            {{ $pemasukan->script() }}
                        </td>
                    </tr>
                </table>

                <table style="width: 100%;">
                    <tr>
                        <th>Chart Produk Terlaris</th>
                    </tr>
                    <tr>
                        <td style="border-radius: 10px 0 0 10px;">
                            <div class="container">
                                <div class="p-6 m-20 bg-white rounded shadow">
                                    {!! $produk_terlaris->container() !!}
                                </div>
                            </div>
                            
                            <script src="{{ $produk_terlaris->cdn() }}"></script>
                            
                            {{ $produk_terlaris->script() }}
                        </td>
                    </tr>
                </table>
                
            </x-partials.card>
        </div>
    </div>    
</x-app-layout>