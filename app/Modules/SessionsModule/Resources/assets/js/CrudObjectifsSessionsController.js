app.controller('CrudObjectifsSessionsController',function($scope,$http,apiUrl,CurrentUser,Notification,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    $scope.objectifs = [];
    function liste_objectifs(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Objectifs/Session/'+$routeParams.session_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            response.data.length>0?$scope.objectifs = response.data :
                $scope.objectifs =  [{
                    INDX:0,
                    ID_OBJECTIF:0,
                    ID_SESSION:$routeParams.session_id,
                    TEXT:''
                }];
        });
    }
    liste_objectifs();

    $scope.AddObjectif = function (){

        $scope.objectifs.push({
            INDX:$scope.objectifs.length,
            ID_OBJECTIF:0,
            ID_SESSION:$routeParams.session_id,
            TEXT:''
        })

    }
    $scope.DeleteObjectif = function (index){
        if($scope.objectifs[index].ID_OBJECTIF != 0){
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
                        url: apiUrl + 'FormaCampAPI/Objectifs/'+$scope.objectifs[index].ID_OBJECTIF,
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
                            $scope.objectifs.splice(index,1)
                        }else{
                            const wrapper = '<p>Erreur</p>';
                            Notification.error({
                                message: wrapper,
                                delay: 2000,
                                positionY: 'bottom',
                                positionX: 'right'
                            });
                        }
                    })

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
        }else{
            $scope.objectifs.splice(index,1);
        }

    }

    $scope.Save = function (){
        let objectifs = $scope.objectifs.filter(function (objectif){
            return objectif.TEXT !== '';
        })
        let form_data = new FormData();
        let api = 'FormaCampAPI/Objectifs';
        form_data.append('objectifs', JSON.stringify(objectifs));
        $http({
            method: 'POST',
            url: apiUrl + api,
            data:form_data,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            if(response.data === true){
                liste_objectifs();
                const wrapper = '<p>Enregistré avec succès</p>';
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
    }
    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
