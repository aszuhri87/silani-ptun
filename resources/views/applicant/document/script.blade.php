<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();
        });

        const initAction = () => {
            $('#select-chief').select2({
                    placeholder: "Cari Nama...",
                    minimumInputLength: 2,
                    language: { inputTooShort: function () { return 'Ketik minimal 2 karakter'; } },
                    ajax: {
                        method: 'GET',
                        url: '/applicant/employee/find',
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
                            console.log(data);
                        },
                        cache: true
                    }
                });

            $('#select-chief').on('select2:select', function (e) {
                e.preventDefault();

                var dt = e.params.data.id;

                $('input[name="chief"]').val(dt);

            });


            $(document).on('change','#select-docs-category', function(event){
                event.preventDefault();
                var id = $(this).find('option:selected').data('id');
                var id_req = $(this).find('option:selected').val();
                $('#form-doc-create').trigger("reset");
                $('#form-doc-create').attr('action','{{url('applicant/document')}}');
                $('#form-doc-create').attr('method','POST');
                $('#form-doc-create').attr('enctype','multipart/form-data');
                $('div#data_input').html("");

                $.get('/applicant/document-select/'+id, function(data){
                    $('#form-doc-create').find('input[name="id_cat"]').val(id);
                        for (i in data){
                            if(data[i].data_type == "textarea"){

                                $('div#data_input').append(`
                                    <label class="form-label mt-1 label">`+data[i].title+`</label>
                                    <div class="input-group">
                                        <textarea data-length="50" class="form-control char-textarea" id="`+data[i].data_type+`" name="requirement_value[`+i+`]"  rows="4" placeholder=""></textarea>
                                    </div>
                                `);
                            }else if(data[i].data_type == "file"){
                                $('div#data_input').append(`
                                    <label class="form-label mt-1 label">`+data[i].title+`</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                        <input type="`+data[i].data_type+`" id="inputGroupFile" class="form-control" placeholder="`+data[i].title+`" name="requirement_value[`+i+`]">

                                        </div>
                                    </div>
                                `);
                            }else
                            {
                                $('div#data_input').append(`
                                    <label class="form-label mt-1 label">`+data[i].title+`</label>
                                    <div class="input-group">
                                        <input type="`+data[i].data_type+`"  class="form-control" placeholder="`+data[i].title+`" name="requirement_value[`+i+`]" pattern=".{`+data[i].data_max+`,}" title="Harus diisi `+data[i].data_max+` karakter">
                                    </div>
                                `);

                            }
                        $('#modal-document').modal('show');
                    }
                })
            });

            // $(document).on('hide.bs.modal','#modal-document', function(event){
            //     location.reload();
            // });

            $(document).on('click', '.btn-detail', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = DocTable.table().row($(this).parents('tr')).data();
                $('#form-doc-create').trigger("reset");
                $('#form-doc-create').attr('action', $(this).attr('href'));
                $('#form-doc-create').attr('method','PUT');
                $('#form-doc-create').attr('enctype','multipart/form-data');

                $('div#doc_file').html("");

                $.get(url, function(data){

                        $('input[name="name"]').val(data.name);
                        $('input[name="date"]').val(data.date_create);
                        $('input[name="document_category"]').val(data.document_category);
                        $('input[name="requirement"]').val(data.requirement);
                        $('input[name="required"]').val(data.required);
                        $('textarea[name="description"]').val(data.description);

                        for (i in data.doc_req){
                        var str = data.doc_req[i].requirement_value;
                            var dotIndex= str.lastIndexOf('.');
                            var ext = str.substring(dotIndex);

                            if(ext=='.jpg'||ext=='.jpeg'||ext=='.png'||ext=='.pdf'){
                                $('div#doc_file').append(`
                                    <label for="basicadd`+i+`">`+data.doc_req[i].requirement_type+`</label>
                                    <div class="input-group mb-1">

                                        <span class="input-group-text " id="basicadd`+i+`" style="width:100%; ">

                                            <a href="/applicant/document/download/`+data.id+`">`+data.doc_req[i].requirement_value+`</a>
                                            <div class="tooltipLink" style="position:absolute;left:93%; width:50px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <embed src="{{ asset('files/`+data.doc_req[i].requirement_value+`') }}">
                                            <div>
                                        </span>
                                    </div>
                                `);
                            }else{
                                $('div#doc_file').append(`
                                    <label for="basicadd`+i+`">`+data.doc_req[i].requirement_value+`</label>
                                    <div class="input-group mb-1 ">
                                        <span class="input-group-text" id="basicadd`+i+`" style="width:100%"> `+data.doc_req[i].requirement_value+`</span>
                                    </div>
                                `);
                            }
                        }

                        if (data.status=="Diproses") {
                            $('#form-doc-create').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-warning mr-1">'+data.status+'</span>');
                        }else if (data.status=='Ditolak') {
                            $('#form-doc-create').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-danger mr-1">'+data.status+'</span>');
                        }else{
                            $('#form-doc-create').find('h4[name="status"]').html('<span class="badge badge-pill badge-light-secondary mr-1">'+data.status+'</span>');
                        }

                    showModal('modal-document-2');

                });
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
                    for (i in data.doc_req){

                    if(data.doc_req[i].data_type == "textarea"){

                        $('div#data_input').append(`
                            <label class="form-label mt-1 label">`+data.doc_req[i].title+`</label>
                            <div class="input-group">
                                <textarea data-length="50" class="form-control char-textarea" id="`+data.doc_req[i].data_type+`" name="requirement_value[`+i+`]"  rows="4" placeholder=""  value="`+data.doc_req[i].requirement_value+`"></textarea>
                            </div>
                        `);
                    }else if(data.doc_req[i].data_type == "file"){

                        $('div#data_input').append(`
                            <label class="form-label mt-1 label">`+data.doc_req[i].title+`</label>
                            <div class="input-group">
                                <input type="file" class="form-control" placeholder="`+data.doc_req[i].title+`" name="requirement_value[`+i+`]" >
                            </div>
                        `);
                    }else
                    {
                        $('div#data_input').append(`
                            <label class="form-label mt-1 label">`+data.doc_req[i].title+`</label>
                            <div class="input-group">
                                <input type="`+data.doc_req[i].data_type+`" class="form-control" placeholder="`+data.doc_req[i].title+`" name="requirement_value[`+i+`]" pattern=".{`+data.doc_req[i].data_max+`,}" title="Harus diisi `+data.doc_req[i].data_max+` karakter">
                            </div>
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
