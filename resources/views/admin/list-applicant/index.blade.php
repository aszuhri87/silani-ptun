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
                            <h3 class="content-header-title float-left mb-0">Daftar Karyawan</h3>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active">Daftar Karyawan
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Basic table -->
        <div class="content-body">
       <!-- Responsive Datatable -->
       <section id="responsive-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom row">
                        <div class="col-xs-12 p-1">
                            <input type="text" id="search" class="form-control" placeholder="Pencarian">
                        </div>
                        <div class="col-xs-12 p-1 text-right">
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#importModal">
                                Import
                            </button>
                            <button type="button" class="btn btn-success" id="create-list-applicant-modal">Tambah</button>
                        </div>
                    </div>
                    <div class="card-datatable table-responsive">
                        <table class="table table-responsive" id="init-table">
                            <thead class="" width="100%">
                                <tr>
                                    <th>#</th>
                                    <th width="30%">Nama</th>
                                    <th width="20%">Username</th>
                                    <th width="30%">Email</th>
                                    <th width="30%">Jabatan</th>
                                    <th width="10%">Aksi</th>
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

<!-- Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{url('admin/applicant/import')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Import Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="number-input">File Excel</label>
                    <div class="custom-file mb-1">
                        <input type="file" name="file" class="form-control" accept=".xls,.xlsx">
                    </div>
                    <a href="{{url('admin/download_format')}}" class="mb-3 text-primary font-italic font-underline"> *Klik teks ini untuk download contoh format </a>
                    <p class="mb-3 text-danger font-italic"> *Import hanya bekerja dengan format excel (.xls, .xlsx), pastikan isi file excel sesuai contoh format! </p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-save">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

@include('admin.list-applicant.modal')

@endsection

@push('script')
@include('admin.list-applicant.script')
@include('admin.list-applicant.script-table')
@endpush
