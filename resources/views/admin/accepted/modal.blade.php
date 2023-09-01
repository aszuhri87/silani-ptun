<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-accepted" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle"
        aria-hidden="true">
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
                    <div class="col-md-12">

                        <form id="form-doc-accepted" name="form-doc-accepted">
                            <div class="row">
                                <div class="col-3">
                                    <label for="name">Nama</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Nilai Keperluan" aria-label="name" aria-describedby="name"
                                            readonly />
                                    </div>
                                    <label for="tanggal">Tanggal</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="date" name="date"
                                            placeholder="Tanggal" aria-label="tanggal" aria-describedby="tanggal"
                                            readonly />
                                    </div>
                                    <label for="Kategori">Kategori</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="document_category"
                                            name="document_category" placeholder="Kategori Dokumen"
                                            aria-label="Kategori" aria-describedby="Kategori" readonly />
                                    </div>
                                    <label for="pemohon">Pemohon</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="applicant" name="applicant"
                                            placeholder="Nama Pemohon" aria-label="pemohon" aria-describedby="pemohon"
                                            readonly />
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="pemohon">No. HP</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                            placeholder="No. HP" aria-label="phone_number" aria-describedby="phone_number"
                                            readonly />
                                    </div>
                                    <label for="description" id="description" class="form-label">Deskripsi</label>
                                    <div class="input-group mb-2">
                                        <textarea data-length="50" class="form-control char-textarea" id="description" name="description" rows="4"
                                            placeholder="" readonly></textarea>
                                    </div>

                                    <label for="status">Status</label>
                                    <div class="input-group mb-2">
                                        <h4 class="mt-1" style="border: none; border-color: transparent;"
                                            id="status" name="status"></h4>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="container-fluid">
                                        <label for="requirement_value">File</label>
                                        <div id="doc_file">

                                        </div>
                                    </div>
                                    <div class="transfer-div">
                                        <div class="media m-1">
                                            <a href="javascript:void(0);" class="mr-25">
                                                <div class="thumbnail">
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <label for="status_edit" id="description" class="form-label">Ubah Status</label>
                            <div class="input-group mb-2">
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_edit1" name="status_edit" class="form-check-input"
                                        value="Diproses">
                                    <label class="form-check-label" for="status_edit1">Diproses</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" id="status_edit2" name="status_edit" class="form-check-input"
                                        value="Ditolak">
                                    <label class="form-check-label" for="status_edit2">Ditolak</label>
                                </div>
                                <div class="form-check form-check-inline confirm_transfer">
                                </div>
                            </div>
                            <label for="keterangan" id="keterangan" class="form-label">Keterangan</label>
                            <div class="input-group mb-2">
                                <textarea data-length="50" class="form-control char-textarea" id="keterangan" name="notes" placeholder=""></textarea>
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
