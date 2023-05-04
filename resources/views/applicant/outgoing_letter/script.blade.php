<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();

            $(document).ready(function(){
                $('.dropify').dropify();
            })

            $('#select-user').select2({
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

        });

        const initAction = () => {
            $('#select-user').on('select2:select', function (e) {
                e.preventDefault();

                var dt = e.params.data.id;

                $('input[name="user_id"]').val(dt);

            });

            $(document).on('click', '#create-outgoing-modal', function(event){
                event.preventDefault();

                $('#form-outgoing').trigger("reset");
                $('#form-outgoing').attr('action','{{url('applicant/outgoing-letter')}}');
                // $('#form-outgoing').attr('enctype', 'multipart/form-data')
                $('#form-outgoing').attr('method','POST');

                showModal('modal-outgoing');
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

                $('#uploaded_file').remove();

                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = OutgoingTable.table().row($(this).parents('tr')).data();
                var data_unit = <?php echo json_encode($data)?>;


                $.get(url, function(data){
                    $('#form-outgoing').find('select[id="select-user"]').append(`<option value="`+ data.data.user_id +`">`+ data.data.name +`</option>`).prop('disabled', true);
                    $('#form-outgoing').find('input[name="letter_number"]').val(data.data.letter_number).prop('disabled', true);
                    $('#form-outgoing').find('input[name="agenda_number"]').val(data.data.agenda_number).prop('disabled', true);
                    $('#form-outgoing').find('input[name="date_letter"]').val(data.data.date_letter).prop('disabled', true);
                    $('#form-outgoing').find('input[name="date_received"]').val(data.data.date_received).prop('disabled', true);
                    $('#form-outgoing').find('textarea[name="description"]').val(data.data.description).prop('disabled', true);

                    if(data.data.uploaded_document){
                        $('.files').html(`
                            <embed class="mt-1" src="{{ asset('files/`+data.data.uploaded_document+`') }}" width="150%" height="600"></embed>
                            `);
                        }
                    });

                    showModal('modal-outgoing');

                    $(document).on('hide.bs.modal','#modal-outgoing', function(event){
                        location.reload();
                    });
                });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();
                var data = OutgoingTable.table().row($(this).parents('tr')).data();
                var url = $(this).attr('href');

                $('#form-outgoing').trigger("reset");
                $('#form-outgoing').attr('method','PUT');

                $.get(url, function(data){
                    $('#form-outgoing').find('select[id="select-user"]').append(`<option value="`+ data.data.user_id +`">`+ data.data.name +`</option>`)
                    $('#form-outgoing').find('input[name="letter_number"]').val(data.data.letter_number);
                    $('#form-outgoing').find('input[name="agenda_number"]').val(data.data.agenda_number);
                    $('#form-outgoing').find('input[name="date_letter"]').val(data.data.date_letter);
                    $('#form-outgoing').find('input[name="date_received"]').val(data.data.date_received);
                    $('#form-outgoing').find('textarea[name="description"]').val(data.data.description);
                    $('#form-outgoing').find('input[name="uploaded_file"]').attr('data-default-file', '{{asset("files/")}}/' + data.data.uploaded_document);

                });

                $('.files').html(`
                        <label for="uploaded_file">File Surat</label>
                        <input type="file" name="uploaded_file" id="uploaded_file" class="dropify">
                        <label style="font-size: 8pt;">*Format harus pdf</label>
                `);

                $('.dropify').dropify();

                showModal('modal-outgoing');
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
                            OutgoingTable.table().draw(false);
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
            $('#form-outgoing').submit(function(event){
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
                    hideModal('modal-outgoing');
                    OutgoingTable.table().draw(false);
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
