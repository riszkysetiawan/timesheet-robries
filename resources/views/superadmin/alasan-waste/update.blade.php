@extends('superadmin.partials.createuser')
@section('title', 'Update Alasan Reject')
@section('container')
    <div class="container">
        <div class="container">

            <div class="row">
                <div id="flStackForm" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Update Alasan Reject Barang</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form id="editData">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="" class="form-label">Alasan</label>
                                        <input type="text" class="form-control" name="alasan"
                                            value="{{ $alasan->alasan }}" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-outline-success btn-rounded mb-2 me-4">
                                    Submit
                                </button>
                                <button type="button" class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                    onclick="window.location.href='{{ route('alasan-waste.admin.index') }}'">Kembali</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#editData').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('alasan-waste.admin.update', Crypt::encryptString($alasan->id)) }}",
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Berhasil!',
                            response.message,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href =
                                    '{{ route('alasan-waste.admin.index') }}';
                            }
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value + '\n';
                        });
                        Swal.fire('Error!', errorMessage, 'error');
                    }
                }
            });
        });
    </script>
@endsection
