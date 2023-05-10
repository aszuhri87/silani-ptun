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
                var dt = VerifTable.table().row($(this).parents('tr')).data();
                $('#form-doc-status').trigger("reset");
                $('#form-doc-status').attr('action', $(this).attr('href'));
                $('#form-doc-status').attr('method','POST');
                $('div#doc_file').html("");

                showModal('modal-edit-status');
            });

            $(document).on('click', '.btn-detail', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = VerifTable.table().row($(this).parents('tr')).data();
                $('#form-doc-verification').trigger("reset");
                $('#form-doc-verification').attr('action', $(this).attr('href'));
                $('#form-doc-verification').attr('method','PUT');

                $.get(url, function(data){
                    $('#form-doc-verification').find('input[name="name"]').val(data.name);
                    $('#form-doc-verification').find('input[name="date"]').val(data.date_create);
                    $('#form-doc-verification').find('input[name="document_category"]').val(data.document_category);
                    $('#form-doc-verification').find('input[name="applicant"]').val(data.applicant);
                    $('#form-doc-verification').find('input[name="requirement_type"]').val(data.requirement_type);
                    $('#form-doc-verification').find('input[name="requirement"]').val(data.requirement);
                    $('#form-doc-verification').find('input[name="required"]').val(data.required);
                    $('#form-doc-verification').find('textarea[name="description"]').val(data.description);



                    if (data.status=='Diproses') {
                        $('#form-doc-verification').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-warning mr-1">'+data.status+'</span>');
                    }else if (data.status=='Ditolak') {
                        $('#form-doc-verification').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-danger mr-1">'+data.status+'</span>');
                    }else{
                        $('#form-doc-verification').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-secondary mr-1">'+data.status+'</span>');
                    }

                    showModal('modal-verification');
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
                            VerifTable.table().draw(false);
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
            $('#form-doc-verification').submit(function(event){
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

                    VerifTable.table().draw(false);
                    hideModal('modal-verification');
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
