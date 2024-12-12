@extends('admin.layout.layout')

@section('title', 'Presensi')

@section('title-bar', 'Presensi')

@section('content')
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Presensi</h4>
                    </div>
                    <div class="text-end m-2">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#Add"
                            class="btn btn-success shadow btn-xs sharp me-1"><i class="fa fa-add"></i></a>
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
                        <div class="table-responsive">
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
                                    @foreach ($presensi as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->jadwalPelajaran->kelas->name }}</td>
                                            <td>{{ $data->jadwalPelajaran->tahunAjaran->name }}</td>
                                            <td>{{ $data->jumlah_pertemuan }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#Edit{{ $data->id }}"
                                                        class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                            class="fa fa-pencil"></i></a>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#Delete{{ $data->id }}"
                                                        class="btn btn-danger shadow btn-xs sharp"><i
                                                            class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- edit -->
                                        <div class="modal fade" id="Edit{{ $data->id }}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                        </button>
                                                    </div>
                                                    <form action="/presensi/{{ $data->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <div class="modal-body">

                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label>Kelas</label>
                                                                    <select name="jadwal_pelajaran_id"
                                                                        id="jadwal_pelajaran_id{{ $data->id }}"
                                                                        class="form-control">
                                                                        <option value="">Pilih Jadwal Pelajaran
                                                                        </option>
                                                                        @foreach ($jadwalPelajaran as $data2)
                                                                            <option value="{{ $data2->id }}"
                                                                                {{ $data2->id == $data->jadwal_pelajaran_id ? 'selected' : '' }}>
                                                                                {{ $data2->kelas->name }} -
                                                                                {{ $data2->tahunAjaran->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label>Jumlah Pertemuan</label>
                                                                    <input type="text" name="jumlah_pertemuan"
                                                                        class="form-control" placeholder="Jumlah Pertemuan"
                                                                        value="{{ $data->jumlah_pertemuan }}">
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger light"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                Changes</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- edit -->
                                        <!-- delete -->
                                        <div class="modal fade" id="Delete{{ $data->id }}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">Anda Yakin Akan Menghapus {{ $data->name }} ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <form action="/presensi/{{ $data->id }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-primary">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- delete -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- add -->
        <div class="modal fade" id="Add">
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
                                    <label>Kelas</label>
                                    <select name="jadwal_pelajaran_id" id="jadwal_pelajaran_id" class="form-control">
                                        <option value="">Pilih Jadwal Pelajaran</option>
                                        @foreach ($jadwalPelajaran as $data)
                                            <option value="{{ $data->id }}">{{ $data->kelas->name }} -
                                                {{ $data->tahunAjaran->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label>Jumlah Pertemuan</label>
                                    <input type="text" name="jumlah_pertemuan" class="form-control"
                                        placeholder="Jumlah Pertemuan">
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
        </div>
        <!-- add -->
    </div>
@endsection

@section('script')

    @foreach ($presensi as $data)
        <script>
            $('#adwal_pelajaran_id{{ $data->id }}').select2({
                dropdownParent: $('#Edit{{ $data->id }}'),
                width: '100%',
            });
        </script>
    @endforeach

    <script>
        $('#jadwal_pelajaran_id').select2({
            dropdownParent: $('#Add'),
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
