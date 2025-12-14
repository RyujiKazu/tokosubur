@extends('layouts.app')

@section('title', 'Dashboard - Toko Subur Gas')

@section('content')
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ url('/') }}">Toko Subur Gas</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i> Admin
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">Pengaturan</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url('/logout') }}">Keluar</a>
                </div>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu Utama</div>
                        <a class="nav-link active" href="{{ url('/') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard / Laporan
                        </a>
                        <a class="nav-link" href="{{ url('/PencatatanPesanan') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Pencatatan Pesanan
                        </a>
                        <a class="nav-link" href="{{ url('/tambahProduk') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Data Produk
                        </a>
                        <a class="nav-link" href="{{ url('/PengolahanPesanan') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                            Pengolahan Pesanan
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Login sebagai:</div>
                    Admin Toko
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Dashboard Penjualan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Ringkasan hari ini</li>
                    </ol>

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Pendapatan Hari Ini</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <span class="h4">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</span>
                                    <div class="small text-white"><i class="fas fa-money-bill-wave"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Transaksi Hari Ini</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <span class="h4">{{ $jumlahTransaksi }} Transaksi</span>
                                    <div class="small text-white"><i class="fas fa-shopping-cart"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Total Produk</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <span class="h4">{{ $totalProduk }} Item</span>
                                    <div class="small text-white"><i class="fas fa-box"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area mr-1"></i>
                                    Tren Penjualan (Minggu Ini)
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar mr-1"></i>
                                    Penjualan per Jenis Gas
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Riwayat Transaksi Terakhir
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Jenis Gas</th>
                                            <th>Jumlah</th>
                                            <th>Total Harga</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($riwayatTransaksi as $item)
                                            <tr>
                                                <td>{{ $item->no_transaksi }}</td>

                                                <td>{{ $item->tanggal->format('d M Y H:i') }}</td>

                                                <td>{{ $item->produk->nama_product ?? 'Produk Dihapus' }}</td>

                                                <td>{{ $item->qty }}</td>

                                                <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada transaksi hari ini.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <script>
        // Kita buat variabel global 'chartData' agar bisa dibaca oleh file external
        var chartData = {
            tglArea: @json($tglArea),
            dataArea: @json($dataArea),
            labelBar: @json($labelBar),
            dataBar: @json($dataBar)
        };
    </script>

    <script src="{{ asset('js/dashboard-charts.js') }}"></script>
@endsection
