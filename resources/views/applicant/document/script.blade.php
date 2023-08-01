<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {
            $('#select-chief').select2({
                    placeholder: "Cari Nama...",
                    minimumInputLength: 2,
                    language: { inputTooShort: function () { return 'Ketik minimal 2 karakter'; } },
                    ajax: {
                        method: 'GET',
                        url: '/applicant/pejabat/find',
                        dataType: 'json',
                        data: function (params) {
                            return {
                                q: $.trim(params.term)
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });

            $('#select-chief').on('select2:select', function (e) {
                e.preventDefault();

                var dt = e.params.data.id;

                $('input[name="chief"]').val(dt);

            });

            $(document).on('change','#document_type', function(event){
                event.preventDefault();
                var id = $(this).find('option:selected').data('id');
                var id_req = $(this).find('option:selected').val();

                console.log(id_req);
                $('#form-doc-create').trigger("reset");
                $('#form-doc-create').attr('action','{{url('applicant/document')}}');
                $('#form-doc-create').attr('method','POST');
                $('#form-doc-create').attr('enctype','multipart/form-data');
                $('div#data_input').html("");
                $('#form-doc-create').find('input[name="id_cat"]').val(id);

                if (id_req == 'Permohonan Magang') {

                    $('div#data_input').append(`
                        <input type="hidden" name="doc_cat" value="`+id_req+`">

                        <label class="form-label mt-1 label"> Surat Permohonan </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[0]">
                                <input type="hidden" name="type_doc[0]" value="Surat Permohonan">
                            </div>
                        </div>

                        <label class="form-label mt-1 label"> Surat Permohonan Magang </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[1]">
                                <input type="hidden" name="type_doc[1]" value="Surat Permohonan Magang">
                            </div>
                        </div>
                    `);

                    showModal('modal-document')
                } else if (id_req == 'Permohonan Sertifikat Magang') {
                    $('div#data_input').append(`
                        <label class="form-label mt-1 label"> Surat Permohonan </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[0]">
                                <input type="hidden" name="type_doc[0]" value="Surat Permohonan">
                            </div>
                        </div>

                        <input type="hidden" name="doc_cat" value="`+id_req+`">
                        <label class="form-label mt-1 label"> Surat Permohonan Seritifikat Magang </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[1]">
                                <input type="hidden" name="type_doc[1]" value="Surat Permohonan Seritifikat Magang">
                            </div>
                        </div>
                    `);

                    showModal('modal-document')
                } else if(id_req == "Permohonan Penelitian"){
                    $('div#data_input').append(`
                        <input type="hidden" name="doc_cat" value="`+id_req+`">
                        <label class="form-label mt-1 label"> Surat Permohonan </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[0]">
                                <input type="hidden" name="type_doc[0]" value="Surat Permohonan">
                            </div>
                        </div>
                        <label class="form-label mt-1 label"> Surat Permohonan atau Pengantar </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[1]">
                                <input type="hidden" name="type_doc[1]" value="Surat Permohonan atau Pengantar">
                            </div>
                        </div>
                        <label class="form-label mt-1 label"> Proposal Penelitian </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[2]">
                                <input type="hidden" name="type_doc[2]" value="Proposal Penelitian">
                            </div>
                        </div>
                    `);

                    showModal('modal-document')
                } else if (id_req == "Surat Keterangan Bebas Perkara"){
                    $('div#bebas_perkara').append(`
                        <input type="hidden" name="doc_cat" value="`+id_req+`">

                        <label class="form-label mt-1 label"> Surat Permohonan </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[0]">
                                <input type="hidden" name="type_doc[0]" value="Surat Permohonan">
                            </div>
                        </div>

                        <label class="form-label mt-1 label"> Jenis </label>
                            <select class="form-control" name="jenis_perkara" id="jenis_perkara">
                                <option value=""> -- Pilih -- </option>
                                <option value="perorangan"> Perorangan </option>
                                <option value="perusahaan"> Perusahaan/Badan Hukum </option>
                            </select>
                        </div>
                    `);

                    $(document).on('change','#bebas_perkara', function(event){

                        var jenis = $(this).find('option:selected').val();

                        if(jenis == "perorangan"){
                            $('div#data_input').html(`
                                <label class="form-label mt-1 label"> Fotocopy KTP </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                        <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[1]">
                                        <input type="hidden" name="type_doc[1]" value="Fotocopy KTP">
                                    </div>
                                </div>
                                <label class="form-label mt-1 label"> Fotocopy KK </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                        <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[2]">
                                        <input type="hidden" name="type_doc[2]" value="Fotocopy KK">
                                    </div>
                                </div>
                                <label class="form-label mt-1 label"> Fotocopy SKCK </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                        <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[3]">
                                        <input type="hidden" name="type_doc[3]" value="Fotocopy SKCK">
                                    </div>
                                </div>
                            `);
                        } else if (jenis == "perusahaan") {
                            $('div#data_input').html(`
                                <label class="form-label mt-1 label"> Surat Permohonan </label>
                                <div class="input-group">
                                        <div class="custom-file">
                                        <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[0]">
                                        <input type="hidden" name="type_doc[0]" value="Surat Permohonan">
                                    </div>
                                </div>

                                <label class="form-label mt-1 label"> Fotocopy KTP Direksi </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                        <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[1]">
                                        <input type="hidden" name="type_doc[1]" value="Fotocopy KTP Direksi">
                                    </div>
                                </div>
                                <label class="form-label mt-1 label"> Fotocopy TDP/SIUP/Akta Pendirian </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                        <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[2]">
                                        <input type="hidden" name="type_doc[2]" value="Fotocopy TDP/SIUP/Akta Pendirian">
                                    </div>
                                </div>
                                <label class="form-label mt-1 label"> Fotocopy Domisili </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                        <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[3]">
                                        <input type="hidden" name="type_doc[3]" value="Fotocopy Domisili">
                                    </div>
                                </div>
                                <label class="form-label mt-1 label"> Fotocopy Surat Kuasa </label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                        <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[4]">
                                        <input type="hidden" name="type_doc[4]" value="Fotocopy Surat Kuasa">
                                    </div>
                                </div>
                            `);
                        } else {
                            $('div#data_input').html(``);
                        }
                    });

                    showModal('modal-document')
                } else if (id_req == "Salinan Putusan"){
                    $('div#data_input').append(`
                        <input type="hidden" name="doc_cat" value="`+id_req+`">
                        <label class="form-label mt-1 label"> Surat Permohonan </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[0]">
                                <input type="hidden" name="type_doc[0]" value="Surat Permohonan">
                            </div>
                        </div>

                        <label class="form-label mt-1 label"> Surat Kuasa (Pihak Tergugat/Penggugat)  </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[1]">
                                <input type="hidden" name="type_doc[1]" value="Surat Kuasa (Pihak Tergugat/Penggugat)">
                            </div>
                        </div>
                        <label class="form-label mt-1 label"> Identitas pemohon (KTP) </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[2]">
                                <input type="hidden" name="type_doc[2]" value="Identitas pemohon (KTP)">
                            </div>
                        </div>
                    `);
                    showModal('modal-document')
                } else if (id_req == "Permohonan Surat Keterangan BHT"){
                    $('div#data_input').append(`
                        <input type="hidden" name="doc_cat" value="`+id_req+`">
                        <label class="form-label mt-1 label"> Surat Permohonan </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[0]">
                                <input type="hidden" name="type_doc[0]" value="Surat Permohonan">
                            </div>
                        </div>

                        <label class="form-label mt-1 label"> Surat Kuasa (Pihak Tergugat/Penggugat)  </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[1]">
                                <input type="hidden" name="type_doc[1]" value="Surat Kuasa (Pihak Tergugat/Penggugat)">
                            </div>
                        </div>
                        <label class="form-label mt-1 label"> Identitas pemohon (KTP) </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[2]">
                                <input type="hidden" name="type_doc[2]" value="Identitas pemohon (KTP)">
                            </div>
                        </div>
                    `);
                    showModal('modal-document')
                }
                else {
                    $('div#data_input').append(`
                        <input type="hidden" name="doc_cat" value="`+id_req+`">
                        <label class="form-label mt-1 label"> Surat Permohonan </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[0]">
                                <input type="hidden" name="type_doc[0]" value="Surat Permohonan">
                            </div>
                        </div>

                        <label class="form-label mt-1 label"> Identitas diri  </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[1]">
                                <input type="hidden" name="type_doc[1]" value="Identitas diri">
                            </div>
                        </div>
                        <label class="form-label mt-1 label"> Surat Pengantar Tujuan </label>
                            <div class="input-group">
                                <div class="custom-file">
                                <input type="file" id="inputGroupFile" class="form-control" name="requirement_value[2]">
                                <input type="hidden" name="type_doc[2]" value="Surat Pengantar Tujuan">
                            </div>
                        </div>
                    `);
                    showModal('modal-document')
                }

                $(document).on('hide.bs.modal','#modal-document', function(event){
                    location.reload();
                });

            });



            $(document).on('change','#select-docs-category', function(event){
                event.preventDefault();
                var id = $(this).find('option:selected').data('id');
                var id_req = $(this).find('option:selected').val();
                $('#form-doc-create').trigger("reset");
                $('#form-doc-create').attr('action','{{url('applicant/document')}}');
                $('#form-doc-create').attr('method','POST');
                $('#form-doc-create').attr('enctype','multipart/form-data');
                $('div#data_input').html("");

                console.log(id);

                $('#form-doc-create').find('input[name="id_cat"]').val(id);

                $.get('/applicant/document-select/'+id, function(data){
                        for (i in data){
                            if(data[i].data_type == "textarea"){

                                $('div#data_input').append(`
                                    <label class="form-label mt-1 label">`+data[i].title+`</label>
                                    <div class="input-group">
                                        <textarea data-length="50" class="form-control char-textarea" id="`+data[i].data_type+`" name="requirement_value[`+i+`]"  rows="4" placeholder=""></textarea>
                                    </div>
                                `);
                            }else if(data[i].data_type == "file"){
                                $('div#data_input').append(`
                                    <label class="form-label mt-1 label">`+data[i].title+`</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                        <input type="`+data[i].data_type+`" id="inputGroupFile" class="form-control" placeholder="`+data[i].title+`" name="requirement_value[`+i+`]">

                                        </div>
                                    </div>
                                `);
                            }else
                            {
                                $('div#data_input').append(`
                                    <label class="form-label mt-1 label">`+data[i].title+`</label>
                                    <div class="input-group">
                                        <input type="`+data[i].data_type+`"  class="form-control" placeholder="`+data[i].title+`" name="requirement_value[`+i+`]" pattern=".{`+data[i].data_max+`,}" title="Harus diisi `+data[i].data_max+` karakter">
                                    </div>
                                `);

                            }

                        }
                    })

                showModal('modal-document')

                // // $('#modal-document').modal('show');

                $(document).on('hide.bs.modal','#modal-document', function(event){
                    location.reload();
                });

            });

            $(document).on('click', '.btn-detail', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = DocTable.table().row($(this).parents('tr')).data();
                $('#form-doc-create').trigger("reset");
                $('#form-doc-create').attr('action', $(this).attr('href'));
                $('#form-doc-create').attr('method','PUT');
                $('#form-doc-create').attr('enctype','multipart/form-data');

                $('div#doc_file').html("");

                $.get(url, function(data){

                        $('input[name="name"]').val(data.name);
                        $('input[name="chief_name"]').val(data.chief_name);
                        $('input[name="date"]').val(data.date_create);
                        $('input[name="document_category"]').val(data.document_category);
                        $('input[name="requirement"]').val(data.type);
                        $('input[name="required"]').val(data.required);
                        $('textarea[name="description"]').val(data.description);

                        for (i in data.doc_req){
                        // var str = data.doc_req[i].requirement_value;
                        //     var dotIndex= str.lastIndexOf('.');
                        //     var ext = str.substring(dotIndex);

                        //     if(ext=='.jpg'||ext=='.jpeg'||ext=='.png'||ext=='.pdf'){
                                $('div#doc_file').append(`
                                    <label for="basicadd`+i+`">`+data.doc_req[i].type+`</label>
                                    <div class="input-group mb-1">

                                        <span class="input-group-text " id="basicadd`+i+`" style="width:100%; ">

                                            <a href="/applicant/document/download/`+data.id+`">`+data.doc_req[i].requirement_value+`</a>
                                            <div class="tooltipLink" style="position:absolute;left:93%; width:50px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <embed src="{{ asset('files/`+data.doc_req[i].requirement_value+`') }}">
                                            <div>
                                        </span>
                                    </div>
                                `);
                            // }else{
                            //     $('div#doc_file').append(`
                            //         <label for="basicadd`+i+`">`+data.doc_req[i].type+`</label>
                            //         <div class="input-group mb-1 ">
                            //             <span class="input-group-text" id="basicadd`+i+`" style="width:100%"> `+data.doc_req[i].requirement_value+`</span>
                            //         </div>
                            //     `);
                            // }
                        }

                        if (data.status=="Diproses") {
                            $('#form-doc-create').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-warning mr-1">'+data.status+'</span>');
                        }else if (data.status=='Ditolak') {
                            $('#form-doc-create').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-danger mr-1">'+data.status+'</span>');
                        }else{
                            $('#form-doc-create').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-secondary mr-1">'+data.status+'</span>');
                        }
                });

                showModal('modal-document-2');
            });

            $('#btn-save').click(function() {
                $.blockUI({
                    message:
                    '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Mohon Tunggu...</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                    css: {
                    backgroundColor: 'transparent',
                    color: '#fff',
                    border: '0'
                    },
                    overlayCSS: {
                    opacity: 0.5
                    },
                    timeout: 1000,
                });

                // setTimeout($.unblockUI, 2100);
            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = DocTable.table().row($(this).parents('tr')).data();
                $('#form-doc-create').trigger("reset");
                $('#form-doc-create').attr('action', $(this).attr('href'));
                $('#form-doc-create').attr('method','POST');
                $('#form-doc-create').attr('enctype','multipart/form-data');
                $('#form-doc-create').find('input[name="name"]').val(dt.name);

                $.get(url, function(data){
                    $('#form-add').html(`<input type="hidden" name="_method" value="PUT">`);
                    for (i in data.doc_req){

                    if(data.doc_req[i].data_type == "textarea"){

                        $('div#data_input').append(`
                            <label class="form-label mt-1 label">`+data.doc_req[i].title+`</label>
                            <div class="input-group">
                                <textarea data-length="50" class="form-control char-textarea" id="`+data.doc_req[i].data_type+`" name="requirement_value[`+i+`]"  rows="4" placeholder=""  value="`+data.doc_req[i].requirement_value+`"></textarea>
                            </div>
                        `);
                    }else if(data.doc_req[i].data_type == "file"){

                        $('div#data_input').append(`
                            <label class="form-label mt-1 label">`+data.doc_req[i].title+`</label>
                            <div class="input-group">
                                <input type="file" class="form-control" placeholder="`+data.doc_req[i].title+`" name="requirement_value[`+i+`]" >
                            </div>
                        `);
                    }else
                    {
                        $('div#data_input').append(`
                            <label class="form-label mt-1 label">`+data.doc_req[i].title+`</label>
                            <div class="input-group">
                                <input type="`+data.doc_req[i].data_type+`" class="form-control" placeholder="`+data.doc_req[i].title+`" name="requirement_value[`+i+`]" pattern=".{`+data.doc_req[i].data_max+`,}" title="Harus diisi `+data.doc_req[i].data_max+` karakter">
                            </div>
                        `);

                    }

                }
                showModal('modal-document');

                $(document).on('hide.bs.modal','#modal-document', function(event){
                    location.reload();
                });
                });
            });

            $(document).on('click', '.btn-delete', function(event){
                event.preventDefault();
                var url = $(this).attr('href');

                Swal.fire({
                    title: 'Hapus data?',
                    text: "Data yang akan anda Hapus akan hilang permanen!",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal!"
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            dataType: 'json',
                        })
                        .done(function(res, xhr, meta) {
                            toastr.success(res.message, 'Success')
                            DocTable.table().draw(false);
                        })
                        .fail(function(res, error) {
                            toastr.error(res.responseJSON.message, 'Gagal')
                        })
                        .always(function() { });
                    }
                })
            });
        },

        formSubmit = () => {
            $('#form-doc-create').submit(function(event){
                event.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    Swal.fire({
                            title: 'Berhasil!',
                            text: "Berhasil menyimpan!",
                        })

                    DocTable.table().draw(false);
                    hideModal('modal-document');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                    Swal.fire({
                            title: 'Gagal!',
                            text: "Gagal menyimpan!",
                        })
                })
                .always(function() { });
            });
        }
    }();
</script>
