<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-docs-category-req" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle"
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

                        <form id="form-doc-category-req" name="form-doc-category-req" class="auth-register-form mt-2">

                            <div class="form-group">
                                <label for="select_unit">Kategori Dokumen</label>
                                <select class="form-control" name="select_docs_category" required>
                                    <option value="">-- Pilih Kategori Dokumen --</option>
                                    @foreach ($docs_category as $dc)
                                        <option value="{{ $dc->id }}" selected>{{ $dc->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="select_unit">Tipe Keperluan</label>
                                <select class="form-control" name="select_req_type" required>
                                    <option value="">-- Pilih Keperluan --</option>
                                    @foreach ($req_type as $rt)
                                        <option value="{{ $rt->requirement_type }}">{{ $rt->requirement_type }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <label for="requirement">Keperluan</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="requirement" name="requirement"
                                    placeholder="Keperluan" aria-label="requirement" aria-describedby="requirement"
                                    required />
                            </div>

                            <label for="required">Diperlukan</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="required" name="required"
                                    placeholder="Diperlukan" aria-label="required" aria-describedby="required"
                                    required />
                            </div>

                            <label for="data_min">Data Minimal</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="data_min" name="data_min"
                                    placeholder="Minimal data" aria-label="data_min" aria-describedby="data_min"
                                    required />
                            </div>

                            <label for="data_max">Data Maksimal</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="data_max" name="data_max"
                                    placeholder="Maksimal data" aria-label="data_max" aria-describedby="data_max"
                                    required />
                            </div>

                            <label for="description" id="description" class="form-label">Deskripsi</label>
                            <div class="input-group">
                                <textarea data-length="50" class="form-control char-textarea" id="description" name="description" rows="3"
                                    placeholder="" required></textarea>
                            </div>
                            <small class="textarea-counter-value float-right bg-success"><span
                                    class="char-count">0</span> / 50 </small>
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
