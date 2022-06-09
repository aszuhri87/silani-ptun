<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {
            $(document).on('click', '#create-req-type', function(event){
                event.preventDefault();

                $('#form-req-type').trigger("reset");
                $('#form-req-type').attr('action','{{url('admin/req-type')}}');
                $('#form-req-type').attr('method','POST');

                showModal('modal-req-type');
            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();

                var data = ReqTypeTable.table().row($(this).parents('tr')).data();

                $('#form-req-type').trigger("reset");
                $('#form-req-type').attr('action', $(this).attr('href'));
                $('#form-req-type').attr('method','PUT');

                $('#form-req-type').find('input[name="requirement_type"]').val(data.requirement_type);
                $('#form-req-type').find('input[name="description"]').val(data.description);
                $('#form-req-type').find('input[name="data_type"]').val(data.data_type);
                $('#form-req-type').find('input[name="data_unit"]').val(data.data_unit);
                showModal('modal-req-type');
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
                            ReqTypeTable.table().draw(false);
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
            $('#form-req-type').submit(function(event){
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    ReqTypeTable.table().draw(false);
                    hideModal('modal-req-type');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
