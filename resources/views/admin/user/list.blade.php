<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="copyright" content="romecody.com"/>
    <meta name="author" content="Rome"/>
    <title>TestApp</title>
    <!-- Load Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="{!! asset('template/css/bootstrap.min.css') !!}"/>
    <link type="text/css" rel="stylesheet" href="{!! asset('template/css/style.css') !!}"/>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script defer src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script defer src="{!! asset('admin/js/AngularJS/main.js') !!}"></script>
    {{--Handle validate image--}}
    <script defer src="{!! asset('admin/js/ng-file-upload-bower-12.2.12/ng-file-upload.min.js') !!}"></script>
    <script defer src="{!! asset('admin/js/ng-file-upload-bower-12.2.12/ng-file-upload-all.min.js') !!}"></script>
    <script defer src="{!! asset('admin/js/ng-file-upload-bower-12.2.12/ng-file-upload-shim.min.js') !!}"></script>
    {{--Handle validate image--}}

    <script defer src="{!! asset('admin/js/AngularJS/angular-messages.js') !!}"></script>
    <script defer src="{!! asset('template/js/dirPagination.js') !!}"></script>

</head>
<style>
    table thead tr {
        cursor: pointer;
    }

    /*This class displays the UP arrow*/
    .arrow-up {
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 10px solid black;
        display: inline-block;
    }

    /*This class displays the DOWN arrow*/
    .arrow-down {
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 10px solid black;
        display: inline-block;
    }
</style>
<body ng-app="MyApp">
<div class="container" ng-controller="MyController">
    <center><h2>Manager Members</h2></center>
    <div class="pull-right">
        <span>Search:</span> <label for=""><input type="text" ng-model="TextSearch" placeholder="Search here"
                                                  class="form-control"></label>
    </div>

    <table class="table table-bordered">
        <thead class="text-center">
        <tr>
            <th ng-click="sortBy('created_at')" class="text-center">Avatar</th>
            <th ng-click="sortBy('name')" class="text-center">Name
                <div ng-class="getSortClass('name')"></div>
            </th>
            <th ng-click="sortBy('age')" class="text-center">Age
                <div ng-class="getSortClass('age')"></div>
            </th>
            <th ng-click="sortBy('email')" class="text-center">Email
                <div ng-class="getSortClass('email')"></div>
            </th>
            <th ng-click="sortBy('address')" class="text-center">Address
                <div ng-class="getSortClass('address')"></div>
            </th>
            <th width="10%" class="text-center">
                <button id="btn-add" class="btn btn-primary btn-xs" ng-click="modal('add')">Add more member</button>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr dir-paginate="mb in members |filter:TextSearch |orderBy:sortColumn:reverse |itemsPerPage:5 as postItems"
            pagination-id="main-pagination" class="text-center"> <!--itemperpage should is the last position-->
            <td><img class="img-thumbnail" width="80" ng-src="{{ url('admin/images/avatars') }}/@{{ mb.avatar }}"></td>
            <td>@{{ mb.name.substring(0,30) }}</td>
            <td>@{{ mb.age }}</td>
            <td>@{{ mb.email }}</td>
            <td>@{{ mb.address.substring(0,50) }}</td>
            <td>
                <button class="btn btn-default btn-xs btn-detail" id="btn-edit" ng-click="modal('edit',mb.id)">Edit
                </button>
                <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(mb.id)">Delete</button>
            </td>
        </tr>

        </tbody>
    </table>
    <span ng-if="postItems.length==0">There no member like that</span>
    <dir-pagination-controls max-size="5" direction-links="true" boundary-links="true"
                             pagination-id="main-pagination"></dir-pagination-controls>

    <!-- Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@{{ frmTitle  }}</h4>
                </div>
                <div class="modal-body">
                    <form name="frmStudent" class="form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Name</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Enter your name" ng-model="member.name" ng-required="true"
                                       ng-maxlength="100"/>
                                <span id="helpBlock2" class="help-block" ng-show="frmStudent.name.$error.maxlength">Name should not be more than 100 character.</span>
                            </div>
                            <div class="col-sm-1">
                                <i class="fa fa-check text-success" ng-show="frmStudent.name.$valid"></i>
                                <i class="fa fa-close text-danger" ng-show="frmStudent.name.$invalid"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="age" class="col-sm-3 control-label">Age</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="age" name="age"
                                       placeholder="Enter your age" ng-model="member.age" ng-required="true"
                                       ng-maxlength="2">
                                <span id="helpBlock2" class="help-block" ng-show="frmStudent.age.$error.maxlength">Age should not more than 2 digits</span>
                            </div>
                            <div class="col-sm-1">
                                <i class="fa fa-check text-success" ng-show="frmStudent.age.$valid"></i>
                                <i class="fa fa-close text-danger" ng-show="frmStudent.age.$invalid"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-3 control-label" ng-disabled="">Address</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="address" name="address"
                                       placeholder="Enter your address" ng-model="member.address" ng-required="true"
                                       ng-maxlength="300">
                                <span id="helpBlock2" class="help-block" ng-show="frmStudent.address.$error.maxlength">Name should not more than 300 characters.</span>
                            </div>
                            <div class="col-sm-1">
                                <i class="fa fa-check text-success" ng-show="frmStudent.address.$valid"></i>
                                <i class="fa fa-close text-danger" ng-show="frmStudent.address.$invalid"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="Enter your email" ng-model="member.email"/>
                                <span id="helpBlock2" class="help-block" ng-show="frmStudent.email.$error.email">This is not Email format</span>
                            </div>
                            <div class="col-sm-1">
                                <i class="fa fa-check text-success" ng-show="frmStudent.email.$valid"></i>
                                <i class="fa fa-close text-danger" ng-show="frmStudent.email.$invalid"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="avatar" class="col-sm-3 control-label" ng-disabled="">Avatar</label>
                            <div class="col-sm-8">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-2">

                                            <input type="file" ngf-select ng-model="picFile" name="file"
                                                   accept="image/*" ngf-max-size="10MB"
                                                   ngf-model-invalid="errorFile"
                                                   ngf-pattern="image/png,image/jpg,image/gif,image/jpeg"
                                                   class="form-control" file="file" id="avatar">

                                            <span id="helpBlock2" class="help-block"
                                                  ng-show="frmStudent.file.$error.pattern">Image only support: png; jpg; jpeg; gif.</span>
                                            <span id="helpBlock2" class="help-block"
                                                  ng-show="frmStudent.file.$error.maxSize">File too large: max 10MB</span>
                                        </div>
                                        <div class="col-sm-8">
                                            <img ng-show="myForm.file.$valid" ngf-thumbnail="picFile"
                                                 class="img-thumbnail" width="100em" id="image">
                                            <button ng-click="picFile = null" ng-show="picFile" class="btn btn-sm btn-warning">
                                                <span style="font-size: 10px">
                                                    <i class="fa fa-close"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <i class="fa fa-check text-success" ng-show="frmStudent.file.$valid"></i>
                                <i class="fa fa-close text-danger" ng-show="frmStudent.file.$invalid"></i>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" ng-click="save(state,id)"
                            >Save
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<!-- Load Bootstrap JS -->
<script type="text/javascript" src="{!! asset('template/js/jquery.min.js')!!}"></script>
<script type="text/javascript" src="{!! asset('template/js/bootstrap.min.js')!!}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#btn-add,#btn-edit").click(function () {
            $('#myModal').modal('show')
        });
    });
</script>
</body>
</html>