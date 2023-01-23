app.controller('CrudApprenantsSessionsController',function($scope,$http,apiUrl,CurrentUser,Notification,$routeParams, $window){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */
    $scope.folderMethodes = {
        'Add' : function(id){
            $scope.Add(id)
        },
        'Delete' : function(id){
            $scope.Delete(id)
        },
        'Emargement' : function(id){
            $scope.Emargement(id)
        }
    }
    $scope.liste_apprenants = [];
    $scope.liste_session_apprenants = [];

    function liste_apprenants(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Apprenants/SessionNot/'+$routeParams.session_id,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_apprenants = response.data;
        });
    }
    function liste_session_apprenants(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Apprenants/Session/'+$routeParams.session_id,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_session_apprenants = response.data;

        });
    }
    liste_session_apprenants();
    liste_apprenants();


    $scope.Add = function (id){
        var form_data = new FormData();
        form_data.append('ID_APPRENANT', id);
        form_data.append('ID_SESSION', $routeParams.session_id);
        $http({
            method: 'POST',
            url: apiUrl + 'FormaCampAPI/Apprenants',
            data:form_data,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            if(response.data == true){
                const wrapper = '<p>Ajouté avec succès</p>';
                Notification.success({
                    message: wrapper,
                    delay: 2000,
                    positionY: 'bottom',
                    positionX: 'right'
                });

                let index = $scope.liste_apprenants.map(function(e) {
                    return e.ID_APPRENANT;
                }).indexOf(id)
                $scope.liste_apprenants[index].Add = true;
                $scope.liste_session_apprenants.push($scope.liste_apprenants[index]);
                $scope.liste_apprenants.splice(index,1);

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
    $scope.Delete = function (id){
        swal({
            title: "Êtes-vous sûr de vouloir supprimer?",
            text: "Pour confirmer veuillez sélectionner votre choix.NB:Ce ne seras plus disponible",
            type: "warning",
            confirmButtonClass:'btn-ns-outline',
            cancelButtonClass:'btn-ns-outline-light',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Supprimer",
            cancelButtonText: "Annuler",
            closeOnConfirm: true,
            closeOnCancel: false
        }, function(isConfirm){
            if (isConfirm) {
                $http({
                    method: 'DELETE',
                    url: apiUrl + 'FormaCampAPI/Apprenants/'+id,
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
                        let index = $scope.liste_session_apprenants.map(function(e) {
                            return e.ID_APPRENANT;
                        }).indexOf(id)
                        $scope.liste_session_apprenants[index].Add = false;
                        $scope.liste_apprenants.push($scope.liste_session_apprenants[index]);
                        $scope.liste_session_apprenants.splice(index,1);
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

    $scope.Emargement = function (apprenant) {
        $window.open(apiUrl + 'Emargement/'+$routeParams.session_id+'/'+apprenant.ID_APPRENANT, '_blank')

    }
    $scope.AllEmargement = function (apprenants) {
        var ids =  _.pluck(apprenants,'ID_APPRENANT').flat();
        $window.open(apiUrl + 'Emargement/'+$routeParams.session_id+'/'+ids, '_blank')

    }
    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
