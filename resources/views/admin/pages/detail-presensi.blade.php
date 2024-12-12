@extends('admin.layout.layout')

@section('title', 'Detail Presensi')

@section('title-bar', 'Detail Presensi')

@section('content')
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Detail Presensi</h4>
                    </div>
                    {{-- <div class="text-end m-2">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#Add"
                            class="btn btn-success shadow btn-xs sharp me-1"><i class="fa fa-add"></i></a>
                    </div> --}}
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mt-2">



                                <?php
                                
                                $nomer = 1;
                                
                                ?>

                                @foreach ($errors->all() as $error)
                                    <li>{{ $nomer++ }}. {{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
                        {{-- <div class="table-responsive">
                            <table id="test" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kelas</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Jumlah Pertemuan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>XII RPL 1</td>
                                        <td>2021/2022</td>
                                        <td>10</td>
                                        <td>
                                            -
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div> --}}
                        <div>
                            <label for="tahun_ajaran">Tahun Ajaran:</label>
                            <select id="tahun_ajaran" class="form-control">
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach ($tahunajaran as $ta)
                                    <option value="{{ $ta->id }}">{{ $ta->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="kelas">Kelas:</label>
                            <select id="kelas" class="form-control" disabled>
                                <option value="">-- Pilih Kelas --</option>
                            </select>
                        </div>

                        <div>
                            <label for="pertemuan">Pertemuan:</label>
                            <select id="pertemuan" class="form-control" disabled>
                                <option value="">-- Pilih Pertemuan --</option>
                            </select>
                        </div>

                        <div>
                            <label for="hari">Hari:</label>
                            <select id="hari" class="form-control" disabled>
                                <option value="">-- Pilih Hari --</option>
                            </select>
                        </div>

                        <div>
                            <label for="mata_pelajaran">Mata Pelajaran:</label>
                            <select id="mata_pelajaran" class="form-control" disabled>
                                <option value="">-- Pilih Mata Pelajaran --</option>
                            </select>
                        </div>


                        <div class="table-responsive">
                            <table id="test" class="display min-w850">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Siswa</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editStatusModal" tabindex="-1" role="dialog" aria-labelledby="editStatusLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStatusLabel">Edit Status Presensi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="siswaId">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control" aria-placeholder="Pilih Status">
                                <option selected value="Hadir">Hadir</option>
                                <option value="Tidak Hadir">Tidak Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveStatus">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- add -->
        {{-- <div class="modal fade" id="Add">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <form action="/presensi" method="post">
                        @csrf
                        <div class="modal-body">

                            <div class="row">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Test">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>

                </div>
            </div>
        </div> --}}
        <!-- add -->
    </div>
@endsection

@section('script')

    <script>
        $('#tahun_ajaran').select2({
            width: '100%'
        });

        $('#kelas').select2({
            width: '100%'
        });

        $('#pertemuan').select2({
            width: '100%'
        });

        $('#hari').select2({
            width: '100%'
        });

        $('#mata_pelajaran').select2({
            width: '100%'
        });
    </script>

    <script>
        $(document).ready(function() {
            // Load kelas berdasarkan tahun ajaran
            $('#tahun_ajaran').change(function() {
                let tahunAjaranId = $(this).val();
                $('#kelas').prop('disabled', true).html('<option value="">-- Pilih Kelas --</option>');
                if (tahunAjaranId) {
                    $.ajax({
                        url: "{{ route('getKelasByTahunAjaran') }}",
                        type: "GET",
                        data: {
                            tahun_ajaran_id: tahunAjaranId
                        },
                        success: function(data) {
                            $('#kelas').prop('disabled', false);
                            data.forEach(kelas => {
                                $('#kelas').append(
                                    `<option value="${kelas.id}">${kelas.name}</option>`
                                );
                            });
                        }
                    });
                }
            });

            // Load pertemuan berdasarkan kelas
            $('#kelas').change(function() {
                let kelasId = $(this).val();
                $('#pertemuan').prop('disabled', true).html(
                    '<option value="">-- Pilih Pertemuan --</option>');
                if (kelasId) {
                    $.ajax({
                        url: "{{ route('getPertemuanByKelas') }}",
                        type: "GET",
                        data: {
                            kelas_id: kelasId
                        },
                        success: function(data) {
                            $('#pertemuan').prop('disabled', false);
                            data.forEach(pertemuan => {
                                $('#pertemuan').append(
                                    `<option value="${pertemuan.id}">${pertemuan.name}</option>`
                                );
                            });
                        }
                    });
                }
            });

            // Load hari berdasarkan pertemuan
            $('#pertemuan').change(function() {
                let pertemuanId = $(this).val();
                $('#hari').prop('disabled', true).html('<option value="">-- Pilih Hari --</option>');
                if (pertemuanId) {
                    $.ajax({
                        url: "{{ route('getHariByPertemuan') }}",
                        type: "GET",
                        data: {
                            pertemuan_id: pertemuanId
                        },
                        success: function(data) {
                            $('#hari').prop('disabled', false);
                            data.forEach(hari => {
                                $('#hari').append(
                                    `<option value="${hari.id}">${hari.name}</option>`
                                );
                            });
                        }
                    });
                }
            });

            // Load mata pelajaran berdasarkan hari
            $('#hari').change(function() {
                let hariId = $(this).val();
                let kelasId = $('#kelas').val();
                $('#mata_pelajaran').prop('disabled', true).html(
                    '<option value="">-- Pilih Mata Pelajaran --</option>');
                if (hariId) {
                    $.ajax({
                        url: "{{ route('getMataPelajaranByHari') }}",
                        type: "GET",
                        data: {
                            hari_id: hariId,
                            kelas_id: kelasId
                        },
                        success: function(data) {
                            $('#mata_pelajaran').prop('disabled', false);
                            data.forEach(mp => {
                                $('#mata_pelajaran').append(
                                    `<option value="${mp.id}">${mp.name}</option>`);
                            });
                        }
                    });
                }
            });

            // // Load siswa berdasarkan semua filter
            // $('#mata_pelajaran').change(function() {
            //     let kelasId = $('#kelas').val();
            //     $.ajax({
            //         url: "{{ route('getSiswaByFilter') }}",
            //         type: "GET",
            //         data: {
            //             kelas_id: kelasId
            //         },
            //         success: function(data) {
            //             let tbody = $('#test tbody');
            //             tbody.html('');
            //             data.forEach((siswa, index) => {
            //                 tbody.append(
            //                     `<tr><td>${index + 1}</td><td>${siswa.name}</td></tr>`
            //                 );
            //             });
            //         }
            //     });
            // });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            let siswaTable = $('#test').DataTable({
                autoWidth: true,
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                buttons: [{
                        extend: 'colvis',
                        className: 'btn btn-primary btn-sm',
                        text: 'Column Visibility'
                    },
                    {
                        extend: 'pageLength',
                        className: 'btn btn-primary btn-sm',
                        text: 'Page Length'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-primary btn-sm',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-primary btn-sm',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary btn-sm',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    }
                ]
            });

            // Load siswa berdasarkan semua filter
            $('#mata_pelajaran').change(function() {
                let kelasId = $('#kelas').val();
                let mataPelajaranId = $(this).val();
                let hariId = $('#hari').val();
                let pertemuanId = $('#pertemuan').val();

                $.ajax({
                    url: "{{ route('getSiswaByFilter') }}",
                    type: "GET",
                    data: {
                        kelas_id: kelasId,
                        mata_pelajaran_id: mataPelajaranId,
                        hari_id: hariId,
                        pertemuan_id: pertemuanId
                    },
                    success: function(data) {
                        siswaTable.clear();
                        data.forEach((siswa, index) => {
                            siswaTable.row.add([
                                index + 1,
                                siswa.name,
                                siswa.status,
                                `<button class="btn btn-primary btn-sm edit-status" data-id="${siswa.id}" data-status="${siswa.status}">Edit</button>`
                            ]);
                        });
                        siswaTable.draw();
                    }
                });
            });

            $('#test').on('click', '.edit-status', function() {
                let siswaId = $(this).data('id');
                let status = $(this).data('status');
                // Isi data di modal
                $('#editStatusModal #siswaId').val(siswaId);
                $('#editStatusModal #status').val(status);
                $('#editStatusModal').modal('show');
            });

            // Submit perubahan status
            $('#saveStatus').click(function() {
                let siswaId = $('#editStatusModal #siswaId').val();
                let status = $('#editStatusModal #status').val();
                let mataPelajaranId = $('#mata_pelajaran').val();
                let hariId = $('#hari').val();
                let pertemuanId = $('#pertemuan').val();

                $.ajax({
                    url: "{{ route('updateStatusPresensi') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        siswa_id: siswaId,
                        status: status,
                        mata_pelajaran_id: mataPelajaranId,
                        hari_id: hariId,
                        pertemuan_id: pertemuanId,
                    },
                    success: function(response) {
                        $('#editStatusModal').modal('hide');
                        $('#mata_pelajaran').trigger('change');
                        toastr.success('Status berhasil diubah', 'Success', {
                            timeOut: 5000,
                            closeButton: !0,
                            debug: !1,
                            newestOnTop: !0,
                            progressBar: !0,
                            positionClass: "toast-top-right",
                            preventDuplicates: !0,
                            onclick: null,
                            showDuration: "300",
                            hideDuration: "1000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                            tapToDismiss: !1
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
