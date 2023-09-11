<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {
            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = DoneTable.table().row($(this).parents('tr')).data();
                $('#form-doc-accepted').trigger("reset");
                $('#form-doc-accepted').attr('action', $(this).attr('href'));

                // console.log($(this).attr('href'));
                $('#form-doc-accepted').attr('method','PUT');
                $('#form-doc-accepted').attr('enctype','multipart/form-data');


                $.get(url, function(data){
                    $('#form-doc-accepted').find('input[name="id"]').val(data.id);
                    $('#form-doc-accepted').find('input[name="name"]').val(data.name);
                    $('#form-doc-accepted').find('input[name="date"]').val(data.date_create);
                    $('#form-doc-accepted').find('input[name="document_category"]').val(data.document_category);
                    $('#form-doc-accepted').find('input[name="applicant"]').val(data.applicant);
                    $('#form-doc-accepted').find('input[name="requirement_type"]').val(data.requirement_type);
                    $('#form-doc-accepted').find('input[name="requirement"]').val(data.requirement);
                    $('#form-doc-accepted').find('input[name="required"]').val(data.required);
                    $('#form-doc-accepted').find('textarea[name="description"]').val(data.description);
                    // $('#form-doc-accepted').find('input[name="status_edit"][value=' + data.status + ']').prop('checked', true);
                    $('#form-doc-accepted').find('textarea[name="ket"]').val(data.notes);

                    // console.log(data.document_category != "Permohonan Surat Keterangan BHT");

                    if (data.document_category == 'Permohonan Magang' || data.document_category == 'Permohonan Penelitian' || data.document_category == 'Permohonan Sertifikat Magang' || data.document_category == 'Lain-lain'){
                        $('.transfer-div').remove();
                    }

                    // if(data.transfer_img != null){
                    //     $('.thumbnail').html(`
                    //         <img src="{{ asset('/files/`+ data.transfer_img+`') }}"
                    //             id="account-upload-img" class="rounded mr-50"
                    //             alt="profile image" height="300px" max-width="500px"/>
                    //     `)
                    // }

                    if (data.status=='Diterima') {
                        $('#form-doc-accepted').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-success mr-1">'+data.status+'</span>');
                    }else if (data.status=='Ditolak') {
                        $('#form-doc-accepted').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-danger mr-1">'+data.status+'</span>');
                    }else{
                        $('#form-doc-accepted').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-secondary mr-1">'+data.status+'</span>');
                    }

                    $('div#link_pdf').html(`
                        <a href="{{url('applicant/done-docs/download_pdf/`+data.id+`')}}" class="btn btn-success btn-sm btn-clean btn-icon" data-toggle="tooltip" data-placement="top" title="Download Lembar Disposisi">
                        Download Lembar Disposisi
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"> <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/> <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/> </svg>
                        </a>
                    `);

                    showModal('modal-accepted');

                    $(document).on('hide.bs.modal','#modal-accepted', function(event){
                    $('input[type="checkbox"]').prop('checked',false);
                    location.reload();
                });
                });
            });

            // $("#transfer_image").change(function() {
            //     var img = $(this).val();
            //     var ext = img.split('.').pop();
            //     var size = this.files[0].size;
            //     var limit_size = 2048;
            //     var size_cal = size/1024;

            //     var id = $('#id').val();

            //     $('#form-doc-accepted').attr('action', "/applicant/done-docs/upload-transer/"+id);
            //     $('#form-doc-accepted').attr('method','POST');
            //     $('#form-doc-accepted').attr('enctype','multipart/form-data');


            //     if (ext == "jpg" || ext == "jpeg" || ext == "png"){
            //         if(size_cal > limit_size){
            //                 Swal.fire({
            //                             title: 'Kesalahan!',
            //                             text: "Ukuran gambar terlalu besar, maksimal 2MB!",
            //                         })
            //                 } else {

            //         $('#form-doc-accepted').submit();
            //         }
            //     } else {
            //         Swal.fire({
            //                 title: 'Kesalahan!',
            //                 text: "Format gambar harus jpeg, jpeg atau png!",
            //             })
            //     }
            // });

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
                            DoneTable.table().draw(false);
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
            $('#form-doc-accepted').submit(function(event){
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
                            text: "Berhasil menyimpan!",
                        })

                    DoneTable.table().draw(false);
                    hideModal('modal-accepted');
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

            $('#upload-file').submit(function(event){
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
