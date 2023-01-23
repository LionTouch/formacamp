app.controller('CrudFormationsSessionsController',function($scope,$http,apiUrl,CurrentUser,Notification,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    $scope.formations = [];
    function liste_formations(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Formations/Session/'+$routeParams.session_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            response.data.length>0?$scope.formations = response.data :
                $scope.formations =  [{
                    INDX:0,
                    ID_FORMATION:0,
                    ID_SESSION:$routeParams.session_id,
                    TEXT:'',
                    sous_formations:[
                        {
                            INDX:0,
                            ID_SUB_FORMATION:0,
                            ID_FORMATION:0,
                            TEXT:''
                        }
                    ]
                }];
        });
    }
    liste_formations();

    $scope.AddFormation = function (){

        $scope.formations.push({
            INDX:$scope.formations.length,
            ID_FORMATION:0,
            ID_SESSION:$routeParams.session_id,
            TEXT:'',
            sous_formations: [
                {
                    INDX:0,
                    ID_SUB_FORMATION:0,
                    ID_FORMATION:0,
                    TEXT:''
                }
            ]
        })

    }
    $scope.DeleteFormation = function (index){
        if($scope.formations[index].ID_FORMATION != 0){
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
                        url: apiUrl + 'FormaCampAPI/Formations/'+$scope.formations[index].ID_FORMATION,
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
                            $scope.formations.splice(index,1)
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
            $scope.formations.splice(index,1);
        }

    }
    $scope.AddSousFormation = function (formation){
        formation.sous_formations.push({
            INDX:$scope.formations.length,
            ID_SUB_FORMATION:0,
            ID_FORMATION:formation.ID_FORMATION,
            TEXT:''
        })

    }
    $scope.DeleteSousFormation = function (formation,index){
        if(formation.sous_formations[index].ID_SUB_FORMATION != 0){
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
                        url: apiUrl + 'FormaCampAPI/SousFormations/'+formation.sous_formations[index].ID_SUB_FORMATION,
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
                            formation.sous_formations.splice(index,1);
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
            formation.sous_formations.splice(index,1);
        }

    }

    $scope.Save = function (){
        let formations = $scope.formations.filter(function (formation){
            return formation.TEXT !== '';
        })
        let form_data = new FormData();
        let api = 'FormaCampAPI/Formations';
        form_data.append('formations', JSON.stringify(formations));
        $http({
            method: 'POST',
            url: apiUrl + api,
            data:form_data,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            if(response.data === true){
                liste_formations();
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
