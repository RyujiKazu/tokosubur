@extends('layouts.app')

@section('title', 'Toko Subur Gas')

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

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
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
                                    {{-- Baris produk baru akan ditambahkan oleh JS --}}
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
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products->sortBy('created_at') as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $product->nama_product }}</td>
                                            <td>Rp {{ number_format($product->harga_product, 0, ',', '.') }}</td>
                                            <td>{{ $product->created_at->format('d M Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" 
                                                        data-toggle="modal" 
                                                        data-target="#editModal" 
                                                        data-id="{{ $product->id_product }}" 
                                                        data-nama="{{ $product->nama_product }}" 
                                                        data-harga="{{ $product->harga_product }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                
                                                <form action="{{ route('produk.destroy', $product->id_product) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->nama_product }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada produk ditambahkan
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

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editProductForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        
                        @if ($errors->edit_error->any())
                             <div class="alert alert-danger">
                                <strong>Whoops!</strong> Terjadi kesalahan:<br><br>
                                <ul>
                                    @foreach ($errors->edit_error->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="edit_nama_product">Nama Produk</label>
                            <input type="text" class="form-control" id="edit_nama_product" name="nama_product" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_harga_product">Harga Produk</label>
                            <input type="number" class="form-control" id="edit_harga_product" name="harga_product" min="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/tambahProduk.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); 
                
                
                var id = button.data('id');
                var nama = button.data('nama');
                var harga = button.data('harga');

                var modal = $(this);

                var actionUrl = '{{ url("produk") }}/' + id;
                modal.find('#editProductForm').attr('action', actionUrl);

                modal.find('#edit_nama_product').val(nama);
                modal.find('#edit_harga_product').val(harga);
            });

            @if ($errors->edit_error->any() && session('error_modal_id'))
                var oldNama = '{{ old('nama_product') }}';
                var oldHarga = '{{ old('harga_product') }}';
                var id = {{ session('error_modal_id') }};

                var modal = $('#editModal');

                var actionUrl = '{{ url("produk") }}/' + id;
                modal.find('#editProductForm').attr('action', actionUrl);

                modal.find('#edit_nama_product').val(oldNama);
                modal.find('#edit_harga_product').val(oldHarga);
                
                modal.modal('show');
            @endif
        });
    </script>
@endpush