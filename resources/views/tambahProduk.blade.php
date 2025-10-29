@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ url('/') }}">Toko Subur Gas</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark">
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
                        <a class="nav-link" href="{{ url('/tambahProduk') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-plus-circle"></i></div>
                            Tambah Produk
                        </a>
                        <a class="nav-link" href="{{ url('/PengolahanPesanan') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Pengolahan Pesanan
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Tambah Produk Baru</h1>

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

                    {{-- Pesan sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-edit mr-1"></i>
                            Form Tambah Produk
                        </div>
                        <div class="card-body">
                            <form action="{{ route('produk.store') }}" method="POST" id="addProductForm">
                                @csrf

                                <div id="product-add-list">
                                    <!-- Baris produk dinamis dibuat via JS -->
                                </div>

                                <div class="row mt-2">
                                    <div class="col">
                                        <button type="button" class="btn btn-success" id="add-product-row">+ Tambah
                                            Produk</button>
                                    </div>
                                </div>

                                <hr>
                                <button type="submit" class="btn btn-primary mt-3">Simpan Produk</button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-box"></i> Daftar Produk Saat Ini
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Tanggal Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $index => $product)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $product->nama_product }}</td>
                                            <td>Rp {{ number_format($product->harga_product, 0, ',', '.') }}</td>
                                            <td>{{ $product->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada produk ditambahkan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Toko Subur Gas {{ date('Y') }}</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/tambahProduk.js') }}"></script>
@endpush
