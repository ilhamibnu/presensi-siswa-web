@extends('admin.layout.layout')

@section('title', 'Jadwal Pelajaran')

@section('title-bar', 'Jadwal Pelajaran')

@section('content')
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Jadwal Pelajaran</h4>
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
                                        <th>Jadwal</th>
                                        @if (Auth::user()->role->name == 'Admin')
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwalpelajaran as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->kelas->name }}</td>
                                            <td>{{ $data->tahunAjaran->name }}</td>
                                            <td>
                                                @if ($data->detailJadwalPelajaran->isEmpty())
                                                    <span class="text-muted">Tidak ada jadwal</span>
                                                @else
                                                    <ul>
                                                        @foreach ($data->detailJadwalPelajaran->groupBy('hari_id') as $hariId => $details)
                                                            <li>
                                                                {{ $details->first()->hari->name }}:
                                                                {{ $details->pluck('mataPelajaran.name')->join(', ') }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                            @if (Auth::user()->role->name == 'Admin')
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
                                            @endif
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
                                                    <form action="/jadwal-pelajaran/{{ $data->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <div class="modal-body">

                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label>Kelas</label>
                                                                    <select name="kelas_id"
                                                                        id="kelas-select-edit{{ $data->id }}"
                                                                        class="form-control">
                                                                        <option value="">Pilih Kelas</option>
                                                                        @foreach ($kelas as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ $item->id == $data->kelas_id ? 'selected' : '' }}>
                                                                                {{ $item->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <label>Tahun Ajaran</label>
                                                                    <select name="tahun_ajaran_id"
                                                                        id="tahun_ajaran-edit{{ $data->id }}"
                                                                        class="form-control">
                                                                        <option value="">Pilih Tahun Ajaran</option>
                                                                        @foreach ($tahun_ajaran as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ $item->id == $data->tahun_ajaran_id ? 'selected' : '' }}>
                                                                                {{ $item->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            @foreach ($hari as $item)
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <label>{{ $item->name }}</label>
                                                                        <select
                                                                            name="mata_pelajaran_id[{{ $item->id }}][]"
                                                                            id="pilih-mapel-edit{{ $item->id }}"
                                                                            class="form-control" multiple="multiple">
                                                                            <option value="">Pilih Mapel</option>
                                                                            @foreach ($matapelajaran as $mapel)
                                                                                <option value="{{ $mapel->id }}"
                                                                                    {{ $data->detailJadwalPelajaran->where('hari_id', $item->id)->pluck('mata_pelajaran_id')->contains($mapel->id)? 'selected': '' }}>
                                                                                    {{ $mapel->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <input type="hidden" name="hari_id[]"
                                                                            value="{{ $item->id }}">
                                                                    </div>
                                                                </div>
                                                            @endforeach
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
                                                        <form action="/jadwal-pelajaran/{{ $data->id }}"
                                                            method="post">
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
        <div class="modal fade" id="Add">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="/jadwal-pelajaran" method="post">
                        @csrf
                        <div class="modal-body">

                            <div class="row">
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select name="kelas_id" id="kelas-select" class="form-control">
                                        <option value="">Pilih Kelas</option>
                                        @foreach ($kelas as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select name="tahun_ajaran_id" id="tahun_ajaran" class="form-control">
                                        <option value="">Pilih Tahun Ajaran</option>
                                        @foreach ($tahun_ajaran as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @foreach ($hari as $data)
                                <div class="row">
                                    <div class="form-group">
                                        <label>{{ $data->name }}</label>
                                        <select name="mata_pelajaran_id[{{ $data->id }}][]"
                                            id="pilih-mapel{{ $data->id }}" class="form-control"
                                            multiple="multiple">
                                            <option value="">Pilih Mapel</option>
                                            @foreach ($matapelajaran as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="hari_id[]" value="{{ $data->id }}">
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')

    {{-- // edit --}}

    @foreach ($jadwalpelajaran as $jp)
        <script>
            $('#kelas-select-edit{{ $jp->id }}').select2({
                dropdownParent: $('#Edit{{ $jp->id }}'),
                width: '100%'
            });
        </script>

        <script>
            $('#tahun_ajaran-edit{{ $jp->id }}').select2({
                dropdownParent: $('#Edit{{ $jp->id }}'),
                width: '100%'
            });
        </script>
    @endforeach

    @foreach ($jadwalpelajaran as $jp)
        @foreach ($hari as $hr)
            <script>
                $('#pilih-mapel-edit{{ $hr->id }}').select2({
                    dropdownParent: $('#Edit{{ $jp->id }}'),
                    width: '100%',
                });
            </script>
        @endforeach
    @endforeach
    @foreach ($hari as $hr)
        <script>
            $('#pilih-mapel-edit{{ $hr->id }}').select2({
                dropdownParent: $('#Edit{{ $hr->id }}'),
                width: '100%',
            });
        </script>
    @endforeach


    {{-- // add --}}

    <script>
        $('#kelas-select').select2({
            dropdownParent: $('#Add'),
            width: '100%'
        });
    </script>

    @foreach ($hari as $data)
        <script>
            $('#pilih-mapel{{ $data->id }}').select2({
                dropdownParent: $('#Add'),
                width: '100%',
            });
        </script>
    @endforeach

    <script>
        $('#tahun_ajaran').select2({
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
