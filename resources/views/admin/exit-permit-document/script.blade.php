<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();

            $('#select-letter').select2({
                    placeholder: "Pilih Nama Pegawai...",
                    minimumInputLength: 2,
                    language: { inputTooShort: function () { return 'Ketik minimal 2 karakter'; } },
                    ajax: {
                        method: 'GET',
                        url: '/admin/employee/find',
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
                        url: '/admin/employee/find',
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
                            console.log(data);
                        },
                        cache: true
                    }
                });


            $('#select-unit').select2({
                    placeholder: "Pilih Unit...",
                    minimumInputLength: 2,
                    language: { inputTooShort: function () { return 'Ketik minimal 2 karakter'; } },
                    ajax: {
                        method: 'GET',
                        url: '/admin/unit/find',
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

            $(document).on('click', '#create-doc-category-modal', function(event){
                event.preventDefault();

                $('#form-doc-category').trigger("reset");
                $('#form-doc-category').attr('action','{{url('admin/exit-permit-document')}}');
                $('#form-doc-category').attr('method','POST');
                showModal('modal-docs-category');
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
                    $('input[name="name"]').val(data.data.name);
                    $('.name').text(data.data.name);
                    $('input[name="nip"]').val(data.data.nip+' / '+data.data.gol);
                    $('input[name="unit"]').val(data.data.unit);
                    $('input[name="reason"]').val(data.data.reason);
                    $('.date').text(data.data.date);
                    $('input[name="time"]').val(data.data.time);
                    $('input[name="approver"]').val(data.data.approver);

                    console.log(data.data);

                    if (data.data.status == 'Ditolak'){
                        $('.status-note').html(
                            `
                                <div style="background-color:rgba(255, 0, 0, 0.47); color:rgb(255, 255, 255); padding: 10px; border-radius: 5px; ">
                                    <p style="font-weight: 700"> Dokumen ${data.data.status} karena: </p>
                                    <p style="font-weight: 500"> ${data.data.notes} </p>
                                </div>
                            `
                        )
                    }

                    $('.signature').html(`
                        <img src="{{asset('/signature/`+data.data.signature+`')}}" alt=""
                            style="min-height: 60px; max-height: 60px;" width="auto"
                            style="margin-left: 50%;">
                    `)

                    $('div#link_pdf').html(`
                        <a href="{{url('admin/exit-permit-document/download_pdf/`+data.data.id+`')}}" class="btn btn-light btn-sm btn-clean btn-icon" data-toggle="tooltip" data-placement="top" title="Print Lembar Disposisi"  >
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
                console.log(data.status);

                if (auth == data.approver){
                    $('.main').remove();
                    $('#form-doc-category').attr('action', '/admin/exit-permit-document/update_approval/' + data.id);

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
                    $('#form-doc-category').attr('action', $(this).attr('href'));
                }


                $('#form-doc-category').trigger("reset");
                $('#form-doc-category').attr('method','PUT');
                // $('#form-doc-category').find('input[name="name"]').val(data.name);
                if (data.name){
                    $('#form-doc-category').find('select[id="select-letter"]').append(`<option value="`+ data.name +`">`+ data.name +`</option>`)
                }

                if (data.unit){
                    $('#form-doc-category').find('select[id="select-unit"]').append(`<option value="`+ data.unit +`">`+ data.unit +`</option>`)
                }

                $('#form-doc-category').find('input[type="date"]').val(data.datetime.toString("mm/dd/yy"));
                $('#form-doc-category').find('textarea[name="reason"]').val(data.reason);

                $('textarea[name="notes"]').val(data.notes);

                showModal('modal-docs-category');
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
            $('#form-doc-category').submit(function(event){
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    DocsCategoryTable.table().draw(false);
                    hideModal('modal-docs-category');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
