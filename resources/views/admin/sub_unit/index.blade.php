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
                            <h3 class="content-header-title float-left mb-0">Sub Unit Bidang</h3>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Master Data</a>
                                    </li>
                                    <li class="breadcrumb-item active">Sub Unit Bidang
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
                                        <button type="button" class="btn btn-success p-1"
                                            id="create-subunit-modal">Tambah</button>
                                    </div>
                                </div>
                                <div class="card-datatable">
                                    <table class="table" id="init-table">
                                        <thead class="" width="100%">
                                            <tr>
                                                <th>#</th>
                                                <th width="25%">Nama</th>
                                                <th width="25%">Unit</th>
                                                <th width="30%">Deskripsi</th>
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

    @include('admin.sub_unit.modal')
@endsection

@push('script')
    @include('admin.sub_unit.script')
    @include('admin.sub_unit.script-table')
@endpush
