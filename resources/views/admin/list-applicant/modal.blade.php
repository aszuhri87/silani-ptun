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

                                <label for="name">Jabatan</label>
                                <div class="form-group">
                                    <select class="form-control" name="title" id="title">
                                        <option value="Ketua">Ketua</option>
                                        <option value="Wakil Ketua">Wakil Ketua</option>
                                        <option value="Panitera ">Panitera </option>
                                        <option value="Sekretaris">Sekretaris</option>
                                        <option value="Pan. Mud. Perkara">Pan Mud Perkara</option>
                                        <option value="Pan. Mud. Hukum">Pan Mud Hukum</option>
                                        <option value="Sub. Bagian Kepegawaian, Organisasi dan Tata Laksana">Sub. Bagian Kepegawaian, Organisasi dan Tata Laksana</option>
                                        <option value="Sub. Bagian Umum dan Keuangan">Sub. Bagian Umum dan Keuangan</option>
                                        <option value="Sub. Bagian Perencanaan, Teknologi Informasi dan Pelaporan">Sub. Bagian Perencanaan, Teknologi Informasi dan Pelaporan</option>
                                        <option value="Hakim">Hakim</option>
                                        <option value="Paniter Pengganti">Paniter Pengganti</option>
                                        <option value="Juru Sita Pengganti">Juru Sita Pengganti</option>
                                        <option value="Arsiparis">Arsiparis</option>
                                        <option value="Pustakawan">Pustakawan</option>
                                        <option value="Analis Pengelola APBN">Analis Pengelola APBN</option>
                                        <option value="Analis Kepegawaian">Analis Kepegawaian</option>
                                        <option value="Analis Perkara Peradilan">Analis Perkara Peradilan</option>
                                        <option value="Pranata Keuangan APBN">Pranata Keuangan APBN</option>
                                        <option value="Pengelola Perkara ,Kepaniteraan Hukum">Pengelola Perkara ,Kepaniteraan Hukum</option>
                                        <option value="Pengad Register Perkara, Kep Muda Hukum ">Pengad Register Perkara, Kep Muda Hukum </option>
                                        <option value="Analis SDM Aparatur">Analis SDM Aparatur</option>
                                        <option value="Analis Tata Laksana">Analis Tata Laksana</option>
                                        <option value="Verifikator Keangan,Sub Bag Umum & KU">Verifikator Keangan,Sub Bag Umum & KU</option>
                                        <option value="Pengelola BMN, Sub Bag Umum dan KU">Pengelola BMN, Sub Bag Umum dan KU</option>
                                        <option value="Analis Perkara Peradilan (CPNS)">Analis Perkara Peradilan (CPNS)</option>
                                        <option value="Komandan Petugas Keamanan ">Komandan Petugas Keamanan </option>
                                    </select>
                                </div>

                                <label for="permit_type">Unit Kerja</label>
                                <select class=" form-control" id="select-unit" data-toggle="collapse" required
                                    data-target="#timeline" required></select>
                                <input type="hidden" id="unit" name="unit_edit">

                                <label for="gol" class="mt-1">Golongan</label>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" id="gol" name="gol" placeholder="gol" aria-label="gol"  aria-describedby="gol" />
                                </div>

                                <label for="name">Password</label>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-merge  @error('password') is-invalid @enderror" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" tabindex="3" />
                                </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-save" class="btn btn-success">Tambah</button>
                </div>
            </form>
            </div>
        </div>
    </div>


</div>
<!-- Vertical modal end-->
