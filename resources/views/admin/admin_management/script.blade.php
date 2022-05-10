<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {

            $(document).on('click', '#create-admin', function(event){
                event.preventDefault();
                $('#form-manage-admin').trigger("reset");
                $('#form-manage-admin').attr('action','{{url('admin/manage-admin')}}');
                $('#form-manage-admin').attr('method','POST');
                showModal('modal-mng-admin');
            });
            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = mngAdminTable.table().row($(this).parents('tr')).data();
                $('#form-manage-admin').trigger("reset");
                $('#form-manage-admin').attr('action', $(this).attr('href'));
                $('#form-manage-admin').attr('method','PUT');

                $.get(url, function(data){
                    $('#form-manage-admin').find('input[name="name"]').val(data.name);
                    $('#form-manage-admin').find('input[name="username"]').val(data.username);
                    $('#form-manage-admin').find('input[name="email"]').val(data.email);
                    $('#form-manage-admin').find('input[name="password"]').val(data.password);
                    $('#form-sub-unit').find('select[name="select_unit"]').val(data.select_unit);
                    showModal('modal-mng-admin');
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
                            mngAdminTable.table().draw(false);
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
            $('#form-manage-admin').submit(function(event){
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    mngAdminTable.table().draw(false);
                    hideModal('modal-mng-admin');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
