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
                    <div class="col-md-12" >
                        <form id="form-doc-category" name="form-doc-category" class="auth-register-form mt-2">
                            <div class="main">
                                <label for="nama">Nama</label>
                                <div class="form-group">
                                    <select class=" form-control" id="select-letter" data-toggle="collapse" required
                                        data-target="#timeline" required></select>
                                    <input type="hidden" id="name" name="name">
                                </div>

                                <div class="form-group">
                                    <label for="permit_type">Unit Kerja</label>
                                    <select class=" form-control" id="select-unit" data-toggle="collapse" required
                                        data-target="#timeline" required></select>
                                    <input type="hidden" id="unit" name="unit">
                                </div>

                                <label for="reason" id="reason" class="form-label">Alasan</label>
                                <div class="input-group">
                                    <textarea data-length="50" class="form-control char-textarea" id="reason" name="reason" required
                                        rows="3" placeholder="" required></textarea>
                                </div>
                                <small class="textarea-counter-value float-right bg-success"><span
                                        class="char-count">0</span> / 50 </small>

                                <div class="row mt-1">
                                    <div class="col-6">
                                        <label class="form-label">Tanggal</label>
                                        <input class="form-control" type="date" name="date" id="date" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Waktu</label>
                                        <input class="form-control" type="time" name="time" id="time" required>
                                    </div>
                                </div>

                                <label for="nama" class="mt-2">Ditujukan kepada</label>
                                <div class="form-group">
                                    <select class=" form-control" id="select-chief" data-toggle="collapse" required
                                        data-target="#timeline" required></select>
                                    <input type="hidden" id="chief" name="chief">
                                </div>
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
                        <div class="modal-body" style="overflow:visible; ">

                            <div class="status-note">

                            </div>
                            <form id="print">
                                <!-- Basic -->
                                <div class="row mt-2">
                                    <div class="col-2">
                                        <img src="{{asset('logo.png')}}" alt=""
                                            style="min-height: 50px; max-height: 100px;" width="auto"
                                            style="margin-left: 30%;">

                                    </div>
                                    <div class="col-10 text-center">
                                        <div style="margin-right: 15%;">
                                            <h3 style="font-family: 'Times New Roman', Times, serif; font-weight: 700;">
                                                <b>PENGADILAN TATA USAHA NEGARA YOGYAKARTA </b></h3>
                                            <p style="font-size:11px; font-weight: 700;">Jl. Janti No.66 Banguntapan
                                                Telp. (0274) 520502 Faks. (0274)581675 <br>
                                                Yogyakarta 5518</p>

                                            <p style="font-size:11px;">Website: www.ptun-yogyakarta.go.id Email:
                                                info@ptun-yogyakarta.go.id</p>
                                        </div>
                                    </div>
                                </div>
                                <hr id="garis" style="border: solid black; ">
                                <div class="text-center">
                                    <h3 style="font-family: 'Times New Roman', Times, serif; font-weight: 700;"> SURAT
                                        IJIN KELUAR KANTOR
                                    </h3>
                                </div>

                                <div class="mt-5"
                                    style="font-family: 'Times New Roman', Times, serif; margin-left: 3%;">
                                    Pejabat : <input type="text" name="from" style="border: 0;">
                                    <input class="form-control" style="border: 0;" type="text" name="name" id="name"
                                        placeholder="...........................................................................................................................................................................................................................................................................................">
                                    <hr style="border-top: dotted 1px;" />
                                    <p> Memberikan izin keluar kantor kepada:</p>
                                    <table class="mb-5">
                                        <tr>
                                            <td>
                                                <p> Nama </p>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <p class="name" style="white-space: none; margin: 0; ">...........................................</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p> NIP/Gol.</p>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <p class="nip" style="white-space: none; margin: 0; "> :...........................................</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p> Unit Kerja</p>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <p class="unit" style="white-space: none; margin: 0; "> :...........................................</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p> Pada</p>
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p> Hari/tanggal</p>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <p class="date" style="white-space: none; margin: 0; "> :...........................................</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p> Jam </p>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <p class="time" style="white-space: none; margin: 0; "> :...........................................</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p> Untuk Keperluan</p>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <p class="reason" style="white-space: none; margin: 0; "> :...........................................</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr>
                                            <td width="25%"></td>
                                            <td width="20%"></td>
                                            <td width="25%"></td>
                                            <td class="" width="30%" style="margin:0;">
                                                <div class="d-flex pl-1">
                                                  Yogyakarta, &nbsp
                                                    <p class="date_sign"> </p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%"></td>
                                            <td width="20%"></td>
                                            <td width="25%"></td>
                                            <td class="" width="30%" style="white-space: nowrap;">
                                                <p class="pl-1" style="white-space: none; margin: 0;">Pejabat yang memberikan izin: </p>
                                                <p class="approver text-center" style="white-space: none; margin: 0; ">...........................................</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%"></td>
                                            <td width="20%"></td>
                                            <td width="25%"></td>
                                            <td width="30%" height="30%">
                                                <div class="signature">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%"></td>
                                            <td width="10%"></td>
                                            <td width="10%"></td>
                                            <td width="50%" height="30%" style="white-space: nowrap;">
                                                <p class="name_sign text-center" style="white-space: none; margin: 0; ">(....................)</p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vertical modal end-->
