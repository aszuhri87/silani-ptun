<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-disposition" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle"
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
                        <form id="form-disposition" name="form-disposition" class="auth-register-form mt-2"
                            enctype="multipart/form-data">
                            <div class="form-method"></div>
                            <div class="main">
                                <label for="index">Indeks</label>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="index" id="index" required>
                                </div>

                                <label for="agenda_number">No. Agenda</label>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="agenda_number" id="agenda_number"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="letter_type">Jenis Surat</label>
                                    <select class=" form-control" id="letter_type" data-toggle="collapse" name="letter_type"
                                        data-target="#timeline" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Rahasia">Rahasia</option>
                                        <option value="Penting">Penting</option>
                                        <option value="Biasa">Biasa</option>
                                    </select>
                                </div>

                                <label for="code">Kode</label>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="code" id="code" required>
                                </div>

                                <label for="date_finish">Tanggal Agenda</label>
                                <div class="form-group">
                                    <input class="form-control" type="date" name="agenda_date" id="agenda_date"
                                        required>
                                </div>

                                <label for="date_finish">Tanggal Penyelesaian</label>
                                <div class="form-group">
                                    <input class="form-control" type="date" name="date_finish" id="date_finish"
                                        required>
                                </div>

                                <label for="date_number">Tanggal Nomor</label>
                                <div class="form-group">
                                    <input class="form-control" type="date" name="date_number" id="date_number"
                                        required>
                                </div>

                                <label for="from">Asal Surat</label>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="from" id="from" required>
                                </div>

                                <label for="resume_content" id="resume_content" class="form-label">Isi Ringkas</label>
                                <div class="input-group">
                                    <textarea data-length="50" class="form-control char-textarea" id="resume_content" name="resume_content" rows="3"
                                        placeholder="" required></textarea>
                                </div>
                                <small class="textarea-counter-value float-right bg-success"><span
                                        class="char-count">0</span> / 50 </small>

                                <label for="nama" class="mt-2">Ditujukan kepada</label>
                                <div class="form-group">
                                    <select class=" form-control" id="select-fordward" data-toggle="collapse"
                                        data-target="#timeline" name="role" required>
                                        <option value="Ketua">Ketua</option>
                                        <option value="Wakil Ketua">Wakil Ketua</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="uploaded_file">File Surat</label>
                                <input type="file" name="uploaded_file" id="uploaded_file" class="dropify"
                                    accept=".pdf" data-allowed-file-extensions="pdf"
                                    data-max-file-size-preview="5M">
                                <label style="font-size: 8pt;">*Format harus pdf</label>
                            </div>
                            <div class="approval mt-1"></div>
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


