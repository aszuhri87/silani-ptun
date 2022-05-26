<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {
            $(document).on('change','#select-docs-category', function(event){
                event.preventDefault();
                var id = $(this).find('option:selected').data('id');
                var id_req = $(this).find('option:selected').val();
                $('#form-doc-create').trigger("reset");
                $('#form-doc-create').attr('action','{{url('applicant/document')}}');
                $('#form-doc-create').attr('method','POST');
                $('#form-doc-create').attr('enctype','multipart/form-data');

                $.get('/applicant/document-select/'+id, function(data){
                    $('#form-doc-create').find('input[name="id_cat"]').val(id);
                        for (i in data){
                            if(data[i].data_type == "textarea"){
                                $('.label-'+i).html(``+data[i].title+``);
                                $('.text-'+i).html(`
                                <textarea data-length="50" class="form-control char-textarea" id="`+data[i].data_type+`" name="requirement_value[`+i+`]"  rows="4" placeholder=""></textarea>
                            `);
                            }else
                            {
                                $('.label-'+i).html(``+data[i].title+``);
                                $('.input-'+i).html(`
                                    <input type="`+data[i].data_type+`"  class="form-control" placeholder="`+data[i].title+`" name="requirement_value[`+i+`]" pattern=".{`+data[i].data_max+`,}" title="Harus diisi `+data[i].data_max+` karakter">
                                `);
                            }
                        $('#modal-document').modal('show');
                    }
                })
            });

            $(document).on('hide.bs.modal','#modal-document', function(event){
                location.reload();
            });

            $(document).on('click', '.btn-detail', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = DocTable.table().row($(this).parents('tr')).data();
                $('#form-doc-create').trigger("reset");
                $('#form-doc-create').attr('action', $(this).attr('href'));
                $('#form-doc-create').attr('method','PUT');
                $('#form-doc-create').attr('enctype','multipart/form-data');

                $.get(url, function(data){
                    for (i in  data){
                        $('input[name="name"]').val(data[i].name);
                        $('input[name="date"]').val(data[i].date_create);
                        $('input[name="document_category"]').val(data[i].document_category);
                        $('input[name="requirement"]').val(data[i].requirement);
                        $('input[name="required"]').val(data[i].required);
                        $('textarea[name="description"]').val(data[i].description);

                        $('.input-'+i).html(`
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1" style="width:100%">`+data[i].requirement_type+` :   <a href="#">`+data[i].requirement_value+`</a></span>
                            </div>
                        `);
                            // var str = data.doc_req[i].requirement_value;
                            // var dotIndex= str.lastIndexOf('.');
                            // var ext = str.substring(dotIndex);

                            // if(ext=='.jpg'||ext=='.jpeg'||ext=='.png'||ext=='.pdf'){
                            //     $('.file-'+i).html(`
                            //     <div class="input-group">
                            //         <span class="input-group-text" id="basic-addon1" style="width:100%">`+data.doc_req[i].requirement_type+` :   <a href="/applicant/document/download/`+data.doc_req[i].id+`">`+data.doc_req[i].requirement_value+`</a></span>
                            //     </div>
                            // `);
                            // }else{
                            //     $('.file-'+i).html(`
                            //     <div class="input-group">
                            //         <span class="input-group-text" id="basic-addon1" style="width:100%">`+data.doc_req[i].requirement_type+` : `+data.doc_req[i].requirement_value+`</span>
                            //     </div>
                            // `);
                            // }

                            // $('input[name="requirement_type"]').val(data[i].requirement_type);

                            if (data[i].status=="Diproses") {
                                $('#form-doc-create').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-warning mr-1">'+data[i].status+'</span>');
                            }else if (data[i].status=='Ditolak') {
                                $('#form-doc-create').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-danger mr-1">'+data[i].status+'</span>');
                            }else{
                                $('#form-doc-create').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-secondary mr-1">'+data[i].status+'</span>');
                            }
                            showModal('modal-document-2');

                        }
                });
            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = DocTable.table().row($(this).parents('tr')).data();
                $('#form-doc-create').trigger("reset");
                $('#form-doc-create').attr('action', $(this).attr('href'));
                $('#form-doc-create').attr('method','POST');
                $('#form-doc-create').attr('enctype','multipart/form-data');
                $('#form-doc-create').find('input[name="name"]').val(dt.name);

                $.get(url, function(data){
                    $('#form-add').html(`<input type="hidden" name="_method" value="PUT">`);
                    for (i in data){
                    // $('input[name="requirement_value"]').val(data[i].requirement_value);
                    // $('input[name="document_category"]').val(data[i].document_category);
                    // $('input[name="requirement"]').val(data[i].requirement);
                    // $('input[name="required"]').val(data[i].required);
                    // $('textarea[name="description"]').val(data[i].description);

                    // $('#form-doc-create').find('input[name="id_cat"]').val(id);


                        if(data[i].data_type == "textarea"){
                            $('.label-'+i).html(``+data[i].title+``);
                            $('.text-'+i).html(`
                            <textarea data-length="50" class="form-control char-textarea" id="`+data[i].data_type+`" name="requirement_value[`+i+`]" rows="4" placeholder=""></textarea>
                        `);
                        }else
                        {
                            $('.label-'+i).html(``+data[i].title+``);
                            $('.input-'+i).html(`
                                <input type="`+data[i].data_type+`"  class="form-control" placeholder="`+data[i].title+`" name="requirement_value[`+i+`]" value="`+data[i].requirement_value+`">
                            `);

                            $('.file-'+i).html(`
                                    <span class="border-0 input-group-text" id="basic-addon1" style="width:100%"> <a href="#">`+data[i].requirement_value+`</a></span>
                            `);
                        }

                }
                showModal('modal-document');
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
                            DocTable.table().draw(false);
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
            $('#form-doc-create').submit(function(event){
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
                    DocTable.table().draw(false);
                    hideModal('modal-document');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>
