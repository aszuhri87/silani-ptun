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
                            <h3 class="content-header-title float-left mb-0">Perizinan Keluar</h3>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Master Data</a>
                                    </li>
                                    <li class="breadcrumb-item active">Perizinan Keluar
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
                <div class="card table-responsive">
                    <div class="card-header border-bottom">
                        <div class="form-row">
                            <input type="text" id="search" class="form-control mr-1" placeholder="Pencarian">
                        </div>
                        <button type="button" class="btn btn-success" id="create-doc-category-modal"> Tambah</button>
                    </div>
                    <div class="card-datatable">
                        <table class="table" id="init-table">
                            <thead class="" width="100%">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">Nama</th>
                                    <th width="15%">Unit</th>
                                    <th width="10%">Tanggal/Waktu</th>
                                    <th width="15%">status</th>
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

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

@include('applicant.exit-permit-document.modal')

@endsection

@push('script')
@include('applicant.exit-permit-document.script')
@include('applicant.exit-permit-document.script-table')
@endpush