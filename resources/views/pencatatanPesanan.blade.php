@extends('layouts.app')

@section('title','Toko Subur Gas')

@section('content')
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ url('/') }}">Toko Subur Gas</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
            <div class="input-group-append">
                <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">Settings</a>
                <a class="dropdown-item" href="#">Activity Log</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ url('/login') }}">Logout</a>
            </div>
        </li>
    </ul>
</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Menu</div>
                    <a class="nav-link" href="{{ url('/') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Laporan Penjualan
                    </a>
                    <a class="nav-link" href="{{ url('/PencatatanPesanan') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Pencatatan Pesanan
                    </a>
                    <a class="nav-link" href="{{ url('/PengolahanPesanan') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Pengolahan Pesanan
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Start Bootstrap
            </div>
        </nav>
    </div>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Pencatatan Pesanan</h1>

                {{-- Tampilkan error validasi jika ada --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Terjadi kesalahan:<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                {{-- Tampilkan pesan error dari controller --}}
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif


                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-edit mr-1"></i>
                        Buat Pesanan Baru
                    </div>
                    <div class="card-body">
                        
                        <form action="{{ route('pesanan.store') }}" method="POST" id="orderForm"> 
                            @csrf

                            {{-- Container untuk baris-baris produk dinamis --}}
                            <div id="product-order-list">
                                <!-- Baris produk dinamis akan muncul di sini (dibuat oleh JS) -->
                            </div>
                            
                            {{-- Tombol untuk menambah baris produk baru --}}
                            <div class="row mt-2">
                                <div class="col">
                                    <button type="button" class="btn btn-success" id="add-product-row">+ Tambah Produk</button>
                                </div>
                            </div>
                            
                            <hr>

                            <div id="summary" class="mt-3">
                                <h4>Total Harga:</h4>
                                <h3 id="total-harga">Rp 0</h3>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Buat Pesanan</button>

                        </form>

                    </div>
                </div>
            </div>
        </main>

        <!-- Modal Konfirmasi (HTML tetap sama) -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">Konfirmasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modalBodyId">
                        <!-- Konten diisi oleh JS -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="confirmSubmitButton">Buat</button>
                    </div>
                </div>
            </div>
        </div>

        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website {{ date('Y') }}</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        // Variabel global yang akan dibaca oleh pencatatanPesanan.js
        window.PRODUCT_DATA = {!! json_encode($products->map(function($product) {
            return [
                'id_product' => $product->id_product,
                'nama_product' => $product->nama_product,
                'harga_product' => $product->harga_product
            ];
        })) !!};
    </script>

    {{-- Memanggil file JS yang sudah kita perbarui --}}
    <script src="{{ asset('js/pencatatanPesanan.js') }}"></script>
@endpush
