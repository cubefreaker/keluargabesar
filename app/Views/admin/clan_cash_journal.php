<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
    <link rel="stylesheet" href="<?=base_url()?>/assets/lib/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?=base_url()?>/assets/lib/datatables/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?=base_url()?>/assets/lib/bootstrap/bootstrap-datepicker3.min.css">
    <style>
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #6777ef;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #6777ef;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #ffffff;
        }

        .card-detail {
            box-shadow: 5px 5px 10px lightgrey;
            border-radius: 20px;
        }
        .datepicker table tr td.today {
            color: #fff;
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .image-preview {
            left: calc(50% - 125px);
        }
    </style>
    <div ng-controller="memberCashCtrl">
        <section class="section">
            <div class="section-header">
                <h1>Kas Keluarga - <?=$clanName?></h1>
                <div class="section-header-breadcrumb">
                    <a class="btn btn-primary" id="modal-member" href="" ng-if="<?=logged_in() ? 1: 0?>" ng-click="edit()">Tambah</a>
                </div>
            </div>
    
            <div class="section-body">
                
            <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Dari Tanggal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" ng-model="dataSearch.dateFrom" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sampai Tanggal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" ng-model="dataSearch.dateTo" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tipe</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-money-bill"></i>
                                            </div>
                                        </div>
                                        <select id="gender" class="form-control" ng-model="dataSearch.typeCash">
                                            <option value="all">- Semua -</option>
                                            <option value="kas">KAS</option>
                                            <option value="zis">ZIS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="input-group">
                                        <button class="btn btn-primary" ng-click="search()">Cari</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="d-none d-md-block">&nbsp;</label>
                                    <div class="input-group">
                                        <a class="btn btn-success pull-right" href="<?=base_url('export/excelCash').$slug?>" target="_blank">Export Excel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header mb-n4">
                        <dl class="row w-100">
                            <dt class="col-lg-1 form-control-lg mb-n3">
                                Saldo :
                            </dt>
                            <dd class="col-lg-11 form-control-lg">
                                <p ng-show="['all', 'kas'].includes(dataSearch.typeCash)" class="font-weight-bolder mb-n1">- Kas = Rp. <?=number_format($saldoKas, 2, '.', ',')?></p>
                                <p ng-show="['all', 'zis'].includes(dataSearch.typeCash)" class="font-weight-bolder">- ZIS = Rp. <?=number_format($saldoZis, 2, '.', ',')?></p>
                            </dd>
                        </dl>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped responsive" id="tableJournal">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No. Jurnal</th>
                                        <th>Tanggal</th>
                                        <th>Tipe</th>
                                        <th>Note</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                    </tr>
                                </thead>
                                <tfoot align="right">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Add-->
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-cash-add">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{dataModal.title}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" ng-model="dataModal.trxDate" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe Kas</label>
                                    <div class="input-group">
                                        <select id="gender" class="form-control" ng-model="dataModal.typeCash">
                                            <option value="kas">KAS</option>
                                            <option value="zis">ZIS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Debit/Kredit</label>
                                    <div class="input-group">
                                        <select id="gender" class="form-control" ng-model="dataModal.DBCR">
                                            <option value="DB">Debit</option>
                                            <option value="CR">Kredit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Nominal</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="0.00" name="amount" ui-number-mask="2" ng-model="dataModal.amount">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>Note</label>
                                <textarea class="form-control" name="description" cols="30" rows="30" ng-model="dataModal.description" style="height: 100px"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="saveCash" type="button" class="btn btn-primary" ng-click="save()">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail-->
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-cash-detail">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{dataDetail.journal_id}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" ng-model="dataDetail.trx_date" class="form-control datepicker" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe Kas</label>
                                    <div class="input-group">
                                        <select id="gender" class="form-control" ng-model="dataDetail.type" disabled>
                                            <option value="kas">KAS</option>
                                            <option value="zis">ZIS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Debit/Kredit</label>
                                    <div class="input-group">
                                        <select id="gender" class="form-control" ng-model="dataDetail.DBCR" disabled>
                                            <option value="DB">Debit</option>
                                            <option value="CR">Kredit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Nominal</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="0.00" name="amount" ui-number-mask="2" ng-model="dataDetail.amount" disabled>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>Note</label>
                                <textarea class="form-control" name="description" cols="30" rows="30" ng-model="dataDetail.description" style="height: 100px" disabled></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?=base_url()?>/assets/lib/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url()?>/assets/lib/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?=base_url()?>/assets/lib/datatables/dataTables.responsive.min.js"></script>
    <script src="<?=base_url()?>/assets/lib/datatables/responsive.bootstrap4.min.js"></script>
    <script src="<?=base_url()?>/assets/lib/bootstrap/bootstrap-datepicker.min.js"></script>
    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        const base_url = '<?=base_url()?>';

        app.controller('memberCashCtrl', function($scope, $http, $compile) {
            $scope.cashJournal = <?=json_encode($clanCashJournal)?>;
            let dateNow = new Date();
            $scope.dataSearch = {
                dateFrom: dateNow.toISOString().split('T')[0],
                dateTo: dateNow.toISOString().split('T')[0],
                typeCash: 'all'
            };

            $scope.openDetail = function (data) {
                $scope.dataDetail = angular.copy(data);
                $('#modal-cash-detail').modal('show');
                $scope.$apply();
            }

            $scope.edit = function(id=null, type='add') {
                if(!<?=logged_in() ? 1: 0?>) return;
                let dateNow = new Date();
                $scope.dataModal = {
                    type: 'add',
                    title: 'Tambah Data',
                    id: id,
                    journalID: '',
                    amount: null,
                    typeCash: 'kas',
                    DBCR: 'DB',
                    description: '',
                    trxDate: dateNow.toISOString().split('T')[0]
                };
                
                if (type != 'add') {
                    _.forEach($scope.cashJournal.data, function(cash) {
                        if(cash.id == id) {
                            $scope.dataModal.type = 'edit';
                            $scope.dataModal.title = 'Edit - ' + cash.journal_id;
                            $scope.dataModal.id = cash.id;
                            $scope.dataModal.typeCash = cash.type;
                            $scope.dataModal.DBCR = cash.DBCR;
                            $scope.dataModal.amount = cash.amount;
                            $scope.dataModal.journalID = cash.journal_id;
                            $scope.dataModal.description = cash.description;
                            $scope.dataModal.trxDate = cash.trx_date;
                        }
                    });
                }
                $('#modal-cash-add').modal('show');
            }

            $scope.save = function() {
                if(!<?=logged_in() ? 1: 0?>) return; 
                if($scope.dataModal.amount == '' || $scope.dataModal.amount == null || $scope.dataModal.amount == 0) {
                    swal('Warning', 'Nominal tidak boleh kosong', 'warning');
                    return false;
                }

                if($scope.dataModal.trxDate == '') {
                    swal('Warning', 'Tanggal tidak boleh kosong', 'warning');
                    return false;
                }

                var formData = new FormData();
                formData.append('data', angular.toJson($scope.dataModal));
                
                $('#saveCash').attr('disabled', true);
                $http.post(`${base_url}/admin/memberCash/${$scope.dataModal.type}`, formData, {
                  transformRequest: angular.identity,
                  headers: {'Content-Type': undefined}
                }).then(function(response) {
                    if (response.data.status == 'success') {
                        swal('Success', `Berhasil ${$scope.dataModal.type == 'edit' ? 'update' : 'menambah'} transaksi`, 'success');
                        $('#saveCash').attr('disabled', false);
                        window.location.reload();
                    } else {
                        swal('Error', 'Something went wrong', 'error');
                        $('#saveCash').attr('disabled', false);
                    }
                });
            };

            $scope.delete = function(data) {
                if(!<?=logged_in() ? 1: 0?>) return;
                swal({
                    title: 'Delete transaksi ini?',
                    text: `"${data.journal_id}" / Rp. ${parseFloat(data.amount).toLocaleString()}`,
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((confirmDelete) => {
                    if (confirmDelete) {
                        $http.post(base_url + '/admin/memberCash/delete', {id: data.id, name: data.journal_id}).then(function(response) {
                            if (response.data.status == 'success') {
                                swal('Success', response.data.message, 'success');
                                window.location.reload();
                            } else {
                                swal('Error', 'Something went wrong', 'error');
                            }
                        });
                    }
                });
            };

            // Render Datatable
            angular.element(document).ready(function () {                
                let table = $('#tableJournal').DataTable({
                    dom: 'Bfrtip',
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    pageLength:100,
                    // lengthMenu: [[10, 50, 100, 250, 1000000], [10, 50, 100, 250, "All"]],
                    paging: true,
                    ordering: true,
                    order: [[0, 'asc']],
                    searching: true,
                    lengthChange: false,
                    responsive: true,
                    ajax: function ( data, callback, settings ) {
                        var out, key, ordered;
                        
                        out = $scope.cashJournal.data;
                        if (data.search.value != '') {
                            out = searchStringInArrayObject(data.search.value, out);

                        }

                        key = data.columns[data.order[0].column].data;
                        ordered = orderByArrayObject(key, out, data.order[0].dir);
                        
                        out = ordered.slice(data.start, data.start+data.length);

                        setTimeout( function () {
                            callback( {
                                draw: data.draw,
                                data: out,
                                recordsTotal: $scope.cashJournal.recordsTotal,
                                recordsFiltered: $scope.cashJournal.recordsFiltered
                            } );
                        }, 50 );
                    },
                    columnDefs: [
                        {
                            "orderable": false,
                            "targets": [0],
                            "visible": false,
                            "data": "id",
                            // "render": function(data, type, row, meta){
                            //     if(type === 'display'){
                            //         data = row.no;
                            //     }

                            //     return data;
                            // }
                        },
                        {
                            "targets": [1],
                            "width": "15%",
                            "data": "journal_id",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = `
                                        <a id="showDetail" href=""><h6>${row.journal_id}</h6></a>
                                        <div class="<?=!logged_in() ? 'd-none': ''?>">
                                            <button
                                                id="edit"
                                                class="btn btn-icon btn-primary btn-xs mr-2 text-white"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="Edit"
                                                ng-click="edit(${row.id}, 'edit')"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a
                                                id="delete"
                                                href="javascript:void(0)"
                                                class="btn btn-icon btn-danger btn-xs mr-2 text-white"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="Delete"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    `;
                                }

                                return data;
                            }
                        },
                        {
                            "targets": [2],
                            "width": "13%",
                            "data": "trx_date",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = data ?? '-';
                                }

                                return data;
                            }
                        },
                        {
                            "targets": [3],
                            "width": "10%",
                            "data": "type",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = data.toUpperCase() || '-';
                                }

                                return data;
                            }
                        },
                        {
                            "targets": [4],
                            "width": "25%",
                            "data": "description",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = data || '-';
                                }

                                return data;
                            }
                        },
                        {
                            "targets": [5],
                            "width": "15%",
                            "className": "text-right",
                            "data": "amount",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = row.DBCR == 'DB' ? 'Rp. ' + parseFloat(row.amount).toLocaleString() : 'Rp. 0';
                                }

                                return data;
                            }
                        },
                        {
                            "targets": [6],
                            "width": "15%",
                            "className": "text-right",
                            "data": "amount",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = row.DBCR == 'CR' ? 'Rp. ' + parseFloat(row.amount).toLocaleString() : 'Rp. 0';
                                }

                                return data;
                            }
                        },
                    ],
                    buttons: ['copy', 'excelFlash', 'excel', 'pdf', 'print'],
                    footerCallback: function ( row, data, start, end, display ) {
                        var api = this.api(), data;
            
                        // converting to interger to find total
                        let intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        let debitTotal = 0; 
                        let creditTotal = 0;
                        data.forEach(el => {
                            if(el.DBCR == 'DB') {
                                debitTotal += intVal(el.amount);
                            } else {
                                creditTotal += intVal(el.amount);
                            }
                        });

                        let total = debitTotal - creditTotal;
                                
                        // Update footer by showing the total with the reference of the column index 
                        $( api.column( 1 ).footer() ).html('Total');
                        $( api.column( 5 ).footer() ).html('+ Rp.'+debitTotal.toLocaleString());
                        $( api.column( 6 ).footer() ).html('- Rp. '+creditTotal.toLocaleString());
                    },
                    createdRow: function ( row, data, index ) {
                        $compile(row)($scope);  //add this to compile the DOM
                    }
                });

                $('#tableJournal tbody').on('click', '#showDetail', function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    $scope.openDetail(data);
                });
                $('#tableJournal tbody').on('click', '#delete', function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    $scope.delete(data);
                });
                
                $scope.search = function() {
                    let data = $scope.dataSearch;
                    let url = base_url + '/memberCash<?=$slug?>/search';
                    $http.post(url, data).then(function(res) {
                        $scope.cashJournal = res.data;
                        table.ajax.reload();
                    });
                }
            });
        });
    </script>
<?= $this->endSection() ?>