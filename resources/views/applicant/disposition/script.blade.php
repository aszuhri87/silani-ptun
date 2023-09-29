<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();

            $('#select-letter').select2({
                    placeholder: "Cari Nama Anda...",
                    minimumInputLength: 2,
                    language: { inputTooShort: function () { return 'Ketik minimal 2 karakter'; } },
                    ajax: {
                        method: 'GET',
                        url: '/applicant/employee/find',
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

            $('#select-chief').select2({
                    placeholder: "Cari Nama Atasan...",
                    minimumInputLength: 2,
                    language: { inputTooShort: function () { return 'Ketik minimal 2 karakter'; } },
                    ajax: {
                        method: 'GET',
                        url: '/applicant/employee/find',
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


            $('#select-unit').select2({
                    placeholder: "Pilih Unit Kerja...",
                    minimumInputLength: 2,
                    language: { inputTooShort: function () { return 'Ketik minimal 2 karakter'; } },
                    ajax: {
                        method: 'GET',
                        url: '/applicant/unit/find',
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
        });

        const initAction = () => {
            $('#select-letter').on('select2:select', function (e) {
                e.preventDefault();

                var dt = e.params.data.id;

                $('input[name="name"]').val(dt);

            });

            $('#select-chief').on('select2:select', function (e) {
                e.preventDefault();

                var dt = e.params.data.text;

                $('input[name="chief"]').val(dt);

            });

            $('#select-unit').on('select2:select', function (e) {
                e.preventDefault();

                var dt = e.params.data.id;

                $('input[name="unit"]').val(dt);

            });

            $(document).on('click', '#create-disposition-modal', function(event){
                event.preventDefault();

                $('#form-disposition').trigger("reset");
                $('#form-disposition').attr('action','{{url('applicant/disposition-document')}}');
                $('#form-disposition').attr('method','POST');

                showModal('modal-disposition');
            });

            $(document).on('click','#btn-print', function(event){
                event.preventDefault();

                printJS({
                    printable: 'print',
                    type: 'html',
                    style:'.col-10{right:7%;}',
                    css:[
                        '../../app-assets/css/bootstrap.css',
                        '../../css/app.css',
                        '../../css/style.css',
                        '../../app-assets/css/colors.css',
                        '../../app-assets/css/bootstrap-extended.css',
                        '../../app-assets/css/components.css'
                    ],
                    documentTitle: Date.now()+'_lembar disposisi'
                });
                document.title = Date.now()+'_lembar disposisi';
            });

            $(document).on('click', '.btn-detail', function(event){
                event.preventDefault();

                var id =  DocsCategoryTable.table().row($(this).parents('tr')).data().id;

                var url = $(this).attr('href');
                var dt = DocsCategoryTable.table().row($(this).parents('tr')).data();
                var data_unit = <?php echo json_encode($data)?>;

                $.get(url, function(data){
                    let disposition = data.data.disposition;

                    $('.index').text(data.data.index);
                    $('.code').text(data.data.code);
                    $('.date_finish').text(data.data.date_finish);
                    $('.date_number').text(data.data.date_number);
                    $('.from').text(data.data.from);
                    $('.resume_content').text(data.data.resume_content);
                    $('.date_finish').text(data.data.date_finish);
                    $('.agenda_numdate').text(data.data.agenda_number+'/'+data.data.agenda_date);

                    $('div#files').append(`
                        <iframe class="mt-1" src="{{ asset('files/`+data.data.uploaded_document+`') }}#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="auto">
                        </iframe>
                    `);

                    if(data.data.letter_type == 'Rahasia'){
                        $('.rahasia').text('✓');
                    }
                    else if(data.data.letter_type == 'Penting'){
                        $('.penting').text('✓');
                    }
                    else {
                        $('.biasa').text('✓');
                    }


                    for(let i = 0; i < disposition.length; i++){
                        let instruction = null;
                        if(disposition[i].instruction == null || disposition[i].instruction == "null"){
                            instruction = "";
                        } else {
                            instruction = "- "+disposition[i].instruction;
                        }

                        if(disposition[i].role == 'Ketua'){
                            $('.forward-1').text('✓');
                            $('.ketua-instruction').append(`
                                <p class="ketua_ins-${i}">
                                    ${instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Wakil Ketua'){
                            $('.forward-2').text('✓');
                            $('.ketua-instruction').append(`
                                <p class="waketua_ins-${i}">
                                    ${instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Panitera'){
                            $('.forward-3').text('✓');
                            $('.panitera-instruction').append(`
                                <p class="panitera_ins-${i}">
                                    ${instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Sekretaris'){
                            $('.forward-4').text('✓');
                            $('.sekretaris-instruction').append(`
                                <p class="sekretaris_ins-${i}">
                                    ${instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Panitera Muda Hukum'){
                            $('.forward-5').text('✓');
                            $('.panmud-instruction').append(`
                                <p class="panmud_ins-${i}">
                                    ${instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Panitera Muda Perkara'){
                            $('.forward-6').text('✓');
                            $('.panmud-instruction').append(`
                                <p class="panmud_ins-${i}">
                                    ${instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Kasub Umum dan Keuangan'){
                            $('.forward-7').text('✓');
                            $('.kasubag-instruction').append(`
                                <p class="kasubag_ins-${i}">
                                    ${instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Kasub Kepegawaian, Ortala'){
                            $('.forward-8').text('✓');
                            $('.kasubag-instruction').append(`
                                <p class="kasubag_ins-${i}">
                                    ${instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Kasub Perencanaan, TI dan Pelaporan'){
                            $('.forward-9').text('✓');
                            $('.kasubag-instruction').append(`
                                <p class="kasubag_ins-${i}">
                                    ${instruction}
                                </p>
                            `);
                        }
                    }


                    for (i in data.data.document_file){
                        $('div#doc_file').append(`
                            <label for="basicadd`+i+`">`+data.data.document_file[i].type+`</label>
                            <div class="input-group mb-1">
                                <span class="input-group-text " id="basicadd`+i+`">
                                    <a href="/applicant/document/download/`+data.data.document_file[i].doc_req_id+`"> Download </a>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"> <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/> <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/> </svg>
                                    <div class="tooltipLink" style="position:absolute; left:135%; width:50px;">
                                        <embed src="{{ asset('files/`+data.data.document_file[i].requirement_value+`') }}">
                                    <div>
                                </span>
                            </div>
                        `);
                    }

                    $('div#link_pdf').html(`
                        <a href="{{url('applicant/disposition-document/download_pdf/`+data.data.id+`')}}" class="btn btn-light btn-sm btn-clean btn-icon" data-toggle="tooltip" data-placement="top" title="Print Lembar Disposisi"  >
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#44559f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></a>
                    `);
                });

                showModal('modal-document');

                $(document).on('hide.bs.modal','#modal-document', function(event){
                    $('input[type="checkbox"]').prop('checked',false);
                    location.reload();
                });
            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();
                var data = DocsCategoryTable.table().row($(this).parents('tr')).data();
                var auth = {!! json_encode(Auth::user()->name) !!}
                var role = {!! json_encode(Auth::user()->title) !!}

                $('#form-disposition').trigger("reset");
                $('#form-disposition').attr('action', `{{url('applicant/disposition-update/${data.id}')}}`);
                $('#form-disposition').attr('method','POST');

                $('#status_false').on('change', function(event){
                    status = $(this).val()
                    if(status == 'tolak'){
                        $('#select-fordward').remove()
                        $('#label-forward').remove()
                    }
                })

                $('#status_true').on('change', function(event){
                    status = $(this).val()
                    if(status == 'setuju'){
                        $('.forward-form').html(
                            `
                            <label for="nama" class="mt-2" id="label-forward">Diteruskan kepada</label>
                                    <div class="form-group">
                                        <select class=" form-control" id="select-fordward" data-toggle="collapse" required
                                            data-target="#timeline" name="role" required>
                                            @if (Auth::user()->title == 'Ketua' || Auth::user()->title == 'Wakil Ketua')
                                                <option value="Panitera">Panitera</option>
                                                <option value="Sekretaris">Sekretaris</option>
                                            @elseif (Auth::user()->title == 'Panitera')
                                                <option value="Panitera Muda Hukum">Panitera Muda Hukum</option>
                                                <option value="Panitera Muda Perkara">Panitera Muda Perkara</option>
                                            @elseif (Auth::user()->title == 'Sekretaris')
                                                <option value="Kasub Umum dan Keuangan">Kasub Umum dan Keuangan</option>
                                                <option value="Kasub Kepegawaian, Ortala">Kasub Kepegawaian, Ortala</option>
                                                <option value="Kasub Perencanaan, TI dan Pelaporan">Kasub Perencanaan, TI dan Pelaporan</option>
                                            @endif
                                        </select>
                                    </div>
                            `
                        )
                    }
                })

                if(data.status_user == 'setuju'){
                    $('#status_true').prop('checked', true);
                } else {
                    $('#status_false').prop('checked', true);
                }

                if(role == 'Kasub Umum dan Keuangan' || role == 'Kasub Kepegawaian, Ortala' ||
                    role == 'Panitera Muda Hukum' || role == 'Panitera Muda Perkara' ||
                    role == 'Kasub Perencanaan, TI dan Pelaporan'
                ){
                    $('#select-fordward').remove()
                    $('#label-forward').remove()
                }

                showModal('modal-disposition');
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
                            DocsCategoryTable.table().draw(false);
                        })
                        .fail(function(res, error) {
                            toastr.error(res.responseJSON.message, 'Gagal')
                        })
                        .always(function() { });
                    }
                })
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
        },
        formSubmit = () => {
            $('#form-disposition').submit(function(event){
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    Swal.fire({
                            title: 'Berhasil!',
                            text: "Berhasil menyimpan!",
                        })

                    DocsCategoryTable.table().draw(false);
                    hideModal('modal-disposition');
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
