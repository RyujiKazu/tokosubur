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
                                        <th>Id Produk</th>
                                        <th>Jumlah</th>
                                        <th>Total Harga</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>TRX-001</td><td>PROD-101</td><td>2</td><td>Rp 150.000</td><td>2025/10/01</td></tr>
                                    <tr><td>TRX-002</td><td>PROD-103</td><td>1</td><td>Rp 80.000</td><td>2025/10/02</td></tr>
                                    <tr><td>TRX-003</td><td>PROD-102</td><td>3</td><td>Rp 210.000</td><td>2025/10/03</td></tr>
                                    <tr><td>TRX-004</td><td>PROD-105</td><td>1</td><td>Rp 50.000</td><td>2025/10/04</td></tr>
                                    <tr><td>TRX-005</td><td>PROD-101</td><td>1</td><td>Rp 75.000</td><td>2025/10/05</td></tr>
                                    <tr><td>TRX-006</td><td>PROD-108</td><td>5</td><td>Rp 500.000</td><td>2025/10/06</td></tr>
                                    <tr><td>TRX-007</td><td>PROD-102</td><td>2</td><td>Rp 140.000</td><td>2025/10/07</td></tr>
                                    <tr><td>TRX-008</td><td>PROD-110</td><td>1</td><td>Rp 1.200.000</td><td>2025/10/08</td></tr>
                                    <tr><td>TRX-009</td><td>PROD-104</td><td>4</td><td>Rp 100.000</td><td>2025/10/09</td></tr>
                                    <tr><td>TRX-010</td><td>PROD-106</td><td>1</td><td>Rp 35.000</td><td>2025/10/10</td></tr>
                                    <tr><td>TRX-011</td><td>PROD-107</td><td>2</td><td>Rp 240.000</td><td>2025/10/11</td></tr>
                                    <tr><td>TRX-012</td><td>PROD-103</td><td>1</td><td>Rp 80.000</td><td>2025/10/12</td></tr>
                                    <tr><td>TRX-013</td><td>PROD-105</td><td>3</td><td>Rp 150.000</td><td>2025/10/13</td></tr>
                                    <tr><td>TRX-014</td><td>PROD-109</td><td>1</td><td>Rp 90.000</td><td>2025/10/14</td></tr>
                                    <tr><td>TRX-015</td><td>PROD-101</td><td>2</td><td>Rp 150.000</td><td>2025/10/15</td></tr>
                                    <tr><td>TRX-016</td><td>PROD-110</td><td>1</td><td>Rp 1.200.000</td><td>2025/10/16</td></tr>
                                    <tr><td>TRX-017</td><td>PROD-102</td><td>1</td><td>Rp 70.000</td><td>2025/10/17</td></tr>
                                    <tr><td>TRX-018</td><td>PROD-108</td><td>2</td><td>Rp 200.000</td><td>2025/10/18</td></tr>
                                    <tr><td>TRX-019</td><td>PROD-104</td><td>5</td><td>Rp 125.000</td><td>2025/10/19</td></tr>
                                    <tr><td>TRX-020</td><td>PROD-106</td><td>3</td><td>Rp 105.000</td><td>2025/10/20</td></tr>
                                    <tr><td>TRX-021</td><td>PROD-101</td><td>1</td><td>Rp 75.000</td><td>2025/10/21</td></tr>
                                    <tr><td>TRX-022</td><td>PROD-107</td><td>1</td><td>Rp 120.000</td><td>2025/10/22</td></tr>
                                    <tr><td>TRX-023</td><td>PROD-103</td><td>4</td><td>Rp 320.000</td><td>2025/10/23</td></tr>
                                    <tr><td>TRX-024</td><td>PROD-109</td><td>1</td><td>Rp 90.000</td><td>2025/10/24</td></tr>
                                    <tr><td>TRX-025</td><td>PROD-105</td><td>2</td><td>Rp 100.000</td><td>2025/10/25</td></tr>
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