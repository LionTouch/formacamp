app.controller('ListeDiplomesController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$uibModal,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */
    $scope.data_limit = "10";
    $scope.infiniteLimit = 6;
    $scope.liste_data = [];

    $scope.ins = {
        ID_ORGANISME:"",
        NOM:""
    };
    /**
     * data list function
     * */
    function data_list(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Diplomes',
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_data =  response.data;
            $scope.current_grid = 1;
            $scope.filter_data = $scope.data_limit;
            $scope.entire = $scope.liste_data.length;
        });
    }




    data_list();

    $scope.loadMore = function() {
        if($scope.liste_data.length > $scope.infiniteLimit){
            $scope.infiniteLimit += 5;
        }
    }, 1000;
    $scope.folderMethodes = {
        'Edit' : function(id){
            $scope.Edit(id)
        }, 'Delete' : function(id){
            $scope.Delete(id)
        }
    }


    $scope.GoTo = function (path){
        $location.path(path);
    }
    /**
     * Popup Add
     * */
    $scope.Add = function (){
        $scope.modalInstance = $uibModal.open({
            templateUrl: apiUrl + 'app/Modules/DiplomesModule/Resources/views/popup_diplome.html',
            windowClass: 'medium',
            scope: $scope,
            resolve: {
                title: function () {
                    return $scope.title = 'Ajouter';
                },
                ins: function () {
                    return $scope.ins = {
                        ID_ORGANISME:"",
                        NOM:""
                    };
                }
            }
        });
        $scope.modalInstance.rendered.then(function () {

        });
    }
    /**
     * Popup Edit
     * */
    $scope.Edit = function (id){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Diplomes/'+id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.modalInstance = $uibModal.open({
                templateUrl: apiUrl + 'app/Modules/DiplomesModule/Resources/views/popup_diplome.html',
                windowClass: 'medium',
                scope: $scope,
                resolve: {
                    title: function () {
                        return $scope.title = 'Modifier';
                    },
                    ins: function () {
                        $scope.ins = response.data;
                        return $scope.ins;
                    }
                }
            });
            $scope.modalInstance.rendered.then(function () {});
        });
    }


    $scope.Save = function (){
        var form_data = new FormData();
        if($scope.ins.ID_DIPLOME != undefined){
            form_data.append('_method' , 'PUT')
            var api = 'FormaCampAPI/Diplomes/'+$scope.ins.ID_DIPLOME;
        }else{
            var api = 'FormaCampAPI/Diplomes';
        }
        Object.keys($scope.ins).forEach(function(k){
            if($scope.ins[k] != null){
                form_data.append(k, $scope.ins[k]);
            }

        });


        $http({
            method: 'POST',
            url: apiUrl + api,
            data:form_data,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            if(response.data == true){
                const wrapper = '<p>Enregistré avec succès</p>';
                Notification.success({
                    message: wrapper,
                    delay: 2000,
                    positionY: 'bottom',
                    positionX: 'right'
                });
                data_list();
                $scope.modalInstance.close()
            }else{
                const wrapper = '<p>Erreur</p>';
                Notification.error({
                    message: wrapper,
                    delay: 2000,
                    positionY: 'bottom',
                    positionX: 'right'
                });
            }
        });

    }

    /**
     * Delete function
     * */
    $scope.Delete = function (id){
        swal({
            title: "Êtes-vous sûr de vouloir supprimer?",
            text: "Pour confirmer veuillez sélectionner votre choix.NB:Ce ne seras plus disponible",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass:'btn-ns-outline',
            cancelButtonClass:'btn-ns-outline-light',
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Supprimer",
            cancelButtonText: "Annuler",
            closeOnConfirm: true,
            closeOnCancel: false
        }, function(isConfirm){
            if (isConfirm) {
                $http({
                    method: 'DELETE',
                    url: apiUrl + 'FormaCampAPI/Diplomes/'+id,
                    headers: {'Content-Type': undefined}
                }).then(function (response) {
                    if(response.data){
                        data_list();
                        const wrapper = '<p>Supprimé avec succès</p>';
                        Notification.success({
                            message: wrapper,
                            delay: 2000,
                            positionY: 'bottom',
                            positionX: 'right'
                        });
                    }else{
                        const wrapper = '<p>Erreur</p>';
                        Notification.error({
                            message: wrapper,
                            delay: 2000,
                            positionY: 'bottom',
                            positionX: 'right'
                        });
                    }
                });
            } else {
                swal({
                        title: "Annulé",
                        text: "Operation annulée :)",
                        type: "error",
                        confirmButtonClass:'btn-ns-outline',
                        showConfirmButton: true,
                        closeOnConfirm: true,
                    });
            }
        });
    }


    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
