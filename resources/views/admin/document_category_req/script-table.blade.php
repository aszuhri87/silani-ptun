<script type="text/javascript">
    var DocsCategoryReqTable = function() {
        var init_table;

        $(document).ready(function() {
            initTable();
            actionTable();
        });

        const initTable = () => {
            init_table = $('#init-table').DataTable({
                destroy: true,
                processing: true,
                responsive: true,
                serverSide: true,
                sScrollY: ($(window).height() < 700) ? $(window).height() - 200 : $(window).height() - 400,
                scrollX: true,
                ajax: {
                    type: 'POST',
                    url: "{{ url('admin/document-category-req/dt') }}",
                },
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'document_category', "name": "document_categories.name"},
                    { data: 'requirement_type', "name": "requirement_types.requirement_type" },
                    { data: 'requirement' },
                    { data: 'required' },
                    { data: 'data_min' },
                    { data: 'data_max' },
                    { data: 'description' },
                    { defaultContent: '' }
                    ],
                columnDefs: [
                    {
                        targets: 0,
                        searchable: false,
                        orderable: false,
                        className: "text-center"
                    },
                    {
                        targets: -1,
                        searchable: false,
                        orderable: false,
                        className: "text-center",
                        data: "id",
                        render : function(data, type, full, meta) {
                            return `
                                <div class="dropdown">
                                        <a class="btn btn-sm btn-flat dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#969696" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                        </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                                    <a href="{{ url('admin/document-category-req') }}/${data}" title="Edit" class="btn btn-edit btn-sm btn-clean btn-icon dropdown-item" title="Edit">
                                        <span class="svg-icon svg-icon-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#47d147" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path>
                                                <polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon>
                                            </svg>
                                        </span>
                                        Edit
                                    </a>

                                    <a href="{{ url('admin/document-category-req') }}/${data}" title="Delete" class="btn btn-light btn-delete btn-sm btn-clean btn-icon dropdown-item" title="Delete">
                                        <span class="svg-icon svg-icon-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d11d18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                        </span>
                                        Hapus
                                    </a>
                                    </div>
                                </div>
                            `
                        }
                    },
                ],
                order: [[1, 'asc']],
                searching: true,
                paging:true,
                lengthChange:false,
                bInfo:true,
                dom: '<"datatable-header"><tr><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    searchPlaceholder: 'Search.',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    processing: '<div class="text-center"> <div class="spinner-border text-primary" role="status"> <span class="sr-only">Loading...</span> </div> </div>',
                },
            });
        },
        actionTable = () => {
            $('#search').on('keyup', function () {
                init_table.search(this.value).draw();
            });

            $('#pageLength').on('change', function () {
                init_table.page.len(this.value).draw();
            });
        }

        return {
            table : function(){
                return init_table;
            },
        }
    }();
</script>
