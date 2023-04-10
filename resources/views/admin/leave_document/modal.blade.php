<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-docs-category" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
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
                        <form id="form-doc-category" name="form-doc-category" class="auth-register-form mt-2">
                            <label for="nama">Nama</label>
                            <div class="form-group">
                                <select class=" form-control" id="select-letter" data-toggle="collapse" required
                                    data-target="#timeline"></select>
                            </div>

                            <div class="form-group">
                                <label for="permit_type">Jenis Cuti</label>
                                <select class="form-control" name="permit_type" id="permit_type" required>
                                    <option value="">-- Pilih Cuti --</option>
                                    <option value="Tahunan"> Tahunan </option>
                                    <option value="Sakit"> Sakit </option>
                                    <option value="Karena Alasan Penting"> Karena Alasan Penting </option>
                                    <option value="Besar"> Besar </option>
                                    <option value="Melahirkan"> Melahirkan </option>
                                    <option value="di Luar Tanggungan Negara"> di Luar Tanggungan Negara </option>
                                </select>
                            </div>

                            <label for="address" id="address" class="form-label">Alasan</label>
                            <div class="input-group">
                                <textarea data-length="50" class="form-control char-textarea" id="reason" name="reason" required
                                    rows="3" placeholder=""></textarea>
                            </div>
                            <small class="textarea-counter-value float-right bg-success"><span
                                    class="char-count">0</span> / 50 </small>

                            <label class="form-label mt-1">Lamanya Cuti</label>
                            <div class="row">
                                <div class="col-6">
                                    <input class="form-control" type="date" name="start_time" id="start_time" required>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" type="date" name="end_time" id="end_time" required>
                                </div>
                            </div>

                            <label for="address" id="address" class="form-label mt-1">Alamat</label>
                            <div class="input-group">
                                <textarea data-length="50" class="form-control char-textarea" id="address" required
                                    name="address" rows="3" placeholder=""></textarea>
                            </div>
                            <small class="textarea-counter-value float-right bg-success"><span
                                    class="char-count">0</span> / 50 </small>

                            <label for="phone" id="phone" class="form-label mt-1">No HP</label>
                            <div class="form-group">
                                <input class="form-control" type="text" name="phone" id="phone" required>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-save" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Vertical modal end-->
