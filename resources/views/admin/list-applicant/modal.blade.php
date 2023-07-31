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
                                        <option value="Panitera Muda Perkara">Panitera Muda Perkara</option>
                                        <option value="Panitera Muda Hukum">Panitera Muda Hukum</option>
                                        <option value="Kasub Kepegawaian, Ortala">Kasub Kepegawaian, Ortala</option>
                                        <option value="Kasub Umum dan Keuangan">Kasub Umum dan Keuangan</option>
                                        <option value="Kasub Perencanaan, TI dan Pelaporan">Kasub Umum dan Keuangan</option>
                                        <option value="Hakim">Hakim</option>
                                        <option value="Panitera Pengganti">Panitera Pengganti</option>
                                        <option value="Juru Sita Pengganti">Juru Sita Pengganti</option>
                                        <option value="Arsiparis">Arsiparis</option>
                                        <option value="Pustakawan">Pustakawan</option>
                                        <option value="Analis Perencanaan">Analis Perencanaan</option>
                                        <option value="Analis Perencanaan, Evaluasi, dan Pelaporan">Analis Perencanaan, Evaluasi, dan Pelaporan</option>
                                        <option value="Analis Pengelolaan Keuangan APBN">Analis Pengelola APBN</option>
                                        <option value="Analis Kepegawaian">Analis Kepegawaian</option>
                                        <option value="Analis Perkara Peradilan">Analis Perkara Peradilan</option>
                                        <option value="Analis SDM Aparatur">Analis SDM Aparatur</option>
                                        <option value="Analis Tata Laksana">Analis Tata Laksana</option>
                                        <option value="Penyusun Laporan Keuangan">Penyusun Laporan Keuangan</option>
                                        <option value="Pengelola BMN, Sub Bag Umum dan KU">Pengelola BMN, Sub Bag Umum dan KU</option>
                                        <option value="Analis Perkara Peradilan">Analis Perkara Peradilan</option>
                                        <option value="Pengadministrasi Umum, Sub Bag Umum dan KU">Pengadministrasi Umum, Sub Bag Umum dan KU</option>
                                        <option value="Komandan Petugas Keamanan ">Komandan Petugas Keamanan </option>
                                    </select>
                                </div>

                                <label for="permit_type">Unit Kerja</label>
                                <select class=" form-control" id="select-unit" data-toggle="collapse"
                                    data-target="#timeline" ></select>
                                <input type="hidden" id="unit" name="unit_id">

                                <label for="nip" class="mt-1">NIP</label>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" id="nip" name="nip" placeholder="nip" aria-label="nip"  aria-describedby="nip" />
                                </div>

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
