<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {

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
                var dt = DoneTable.table().row($(this).parents('tr')).data();
                $('#form-doc-accepted').trigger("reset");
                $('#form-doc-accepted').attr('action', $(this).attr('href'));
                $('#form-doc-accepted').attr('method','PUT');
                $('div#doc_file').html("");

                $.get(url, function(data){
                    $('#form-doc-accepted').find('input[name="name"]').val(data.name);
                    $('#form-doc-accepted').find('input[name="date"]').val(data.date_create);
                    $('#form-doc-accepted').find('input[name="document_category"]').val(data.document_category);
                    $('#form-doc-accepted').find('input[name="applicant"]').val(data.applicant);
                    $('#form-doc-accepted').find('input[name="requirement_type"]').val(data.requirement_type);
                    $('#form-doc-accepted').find('input[name="requirement"]').val(data.requirement);
                    $('#form-doc-accepted').find('input[name="required"]').val(data.required);
                    $('#form-doc-accepted').find('textarea[name="description"]').val(data.description);
                    $('#form-doc-accepted').find('input[name="status_edit"][value=' + data.status + ']').prop('checked', true);
                    $('#form-doc-accepted').find('textarea[name="notes"]').val(data.notes);
                    $('#form-doc-accepted').find('input[name="phone_number"]').val(data.phone_number);

                    for (i in data.doc_req){
                        $('div#doc_file').append(`
                                    <label for="basicadd`+i+`">`+data.doc_req[i].type+`</label>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text " id="basicadd`+i+`" style="width:100%; ">
                                            <a style="font-size:12px;" href="/admin/verification/download/`+data.id+`">`+data.doc_req[i].requirement_value+`</a>
                                            <div class="tooltipLink" style="position:absolute;left:93%; width:50px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <embed src="{{ asset('files/`+data.doc_req[i].requirement_value+`') }}">
                                            <div>
                                        </span>
                                    </div>
                                `);
                    }

                    if (data.status=='Diterima') {
                        $('#form-doc-accepted').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-success mr-1">'+data.status+'</span>');
                    }else if (data.status=='Ditolak') {
                        $('#form-doc-accepted').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-danger mr-1">'+data.status+'</span>');
                    }else{
                        $('#form-doc-accepted').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-secondary mr-1">'+data.status+'</span>');
                    }

                    showModal('modal-accepted');
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
                            DoneTable.table().draw(false);
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
            $('#form-doc-accepted').submit(function(event){
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

                    DoneTable.table().draw(false);
                    hideModal('modal-accepted');
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
