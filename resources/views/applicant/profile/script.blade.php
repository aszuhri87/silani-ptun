<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            $('#change-profile').trigger("reset");
            $('#change-profile').attr('action','{{url('applicant/profile/update_profile')}}');
            $('#change-profile').attr('method','POST');
            $('#change-profile').attr('enctype','multipart/form-data');

            formSubmit();
            initAction();
        });

        const initAction = () => {
            $(document).on('click', '#account-pill-password', function(event){
                event.preventDefault();

                $('#change-password').trigger("reset");
                $('#change-password').attr('action','{{url('applicant/profile/update_password')}}');
                $('#change-password').attr('method','POST');
                $('#change-password').attr('enctype','multipart/form-data');

            });

            $("#image").change(function() {
                var img = $(this).val();
                var ext = img.split('.').pop();
                var size = this.files[0].size;
                var limit_size = 2048;
                var size_cal = size/1024;

                if (ext == "jpg" || ext == "jpeg" || ext == "png"){
                    if(size_cal > limit_size){
                        Swal.fire({
                                title: 'Kesalahan!',
                                text: "Ukuran gambar terlalu besar, maksimal 2MB!",
                            })
                    } else {
                        $('#change-profile').submit();
                    }
                } else {
                    Swal.fire({
                            title: 'Kesalahan!',
                            text: "Format gambar harus jpeg, jpeg atau png!",
                        })
                }
            });

            $("#reset_photo").click(function() {
                    $('#no_image').val('true');
                    $('#change-profile').submit();
            });

            $(document).on('click', '#account-pill-info', function(event){
                event.preventDefault();

                var data = <?php echo json_encode($data)?>;

                $('#change-info').trigger("reset");
                $('#change-info').attr('action','{{url('applicant/profile/update_info')}}');
                $('#change-info').attr('method','POST');
                $('#change-info').attr('enctype','multipart/form-data');

                $.get('/applicant/profile/'+data.id, function(data){
                    $('#change-info').find('textarea[name="address"]').val(data.address);
                    $('#change-info').find('input[name="gender"][value=' + data.gender + ']').prop('checked', true);
                    // $('#change-info').find('img[name="signature"]').prop('url', '');
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
                        text: "Berhasil ganti profile!",
                    })

                    location.reload();
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                    Swal.fire({
                        title: 'Gagal!',
                        text: "Gagal ganti profile!",
                    })
                })
                .always(function() { });
            });

            $('#change-info').submit(function(event){
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
                        text: "Berhasil ganti profile!",
                    })

                    location.reload();
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                    Swal.fire({
                        title: 'Gagal!',
                        text: "Gagal ganti profile!",
                    })
                })
                .always(function() { });
            });
        }
    }();
</script>
