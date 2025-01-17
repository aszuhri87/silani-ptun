@extends('layouts.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Buat Dokumen</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">Buat Dokumen
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- Bootstrap Select start -->
                <section class="bootstrap-select">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Pilih Kategori Dokumen</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Basic Select -->
                                    <div class="form-group">
                                        <label for="basicSelect">Kategori Dokumen</label>
                                        <select class="form-control m-1" name="document_type" id="document_type">
                                            <option value=""> -- Pilih --</option>
                                            <option value="Permohonan Magang">Permohonan Magang </option>
                                            <option value="Permohonan Penelitian">Permohonan Penelitian </option>
                                            <option value="Permohonan Sertifikat Magang">Permohonan Sertifikat Magang
                                            </option>
                                            <option value="Surat Keterangan Bebas Perkara">Surat Keterangan Bebas Perkara
                                            </option>
                                            <option value="Salinan Putusan">Salinan Putusan </option>
                                            <option value="Permohonan Surat Keterangan BHT">Permohonan Surat Keterangan BHT
                                                (Berkekuatan Hukum Tetap) </option>
                                            <option value="Lain-lain">Lain-lain </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Responsive Datatable -->
                <section id="responsive-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <div class="form-row">
                                        <input type="text" id="search" class="form-control mr-1"
                                            placeholder="Pencarian">
                                    </div>
                                </div>
                                <div class="card-datatable">
                                    <table class="table" id="init-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Kategori Dokumen</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Responsive Datatable -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    @include('applicant.document.modal')
@endsection

@push('script')
    @include('applicant.document.script')
    @include('applicant.document.script-table')
@endpush
