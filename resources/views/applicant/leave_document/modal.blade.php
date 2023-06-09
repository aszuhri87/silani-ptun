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
                    <form id="form-doc-category" name="form-doc-category" class="auth-register-form mt-2">
                        <div class="col-md-12 econtent">
                            <div class="form-group">
                                <label for="permit_type">Unit Kerja</label>
                                <select class=" form-control" id="select-unit" data-toggle="collapse" required
                                    data-target="#timeline" required></select>
                                <input type="hidden" id="unit" name="unit">
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
                                    <option value="Luar Tanggungan Negara"> di Luar Tanggungan Negara </option>
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
                            <div class="form-group">
                                <input class="form-control" type="text" name="leave_long" id="leave_long" required>
                            </div>

                            <label class="form-label mt-1">Tanggal Cuti</label>
                            <div class="row">
                                <div class="col-6">
                                    <input class="form-control" type="datetime-local" name="start_time" id="start_time" required>
                                </div>
                                <div class="col-6">
                                    <input class="form-control" type="datetime-local" name="end_time" id="end_time" required>
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

                            <label for="phone" id="phone" class="form-label mt-1">Masa Kerja</label>
                            <div class="form-group">
                                <input class="form-control" type="text" name="working_time" id="working_time" required>
                            </div>

                            <label for="nama">Cari Atasan</label>
                            <div class="form-group">
                                <select class=" form-control" id="select-chief" data-toggle="collapse" required
                                    data-target="#timeline"></select>
                                <input type="hidden" name="chief">
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

