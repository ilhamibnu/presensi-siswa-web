@extends('admin.layout.layout')

@section('title', 'Detail Presensi 2')

@section('title-bar', 'Detail Presensi 2')

@section('content')
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Detail Presensi 2</h4>
                    </div>
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
                        <form method="POST" action="{{ route('rekap.kelas') }}">
                            @csrf
                            <div>
                                <label for="tahun_ajaran">Tahun Ajaran:</label>
                                <select id="tahun_ajaran" name="tahun_ajaran_id" class="form-control">
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    @foreach ($tahunajaran as $ta)
                                        <option value="{{ $ta->id }}">{{ $ta->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="kelas">Kelas:</label>
                                <select id="kelas" name="kelas_id" class="form-control" disabled>
                                    <option value="">-- Pilih Kelas --</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Generate Rekap</button>
                        </form>

                        @if (!empty($rekapPresensi_2) && $rekapPresensi_2 !== '0')
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Siswa</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Pertemuan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rekapPresensi_2 as $data)
                                            <tr>
                                                <td rowspan="{{ count($data['status_per_pertemuan']) }}">
                                                    {{ $data['name'] }}</td>
                                                <td rowspan="{{ count($data['status_per_pertemuan']) }}">
                                                    {{ $data['mata_pelajaran'] ?? 'Mata Pelajaran Tidak Ditemukan' }}</td>
                                                @foreach ($data['status_per_pertemuan'] as $key => $pertemuan)
                                                    @if ($key > 0)
                                            <tr>
                                        @endif
                                        <td>Pertemuan {{ $pertemuan }}</td>
                                        <td>{{ $pertemuan }}</td>
                                        @if ($key > 0)
                                            </tr>
                                        @endif
                        @endforeach
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning mt-3">Data presensi tidak ditemukan.</div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function() {
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

            $('#kelas').change(function() {
                let kelasId = $(this).val();
                $('#mata_pelajaran').prop('disabled', true).html(
                    '<option value="">-- Pilih Mata Pelajaran --</option>');

                if (kelasId) {
                    $.ajax({
                        url: "{{ route('getMataPelajaranByKelas') }}",
                        type: "GET",
                        data: {
                            kelas_id: kelasId
                        },
                        success: function(data) {
                            if (Array.isArray(data)) {
                                $('#mata_pelajaran').prop('disabled', false);
                                data.forEach(mataPelajaran => {
                                    $('#mata_pelajaran').append(
                                        `<option value="${mataPelajaran.id}">${mataPelajaran.name}</option>`
                                    );
                                });
                            } else {
                                console.error('Data is not an array:', data);
                            }
                        },
                        error: function(xhr) {
                            console.error('Error fetching mata pelajaran:', xhr);
                        }
                    });
                }
            });
        });
    </script>


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
        $('#test').DataTable({
            autoWidth: true,
            // "lengthMenu": [
            //     [16, 32, 64, -1],
            //     [16, 32, 64, "All"]
            // ]
            dom: 'Bfrtip',


            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],

            buttons: [{
                    extend: 'colvis',
                    className: 'btn btn-primary btn-sm',
                    text: 'Column Visibility',
                    // columns: ':gt(0)'


                },

                {

                    extend: 'pageLength',
                    className: 'btn btn-primary btn-sm',
                    text: 'Page Length',
                    // columns: ':gt(0)'
                },


                // 'colvis', 'pageLength',

                {
                    extend: 'excel',
                    className: 'btn btn-primary btn-sm',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },

                // {
                //     extend: 'csv',
                //     className: 'btn btn-primary btn-sm',
                //     exportOptions: {
                //         columns: [0, ':visible']
                //     }
                // },
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
                },

                // 'pageLength', 'colvis',
                // 'copy', 'csv', 'excel', 'print'

            ],
        });
    </script>


@endsection
