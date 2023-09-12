<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-accepted" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle"
        aria-hidden="true">
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
                    <div class="col-md-12">

                        <form id="form-doc-accepted" name="form-doc-accepted" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <label for="name">Nama</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Nama" aria-label="name" aria-describedby="name" readonly />
                                    </div>
                                    <label for="tanggal">Tanggal</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="date" name="date"
                                            placeholder="Tanggal" aria-label="tanggal" aria-describedby="tanggal"
                                            readonly />
                                    </div>
                                    <label for="category">Kategori</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="document_category"
                                            name="document_category" placeholder="Kategori" aria-label="category"
                                            aria-describedby="category" readonly />
                                    </div>
                                    <label for="pemohon">Pemohon</label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="applicant" name="applicant"
                                            placeholder="Nama Pemohon" aria-label="pemohon" aria-describedby="pemohon"
                                            readonly />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">

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

                                    <div id="link_pdf"></div>

                                </div>
                            </div>
                            <div class="row">
                                <label for="ket" id="ket" class="form-label">Keterangan</label>
                                <div class="input-group mb-2">
                                    <textarea data-length="50" class="form-control char-textarea" id="ket" name="ket" rows="4"
                                        placeholder="" readonly></textarea>
                                </div>
                            </div>
                            <div id="surat_balasan">

                            </div>
                                {{-- <div class="transfer-div">
                                    <div class="media">
                                        <a href="javascript:void(0);" class="mr-25">
                                            <div class="thumbnail">

                                            </div>
                                        </a>

                                        </div>
                                        {{-- <div class="media-body mt-75 ml-1">
                                            <label for="transfer_image"
                                                class="btn btn-sm btn-success mb-75 mr-75">Upload Bukti Transfer</label>
                                            <input type="file" id="transfer_image" name="transfer_image" hidden
                                                accept="image/*" max-file-size="10240000" />
                                            <input type="hidden" id="id" name="id">
                                            <p style="margin:none; white-space: no-wrap;" class="text-primary"> *Format: JPG, JPEG atau PNG. Max ukuran 2MB</p>
                                            <p style="margin:none; white-space: no-wrap;" class="text-primary"> *Pembayaran PNBP dapat dilakukan melalui transfer ke rekening BRI 024501001579307 a.n. RPL 030 PTUN Yogyakarta </p>
                                    </div> --}}
                            {{-- </div>                  --}}
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
