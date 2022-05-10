<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {


            $(document).on('click', '#add-doc-category-req-modal', function(event){
                event.preventDefault();

                $('#form-doc-category-req').trigger("reset");
                $('#form-doc-category-req').attr('action','{{url('admin/document-category-req')}}');
                $('#form-doc-category-req').attr('method','POST');
                showModal('modal-docs-category-req');
            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();

                var data = DocsCategoryReqTable.table().row($(this).parents('tr')).data();

                $('#form-doc-category-req').trigger("reset");
                $('#form-doc-category-req').attr('action', $(this).attr('href'));
                $('#form-doc-category-req').attr('method','PUT');
                $('#form-doc-category-req').find('input[name="requirement"]').val(data.requirement);
                $('#form-doc-category-req').find('input[name="required"]').val(data.required);
                $('#form-doc-category-req').find('input[name="data_min"]').val(data.data_min);
                $('#form-doc-category-req').find('input[name="data_max"]').val(data.data_max);
                $('#form-doc-category-req').find('textarea[name="description"]').val(data.description);
                $('#form-doc-category-req').find('select[name="select_docs_category"]').val(data.select_docs_category);
                $('#form-doc-category-req').find('select[name="select_req_type"][option]').val(data.select_req_type);
                showModal('modal-docs-category-req');
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
                            DocsCategoryReqTable.table().draw(false);
                        })
                        .fail(function(res, error) {
                            toastr.error(res.responseJSON.message, 'Gagal')
                        })
                        .always(function() { });
                    }
                })
            });

            $(document).on('click', '.btn-detail', function(event){
                event.preventDefault();
                showModal('modal-docs-category-req-dt');
            });
        },
        formSubmit = () => {
            $('#form-doc-category-req').submit(function(event){
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    DocsCategoryReqTable.table().draw(false);
                    hideModal('modal-docs-category-req');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
