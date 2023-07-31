<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();

            $(document).ready(function(){
                $('.dropify').dropify();
            })

            Pusher.logToConsole = false;

            var pusher = new Pusher('9b20901b264fe57d21bd', {
              cluster: 'ap1',
              encrypted:true
            });

            var channel = pusher.subscribe('my-channel');
            channel.bind('App\\Events\\DispositionNotif', function(data) {
                const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 5000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
                })

                if(data){
                    Toast.fire({
                      icon: 'info',
                      title: data.message
                    })
                    // alert();
                }
            });

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
                $('#form-disposition').attr('action','{{url('admin/disposition-document')}}');
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

                var id = $(this).data('id');
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
                        <embed class="mt-1" src="{{ asset('files/`+data.data.uploaded_document+`') }}#toolbar=0&navpanes=0&scrollbar=0" width="150%" height="600">
                        </embed>
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
                        if(disposition[i].role == 'Ketua'){
                            $('.forward-1').text('✓');
                            $('.ketua-instruction').append(`
                                <p class="ketua_ins-${i}"> -
                                    ${disposition[i].instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Panitera'){
                            $('.forward-2').text('✓');
                            $('.panitera-instruction').append(`
                                <p class="panitera_ins-${i}"> -
                                    ${disposition[i].instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Sekretaris'){
                            $('.forward-3').text('✓');
                            $('.sekretaris-instruction').append(`
                                <p class="sekretaris_ins-${i}"> -
                                    ${disposition[i].instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Panitera Muda Hukum'){
                            $('.forward-4').text('✓');
                            $('.panmud-instruction').append(`
                                <p class="panmud_ins-${i}"> -
                                    ${disposition[i].instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Panitera Muda Perkara'){
                            $('.forward-5').text('✓');
                            $('.panmud-instruction').append(`
                                <p class="panmud_ins-${i}"> -
                                    ${disposition[i].instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Kasub Umum dan Keuangan'){
                            $('.forward-6').text('✓');
                            $('.kasubag-instruction').append(`
                                <p class="kasubag_ins-${i}"> -
                                    ${disposition[i].instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Kasub Kepegawaian, Ortala'){
                            $('.forward-7').text('✓');
                            $('.kasubag-instruction').append(`
                                <p class="kasubag_ins-${i}"> -
                                    ${disposition[i].instruction}
                                </p>
                            `);
                        }

                        if(disposition[i].role == 'Kasub Umum dan Keuangan'){
                            $('.forward-8').text('✓');
                            $('.kasubag-instruction').append(`
                                <p class="kasubag_ins-${i}"> -
                                    ${disposition[i].instruction}
                                </p>
                            `);
                        }
                    }


                    $('div#link_pdf').html(`
                        <a href="{{url('admin/disposition-document/download_pdf/`+data.data.id+`')}}" class="btn btn-light btn-sm btn-clean btn-icon" data-toggle="tooltip" data-placement="top" title="Print Lembar Disposisi"  >
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

                if (auth == data.approver){
                    $('.main').remove();
                    $('#form-disposition').attr('action', 'Simpan/applicant/exit-permit-document/update_approval/' + data.id);

                    $('.approval').html(
                        `
                            <div class="form-check form-check-inline custom-radio mb-2">
                                <input type="radio" id="status_edit1" name="status" class="form-check-input"  value="Disetujui">
                                <label class="form-check-label" for="status_edit1">Setuju</label>
                              </div>
                              <div class="form-check form-check-inline custom-radio">
                                <input type="radio" id="status_edit2" name="status" class="form-check-input" value="Ditolak">
                                <label class="form-check-label" for="status_edit2">Tolak</label>
                              </div>
                            </div>

                            <br>

                            <label for="notes" id="notes" class="form-label">Catatan</label>
                            <div class="input-group">
                                <textarea data-length="50" class="form-control char-textarea" id="notes" name="notes"
                                    rows="3" placeholder=""></textarea>
                            </div>
                            <small class="textarea-counter-value float-right bg-success"><span
                                    class="char-count">0</span> / 50 </small>
                        `
                    )
                }
                else{
                    $('#form-disposition').attr('action', $(this).attr('href'));
                }


                $('#form-disposition').trigger("reset");
                $('#form-disposition').attr('action', $(this).attr('href'));
                $('#form-disposition').attr('method','POST');
                $('.form-method').html(`{{ method_field('put') }}`);

                if (data.name){
                    $('#form-disposition').find('select[id="select-letter"]').append(`<option value="`+ data.name +`">`+ data.name +`</option>`)
                }

                if (data.unit){
                    $('#form-disposition').find('select[id="select-unit"]').append(`<option value="`+ data.unit +`">`+ data.unit +`</option>`)
                }

                $('#form-disposition').find('input[name="index"]').val(data.index);
                $('#form-disposition').find('input[name="agenda_number"]').val(data.agenda_number);
                $('#form-disposition').find('input[name="code"]').val(data.code);
                $('#form-disposition').find('input[name="agenda_date"]').val(data.agenda_date);
                $('#form-disposition').find('input[name="date_finish"]').val(data.date_finish);
                $('#form-disposition').find('input[name="date_number"]').val(data.date_number);
                $('#form-disposition').find('input[name="from"]').val(data.from);
                $('#form-disposition').find('textarea[name="resume_content"]').val(data.resume_content);
                $('#form-disposition').find('input[name="uploaded_file"]').attr("data-default-file", "{{asset('files/"+ data.uploaded_document +"')}}");
                console.log(data.uploaded_document);
                $('textarea[name="notes"]').val(data.notes);

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
