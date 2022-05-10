<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {
            $(document).on('click', '#create-modal-unit', function(event){
                event.preventDefault();

                $('#form-unit').trigger("reset");
                $('#form-unit').attr('action','{{url('admin/unit')}}');
                $('#form-unit').attr('method','POST');

                showModal('modal-unit');
            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();

                var data = UnitTable.table().row($(this).parents('tr')).data();

                $('#form-unit').trigger("reset");
                $('#form-unit').attr('action', $(this).attr('href'));
                $('#form-unit').attr('method','PUT');

                $('#form-unit').find('input[name="name"]').val(data.name);
                $('#form-unit').find('textarea[name="description"]').val(data.description);

                showModal('modal-unit');
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
                            UnitTable.table().draw(false);
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
            $('#form-unit').submit(function(event){
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    UnitTable.table().draw(false);
                    hideModal('modal-unit');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
