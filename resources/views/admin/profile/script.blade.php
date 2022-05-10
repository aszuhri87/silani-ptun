<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            $('#change-profile').trigger("reset");
            $('#change-profile').attr('action','{{url('admin/profile/update_profile')}}');
            $('#change-profile').attr('method','POST');
            $('#change-profile').attr('enctype','multipart/form-data');

            formSubmit();
            initAction();
        });

        const initAction = () => {

            $(document).on('click', '#account-pill-password', function(event){
                event.preventDefault();

                $('#change-password').trigger("reset");
                $('#change-password').attr('action','{{url('admin/profile/update_password')}}');
                $('#change-password').attr('method','POST');
                $('#change-password').attr('enctype','multipart/form-data');

            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();

                var data = SubUnitTable.table().row($(this).parents('tr')).data();

                $('#form-sub-unit').trigger("reset");
                $('#form-sub-unit').attr('action', $(this).attr('href'));
                $('#form-sub-unit').attr('method','PUT');

                $('#form-sub-unit').find('input[name="name"]').val(data.name);
                $('#form-sub-unit').find('textarea[name="description"]').val(data.description);
                $('#form-sub-unit').find('select[name="select_unit"]').val(data.select_unit);
                showModal('modal-subunit');
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
                            SubUnitTable.table().draw(false);
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
            $('#change-password').submit(function(event){
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
                            text: "Berhasil ganti password!",
                        })
                        // SubUnitTable.table().draw(false);
                        // hideModal('modal-subunit');
                    })
                    .fail(function(res, error) {
                        toastr.error(res.responseJSON.message, 'Gagal')
                        Swal.fire({
                            title: 'Gagal!',
                            text: "Gagal ganti password!",
                        })
                    })
                    .always(function() { }
                );
            });

            $('#change-profile').submit(function(event){
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
                        text: "Berhasil ganti password!",
                    })
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                    Swal.fire({
                        title: 'Gagal!',
                        text: "Gagal ganti password!",
                    })
                })
                .always(function() { });
            });
        }
    }();
</script>
