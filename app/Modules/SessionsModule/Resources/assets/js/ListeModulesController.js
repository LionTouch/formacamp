app.controller('ListeModulesController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams,$uibModal){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */
    $scope.liste_data = [];
    $scope.liste_modalites = [];

    $scope.step = 1;
    let date = new Date();
    date.setHours(0);
    date.setMinutes(0);
    date.setSeconds(0);
    date.setMilliseconds(0);
    $scope.ins = {
        NOM:'',
        ID_SESSION:$routeParams.session_id,
        ID_MODALITE:0

    }
    $scope.session = {};
    $scope.GoTo = function (path){
        $location.path(path);
    }
    /**
     * data list function
     * */
    function data_session(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Sessions/'+$routeParams.session_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.session =  response.data;
        },function (response) {
            $location.path('/Sessions');
        });
    }
    /**
     * data list function
     * */
    function data_list(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Modules/Session/'+$routeParams.session_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_data =  response.data;
            $scope.current_grid = 1;
            $scope.filter_data = $scope.data_limit;
            $scope.entire = $scope.liste_data.length;
        });
    }



    function liste_modalites(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/ModalitesModules',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_modalites = response.data;
        });
    }

    data_session();
    data_list();
    // liste_types_prix();
    liste_modalites();
    // liste_tarifs_prix();

    $scope.folderMethodes = {
        'Edit' : function(id){
            $scope.Edit(id)
        }, 'Delete' : function(id){
            $scope.Delete(id)
        }
    }
    $scope.ShowPrixModule = function (module){
        module.TypeFolder = 'Prix';
    }
    $scope.ShowDateModule = function (module){
        module.TypeFolder = 'Date';

    }
    $scope.ChooseModalite = function (id,e){
        $scope.ins.ID_MODALITE = id;
        $('.modalite').removeClass('active');
        $(e.currentTarget).addClass('active');
    }
    /**
     * Popup Add
     * */
    $scope.Add = function (){
        $scope.modalInstance = $uibModal.open({
            templateUrl: apiUrl + 'app/Modules/SessionsModule/Resources/views/popup_module.html',
            windowClass: 'medium',
            size: 'lg',
            scope: $scope,
            resolve: {
                title: function () {
                    return $scope.title = 'Ajouter';
                },
                ins: function () {
                    return $scope.ins = {
                        NOM:'',
                        ID_SESSION:$routeParams.session_id,
                        ID_MODALITE:$scope.liste_modalites[0].ID_MODALITE
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
            url: apiUrl + 'FormaCampAPI/Modules/'+id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.modalInstance = $uibModal.open({
                templateUrl: apiUrl + 'app/Modules/SessionsModule/Resources/views/popup_module.html',
                windowClass: 'medium',
                size:'lg',
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

    /**
     * Delete function
     * */
    $scope.DeleteSession = function (){
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
                    url: apiUrl + 'FormaCampAPI/Sessions/'+$routeParams.session_id,
                    headers: {'Content-Type': undefined}
                }).then(function (response) {
                    if(response.data){
                        const wrapper = '<p>Supprimé avec succès</p>';
                        Notification.success({
                            message: wrapper,
                            delay: 2000,
                            positionY: 'bottom',
                            positionX: 'right'
                        });
                        $location.path('/Sessions');
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
                    url: apiUrl + 'FormaCampAPI/Modules/'+id,
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

    $scope.Save = function (){
        var form_data = new FormData();
        if($scope.ins.ID_MODULE != undefined){
            form_data.append('_method' , 'PUT')
            var api = 'FormaCampAPI/Modules/'+$scope.ins.ID_MODULE;
        }else{
            var api = 'FormaCampAPI/Modules';
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

    $scope.UpdateType = function (session){
        var form_data = new FormData();
        var api = 'FormaCampAPI/Sessions/Type/'+session.ID_SESSION;
        form_data.append('_method' , 'PUT');
        form_data.append('TYPE', session.TYPE+1);

        $http({
            method: 'POST',
            url: apiUrl + api,
            data:form_data,
            headers: {"Content-Type": undefined }
        }).then(function (response) {
            if(response.data == true){
                const wrapper = '<p>Enregistré avec succès</p>';
                Notification.success({
                    message: wrapper,
                    delay: 2000,
                    positionY: 'bottom',
                    positionX: 'right'
                });
                session.TYPE = session.TYPE+1;
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
    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
