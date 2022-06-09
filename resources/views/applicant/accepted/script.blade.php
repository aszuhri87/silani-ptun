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
                var dt = DoneTable.table().row($(this).parents('tr')).data();
                $('#form-doc-accepted').trigger("reset");
                $('#form-doc-accepted').attr('action', $(this).attr('href'));
                $('#form-doc-accepted').attr('method','PUT');

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
                    $('#form-doc-accepted').find('textarea[name="ket"]').val(data.notes);

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
                    DoneTable.table().draw(false);
                    hideModal('modal-accepted');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
