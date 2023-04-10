<script type="text/javascript">
    var Page = function() {
        $(document).ready(function() {
            formSubmit();
            initAction();

            $('#select-chief').select2({
                    placeholder: "Pilih Nama Pegawai...",
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
                        },
                        cache: true
                    }
                });

                $('#select-unit').select2({
                    placeholder: "Pilih Unit Kerja...",
                    minimumInputLength: 2,
                    language: { inputTooShort: function () { return 'Ketik minimal 2 karakter'; } },
                    ajax: {
                        method: 'GET',
                        url: '/applicant/unit/find',
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
            $('#select-chief').on('select2:select', function (e) {
                e.preventDefault();

                var dt = e.params.data.id;

                $('input[name="chief"]').val(dt);

            });

            $('#select-unit').on('select2:select', function (e) {
                e.preventDefault();

                var dt = e.params.data.id;

                $('input[name="unit"]').val(dt);

            });

            $(document).on('click', '#create-doc-category-modal', function(event){
                event.preventDefault();

                $('#form-doc-category').trigger("reset");
                $('#form-doc-category').attr('action','{{url('applicant/leave-document')}}');
                $('#form-doc-category').attr('method','POST');

                showModal('modal-docs-category');
            });

            $(document).on('click', '.btn-edit', function(event){
                event.preventDefault();

                var item =  {!! json_encode($data) !!};
                var data = DocsCategoryTable.table().row($(this).parents('tr')).data();
                var url = $(this).attr('href');

                $('#form-doc-category').trigger("reset");
                $('#form-doc-category').attr('action', $(this).attr('href'));
                $('#form-doc-category').attr('method','PUT');

                $.get(url, function(data){
                    $('select[id="permit_type"]').find('option[value=' + JSON.stringify(data.data.permit_type) + ']').prop('selected', true);
                    $('textarea[name="reason"]').val(data.data.reason);
                    $('textarea[name="address"]').val(data.data.address);
                    $('input[name="phone"]').val(data.data.phone);
                    $('input[name="working_time"]').val(data.data.working_time);
                    $('select[id="select-unit"]').find('option[value=' + JSON.stringify(data.data.unit) + ']').prop('selected', true);

                    console.log(data.data);
                    for(let i=0; i< data.data.approval.length; i++){
                        if(data.data.approval[i].user_id == {!! json_encode(Auth::user()->id)!!}){
                            $('.econtent').html(`
                                <div class="form-group">
                                    <label for="approval_status">Status Perizinan</label>
                                    <select class="form-control" name="approval_status" id="approval_status">
                                        <option value="">-- Pilih --</option>
                                        <option value="Disetujui"> Disetujui </option>
                                        <option value="Perubahan"> Perubahan </option>
                                        <option value="Ditangguhkan Alasan Penting"> Ditangguhkan </option>
                                        <option value="Tidak Disetujui"> Tidak Disetujui </option>
                                    </select>
                                </div>

                                <label for="approval_note" id="approval_note" class="form-label">Catatan</label>
                                <div class="input-group">
                                    <textarea data-length="50" class="form-control char-textarea" id="approval_note" name="approval_note"
                                        rows="3" placeholder=""></textarea>
                                </div>

                                <input type="hidden" name="approver" value="true">
                            `);
                        }
                    }
                });
                showModal('modal-docs-category');
            });

            $(document).on('click', '.btn-detail', function(event){
                event.preventDefault();

                var id = $(this).data('id');
                var url = $(this).attr('href');
                var dt = DocsCategoryTable.table().row($(this).parents('tr')).data();
                var data_unit = <?php echo json_encode($data)?>;

                $.get(url, function(data){
                    $('.name').text(data.data.name);
                    $('.nip').text(data.data.nip);
                    $('.title').text(data.data.title);
                    $('.tanggal').text(' '+data.data.tanggal);

                    console.log(data.data);

                    if(data.data.permit_type == 'Tahunan'){
                        $('.cuti_tahunan').text('✓');
                    }
                    else if(data.data.permit_type == 'Besar'){
                        $('.cuti_besar').text('✓');
                    }
                    else if(data.data.permit_type == 'Sakit'){
                        $('.cuti_sakit').text('✓');
                    }
                    else if(data.data.permit_type == 'Besar'){
                        $('.cuti_besar').text('✓');
                    }
                    else if(data.data.permit_type == 'Melahirkan'){
                        $('.cuti_melahirkan').text('✓');
                    }
                    else if(data.data.permit_type == 'Karena Alasan Penting'){
                        $('.cuti_penting').text('✓');
                    }
                    else if(data.data.permit_type == 'Luar Tanggungan Negara'){
                        $('.cuti_luar').text('✓');
                    }

                    var s_date = new Date(data.data.start_time);
                    var e_date = new Date(data.data.end_time);

                    let count_time = (e_date.getDate() - s_date.getDate());

                    $('.name_sign').text('('+data.data.name+')');
                    $('.reason').text(data.data.reason);
                    $('.nip').text(data.data.nip);
                    $('.working_time').text(data.data.working_time);
                    $('.unit').text(data.data.unit);
                    $('.title').text(data.data.title);
                    $('.address').text(data.data.address);
                    $('.phone').text(data.data.phone);
                    $('.start_time').text(data.data.start_time);
                    $('.end_time').text(data.data.end_time);
                    $('.count_time').text(count_time);

                    $('.user-sign').html(`
                        <img src="{{asset('/signature/`+data.data.signature+`')}}" alt=""
                        style="min-height: 60px; max-height: 60px;" width="auto"
                        style="margin-left: 50%;">
                    `);

                    // if(data.data.approval[0].approval_status == 'Disetujui'){
                    //     $('.agree-1').text('✓');
                    // }
                    // else if(data.data.approval[0].approval_status == 'Perubahan'){
                    //     $('.agree-2').text('✓');
                    // }
                    // else if(data.data.approval[0].approval_status == 'Ditangguhkan'){
                    //     $('.agree-3').text('✓');
                    // }
                    // else{
                    //     $('.agree-4').text('✓');
                    // }


                    for(let i = 0; i < data.data.approval.length; i++){
                        if(data.data.approval[i].approval_type == 'ATASAN'){
                            if(data.data.approval[i].approval_status == 'Disetujui'){
                                $('.agree-1').text('✓');
                            }
                            else if(data.data.approval[i].approval_status == 'Perubahan'){
                                $('.agree-2').text('✓');
                            }
                            else if(data.data.approval[i].approval_status == 'Ditangguhkan'){
                                $('.agree-3').text('✓');
                            }
                            else{
                                $('.agree-4').text('✓');
                            }

                            $('.atasan-sign').html(`
                                <img src="{{asset('/signature/`+data.data.approval[i].signature+`')}}" alt=""
                                style="min-height: 60px; max-height: 60px;" width="auto"
                                style="margin-left: 50%;">
                            `);

                            $('.atasan_name').text(data.data.approval[i].chief.toUpperCase()+' PTUN YOGYAKARTA');
                        }

                        if(data.data.approval[i].approval_type == 'PEJABAT'){
                            if(data.data.approval[i].approval_status == 'Disetujui'){
                                $('.final-agree-1').text('✓');
                            }
                            else if(data.data.approval[i].approval_status == 'Perubahan'){
                                $('.final-agree-2').text('✓');
                            }
                            else if(data.data.approval[i].approval_status == 'Ditangguhkan'){
                                $('.final-agree-3').text('✓');
                            }
                            else{
                                $('.final-agree-4').text('✓');
                            }

                            $('.ketua-sign').html(`
                                <img src="{{asset('/signature/`+data.data.approval[i].signature+`')}}" alt=""
                                style="min-height: 60px; max-height: 60px;" width="auto"
                                style="margin-left: 50%;">
                            `);

                            $('.ketua_name').text(data.data.approval[i].chief.toUpperCase()+' PTUN YOGYAKARTA');
                        }


                    }



                    // $('input[name="reason"]').val(data.data.reason);
                    // $('input[name="datetime"]').val(data.data.datetime);

                    // $('div#link_pdf').html(`
                    //     <a href="{{url('applicant/exit-permit-document/download_pdf/`+data.data.id+`')}}" class="btn btn-light btn-sm btn-clean btn-icon" data-toggle="tooltip" data-placement="top" title="Print Lembar Disposisi"  >
                    //     <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#44559f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></a>
                    // `);
                });

                showModal('modal-document');

                $(document).on('hide.bs.modal','#modal-document', function(event){
                    $('input[type="checkbox"]').prop('checked',false);
                    location.reload();
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
                            DocsCategoryTable.table().draw(false);
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
            $('#form-doc-category').submit(function(event){
                event.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                })
                .done(function(res, xhr, meta) {
                    toastr.success(res.message, 'Success')
                    DocsCategoryTable.table().draw(false);
                    hideModal('modal-docs-category');
                })
                .fail(function(res, error) {
                    toastr.error(res.responseJSON.message, 'Gagal')
                })
                .always(function() { });
            });
        }
    }();
</script>