<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-document" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div id="link_pdf">

                    </div>
                    <br>
                    <h5 class="modal-title" id="SubUnitModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div>

                <div class="container-fluid" >
                <div class="modal-body" >

                    <form  id="print">
                     <!-- Basic -->
                     <div class="container-fluid" >
                        FORMULIR PERMINTAAN DAN PEMBERIAN CUTI
                    <table width="100%" class="table-responsive">

                    <td style="padding: 10px; border: 3px solid;">

                    <table style="border: none;" width="100%">
                        <tr>
                            <td style="width: 50%; padding: 60px;">
                            </td>
                            <td>
                                <div style="font-family: Arial;">
                                    ANAK LAMPIRAN 1.b
                                    <br>
                                    PERATURAN BADAN KEPEGAWAIAN NEGARA REPUBLIK
                                    <br>
                                    INDONESIA
                                    <br>
                                    NOMOR 24 TAHUN 2017
                                    <br>
                                </div>
                                <div style="padding-top: 15px;">
                                    <div style="display: flex; padding: 0; margin: 0;  white-space:0;">
                                        Yogyakarta, &nbsp; <p class="tanggal" style="padding: 0; margin: 0;  white-space:0;"></p>
                                    </div>
                                    <div style="display: flex; padding: 0; margin: 0;  white-space:0;">
                                        Kepada
                                        <br>
                                        Yth. Ketua Pengadilan TUN Yogyakarta <br>
                                        di. <br> Yogyakarta
                                    </div>
                                </div>

                            </td>
                        </tr>
                    </table>
                    <br>
                    <div style="text-align: center; font-size: 10; font-weight: 700;">
                        FORMULIR PERMINTAAN DAN PEMBERIAN CUTI <br>
                    W3-TUN5 /               /KP.05.02/ 10 /{{date('Y')}}
                    </div>
                    <table width="100%" >
                        <tr>
                            <th colspan="4">
                               I. DATA PEGAWAI
                            </th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; width: 15%;">
                                Nama
                            </td>
                            <td style="border: 1px solid; width: 30%;">
                                <p class="name" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                            <td style="border: 1px solid; width: 15%;">
                                NIP
                            </td>
                            <td style="border: 1px solid; width: 30%;">
                                <p class="nip" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; width: 15%;">
                                Jabatan
                            </td>
                            <td style="border: 1px solid; width: 30%;">
                                <p class="title" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                            <td style="border: 1px solid; width: 15%;">
                                Masa Kerja
                            </td>
                            <td style="border: 1px solid; width: 30%;">
                                <p class="working_time"></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; width: 15%;">
                                Unit Kerja
                            </td>
                            <td style="border: 1px solid;" colspan="3">
                                <p class="unit" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table width="100%">
                        <tr>
                            <th>
                               II. JENIS CUTI YANG DIAMBIL. **
                            </th>
                        </tr>
                        <tr te>
                            <td style="border: 1px solid; width: 40%;">
                                1. Cuti Tahunan
                            </td>
                            <td style="border: 1px solid; width: 10%; text-align: center">
                                <p class="cuti_tahunan" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                            <td style="border: 1px solid; width: 40%;">
                                1. Cuti Besar
                            </td>
                            <td style="border: 1px solid; width: 10%; text-align: center;">
                                <p class="cuti_besar" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; width: 40%;">
                                2. Cuti Sakit
                            </td>
                            <td style="border: 1px solid; width: 10%; text-align: center;">
                                <p class="cuti_sakit" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                            <td style="border: 1px solid; width: 40%;">
                                2. Cuti Melahirkan
                            </td>
                            <td style="border: 1px solid; width: 10%; text-align: center;">
                                <p class="cuti_melahirkan" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; width: 40%;">
                                3. Cuti Karena Alasan Penting
                            </td>
                            <td style="border: 1px solid; width: 10%; text-align: center;">
                                <p class="cuti_penting" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                            <td style="border: 1px solid; width: 40%;">
                                3. Cuti di Luar Tanggungan Negara
                            </td>
                            <td style="border: 1px solid; width: 10%; text-align: center;">
                                <p class="cuti_luar" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table width="100%">
                        <tr>
                            <th>
                               III. ALASAN CUTI
                            </th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; height: 40px;">
                                <p class="reason" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table width="100%">
                        <tr>
                            <th colspan="4">
                               IV. LAMANYA CUTI
                            </th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; height: 30px; width: 10%;">
                                Selama
                            </td>
                            <td style="border: 1px solid; height: 30px; width: 28%;">
                                <p class="count_time" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                            <td style="border: 1px solid; height: 30px; width: 15%;">
                                Mulai Tanggal
                            </td>
                            <td style="border: 1px solid; height: 30px; width: 20%;">
                                <p class="start_time" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                            <td style="border: 1px solid; height: 30px; width: 7%;">
                                s/d
                            </td>
                            <td style="border: 1px solid; height: 30px; width: 20%;">
                                <p class="end_time" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table width="100%">
                        <tr>
                            <th colspan="6">
                               V. CATATAN CUTI ***
                            </th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; width: 20%;" colspan="3">
                                1. Cuti Tahunan
                            </td>
                            <td style="border: 1px solid; width: 20%;">
                                CUTI BESAR
                            </td>
                            <td style="border: 1px solid; width: 10%;" >
                                <p class="besar" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; width: 1%;">
                                Tahun
                            </td>
                            <td style="border: 1px solid; width: 1%;">
                                Sisa
                            </td>
                            <td style="border: 1px solid; width: 1%;">
                                Keterangan
                            </td>
                            <td style="border: 1px solid; width: 10%;">
                                CUTI SAKIT
                            </td>
                            <td style="border: 1px solid; width: 10%;">
                                <p class="sakit" style="padding: 0; margin: 0;  white-space:0; text-align:center;"></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; height: 15px;">

                            </td>
                            <td style="border: 1px solid; height: 15px; ">
                            </td>
                            <td style="border: 1px solid; height: 15px;">
                            </td>
                            <td style="border: 1px solid; width: 10%;">
                                CUTI MELAHIRKAN
                            </td>
                            <td style="border: 1px solid; width: 10%;">
                                <p class="melahirkan" style="padding: 0; margin: 0;  white-space:0; text-align:center"></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; height: 15px;">
                                <b>N-1</b>
                            </td>
                            <td style="border: 1px solid; height: 15px; ">
                                <b class="remain0">....hari</b>
                            </td>
                            <td style="border: 1px solid; height: 15px;">
                                <b class="amount0">Masih....hari</b>
                            </td>
                            <td style="border: 1px solid; width: 10%;">
                                CUTI  KARENA ALASAN PENTING
                            </td>
                            <td style="border: 1px solid; width: 10%;">
                                <p class="penting" style="padding: 0; margin: 0;  white-space:0; text-align:center"></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; height: 15px;">
                                <b>N</b>
                            </td>
                            <td style="border: 1px solid; height: 15px; ">
                                <b class="remain1">....hari</b>
                            </td>
                            <td style="border: 1px solid; height: 15px;">
                                <b class="amount1">Masih....hari</b>
                            </td>
                            <td style="border: 1px solid; width: 10%;">
                                CUTI DI LUAR TANGGUNGAN NEGARA
                            </td>
                            <td style="border: 1px solid; width: 10%;">
                                <p class="tanggungan" style="padding: 0; margin: 0;  white-space:0; text-align:center"></p>
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table width="100%">
                        <tr>
                            <th colspan="3">
                                ALAMAT SELAMA MENJALANKAN CUTI
                            </th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; width: 45%; text-align:center;">
                                Alamat Lengkap
                            </td>
                            <td style="border: 1px solid; width: 25%; text-align:center;">
                                Telpon
                            </td>
                            <td style="border-top: 1px solid; border-right: 1px solid; border-left: 1px solid; width: 40%; text-align:center;">
                                <b>Hormat Saya,</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid; border-left: 1px solid; height: 15px;">
                                <p class="address" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                            <td style="border-right: 1px solid; border-left: 1px solid; height: 15px; text-align: center;">
                                <p class="phone" style="padding: 0; margin: 0;  white-space:0;"></p>
                            </td>
                            <td style="height: 15px; border-right: 1px solid; border-left: 1px solid;">
                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid; border-left: 1px solid;">
                            </td>
                            <td style="border-right: 1px solid;">

                            </td>
                            <td style="border-right: 1px solid; border-left: 1px solid;" class="user-sign">

                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid; border-left: 1px solid; border-bottom: 1px solid;">

                            </td>
                            <td style=" border-right: 1px solid; border-bottom: 1px solid; height: 15px;">

                            </td>
                            <td style="text-align:center; border-right: 1px solid; border-bottom: 1px solid;">
                                <b style="text-decoration: underline; padding: 0; margin: 0;  white-space:0"><p class="name_sign" style="padding: 0; margin: 0;  white-space:0;"></p></b> <b class="nip"></b>
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table width="100%">
                        <tr>
                            <th colspan="4">
                                PERTIMBANGAN ATASAN LANGSUNG **
                            </th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; width: 15%; text-align:center;">
                                DISETUJUI
                            </td>
                            <td style="border: 1px solid; width: 25%; text-align:center;">
                                PERUBAHAN ****
                            </td>
                            <td style="border: 1px solid; width: 30%; text-align:center;">
                                DITANGGUHKAN ****
                            </td>
                            <td style="border: 1px solid; width: 30%; text-align:center;">
                                TIDAK DISETUJUI ****
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; text-align:center; height: 15px;">
                                <p class="agree-1"></p>
                            </td>
                            <td style="border: 1px solid; text-align:center; height: 15px;">
                                <p class="agree-2"></p>
                            </td>
                            <td style="border: 1px solid; text-align:center; height: 15px;">
                                <p class="agree-3"></p>
                            </td>
                            <td style="border: 1px solid; text-align:center; height: 15px;">
                                <p class="agree-4"></p>

                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid; border-left: 1px solid;" colspan="3">
                            </td>
                            <td style="border-right: 1px solid; text-align:center;">
                                {{-- <b class="atasan_name"> <br> </b> --}}

                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid; border-left: 1px solid;" colspan="3">
                            </td>
                            <td style="border-right: 1px solid; border-left: 1px solid; text-align:center;" class="atasan_sign">


                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid; border-bottom: 1px solid; border-left: 1px solid; height: 15px;"  colspan="3">

                            </td>
                            <td style="border-right: 1px solid; border-bottom: 1px solid; text-align:center;">
                                 <p><b style="text-decoration: underline;" class="atasan_name">(..................)</b> <br><b class="nip_atasan"></p>
                            </td>
                        </tr>
                    </table>

                    <br>

                    <table width="100%">
                        <tr>
                            <th colspan="4">
                                KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI **
                            </th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; width: 15%; text-align:center;">
                                DISETUJUI
                            </td>
                            <td style="border: 1px solid; width: 25%; text-align:center;">
                                PERUBAHAN ****
                            </td>
                            <td style="border: 1px solid; width: 30%; text-align:center;">
                                DITANGGUHKAN ****
                            </td>
                            <td style="border: 1px solid; width: 30%; text-align:center;">
                                TIDAK DISETUJUI ****
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid; text-align:center; height: 15px;">
                                <p class="final-agree-1"></p>
                            </td>
                            <td style="border: 1px solid; text-align:center; height: 15px;">
                                <p class="final-agree-2"></p>
                            </td>
                            <td style="border: 1px solid; text-align:center; height: 15px;">
                                <p class="final-agree-3"></p>
                            </td>
                            <td style="border: 1px solid; text-align:center; height: 15px;">
                                <p class="final-agree-4"></p>

                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid; border-left: 1px solid;" colspan="3">
                            </td>
                            <td style="border-right: 1px solid; text-align:center;">
                                {{-- <b class=""> <br> </b> --}}

                            </td>
                        </tr>
                        <tr>
                            <td style="border-left: 1px solid; border-right: 1px solid;" colspan="3">
                            </td>
                            <td style="border-right: 1px solid; text-align:center;" class="ketua-sign">
                            </td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid; border-left: 1px solid; border-bottom: 1px solid; height: 15px;"  colspan="3">

                            </td>
                            <td style="border-right: 1px solid; border-bottom: 1px solid; text-align:center;">
                                 <p><b style="text-decoration: underline;" class="ketua_name">(..................)</b> <br> <b class="nip_ketua"></p>
                            </td>
                        </tr>
                    </td>
                    </tr>
                    </table>
                    <b>Catatan: </b>
                    <br>
                    * Coret yang tidak perlu
                    <br>
                    ** Pilih salah satu dengan centang (✓)
                    <br>
                    *** diisi oleh pejabat yang menangani bidang kepegawaian sebelum PNS mengajukan Cuti
                    <br>
                    **** diberi tanda centang dan alasannya,.

                    </td>
                    </table>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vertical modal end-->



