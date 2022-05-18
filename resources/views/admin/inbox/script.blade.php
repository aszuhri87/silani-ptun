<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {
            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = InboxTable.table().row($(this).parents('tr')).data();
                $('#form-doc-inbox').trigger("reset");
                $('#form-doc-inbox').attr('action', $(this).attr('href'));
                $('#form-doc-inbox').attr('method','PUT');

                $.get(url, function(data){
                    $('#form-doc-inbox').find('input[name="name"]').val(data.name);
                    $('#form-doc-inbox').find('input[name="date"]').val(data.date_create);
                    $('#form-doc-inbox').find('input[name="document_category"]').val(data.document_category);
                    $('#form-doc-inbox').find('input[name="applicant"]').val(data.applicant);
                    $('#form-doc-inbox').find('input[name="requirement_type"]').val(data.requirement_type);
                    $('#form-doc-inbox').find('input[name="requirement"]').val(data.requirement);
                    $('#form-doc-inbox').find('input[name="required"]').val(data.required);
                    $('#form-doc-inbox').find('textarea[name="description"]').val(data.description);
                    $('#form-doc-inbox').find('input[name="status_edit"][value=' + data.status + ']').prop('checked', true);


                    for (i in data.doc_req){
                        var str = data.doc_req[i].requirement_value;
                        var dotIndex= str.lastIndexOf('.');
                        var ext = str.substring(dotIndex);

                        if(ext=='.jpg'||ext=='.jpeg'||ext=='.png'||ext=='.pdf'){
                            $('.file-'+i).html(`
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1" style="width:100%">`+data.doc_req[i].requirement_type+` :   <a href="/admin/verification/download/`+data.doc_req[i].id+`">`+data.doc_req[i].requirement_value+`</a></span>
                            </div>
                        `);
                        }else{
                            $('.file-'+i).html(`
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1" style="width:100%">`+data.doc_req[i].requirement_type+` : `+data.doc_req[i].requirement_value+`</span>
                            </div>
                        `);
                        }
                    }

                    if (data.status=="Menunggu") {
                        $('#form-doc-inbox').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-secondary mr-1">'+data.status+'</span>');
                    }else if (data.status=="Ditolak") {
                        $('#form-doc-inbox').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-danger mr-1">'+data.status+'</span>');
                    }else{
                        $('#form-doc-inbox').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-secondary mr-1">'+data.status+'</span>');
                    }

                });
                showModal('modal-inbox');
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
                            InboxTable.table().draw(false);
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
            $('#form-doc-inbox').submit(function(event){
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    InboxTable.table().draw(false);
                    hideModal('modal-inbox');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
