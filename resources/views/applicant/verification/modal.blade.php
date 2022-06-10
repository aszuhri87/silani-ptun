<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-verification" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="SubUnitModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <!-- Basic -->
                     {{-- <div class="col-md-12"> --}}

                        <form id="form-doc-verification" name="form-doc-verification" >
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <label for="name">Nama</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama" aria-label="name"  aria-describedby="name" readonly/>
                                    </div>
                                    <label for="tanggal">Tanggal</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="date" name="date" placeholder="Tanggal" aria-label="tanggal"  aria-describedby="tanggal" readonly />
                                    </div>
                                    <label for="category">Kategori</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="document_category" name="document_category" placeholder="Kategori" aria-label="category"  aria-describedby="category" readonly />
                                    </div>
                                    <label for="pemohon">Pemohon</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="applicant" name="applicant" placeholder="Nama Pemohon" aria-label="pemohon"  aria-describedby="pemohon" readonly />
                                    </div>
                                    <label for="requirement_type">Jenis Keperluan</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="requirement_type" name="requirement_type" placeholder="Jenis Keperluan" aria-label="requirement_type"  aria-describedby="requirement_type" readonly/>
                                    </div>

                                </div>
                                <div class="col-12 col-md-6 col-lg-6">

                                    <label for="requirement">Keperluan</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="requirement" name="requirement" placeholder="Keperluan" aria-label="requirement"  aria-describedby="requirement" readonly/>
                                    </div>

                                    <label for="required">Dibutuhkan</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="required" name="required" placeholder="Dibutuhkan" aria-label="required"  aria-describedby="required" readonly/>
                                    </div>

                                    <label for="description" id="description" class="form-label">Deskripsi</label>
                                    <div class="input-group mb-2">
                                        <textarea data-length="50" class="form-control char-textarea" id="description" name="description" rows="4" placeholder="" readonly></textarea>
                                     </div>

                                    <label for="status">Status</label>
                                    <div class="input-group mb-2">

                                        {{-- <input type="text" class="form-control" style="border: none; border-color: transparent; background:white;" id="status" name="status" placeholder="Status" aria-label="requirement_value"  aria-describedby="requirement_value" disabled/> --}}
                                        <h4 class="mt-1" style="border: none; border-color: transparent;" id="status" name="status"></h4>
                                    </div>



                                </div>
                        </div>

                    </div>
                <div class="modal-footer">
                    {{-- <button type="submit" id="btn-save" class="btn btn-success">Proses</button> --}}
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<!-- Vertical modal end-->
