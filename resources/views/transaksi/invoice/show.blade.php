<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Show Pesanan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

                <div class="page-content container">
                    <div class="page-header text-blue-d2">
                        <h1 class="page-title text-secondary-d1">
                            <small class="page-info">
                                {{ $invoice->invoice }}
                            </small>
                        </h1>

                        <div class="page-tools">
                            <div class="action-buttons">
                                <a href="{{ route('invoice.index') }}" class="button">
                                    <i class=" mr-1 icon ion-md-return-left text-primary"></i>
                                    Back to Index
                                </a>

                                <a href="{{ route('pesanan.invoice_pdf', $invoice) }}" class="button" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                    <i class="mr-1 icon ion-md-download"></i>
                                    Export PDF
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="container px-0">
                        <div class="row mt-4">
                            <div class="col-12 col-lg-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div>
                                            <span class="text-sm align-middle">To :</span>
                                            <span class="text-600 text-110 text-blue align-middle">
                                                {{ $invoice->user->nama }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="my-1">
                                                {{ $invoice->user->alamat }}
                                            </div>
                                            <div class="my-1">
                                                {{ $invoice->user->email }}
                                            </div>
                                            <div class="my-1"><i class="fa fa-phone fa-flip-horizontal" style="color: #800000;"></i> <b class="text-600">{{ $invoice->user->no_telepon }}</b></div>
                                        </div>
                                    </div>

                                    <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                        <hr class="d-sm-none" />
                                        <div>
                                            <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                                Invoice
                                            </div>

                                            <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">ID :</span> {{ $invoice->invoice }}</div>

                                            <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Date :</span> {{ $invoice->created_at }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="row text-600 text-white bgc-default-tp1 py-25">
                                        <div class="d-none d-sm-block col-1">#</div>
                                        <div class="col-9 col-sm-5">Nama Produk</div>
                                        <div class="d-none d-sm-block col-4 col-sm-2">Quantity</div>
                                        <div class="d-none d-sm-block col-sm-2">Harga Satuan</div>
                                        <div class="col-2">Total</div>
                                    </div>

                                    <div class="text-95 text-secondary-d3">
                                        @php
                                            $total_subtotal = 0;
                                        @endphp
                                        
                                        @foreach($pesanans as $index => $pesanan)
                                            @if (isset($pesanan->jumlah_pesanan) && isset($pesanan->harga))
                                                @php
                                                    $subtotal = $pesanan->jumlah_pesanan * $pesanan->harga;
                                                    $total_subtotal += $subtotal;
                                                @endphp
                                                <div class="row mb-2 mb-sm-0 py-25 bg_kolom">
                                                    <div class="d-none d-sm-block col-1">{{ $index+1 }}</div>
                                                    <div class="col-9 col-sm-5">{{ $pesanan->produk->nama_produk }}</div>
                                                    <div class="d-none d-sm-block col-2">{{ $pesanan->jumlah_pesanan }}</div>
                                                    <div class="d-none d-sm-block col-2 text-95">{{ IDR($pesanan->harga) }}</div>
                                                    <div class="col-2 text-secondary-d2">{{ IDR($pesanan->jumlah_pesanan * $pesanan->harga) }}</div>
                                                </div> 
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="row border-b-2 brc-default-l2"></div>

                                    <div class="row mt-3">
                                        <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                                            
                                        </div>
                                        <div class="col-12 col-sm-5 text-120 order-first order-sm-last">
                                            <div class="row my-2">
                                                <div class="col-7 text-right">
                                                    Sub Total
                                                </div>
                                                <div class="col-5">
                                                    <span class="text-secondary-d1">{{ IDR($total_subtotal) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row mt-3">
                                        <div class="col-12 text-120">
                                                <div class="row my-2">
                                                    <div class="col-10 text-right">
                                                        Tagihan Total
                                                    </div>
                                                    <div class="col-2">
                                                        <span class="text-secondary-d1">{{ IDR($invoice->tagihan_saat_pesan) }}</span>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-12 text-120">
                                                <div class="row my-2">
                                                    <div class="col-10 text-right">
                                                        Jumlah Bayar
                                                    </div>
                                                    <div class="col-2">
                                                        <span class="text-secondary-d1">{{ IDR($invoice->jumlah_bayar) }}</span>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-12 text-120">
                                                <div class="row my-2">
                                                    <div class="col-10 text-right">
                                                        Tagihan Sisa
                                                    </div>
                                                    <div class="col-2">
                                                        <span class="text-secondary-d1">{{ IDR($invoice->tagihan_sisa) }}</span>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
