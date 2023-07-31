<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-document" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="SubUnitModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <!-- Basic -->
                     <div class="col-md-12">
                        <form id="form-doc-create" enctype="multipart/form-data" >
                            <div class="row">
                                <div class="col-12 form-add">
                                    <input type="hidden"  class="form-control" name="id_cat">
                                    <label class="form-label mt-auto">Nama</label>
                                    <div class="input-group">
                                        <input type="text"  class="form-control" placeholder="Nama dokumen" name="name" required>
                                    </div>

                                    <label for="nama" class="mt-2">Ditujukan Kepada</label>
                                    <div class="form-group">
                                        {{-- <select class=" form-control" id="select-chief" data-toggle="collapse"
                                            data-target="#timeline" required></select>
                                        <input type="hidden" id="chief" name="chief"> --}}

                                        <select class="form-control" name="chief" id="" data-toggle="collapse">
                                            <option value=""> -- Pilih --</option>
                                            @foreach ($pejabat as $p)
                                                <option value="{{ $p->id }}"> {{ $p->name }} - ({{ $p->title }})</option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <div id="bebas_perkara" class="mb-1">

                                    </div>

                                    <div id="data_input" class="mb-1">

                                    </div>

                                    <span id="errormsg" class="text-danger">

                                    </span>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-save" class="btn btn-success">Proses</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<!-- Vertical modal end-->

<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-document-2" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="SubUnitModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <!-- Basic -->
                        <form id="form-doc-create-2" name="form-doc-create" enctype="multipart/form-data" >
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <label for="requirement_value">Nama</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nilai Keperluan" aria-label="requirement_value"  aria-describedby="requirement_value" readonly/>
                                    </div>
                                    <label for="requirement_value">Kepada</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="chief_name" name="chief_name" placeholder="Nilai Keperluan" aria-label="requirement_value"  aria-describedby="requirement_value" readonly/>
                                    </div>
                                    <label for="requirement_value">Tanggal</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="date" name="date" placeholder="Status" aria-label="requirement_value"  aria-describedby="requirement_value" readonly />
                                    </div>
                                    <label for="requirement_value">Kategori</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="document_category" name="document_category" placeholder="Nilai Keperluan" aria-label="requirement_value"  aria-describedby="requirement_value" readonly />
                                    </div>
                                    {{-- <label for="requirement_value">Keperluan</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="requirement" name="requirement" placeholder="Status" aria-label="requirement_value"  aria-describedby="requirement_value" readonly/>
                                    </div>

                                    <label for="requirement_value">Dibutuhkan</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="required" name="required" placeholder="Nilai Keperluan" aria-label="requirement_value"  aria-describedby="requirement_value" readonly/>
                                    </div> --}}

                                    <label for="description" id="description" class="form-label">Deskripsi</label>
                                    <div class="input-group mb-2">
                                        <textarea data-length="50" class="form-control char-textarea" id="description" name="description" rows="3" placeholder="" readonly></textarea>
                                     </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6" >
                                    <label for="requirement_value">Dokumen/File</label>

                                    <div class="mt-1" id="doc_file">

                                    </div>
                                </div>
                        </div>
                </div>
                <div class="modal-footer">
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<!-- Vertical modal end-->

