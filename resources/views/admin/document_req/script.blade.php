<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {
            $(document).on('click', '#create-doc-req-modal', function(event){
                event.preventDefault();

                $('#form-doc-req').trigger("reset");
                $('#form-doc-req').attr('action','{{url('admin/document-req')}}');
                $('#form-doc-req').attr('method','POST');
                showModal('modal-docs-req');
            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();

                var data = DocsReqTable.table().row($(this).parents('tr')).data();

                $('#form-doc-req').trigger("reset");
                $('#form-doc-req').attr('action', $(this).attr('href'));
                $('#form-doc-req').attr('method','PUT');
                $('#form-doc-req').find('input[name="requirement_value"]').val(data.requirement_value);
                $('#form-doc-req').find('select[name="select_docs"]').val(data.select_docs);
                $('#form-doc-req').find('select[name="select_docs_category_req"]').val(data.select_docs_category_req);
                showModal('modal-docs-req');
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
                            DocsReqTable.table().draw(false);
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
            $('#form-doc-req').submit(function(event){
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    DocsReqTable.table().draw(false);
                    hideModal('modal-docs-req');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
