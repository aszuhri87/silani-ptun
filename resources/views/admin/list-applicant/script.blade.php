<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();

            $('#select-unit').select2({
                    placeholder: "Pilih Unit Kerja...",
                    minimumInputLength: 2,
                    language: { inputTooShort: function () { return 'Ketik minimal 2 karakter'; } },
                    ajax: {
                        method: 'GET',
                        url: '/admin/unit/find',
                        dataType: 'json',
                        data: function (params) {
                            return {
                                q: $.trim(params.term)
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });
        });

        const initAction = () => {

            $('#select-unit').on('select2:select', function (e) {
                    e.preventDefault();

                    var dt = e.params.data.id;

                    $('input[name="unit"]').val(dt);

                });

            $(document).on('click', '#create-list-applicant-modal', function(event){
                event.preventDefault();

                $('#form-list-applicant').trigger("reset");
                $('#form-list-applicant').attr('action','{{url('admin/list-applicant')}}');
                $('#form-list-applicant').attr('method','POST');
                showModal('modal-list-applicant');
            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();

                var data = SubUnitTable.table().row($(this).parents('tr')).data();

                $('#form-list-applicant').trigger("reset");
                $('#form-list-applicant').attr('action', $(this).attr('href'));
                $('#form-list-applicant').attr('method','PUT');

                $('#form-list-applicant').find('input[name="name"]').val(data.name);
                $('#form-list-applicant').find('input[name="email"]').val(data.email);
                $('#form-list-applicant').find('input[name="username"]').val(data.username);
                $('#form-list-applicant').find('option[value=' + JSON.stringify(data.title) + ']').prop('selected', true);


                $('#form-list-applicant').find('input[name="gol"]').val(data.gol);

                showModal('modal-list-applicant');
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
                    baseZ: 2000
                });

                // setTimeout($.unblockUI, 2100);
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
            $('#form-list-applicant').submit(function(event){
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

                    SubUnitTable.table().draw(false);
                    hideModal('modal-list-applicant');
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
