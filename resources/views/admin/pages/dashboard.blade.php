@extends('admin.layout.layout')

@section('title', 'Dashboard')

@section('title-bar', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-xxl-12">
                <div class="row">
                    {{-- <div class="col-sm-6">
                        <div class="card avtivity-card">
                            <div class="card-body">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <p class="fs-14 mb-2">Jumlah Sub kriteria</p>
                                        <span class="title text-black font-w600">0</span>
                                    </div>
                                </div>
                                <div class="progress" style="height:5px;">
                                    <div class="progress-bar bg-success" style="width: 42%; height:5px;"
                                        aria-label="Progess-success" role="progressbar">
                                        <span class="sr-only">42% Complete</span>
                                    </div>
                                </div>
                            </div>
                            <div class="effect bg-success"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card avtivity-card">
                            <div class="card-body">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <p class="fs-14 mb-2">Jumlah Kriteria</p>
                                        <span class="title text-black font-w600">0</span>
                                    </div>
                                </div>
                                <div class="progress" style="height:5px;">
                                    <div class="progress-bar bg-secondary" style="width: 82%; height:5px;"
                                        aria-label="Progess-secondary" role="progressbar">
                                        <span class="sr-only">42% Complete</span>
                                    </div>
                                </div>
                            </div>
                            <div class="effect bg-secondary"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card avtivity-card">
                            <div class="card-body">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <p class="fs-14 mb-2">Jumlah Anak</p>
                                        <span class="title text-black font-w600">0</span>
                                    </div>
                                </div>
                                <div class="progress" style="height:5px;">
                                    <div class="progress-bar bg-danger" style="width: 90%; height:5px;"
                                        aria-label="Progess-danger" role="progressbar">
                                        <span class="sr-only">42% Complete</span>
                                    </div>
                                </div>
                            </div>
                            <div class="effect bg-danger"></div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if (Session::get('login'))
        <script>
            toastr.success("Login Berhasil", "Info", {
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
            })
        </script>
    @endif

    @if (Session::get('updateprofil'))
        <script>
            toastr.success("Profil Berhasil Diubah", "Info", {
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
            })
        </script>
    @endif

    @if (Session::get('error'))
        <script>
            toastr.error("Profil Gagal Diubah", "Info", {
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
            })
        </script>
    @endif

    @if (Session::get('dataerror'))
        <script>
            toastr.error("Lengkapi Data Terlebih Dahulu", "Info", {
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
            })
        </script>
    @endif
@endsection
