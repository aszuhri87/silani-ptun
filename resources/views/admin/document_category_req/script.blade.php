<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              height: 600,
              timer: 5000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
            })

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
                $('#form-doc-category-req').find('select[name="select_docs_category"]').find('option[value=' + data.document_category_id + ']').prop('selected', true);
                $('#form-doc-category-req').find('select[name="select_req_type"]').find("option[value='" + data.requirement_type + "']").prop('selected', true);
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
            $('#form-doc-category-req').submit(function(event){
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

                    DocsCategoryReqTable.table().draw(false);
                    hideModal('modal-docs-category-req');
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
