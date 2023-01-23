app.controller('CrudProfilsApprenantsSessionsController',function($scope,$http,apiUrl,CurrentUser,Notification,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    $scope.profils = [];

    function liste_profils(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/ProfilsApprenants/Session/'+$routeParams.session_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.profils = response.data;
        });

    }
    liste_profils();

    $scope.AddProfil = function (type){

        $scope.profils[type].DATA.push({
            INDX:$scope.profils.length,
            TYPE:type,
            ID_PROFIL:0,
            ID_SESSION:$routeParams.session_id,
            TEXT:''
        })

    }
    $scope.DeleteProfil = function (index,type){
        if($scope.profils[type].DATA[index].ID_PROFIL != 0){
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
                        url: apiUrl + 'FormaCampAPI/ProfilsApprenants/'+$scope.profils[type].DATA[index].ID_PROFIL,
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
                            $scope.profils[type].DATA.splice(index,1)
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
            $scope.profils[type].DATA.splice(index,1)
        }

    }

    $scope.Save = function (){
        let potentiels = $scope.profils[0].DATA.filter(function (potentiel){
            return potentiel.TEXT !== '';
        })
        let prerequis = $scope.profils[1].DATA.filter(function (prerequi){
            return prerequi.TEXT !== '';
        })

        let form_data = new FormData();
        let api = 'FormaCampAPI/ProfilsApprenants';
        form_data.append('potentiels', JSON.stringify(potentiels));
        form_data.append('prerequis', JSON.stringify(prerequis));
        $http({
            method: 'POST',
            url: apiUrl + api,
            data:form_data,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            if(response.data === true){
                liste_profils();
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
