<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-mng-admin" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle"
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
                        <form id="form-manage-admin">
                            <label for="name">Nama</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="nama" aria-label="name" aria-describedby="name" />
                            </div>
                            <label for="username">Username</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="username" aria-label="username" aria-describedby="username" />
                            </div>
                            <label for="email">Email</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="email" aria-label="email" aria-describedby="email" />
                            </div>
                            <label for="password">Password</label>
                            <div class="input-group mb-2">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="password" aria-label="password" aria-describedby="password" />
                            </div>
                            <div class="form-group">
                                <label for="role">Unit</label>
                                <select class="form-control" name="role">
                                    <option value="">-- Pilih Unit --</option>
                                    <option value="Persuratan"> Persuratan </option>
                                    <option value="Kepegawaian"> Kepegawaian </option>
                                </select>
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
