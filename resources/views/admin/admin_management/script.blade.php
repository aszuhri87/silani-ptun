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
                    $('#form-manage-admin').find('select[name="role"]').find('option[value=' + data.role + ']').prop('selected', true);
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
                    Swal.fire({
                            title: 'Berhasil!',
                            text: "Berhasil menyimpan!",
                        })

                    mngAdminTable.table().draw(false);
                    hideModal('modal-mng-admin');
                })
                .fail(function(res, error) {
                    Swal.fire({
                            title: 'Gagal!',
                            text: res.responseJSON.message,
                        })
                })
                .always(function() { });
            });
        }
    }();
</script>
