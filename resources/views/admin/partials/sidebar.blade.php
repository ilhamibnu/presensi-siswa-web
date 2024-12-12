<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li><a class="ai-icon @if (request()->is('dashboard')) mm-active @endif" href="/dashboard"
                    aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>

            </li>
            {{-- <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-internet"></i>
                    <span class="nav-text">Data Kriteria</span>
                </a>
                <ul aria-expanded="false">
                    <li @if (request()->is('data-kriteria')) mm-active @endif><a href="/data-kriteria">Kriteria</a></li>
                    <li @if (request()->is('data-subkriteria')) mm-active @endif><a href="/data-subkriteria">Sub Kriteria</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-internet"></i>
                    <span class="nav-text">Data WHO</span>
                </a>
                <ul aria-expanded="false">
                    <li @if (request()->is('data-tinggi-badan-perempuan-umur')) mm-active @endif><a href="/data-tinggi-badan-perempuan-umur">Tinggi Badan Perempuan Umur</a></li>
                    <li @if (request()->is('data-berat-badan-perempuan-umur')) mm-active @endif><a href="/data-berat-badan-perempuan-umur">Berat Badan Perempuan Umur</a></li>
                    <li @if (request()->is('data-tinggi-badan-laki-laki-umur')) mm-active @endif><a href="/data-tinggi-badan-laki-umur">Tinggi Badan Laki-laki Umur</a></li>
                    <li @if (request()->is('data-berat-badan-laki-laki-umur')) mm-active @endif><a href="/data-berat-badan-laki-umur">Berat Badan Laki-laki Umur</a></li>
                </ul>
            </li> --}}

            @if (Auth::user()->role->name == 'Admin')
                <li><a href="/presensi" class="ai-icon @if (request()->is('presensi')) mm-active @endif"
                        aria-expanded="false">
                        <i class="fa fa-calendar-check"></i>
                        <span class="nav-text">Presensi</span>
                    </a>
                </li>
            @endif

            <li><a href="/detail-presensi" class="ai-icon @if (request()->is('detail-presensi')) mm-active @endif"
                    aria-expanded="false">
                    <i class="fa fa-calendar-check"></i>
                    <span class="nav-text">Detail Presensi</span>
                </a>
            </li>

            <li><a href="/rekap-presensi" class="ai-icon @if (request()->is('rekap-presensi')) mm-active @endif"
                    aria-expanded="false">
                    <i class="fa fa-database"></i>
                    <span class="nav-text">Rekap Presensi </span>
                </a>
            </li>

            {{-- <li><a href="/rekap-presensi2" class="ai-icon @if (request()->is('rekap-presensi2')) mm-active @endif"
                    aria-expanded="false">
                    <i class="fa fa-database"></i>
                    <span class="nav-text">Rekap Presensi 2</span>
                </a>
            </li> --}}

            @if (Auth::user()->role->name == 'Admin')
                <li><a href="/tahun-ajaran" class="ai-icon @if (request()->is('tahun-ajaran')) mm-active @endif"
                        aria-expanded="false">
                        <i class="fa fa-calendar"></i>
                        <span class="nav-text">Tahun Ajaran</span>
                    </a>
                </li>
            @endif

            <li><a href="/jadwal-pelajaran" class="ai-icon @if (request()->is('jadwal-pelajaran')) mm-active @endif"
                    aria-expanded="false">
                    <i class="fa fa-calendar-alt"></i>
                    <span class="nav-text">Jadwal Pelajaran</span>
                </a>
            </li>

            @if (Auth::user()->role->name == 'Admin')
                <li><a href="/mata-pelajaran" class="ai-icon @if (request()->is('mata-pelajaran')) mm-active @endif"
                        aria-expanded="false">
                        <i class="fa fa-book"></i>
                        <span class="nav-text">Mata Pelajaran</span>
                    </a>
                </li>

                <li><a href="/kelas" class="ai-icon @if (request()->is('kelas')) mm-active @endif"
                        aria-expanded="false">
                        <i class="fa fa-building"></i>
                        <span class="nav-text">Kelas</span>
                    </a>
                </li>

                <li><a href="/guru" class="ai-icon @if (request()->is('guru')) mm-active @endif"
                        aria-expanded="false">
                        <i class="fa fa-chalkboard-teacher"></i>
                        <span class="nav-text">Guru</span>
                    </a>
                </li>

                <li><a href="/siswa" class="ai-icon @if (request()->is('siswa')) mm-active @endif"
                        aria-expanded="false">
                        <i class="fa fa-users"></i>
                        <span class="nav-text">Siswa</span>
                    </a>
                </li>
            @endif

            {{-- <li><a href="/data-penghitungan-hasil" class="ai-icon @if (request()->is('data-penghitungan-hasil')) mm-active @endif" aria-expanded="false">
                    <i class="flaticon-381-file"></i>
                    <span class="nav-text">Penghitungan Hasil</span>
                </a>
            </li>
            <li><a href="/data-penghitungan-detail" class="ai-icon @if (request()->is('data-penghitungan-detail')) mm-active @endif" aria-expanded="false">
                    <i class="flaticon-381-file"></i>
                    <span class="nav-text">Penghitungan Detail</span>
                </a>
            </li> --}}
        </ul>
    </div>
</div>