<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-document" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div id="link_pdf"></div>
                    <br>
                    <h5 class="modal-title" id="SubUnitModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div>
                    <div class="container-fluid">
                        <div class="modal-body ">

                            <div class="status-note">

                            </div>
                            <form id="print">

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td colspan="2">
                                                <H3 class="no-space">
                                                    PENGADILAN TATA USAHA NEGARA YOGYAKARTA
                                                </H3>
                                                <p class="no-space bold">Jalan : Janti No.66 Banguntapan, Bantul</p>
                                                <p class="no-space bold">Telp. : 0274-520502 Fax : 0274581675</p>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <h2 class="text-underlined text-center no-space">
                                                    LEMBAR DISPOSISI
                                                </h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <div class="d-flex">
                                                    <p class="no-space" style="width: 60px;">Indeks : </p>
                                                    <p class="no-space  index" style="float: left;"></p>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="display: flex;">
                                                    <p class="no-space" style="width: 60px;">Rahasia </p>
                                                    <p class="no-space" style="float: left;">: </p>
                                                    <p class="no-space rahasia" style="float: left;"></p>
                                                </div>
                                                <div style="display: flex;">
                                                    <p class="no-space" style="width: 60px;">Penting </p>
                                                    <p class="no-space" style="float: left;">: </p>
                                                    <p class="no-space penting" style="float: left;"></p>
                                                </div>
                                                <div style="display: flex;">
                                                    <p class="no-space" style="width: 60px;">Biasa </p>
                                                    <p class="no-space" style="float: left;">:</p>
                                                    <p class="no-space biasa" style="float: left;"></p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <div class="d-flex">
                                                    <p class="no-space">
                                                        Kode :
                                                    </p>
                                                    <p class="no-space code" style="float: left;"></p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <p class="no-space">
                                                        Tanggal Penyelesaian :
                                                    </p>
                                                    <p class="no-space date_finish" style="float: left;"></p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div style="display: flex;">
                                                    <p class="one-space" style="width: 150px;">Tanggal Nomor</p>
                                                    <p class="one-space" style="float: left;">: </p>
                                                    <p class="no-space date_number" style="float: left;"></p>
                                                </div>
                                                <div style="display: flex;">
                                                    <p class="one-space" style="width: 150px;">Asal Surat</p>
                                                    <p class="one-space" style="float: left;">: </p>
                                                    <p class="no-space from" style="float: left;"></p>
                                                </div>
                                                <div style="display: flex;">
                                                    <p class="one-space" style="width: 150px;">Isi Ringkas</p>
                                                    <p class="one-space" style="float: left;">: </p>
                                                    <p class="no-space resume_content" style="float: left;"></p>
                                                </div>
                                                <div style="display: flex;">
                                                    <p class="one-space" style="width: 150px;">No/Tgl Agenda </p>
                                                    <p class="one-space" style="float: left;">: </p>
                                                    <p class="no-space agenda_numdate" style="float: left;"></p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <h5 class="no-space">INSTRUKSI INFORMASI :</h5>
                                                <div class="ketua-instruction"></div>
                                            </td>
                                            <td>
                                                <h5 class="no-space">DITERUSKAN KEPADA :</h5>
                                                <div style="display: flex;">
                                                    <p class="no-space">1. Ketua</p>
                                                    <p class="no-space forward-1" style="float: left;"></p>
                                                </div>
                                                <div style="display: flex;">
                                                    <p class="no-space">2. Wakil Ketua</p>
                                                    <p class="no-space forward-2" style="float: left;"></p>
                                                </div>
                                                <div style="display: flex;">
                                                    <p class="no-space">3. Panitera</p>
                                                    <p class="no-space forward-3" style="float: left;"></p>
                                                </div>
                                                <div style="display: flex;">
                                                    <p class="no-space">4. Sekretaris</p>
                                                    <p class="no-space forward-4" style="float: left;"></p>
                                                </div>
                                                <div style="display: flex;">
                                                    <p class="no-space">5. Panitera Muda Hukum</p>
                                                    <p class="no-space forward-5" style="float: left;"></p>
                                                </div>
                                                <div style="display: flex;">
                                                    <p class="no-space">6. Panitera Muda Perkara</p>
                                                    <p class="no-space forward-6" style="float: left;"></p>
                                                </div>
                                                <div style="display: flex;">
                                                    <p class="no-space">7. Kasub Umum dan Keuangan</p>
                                                    <p class="no-space forward-7" style="float: left;"></p>
                                                </div>
                                                <div style="display: flex;">
                                                    <p class="no-space">8. Kasub Kepegawaian, Ortala</p>
                                                    <p class="no-space forward-8" style="float: left;"></p>
                                                </div>
                                                <div style="display: flex;">
                                                    <p class="no-space">9. Kasub Perencanaan, TI dan Pelaporan</p>
                                                    <p class="no-space forward-9" style="float: left;"></p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="2" height="100px">
                                                <h5 class="no-space">DISPOSISI PANITERA :</h5>
                                                <div class="panitera-instruction"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="2" height="100px"
                                                style="border-bottom-style: dashed;">
                                                <h5 class="no-space">DISPOSISI SEKRETARIS :</h5>
                                                <div class="sekretaris-instruction"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="2" height="100px"
                                                style="border-top-style: dashed;">
                                                <div style="display: flex;">
                                                    <h5 class="no-space" style="width: 170px;">DISPOSISI PANMUD </h5>
                                                    <h5 class="no-space" style="float: left;">: </h5>
                                                    <div class="panmud-instruction"></div>
                                                </div>
                                                <br>
                                                <div style="display: flex;">
                                                    <h5 class="no-space" style="width: 170px;">DISPOSISI KASUBAG </h5>
                                                    <h5 class="no-space" style="float: left;">: </h5>
                                                    <div class="kasubag-instruction"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <hr>
                            </div>
                            <div class="col-12">
                                <label for="requirement_value">Dokumen/File: </label>

                                <div class="mt-1" id="doc_file">

                                </div>

                                <label for="requirement_value" class="mt-2">Dokumen/File Upload Manual: </label>
                                <div class="row" id="files"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vertical modal end-->
