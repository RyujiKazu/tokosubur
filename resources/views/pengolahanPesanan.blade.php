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
                <h1 class="mt-4">Pengolahan Pesanan</h1>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Tabel Transaksi
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No Transaksi</th>
                                        <th>Jumlah</th>
                                        <th>Total Harga</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- 
                                        Catatan: Saya harus mengasumsikan jumlah galon/gas agar sesuai total harga
                                        Asumsi Harga: Galon = 7.000, Gas = 20.000
                                        Data dummy ini disesuaikan agar demonya berfungsi
                                    --}}
                                    <tr><td>TRX-001</td><td>3</td><td>Rp 34.000</td><td>2025/10/01</td><td><a href="#" class="btn btn-info btn-sm mr-1 button-detail" data-id="TRX-001" data-galon="2" data-gas="1">Detail</a><a href="#" class="btn btn-danger btn-sm button-delete" data-id="TRX-001">Delete</a></td></tr>
                                    <tr><td>TRX-002</td><td>4</td><td>Rp 80.000</td><td>2025/10/02</td><td><a href="#" class="btn btn-info btn-sm mr-1 button-detail" data-id="TRX-002" data-galon="0" data-gas="4">Detail</a><a href="#" class="btn btn-danger btn-sm button-delete" data-id="TRX-002">Delete</a></td></tr>
                                    <tr><td>TRX-003</td><td>3</td><td>Rp 21.000</td><td>2025/10/03</td><td><a href="#" class="btn btn-info btn-sm mr-1 button-detail" data-id="TRX-003" data-galon="3" data-gas="0">Detail</a><a href="#" class="btn btn-danger btn-sm button-delete" data-id="TRX-003">Delete</a></td></tr>
                                    <tr><td>TRX-004</td><td>2</td><td>Rp 40.000</td><td>2025/10/04</td><td><a href="#" class="btn btn-info btn-sm mr-1 button-detail" data-id="TRX-004" data-galon="0" data-gas="2">Detail</a><a href="#" class="btn btn-danger btn-sm button-delete" data-id="TRX-004">Delete</a></td></tr>
                                    <tr><td>TRX-005</td><td>1</td><td>Rp 27.000</td><td>2025/10/05</td><td><a href="#" class="btn btn-info btn-sm mr-1 button-detail" data-id="TRX-005" data-galon="1" data-gas="1">Detail</a><a href="#" class="btn btn-danger btn-sm button-delete" data-id="TRX-005">Delete</a></td></tr>
                                    <tr><td>TRX-006</td><td>5</td><td>Rp 35.000</td><td>2025/10/06</td><td><a href="#" class="btn btn-info btn-sm mr-1 button-detail" data-id="TRX-006" data-galon="5" data-gas="0">Detail</a><a href="#" class="btn btn-danger btn-sm button-delete" data-id="TRX-006">Delete</a></td></tr>
                                    <tr><td>TRX-007</td><td>4</td><td>Rp 54.000</td><td>2025/10/07</td><td><a href="#" class="btn btn-info btn-sm mr-1 button-detail" data-id="TRX-007" data-galon="2" data-gas="2">Detail</a><a href="#" class="btn btn-danger btn-sm button-delete" data-id="TRX-007">Delete</a></td></tr>
                                    <tr><td>TRX-008</td><td>1</td><td>Rp 20.000</td><td>2025/10/08</td><td><a href="#" class="btn btn-info btn-sm mr-1 button-detail" data-id="TRX-008" data-galon="0" data-gas="1">Detail</a><a href="#" class="btn btn-danger btn-sm button-delete" data-id="TRX-008">Delete</a></td></tr>
                                    {{-- Data dummy lainnya bisa mengikuti pola yang sama --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- [START] MODAL UNTUK DETAIL/UPDATE -->
        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Transaksi: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Form untuk update -->
                    <form id="detailForm" action="" method="POST">
                        @csrf
                        @method('PUT') <!-- Method spoofing untuk update -->
                        <div class="modal-body">
                            <p>Ubah jumlah barang untuk menghitung ulang total harga.</p>
                            
                            <!-- Input untuk ID Transaksi (disembunyikan) -->
                            <input type="hidden" id="detailTransactionId" name="transaction_id">

                            <div class="form-group">
                                <label for="detailJumlahGalon">Jumlah Galon</label>
                                <input type="number" id="detailJumlahGalon" name="jumlah_galon" class="form-control" min="0">
                            </div>
            
                            <div class="form-group">
                                <label for="detailJumlahGas">Jumlah Gas</label>
                                <input type="number" id="detailJumlahGas" name="jumlah_gas" class="form-control" min="0">
                            </div>
                        
                            <hr>
                            <div id="summary" class="mt-3">
                                <h4>Total Harga Baru:</h4>
                                <h3 id="detailTotalHarga">Rp 0</h3>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update Pesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- [END] MODAL UNTUK DETAIL/UPDATE -->


        <!-- [START] MODAL UNTUK KONFIRMASI DELETE -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Transaksi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- Form untuk delete -->
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE') <!-- Method spoofing untuk delete -->
                        <div class="modal-body">
                            <p id="deleteModalText">Apakah Anda yakin ingin menghapus transaksi ini?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Ya, Hapus Transaksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- [END] MODAL UNTUK KONFIRMASI DELETE -->


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
    {{-- Memanggil file JS eksternal yang baru --}}
    <script src="{{ asset('js/pengolahanPesanan.js') }}"></script>
@endpush

