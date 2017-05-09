var MyApp = angular.module('MyApp', ['angularUtils.directives.dirPagination', 'ngMessages', 'ngFileUpload'])
    .constant('API', 'http://localhost/vovan/ScutiTestApp3Test/public/');//dependecy theo stt

//----------------------------------------------------------------------//
//-------------------declare to handle file upload:---------------------//
//----------------------------------------------------------------------//

MyApp.directive('file', function () {
    return {
        scope: {
            file: '='
        },
        link: function (scope, el, attrs) {
            el.bind('change', function (event) {
                var file = event.target.files[0];
                scope.file = file ? file : '';
                scope.$apply();
            });
        }
    };
});

//----------------------------------------------------------------------//
//--------------declare to Mycontroller controller:---------------------//
//----------------------------------------------------------------------//

MyApp.controller('MyController', ['$scope', '$http', '$log', 'Upload', '$timeout' ,'API', function ($scope, $http, $log, Upload, $timeout ,API) {

    //Handle to get the list of member:
    $http.get(API + 'list').then(function successCallback(response) {
        $scope.members = response.data.members;
    }, function errorCallback(response) {
        $log.error(response);
    });

    //----------------------------------------------------------------------//
    //--------------Handle to show the title of the modal popup:------------//
    //----------------------------------------------------------------------//

    $scope.modal = function (state, id) {
        $scope.state = state;
        switch (state) {
            case "add" :
                $scope.frmTitle = "Add member";
                $scope.member = {};
                $scope.file = '';
                $('#avatar').val('');
                $('#image').attr('src', '');

                break;
            case "edit":
                $scope.frmTitle = "Edit member";
                $scope.id = id;
                $scope.file = '';

                $http.get(API + 'edit/' + id).then(function successCallback(response) {

                    $('#avatar').val('');
                    $('#image').attr('src', API+'admin/images/avatars/'+response.data.thisMember.avatar);
                    //get the member info , bind to member, take to view.
                    $scope.member = response.data.thisMember;

                }, function errorCallback(response) {

                });
                break;
            default:
                $scope.frmTitle = "unknow";
                break;
        }
        //run modal
        $("#myModal").modal('show');
    };

    //----------------------------------------------------------------------//
    //------------------------Handle to save member:------------------------//
    //----------------------------------------------------------------------//

    $scope.save = function (state, id) {
        if (state == 'add') {
            var url = API + 'add';
            var data = {
                name: $scope.member.name,
                email: $scope.member.email,
                address: $scope.member.address,
                age: $scope.member.age,
                avatar: $scope.file,
            };
            $http({
                method: 'POST',
                url: url,
                headers: {'Content-Type': undefined},
                data: data,

                transformRequest: function (data, headersGetter) {
                    var formData = new FormData();
                    angular.forEach(data, function (value, key) {
                        formData.append(key, value);
                    });
                    return formData;
                }
            }).then(function successCallback(response) {
                //get new data list (do not reload)
                $scope.members = response.data.listmember;
                //hide the modal
                $("#myModal").modal('hide');

            }, function errorCallback(response) {
                console.log(response.data);
            });
        }
        if (state == 'edit') {

            var url = API + 'edit/' + id;
            var data = {
                name: $scope.member.name,
                email: $scope.member.email,
                address: $scope.member.address,
                age: $scope.member.age,
                avatar: $scope.file,
            };
            $http({
                method: 'POST',
                url: url,
                data: data,
                headers: {'Content-Type': undefined},
                transformRequest: function (data, headersGetter) {
                    var formData = new FormData();
                    angular.forEach(data, function (value, key) {
                        formData.append(key, value);
                    });
                    return formData;
                }
            }).then(function successCallback(response) {

                //get new data list (do not reload)
                $scope.members = response.data.listmember;
                //hide the modal
                $("#myModal").modal('hide');
                // location.reload();

            }, function errorCallback(response) {
                console.log(response);
            });
        }
    }
    //----------------------------------------------------------------------//
    //----------------------Handle to delete member:------------------------//
    //----------------------------------------------------------------------//

    $scope.confirmDelete = function (id) {
        var isConfirmDelete = confirm('Bạn có muốn xóa dữ liệu này hay không?');
        if (isConfirmDelete) {
            //send data to delete member;
            $http.get(API + 'delete/' + id).then(function successCallback(response) {

                //get new data list (do not reload)
                $scope.members = response.data.listmember;
                //hide the modal
                $("#myModal").modal('hide');

            }, function errorCallback(response) {
                console.log(response);
            });
        }
    }

    //define default "TextSearch":
    $scope.TextSearch = '';

    //----------------------------------------------------------------------//
    //---------------Handle to sort member by click header:-----------------//
    //----------------------------------------------------------------------//

    //set default "sortColumn" index and, "reverse" index.
    $scope.sortColumn = 'name';
    $scope.reverse = false;       //false is 'ASC' , true is 'DESC'.

    $scope.sortBy = function (column) {
        if ($scope.sortColumn == column)
            $scope.reverse = !$scope.reverse;
        else
            $scope.reverse = false;
        $scope.sortColumn = column;
    };

    //----------------------------------------------------------------------//
    //-------------Handle to display up/down arrow when click.--------------//
    //----------------------------------------------------------------------//

    $scope.getSortClass = function (column) {
        if ($scope.sortColumn == column) {
            if ($scope.reverse) {
                return 'arrow-up';
            } else {
                return 'arrow-down';
            }
        }
        return '';
    };
}]);





