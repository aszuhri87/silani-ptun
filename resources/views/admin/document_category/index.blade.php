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
                            <h3 class="content-header-title float-left mb-0">Kategori Dokumen</h3>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Master Data</a>
                                    </li>
                                    <li class="breadcrumb-item active">Kategori Dokumen
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
                                    <div class="col-xs-6 m1-1 p-1">
                                        <input type="text" id="search" class="form-control" placeholder="Pencarian">
                                    </div>
                                    <div class="col-xs-6 mr-1 text-right p-1">
                                        <button type="button" class="btn btn-success" id="create-doc-category-modal">
                                            Tambah</button>
                                    </div>
                                </div>
                                <div class="card-datatable">
                                    <table class="table" id="init-table">
                                        <thead class="" width="100%">
                                            <tr>
                                                <th>#</th>
                                                <th width="25%">Nama</th>
                                                <th width="15%">Unit</th>
                                                <th width="25%">Sub unit</th>
                                                <th width="20%">Deskripsi</th>
                                                <th width="20%">Kategori</th>
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

    @include('admin.document_category.modal')
@endsection

@push('script')
    @include('admin.document_category.script')
    @include('admin.document_category.script-table')
@endpush
