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
                    <div class="col-md-12">
                        <form id="form-doc-category" name="form-doc-category" class="auth-register-form mt-2">
                            <label for="nama">Nama</label>
                            <div class="form-group">
                                <select class=" form-control" id="select-letter" data-toggle="collapse" required
                                    data-target="#timeline"></select>
                            </div>

                            <div class="form-group">
                                <label for="permit_type">Unit Kerja</label>
                                <select class=" form-control" id="select-unit" data-toggle="collapse" required
                                    data-target="#timeline"></select>
                            </div>

                            <label for="address" id="address" class="form-label">Alasan</label>
                            <div class="input-group">
                                <textarea data-length="50" class="form-control char-textarea" id="reason" name="reason" required
                                    rows="3" placeholder=""></textarea>
                            </div>
                            <small class="textarea-counter-value float-right bg-success"><span
                                    class="char-count">0</span> / 50 </small>

                            <label class="form-label mt-1">Waktu</label>
                            <div class="row">
                                <div class="col-12">
                                    <input class="form-control" type="date" name="datetime" id="start_time" required>
                                </div>
                            </div>

                            <small class="textarea-counter-value float-right bg-success"><span
                                    class="char-count">0</span> / 50 </small>
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
        <div class="modal-dialog" role="document">
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

                <div class="container" >
                <div class="modal-body" >

                    <form  id="print">
                     <!-- Basic -->
                     <div class="row mt-2">
                         <div class="col-2">
                            <img src="{{asset('logo.png')}}" alt="" height="100px" width="auto" style="margin-left: 30%;">

                        </div>
                        <div class="col-10 text-center">
                            <div style="margin-right: 15%;">
                                <h3 style="font-family: 'Times New Roman', Times, serif; font-weight: 700;"><b>PENGADILAN TATA USAHA NEGARA YOGYAKARTA </b></h3>
                                <p style="font-size:11px; font-weight: 700;">Jl. Janti No.66 Banguntapan Telp. (0274) 520502 Faks. (0274)581675 <br>
                                Yogyakarta 5518</p>

                                <p style="font-size:11px;">Website: www.ptun-yogyakarta.go.id Email: info@ptun-yogyakarta.go.id</p>
                            </div>
                        </div>
                    </div>
                    <hr id="garis" style="border: solid black; ">
                    <div class="text-center">
                        <h3 style="font-family: 'Times New Roman', Times, serif; font-weight: 700;"> SURAT IJIN KELUAR KANTOR
                        </h3>
                    </div>

                    <div class="mt-5" style="font-family: 'Times New Roman', Times, serif; margin-left: 3%;">
                        Pejabat  : <input type="text" name="from" style="border: 0;">
                        <input class="form-control" style="border: 0;" type="text" name="name" id="name" placeholder="...........................................................................................................................................................................................................................................................................................">
                        <hr style="border-top: dotted 1px;" />
                        <p> Memberikan izin keluar kantor kepada:</p>
                        <table class="mb-5">
                            <tr>
                                <td>
                                    <p> Nama: </p>
                                </td>
                                <td>
                                    <div class="form-group" >
                                        <input class="form-control" style="width: 500px; border: 0;" type="text" name="name" id="name" placeholder="............................................................................................................................">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p> NIP/Gol.:</p>
                                </td>
                                <td>
                                    <div class="form-group" >
                                        <input class="form-control" style="width: 500px; border: 0;" type="text" name="nip" id="nip" placeholder="............................................................................................................................">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p> Unit Kerja:</p>
                                </td>
                                <td>
                                    <div class="form-group" >
                                        <input class="form-control" style="width: 500px; border: 0;" type="text" name="unit" id="unit" placeholder="............................................................................................................................">
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
                                    <p> Hari/tanggal:</p>
                                </td>
                                <td>
                                    <div class="form-group" >
                                        <input class="form-control" style="width: 500px; border: 0;" type="text" name="datetime" id="datetime" placeholder="............................................................................................................................">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p> Jam:</p>
                                </td>
                                <td>
                                    <div class="form-group" >
                                        <input class="form-control" style="width: 500px; border: 0;" type="text" name="datetime" id="datetime" placeholder="............................................................................................................................">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p> Untuk Keperluan:</p>
                                </td>
                                <td>
                                    <div class="form-group" >
                                        <input class="form-control" style="width: 500px; border: 0;" type="text" name="reason" id="reason" placeholder="............................................................................................................................">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="" width="25%">
                                    <div class="d-flex">
                                        Yogyakarta,
                                        <input class="form-control pb-2" style="border: 0;" type="text" name="name" id="name" placeholder="...................................................................">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td width="25%" >
                                     Pejabat yang memberikan izin:
                                    <input class="form-control" style="border: 0;" type="text" name="name" id="name" placeholder="...................................................................">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td width="25%" height="30%">
                                    <img src="" alt="">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td width="25%" height="30%" >
                                    <input class="form-control" style="border: 0;" type="text" name="name" id="name" placeholder="(..........................)">
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


