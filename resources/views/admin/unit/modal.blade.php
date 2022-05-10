<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-unit" tabindex="-1" role="dialog" aria-labelledby="unitModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unitModalTitle">Data Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <!-- Basic -->
                     <div class="col-md-12">
                        <form id="form-unit" name="form-unit" class="auth-register-form mt-2" >

                            <label for="name">Nama</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="name" placeholder="Nama" aria-label="Name" aria-describedby="name" />
                            </div>

                            <label for="description" class="form-label">Deskripsi</label>
                            <div class="input-group">

                            <textarea data-length="50" class="form-control char-textarea" id="description" name="description" rows="3" placeholder=""></textarea>

                            </div>
                            <small class="textarea-counter-value float-right bg-success"><span class="char-count">0</span> / 50 </small>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btn-save" >Simpan</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<!-- Vertical modal end-->
