<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Diagram Sales
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
                        <th>Chart Jenis Kelamin</th>
                    </tr>
                    <tr>
                        <td style="border-radius: 10px 0 0 10px;">
                            <div class="container">
                                <div class="p-6 m-20 bg-white rounded shadow">
                                    {!! $jk->container() !!}
                                </div>
                            </div>
                            
                            <script src="{{ $jk->cdn() }}"></script>
                            
                            {{ $jk->script() }}
                        </td>
                    </tr>
                </table>
                
            </x-partials.card>
        </div>
    </div>    
</x-app-layout>