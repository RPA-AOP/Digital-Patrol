/**
 * App user list
 */

'use strict';

// Datatable (jquery)
$(function () {
    var dtUserTable = $('.datatables-users'),
        statusObj = {
            1: {title: 'Active', class: 'bg-label-success'},
            0: {title: 'Inactive', class: 'bg-label-secondary'}
        };

    var userView = baseUrl + 'app/user/view/account';

    // Users List datatable
    if (dtUserTable.length) {
        var dtUser = dtUserTable.DataTable({
            ajax: baseUrl + 'management-user/list', // JSON file to add data
            columns: [
                // columns according to JSON
                {data: ''},
                {data: 'name'},
                {data: 'npk'},
                {data: 'user_group.name',},
                {
                    data: 'company.company_name',
                    defaultContent: '-'
                },
                {data: 'status'},
                {data: ''}
            ],
            columnDefs: [
                {
                    // For Responsive
                    className: 'control',
                    orderable: false,
                    searchable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function (data, type, full, meta) {
                        return '';
                    }
                },
                {
                    // User full name and email
                    targets: 1,
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        var $name = full['name'],
                            $email = full['email'],
                            $image = full['image'];
                        if ($image) {
                            // For Avatar image
                            var $output =
                                '<img src="' + assetsPath + 'img/avatars/' + $image + '" alt="Avatar" class="rounded-circle">';
                        } else {
                            // For Avatar badge
                            var stateNum = Math.floor(Math.random() * 6);
                            var states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'];
                            var $state = states[stateNum],
                                $name = full['name'],
                                $initials = $name.match(/\b\w/g) || [];
                            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                            $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
                        }
                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-left align-items-center">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar avatar-sm me-3">' +
                            $output +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<a href="' +
                            userView +
                            '" class="text-body text-truncate"><span class="fw-semibold">' +
                            $name +
                            '</span></a>' +
                            '<small class="text-muted">' +
                            $email +
                            '</small>' +
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },
                {
                    // Company
                    targets: 2,
                    render: function (data, type, full, meta) {
                        var $npk = '-'
                        if (full['npk']) {
                            $npk = full['npk'];
                        }

                        return '<span class="fw-semibold">' + $npk + '</span>';
                    }
                },
                {
                    // User Role
                    targets: 3,
                    render: function (data, type, full, meta) {
                        var $role = full['user_group']['name'];
                        var roleBadgeObj = {
                            ADMINISTRATOR:
                                '<span class="badge badge-center rounded-pill bg-label-warning me-3 w-px-30 h-px-30"><i class="ti ti-user ti-sm"></i></span>',
                            'ADMIN HOLDING':
                                '<span class="badge badge-center rounded-pill bg-label-primary me-3 w-px-30 h-px-30"><i class="ti ti-chart-pie-2 ti-sm"></i></span>',
                            'ADMIN COMPANY':
                                '<span class="badge badge-center rounded-pill bg-label-info me-3 w-px-30 h-px-30"><i class="ti ti-edit ti-sm"></i></span>',
                            SECURITY:
                                '<span class="badge badge-center rounded-pill bg-label-secondary me-3 w-px-30 h-px-30"><i class="ti ti-device-laptop ti-sm"></i></span>'
                        };
                        return "<span class='text-truncate d-flex align-items-center'>" + roleBadgeObj[$role] + $role + '</span>';
                    }
                },
                {
                    // Company
                    targets: 4,
                    render: function (data, type, full, meta) {
                        var $company = '-'
                        if (full['company']) {
                            $company = full['company']['company_name'];
                        }

                        return '<span class="fw-semibold">' + $company + '</span>';
                    }
                },
                {
                    // User Status
                    targets: 5,
                    render: function (data, type, full, meta) {
                        var $status = full['status'];

                        return (
                            '<span class="badge ' +
                            statusObj[$status].class +
                            '" text-capitalized>' +
                            statusObj[$status].title +
                            '</span>'
                        );
                    }
                },
                {
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return (
                            '<div class="d-flex align-items-center">' +
                            '<a href="' + baseUrl + 'management-user/edit/' + full['id_user'] + '" class="btn btn-sm btn-icon"><i class="ti ti-edit"></i></a>' +
                            '<a href="javascript:;" onclick="deleteUser(' + full['id_user'] + ')"class="text-body delete-record"><i class="ti ti-trash ti-sm mx-2"></i></a>' +
                            '</div>'
                        );
                    }
                }
            ],
            order: [[1, 'desc']],
            dom:
                '<"row mx-2"' +
                '<"col-sm-12 col-md-4 col-lg-6" l>' +
                '<"col-sm-12 col-md-8 col-lg-6"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center align-items-center flex-sm-nowrap flex-wrap me-1"<"me-3"f><"user_role w-px-200 pb-3 pb-sm-0"><"user_company w-px-200 pb-3 pb-sm-0 ms-3">>>' +
                '>t' +
                '<"row mx-2"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            language: {
                sLengthMenu: 'Show _MENU_',
                search: 'Search',
                searchPlaceholder: 'Search..'
            },
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details of ' + data['name'];
                        }
                    }),
                    type: 'column',
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>'
                                : '';
                        }).join('');

                        return data ? $('<table class="table"/><tbody />').append(data) : false;
                    }
                }
            },
            initComplete: function () {
                // Adding role filter once table initialized
                this.api()
                    .columns(3)
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select id="UserRole" class="form-select text-capitalize"><option value=""> Filter Role </option></select>'
                        )
                            .appendTo('.user_role')
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                            });
                    });

                this.api()
                    .columns(4)
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select id="UserCompany" class="form-select text-capitalize"><option value=""> Filter Company </option></select>'
                        )
                            .appendTo('.user_company')
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();

                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                if (d) {
                                    select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                                }
                            });
                    });
            }
        });
    }
    // Delete Record
    $('.datatables-users tbody').on('click', '.delete-record', function () {
        dtUser.row($(this).parents('tr')).remove().draw();
    });

    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);



});


