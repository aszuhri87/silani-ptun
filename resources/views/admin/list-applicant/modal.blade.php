<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-list-applicant" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle" aria-hidden="true">
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

                        <form id="form-list-applicant" name="form-list-applicant" class="auth-register-form mt-2" >
                                <label for="name">Nama</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama" aria-label="name"  aria-describedby="name" />
                                </div>

                                <label for="name">Username</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" aria-label="username"  aria-describedby="username" />
                                </div>

                                <label for="name">Email</label>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="email" aria-label="email"  aria-describedby="email" />
                                </div>

                                <label for="name">Password</label>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-merge  @error('password') is-invalid @enderror" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" tabindex="3" />
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
