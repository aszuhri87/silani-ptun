<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-docs-req" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle"
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

                        <form id="form-doc-req" name="form-doc-req" class="auth-register-form mt-2">

                            <div class="form-group">
                                <label for="select_unit">Dokumen</label>
                                <select class="form-control" name="select_docs">
                                    <option value="">-- Pilih Unit --</option>
                                    @foreach ($docs as $d)
                                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="select_unit">Kategori Keperluan Dokumen</label>
                                <select class="form-control" name="select_docs_category_req">
                                    <option value="">-- Pilih Sub Unit --</option>
                                    @foreach ($docs_category_req as $dcr)
                                        <option value="{{ $dcr->id }}">{{ $dcr->requirement }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <label for="requirement_value">Nilai Keperluan</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="requirement_value"
                                    name="requirement_value" placeholder="Nilai Keperluan"
                                    aria-label="requirement_value" aria-describedby="requirement_value" />
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
