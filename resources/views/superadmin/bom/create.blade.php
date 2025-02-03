@extends('superadmin.partials.createbom')
@section('title', 'Tambah BOM')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row mb-4 layout-spacing layout-top-spacing">
                <div class="col-xxl-9 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <form id="simpanBom">
                        @csrf
                        <div class="widget-content widget-content-area ecommerce-create-section">
                            <div class="row mb-4">
                                <div class="col-sm-9">
                                    <label for="">Pilih Produk</label>
                                    <select name="kode_product" class="form-control" id="kode_product">
                                        <option value="">Pilih Produk</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->kode_produk }}">{{ $product->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label for="">Gramasi Utama</label>
                                    <input type="number" name="qty" class="form-control" id="qty" value="">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 mt-xxl-0 mt-4">
                            <div class="widget-content widget-content-area ecommerce-create-section">
                                <div id="raw-materials-container">
                                    <div class="row mb-4">
                                        <div class="col-xxl-12 col-md-6 mb-4">
                                            <label for="">Bahan Utama</label>
                                            <select name="kode_barang[]" class="form-control kode_bahan">
                                                <option value="">Pilih Bahan</option>
                                                @foreach ($barangs as $barang)
                                                    <option value="{{ $barang->kode_barang }}">{{ $barang->nama_barang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xxl-12 col-md-3 mb-4">
                                            <label>Presentase Bahan</label>
                                            <input type="text" name="persentase[]" class="form-control persentase">
                                        </div>
                                        <div class="col-xxl-12 col-md-3 mb-4">
                                            <label>Gramasi Bahan</label>
                                            <input type="number" name="gramasi[]" class="form-control gramasi" readonly>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-success" id="btntambah" type="button">Tambah Raw Materials</button>
                                <button class="btn btn-danger" id="btnhapus" type="button">Hapus Raw Materials</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-success" id="btnSimpan" type="submit">Simpan</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            let materialCount = 1;

            // Aktifkan Select2 untuk elemen awal
            $('#kode_product').select2();
            $('.kode_bahan').select2();

            // Perhitungan gramasi saat halaman dimuat
            function calculateGramasiForAll() {
                const qty = parseFloat($('#qty').val()) || 0;
                $('.persentase').each(function(index) {
                    const presentase = parseFloat($(this).val()) || 0;
                    const gramasi = (qty * presentase) / 100;
                    // Update input gramasi dengan hasil perhitungan
                    $(this).closest('.row').find('.gramasi').val(gramasi.toFixed(2));
                });
            }

            // Perhitungan Gramasi berdasarkan Presentase dan Qty
            $(document).on('input', '.persentase', function() {
                calculateGramasiForAll();
            });

            // Update semua gramasi jika qty berubah
            $('#qty').on('input', function() {
                calculateGramasiForAll();
            });

            // Tambahkan Raw Materials baru
            $('#btntambah').click(function() {
                materialCount++;

                const rawMaterialHTML = `
        <div class="row mb-4" id="raw-material-${materialCount}">
            <div class="col-xxl-12 col-md-6 mb-4">
                <label for="">Bahan Utama</label>
                <select name="kode_barang[]" class="form-control kode_bahan">
                    <option value="">Pilih Bahan</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->kode_barang }}">{{ $barang->nama_barang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xxl-12 col-md-3 mb-4">
                <label>Presentase Bahan</label>
                <input type="text" name="persentase[]" class="form-control persentase" data-material="${materialCount}">
            </div>
            <div class="col-xxl-12 col-md-3 mb-4">
                <label>Gramasi Bahan</label>
                <input type="number" name="gramasi[]" class="form-control gramasi" id="gramasi-${materialCount}">
            </div>
        </div>`;

                $('#raw-materials-container').append(rawMaterialHTML);
                $('.kode_bahan').select2();

                // Perhitungan gramasi untuk raw material baru
                calculateGramasiForAll();
            });


            // Hapus Raw Materials terakhir
            $('#btnhapus').click(function() {
                if (materialCount > 1) {
                    $(`#raw-material-${materialCount}`).remove();
                    materialCount--;
                    calculateGramasiForAll(); // Update setelah hapus
                }
            });

            // Perhitungan gramasi otomatis setelah halaman dimuat pertama kali
            calculateGramasiForAll();

            $('#simpanBom').on('submit', function(e) {
                e.preventDefault(); // Mencegah form submit langsung

                // Ambil data dari form
                let formData = {
                    kode_product: $('#kode_product').val(),
                    qty: $('#qty').val(),
                    kode_barang: $("input[name='kode_barang[]']").map(function() {
                        return $(this).val();
                    }).get(),
                    persentase: $("input[name='persentase[]']").map(function() {
                        return $(this).val();
                    }).get(),
                    gramasi: $("input[name='gramasi[]']").map(function() {
                        return $(this).val();
                    }).get()
                };

                // Kirim data ke server menggunakan AJAX
                $.ajax({
                    url: "{{ route('bom.admin.store') }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                            }).then(() => {
                                window.location
                                    .href =
                                    '{{ route('bom.admin.index') }}'; // Reload halaman atau redirect
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors; // Ambil error dari response
                        let errorMessage = 'Terjadi kesalahan:\n';

                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage +=
                                    `- ${errors[key][0]}\n`; // Ambil pesan error pertama
                            }
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: errorMessage,
                        });
                    }
                });
            });
        });
    </script>
@endsection
