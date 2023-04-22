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
    <div ng-controller="memberCtrl">
        <section class="section">
            <div class="section-header">
                <h1>Anggota Keluarga - <?=$clanName?></h1>
                <div class="section-header-breadcrumb">
                    <a class="btn btn-success mr-1" id="export-member" href="<?=base_url('export/excel').$slug?>" target="_blank">Export Excel</a>
                    <a class="btn btn-primary" id="modal-member" href="" ng-if="<?=logged_in() ? 1: 0?>" ng-click="edit()">Tambah</a>
                </div>
            </div>
    
            <div class="section-body">
                <div class="card">
                    <!-- <div class="card-header">
                    </div> -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped responsive" id="tableMembers">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Suami/Istri</th>
                                        <th>Bapak</th>
                                        <th>Ibu</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" role="dialog" id="modal-member-action">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">{{dataModal.title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-md-12 text-center">
                        <div class="form-group">
                            <label>Foto</label>
                            <div class="input-group">
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">Upload Foto</label>
                                    <input type="file" ng-model="dataModal.imgFile" ngf-select="onFileSelect($file)" ngf-pattern="'image/*'" name="image" id="image-upload" />
                                </div>
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-font"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" ng-model="dataModal.name" placeholder="Tulis nama..." name="name">
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-venus-mars"></i>
                                    </div>
                                </div>
                                <select id="gender" class="form-control" ng-model="dataModal.gender" ng-change="onChangeGender()">
                                    <option value="male">Laki - laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>No. Telepon</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" ng-model="dataModal.phone" placeholder="Tulis nomor telepon..." name="phone">
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Alamat</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-home"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" ng-model="dataModal.address" placeholder="Tulis alamat..." name="address">
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" ng-model="dataModal.birth_date" class="form-control datepicker">
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Meninggal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" ng-model="dataModal.death_date" class="form-control datepicker">
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Bapak</label>
                            <div class="input-group">
                                <select id="father" class="form-control" select22 ng-model="dataModal.father_id" ng-change="onChangeParent(dataModal.father_id, 'father')">
                                    <option value="">-- Tidak Ada --</option>
                                    <option ng-repeat="member in members.data | filter: { gender: '!female'}" value="{{member.id}}">{{member.name}}</option>
                                </select>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Ibu</label>
                            <div class="input-group">
                                <select id="mother" class="form-control" select22 ng-model="dataModal.mother_id" ng-change="onChangeParent(dataModal.mother_id, 'mother')">
                                    <option value="">-- Tidak Ada --</option>
                                    <option ng-repeat="member in members.data | filter: { gender: 'female'}" value="{{member.id}}">{{member.name}}</option>
                                </select>
                            </div>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ dataModal.gender == 'male' ? 'Istri' : 'Suami'}}</label>
                            <div class="input-group">
                                <select id="spouse" ng-if="dataModal.gender == 'male'" class="form-control" select22 multiple ng-model="dataModal.spouse_id">
                                    <option value="">-- Tidak Ada --</option>
                                    <option ng-repeat="member in members.data | filter: { gender: 'female'}" value="{{member.id}}">{{member.name}}</option>
                                </select>
                                <select id="spouse" ng-if="dataModal.gender == 'female'" class="form-control" select22 ng-model="dataModal.spouse_id">
                                    <option value="">-- Tidak Ada --</option>
                                    <option ng-repeat="member in members.data | filter: { gender: '!female'}" value="{{member.id}}">{{member.name}}</option>
                                </select>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-book-dead"></i>
                                    </div>
                                </div>
                                <select id="gender" class="form-control" ng-model="dataModal.status">
                                    <option value="A">Hidup</option>
                                    <option value="D">Meninggal</option>
                                </select>
                            </div>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="saveMember" type="button" class="btn btn-primary" ng-click="save()">Save</button>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" role="dialog" id="modal-member-detail">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <hr/>
                    <div class="modal-body">
                        <div class="row gutters-sm">
                            <div class="col-md-4 mb-3">
                                <div class="card card-detail">
                                    <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="{{dataDetail.avatar_url}}" alt="Admin" class="rounded-circle" width="150">
                                        <div class="mt-3">
                                        <h4>{{ dataDetail.name }}</h4>
                                        <p class="text-secondary mb-1">{{ dataDetail.gender == 'male' ? 'Laki - laki' : 'Perempuan' }}</p>
                                        <p class="text-secondary font-size-sm">Umur : {{ dataDetail.age }} Tahun {{dataDetail.status == 'D' ? '(Alm)' : ''}}</p>
                                        <!-- <button class="btn btn-primary">Follow</button> -->
                                        <!-- <button class="btn btn-outline-primary">Message</button> -->
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <!-- <div class="card card-detail mt-3">
                                    <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Website</h6>
                                        <span class="text-secondary">https://bootdey.com</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>Github</h6>
                                        <span class="text-secondary">bootdey</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>Twitter</h6>
                                        <span class="text-secondary">@bootdey</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>Instagram</h6>
                                        <span class="text-secondary">bootdey</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>Facebook</h6>
                                        <span class="text-secondary">bootdey</span>
                                    </li>
                                    </ul>
                                </div> -->
                            </div>
                            <div class="col-md-8">
                            <div class="card card-detail mb-3">
                                <div class="card-body">
                                <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Biodata</i></h6>
                                <div class="row">
                                    <div class="col-sm-3">
                                    <h6 class="mb-0">Nama</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                    {{ dataDetail.name }} {{dataDetail.status == 'D' ? '(Alm)' : ''}}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                    <h6 class="mb-0">Tgl. Lahir</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                    {{ dataDetail.birth_date || '-'}}
                                    </div>
                                </div>
                                <hr>
                                <div class="row" ng-show="dataDetail.status == 'D'">
                                    <div class="col-sm-3">
                                    <h6 class="mb-0">Tgl. Meninggal</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                    {{ dataDetail.death_date || '-'}}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                    <h6 class="mb-0">No. Telepon</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                    {{ dataDetail.phone || '-'}}
                                    </div>
                                </div>
                                <hr>
                                <!-- <div class="row">
                                    <div class="col-sm-3">
                                    <h6 class="mb-0">Mobile</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                    (320) 380-4539
                                    </div>
                                </div>
                                <hr> -->
                                <div class="row">
                                    <div class="col-sm-3">
                                    <h6 class="mb-0">Alamat</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                    {{ dataDetail.address || '-'}}
                                    </div>
                                </div>
                                <hr>
                                <!-- <div class="row">
                                    <div class="col-sm-12">
                                    <a class="btn btn-info " target="__blank" href="https://www.bootdey.com/snippets/view/profile-edit-data-and-skills">Edit</a>
                                    </div>
                                </div> -->
                                </div>
                            </div>

                            <div class="row gutters-sm">
                                <div class="col-sm-12 mb-3">
                                    <div class="card card-detail h-100">
                                        <div class="card-body">
                                            <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">Keluarga</i></h6>
                                            <div class="row mb-2">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Bapak</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary" ng-click="changeDetail(dataDetail.father_id, 'id')">
                                                    <a href="">{{ dataDetail.father_name || '-'}} {{dataDetail.father_name && dataDetail.status == 'D' ? '(Alm)' : ''}}</a>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mb-2">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Ibu</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary" ng-click="changeDetail(dataDetail.mother_id, 'id')">
                                                    <a href="">{{ dataDetail.mother_name || '-'}} {{dataDetail.mother_name && dataDetail.status == 'D' ? '(Alm)' : ''}}</a>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mb-2">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Saudara ({{ dataDetail.siblings.length }})</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <p class="mb-n1" ng-repeat="sib in dataDetail.siblings">
                                                        <a href="" ng-click="changeDetail(sib)">{{ sib.name }} ({{ sib.gender == 'male' ? 'L' : 'P'}}) {{sib.status == 'D' ? '(Alm)' : ''}}</a>
                                                    </p>
                                                    <span ng-show="dataDetail.siblings.length <= 0"> - </span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mb-2">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">{{ dataDetail.gender == 'male' ? 'Istri' : 'Suami' }}</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <p class="mb-n1" ng-repeat="spouse in dataDetail.spouses">
                                                        <a href="" ng-click="changeDetail(spouse)">{{ spouse.name }} {{spouse.status == 'D' ? '(Alm)' : ''}}</a>
                                                    </p>
                                                    <span ng-show="dataDetail.spouses.length <= 0"> - </span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mb-2">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Anak ({{ dataDetail.children.length }})</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <p class="mb-n1" ng-repeat="child in dataDetail.children">
                                                        <a href="" ng-click="changeDetail(child)">{{ child.name }} ({{ child.gender == 'male' ? 'L' : 'P'}}) {{child.status == 'D' ? '(Alm)' : ''}}</a>
                                                    </p>
                                                    <span ng-show="dataDetail.children.length <= 0"> - </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
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
    <script src="<?=base_url()?>/assets/lib/jquery/jquery.uploadPreview.min.js"></script>
    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });
        
        $.uploadPreview({
          input_field: "#image-upload",   // Default: .image-upload
          preview_box: "#image-preview",  // Default: .image-preview
          label_field: "#image-label",    // Default: .image-label
          label_default: "Upload Foto",   // Default: Choose File
          label_selected: "Ganti Foto",  // Default: Change File
          no_label: false,                // Default: false
          success_callback: null          // Default: null
        });

        const base_url = '<?=base_url()?>';

        app.controller('memberCtrl', function($scope, $http, $compile) {
            $scope.members = <?=json_encode($clanMembers)?>;
            // console.log($scope.members);

            function findMember(id) {
                for (var i = 0; i < $scope.members.data.length; i++) {
                    if ($scope.members.data[i].id == id) {
                        return $scope.members.data[i];
                    }
                }
            }

            function findSpouse(ids) {
                let result = []
                for (var i = 0; i < $scope.members.data.length; i++) {
                    if (ids.includes($scope.members.data[i].id)) {
                        result.push($scope.members.data[i]);
                    }
                }
                return result;
            }

            function findChildren(parentId, gender) {
                let result = []
                for (var i = 0; i < $scope.members.data.length; i++) {
                    if(gender == 'male') {
                        if ($scope.members.data[i].father_id == parentId) {
                            result.push($scope.members.data[i]);
                        }
                    } else {
                        if ($scope.members.data[i].mother_id == parentId) {
                            result.push($scope.members.data[i]);
                        }
                    }
                }
                return result;
            }

            function findSiblings(fid, mid, id) {
                let result = []
                for (var i = 0; i < $scope.members.data.length; i++) {
                    if ((fid && $scope.members.data[i].father_id == fid) || (mid && $scope.members.data[i].mother_id == mid)) {
                        if($scope.members.data[i].id != id) result.push($scope.members.data[i]);
                    }
                }
                return result;
            }

            function findSpouseSelect(pId) {
                for (var i = 0; i < $scope.members.data.length; i++) {
                    if ($scope.members.data[i].spouse_id.includes(pId)) {
                        return $scope.members.data[i].id;
                    }
                }
            }

            $scope.onChangeGender = function() {
                $scope.dataModal.spouse_id = '';
            }

            $scope.onChangeParent = function(pId, change) {
                if(change == 'father') {
                    $scope.dataModal.mother_id = findSpouseSelect(pId);
                } else {
                    $scope.dataModal.father_id = findSpouseSelect(pId);
                }
            }

            $scope.openDetail = function (data) {
                $scope.dataDetail = angular.copy(data);
                $scope.dataDetail.spouses = findSpouse($scope.dataDetail.spouse_id);
                $scope.dataDetail.children = findChildren($scope.dataDetail.id, $scope.dataDetail.gender);
                $scope.dataDetail.siblings = findSiblings(data.father_id, data.mother_id, data.id);
                $('#modal-member-detail').modal('show');
                $scope.$apply();
            }

            $scope.changeDetail = function(data, type='data') {
                if(!data) return;
                $scope.dataDetail = type == 'id' ? angular.copy(findMember(data)) : angular.copy(data);
                $scope.dataDetail.spouses = findSpouse($scope.dataDetail.spouse_id);
                $scope.dataDetail.children = findChildren($scope.dataDetail.id, $scope.dataDetail.gender);
                $scope.dataDetail.siblings = findSiblings($scope.dataDetail.father_id, $scope.dataDetail.mother_id, $scope.dataDetail.id);
                $('#modal-member-detail').animate({ scrollTop: 0 }, 500);
                console.log('change', $scope.dataDetail);
            }

            $scope.edit = function(id=null, type='add') {
                if(!<?=logged_in() ? 1: 0?>) return;
                $('.image-preview').css({'background-image' : 'none'});
                $scope.dataModal = {
                    type: 'add',
                    title: 'Tambah anggota',
                    id: id,
                    name: null,
                    gender: 'male',
                    phone: null,
                    address: null,
                    status: 'A',
                    birth_date: null,
                    death_date: null,
                    spouse_id: null,
                    father_id: null,
                    mother_id: null,
                    imgFile: null
                };
                
                if (type != 'add') {
                    _.forEach($scope.members.data, function(member) {
                        if(member.id == id) {
                            $scope.dataModal.type = 'edit';
                            $scope.dataModal.title = 'Edit - ' + member.name;
                            $scope.dataModal.name = member.name;
                            $scope.dataModal.gender = member.gender;
                            $scope.dataModal.phone = member.phone;
                            $scope.dataModal.address = member.address;
                            $scope.dataModal.status = member.status;
                            $scope.dataModal.birth_date = member.birth_date;
                            $scope.dataModal.death_date = member.death_date;
                            $scope.dataModal.father_id = member.father_id;
                            $scope.dataModal.mother_id = member.mother_id;
                            $scope.dataModal.avatar = member.avatar;

                            if ($scope.dataModal.gender == 'male') {
                                $scope.dataModal.spouse_id = member.spouse_id;
                            } else {
                                $scope.dataModal.spouse_id = member.spouse_id.length > 0 ? member.spouse_id[0] : '';
                            }

                            if($scope.dataModal.avatar) {
                                $('.image-preview').css(
                                    {
                                        'background-image' : 'url(' + member.avatar_url + ')',
                                        'background-size' : 'cover',
                                        'background-position' : 'center',
                                    }
                                );
                            }
                        }
                    });
                }
                $('#modal-member-action').modal('show');
            }

            $scope.save = function() {
                if(!<?=logged_in() ? 1: 0?>) return; 
                if($scope.dataModal.name == '' || $scope.dataModal.name == null) {
                    swal('Warning', 'Nama tidak boleh kosong', 'warning');
                    return false;
                }

                var formData = new FormData();
                formData.append('avatar', $scope.dataModal.imgFile);
                formData.append('data', angular.toJson($scope.dataModal));
                
                $('#saveMember').attr('disabled', true);
                $http.post(`${base_url}/admin/member/${$scope.dataModal.type}`, formData, {
                  transformRequest: angular.identity,
                  headers: {'Content-Type': undefined}
                }).then(function(response) {
                    if (response.data.status == 'success') {
                        swal('Success', `Berhasil ${$scope.dataModal.type == 'edit' ? 'update' : 'menambah'} anggota`, 'success');
                        $('#saveMember').attr('disabled', false);
                        window.location.reload();
                    } else {
                        swal('Error', 'Something went wrong', 'error');
                        $('#saveMember').attr('disabled', false);
                    }
                });
            };

            $scope.delete = function(data) {
                if(!<?=logged_in() ? 1: 0?>) return;
                swal({
                    title: 'Delete this member?',
                    text: `"${data.name}"`,
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((confirmDelete) => {
                    if (confirmDelete) {
                        $http.post(base_url + '/admin/member/delete', {id: data.id, name: data.name}).then(function(response) {
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
                var table = $('#tableMembers').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    pageLength:10,
                    // lengthMenu: [[10, 50, 100, 250, 1000000], [10, 50, 100, 250, "All"]],
                    paging: true,
                    ordering: true,
                    order: [[0, 'asc']],
                    searching: true,
                    lengthChange: false,
                    responsive: true,
                    ajax: function ( data, callback, settings ) {
                        var out, key, ordered;
                        
                        out = $scope.members.data;
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
                                recordsTotal: $scope.members.recordsTotal,
                                recordsFiltered: $scope.members.recordsFiltered
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
                            "data": "name",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = `
                                        <a id="showDetail" href=""><h6>${row.name} ${row.status == 'D' ? '(Alm)' : ''}</h6></a>
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
                            "data": "gender",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = row.gender == 'male' ? 'Laki - laki' : 'Perempuan';
                                }

                                return data;
                            }
                        },
                        {
                            "targets": [3],
                            "data": "birth_date",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = row.birth_date ?? '-';
                                }

                                return data;
                            }
                        },
                        {
                            "targets": [4],
                            "data": "spouse_name",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = row.spouse_name || '-';
                                }

                                return data;
                            }
                        },
                        {
                            "targets": [5],
                            "data": "father_name",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = row.father_name || '-';
                                }

                                return data;
                            }
                        },
                        {
                            "targets": [6],
                            "data": "mother_name",
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    data = row.mother_name || '-';
                                }

                                return data;
                            }
                        }
                    ],
                    createdRow: function ( row, data, index ) {
                        $compile(row)($scope);  //add this to compile the DOM
                    }
                });

                // $('#tableMembers tbody').on('click', '#edit', function () {
                //     var data = table.row( $(this).parents('tr') ).data();
                //     $scope.edit(data, 'edit');
                // });
                $('#tableMembers tbody').on('click', '#showDetail', function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    $scope.openDetail(data);
                });
                $('#tableMembers tbody').on('click', '#delete', function () {
                    var data = table.row( $(this).parents('tr') ).data();
                    $scope.delete(data);
                });
            });
        });
    </script>
<?= $this->endSection() ?>