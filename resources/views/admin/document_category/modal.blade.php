<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-docs-category" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle" aria-hidden="true">
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

                        <form id="form-doc-category" name="form-doc-category" class="auth-register-form mt-2" >


                                <label for="nama">Nama</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama" aria-label="Nama"  aria-describedby="nama" />
                                </div>
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <select class="form-control" name="unit" id="unit">
                                        <option value="">-- Pilih Unit --</option>
                                        @foreach ($unit as $u )

                                        <option value="{{$u->id}}">{{$u->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sub_unit">Sub Unit</label>
                                    <select class="form-control" name="sub_unit" id="sub_unit">
                                        <option value="">-- Pilih Sub Unit --</option>
                                        @foreach ($sub_unit as $su )
                                            <option value="{{$su->id}}">{{$su->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label for="description" id="description" class="form-label">Deskripsi</label>
                                <div class="input-group">
                                    <textarea data-length="50" class="form-control char-textarea" id="description" name="description" rows="3" placeholder=""></textarea>
                                </div>
                                <small class="textarea-counter-value float-right bg-success"><span class="char-count">0</span> / 50 </small>

                                <div class="form-group">
                                    <label for="category">Kategori</label>
                                    <select class="form-control" name="category" id="category">
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="umum"> Umum </option>
                                        <option value="karyawan"> Karyawan </option>

                                    </select>
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

