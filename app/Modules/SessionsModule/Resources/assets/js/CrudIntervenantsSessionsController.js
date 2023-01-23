app.controller('CrudIntervenantsSessionsController',function($scope,$http,apiUrl,CurrentUser,Notification,$routeParams,$rootScope,$timeout ){
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
        'ToggleSeance' : function(item,seance){
            $scope.ToggleSeance(item,seance)
        },
        'ToggleSeances' : function(id,type,intervenant){
            $scope.ToggleSeances(id,type,intervenant)
        },
        'CheckSelected' : function(item){
            $scope.CheckSelected(item)
        }
    }

    $scope.liste_types_seances = [];
    $scope.liste_intervenants = [];
    $scope.liste_session_intervenants = [];

    function liste_intervenants(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Intervenants/SessionNot/'+$routeParams.session_id,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_intervenants = response.data;
        });
    }
    function liste_session_intervenants(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Intervenants/Session/'+$routeParams.session_id,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_session_intervenants = response.data;

        });
    }

    function liste_types_seances(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/TypesSeancesModules',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_types_seances = response.data;
        });
    }
    liste_session_intervenants();
    liste_intervenants();
    liste_types_seances();

    $scope.Add = function (id){
        var form_data = new FormData();
        form_data.append('ID_INTERVENANT', id);
        form_data.append('ID_SESSION', $routeParams.session_id);
        $http({
            method: 'POST',
            url: apiUrl + 'FormaCampAPI/Intervenants',
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
                liste_session_intervenants();
                liste_intervenants();
                // let index = $scope.liste_intervenants.map(function(e) {
                //     return e.ID_INTERVENANT;
                // }).indexOf(id)
                // $scope.liste_intervenants[index].Add = true;
                // $scope.liste_session_intervenants.push($scope.liste_intervenants[index]);
                // $scope.liste_intervenants.splice(index,1);

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
        console.log(id)
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
                    url: apiUrl + 'FormaCampAPI/Intervenants/'+id,
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
                        // let index = $scope.liste_session_intervenants.map(function(e) {
                        //     return e.ID_INTERVENANT;
                        // }).indexOf(id)
                        // $scope.liste_session_intervenants[index].Add = false;
                        // $scope.liste_intervenants.push($scope.liste_session_intervenants[index]);
                        // $scope.liste_session_intervenants.splice(index,1);
                        liste_session_intervenants();
                        liste_intervenants();
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

    $scope.ToggleSeance = function (item,seance){
        if(!seance.SELECTED){
            var form_data = new FormData();
            form_data.append('ID_INTERVENANT', item.ID_INTERVENANT);
            form_data.append('ID_SEANCE', seance.ID_SEANCE);
            $http({
                method: 'POST',
                url: apiUrl + 'FormaCampAPI/SeancesIntervenants',
                data:form_data,
                headers: {"Content-Type": undefined },
            }).then(function (response) {
                if(response.data == true){
                    const wrapper = '<p>Ajoutée avec succès</p>';
                    Notification.success({
                        message: wrapper,
                        delay: 2000,
                        positionY: 'bottom',
                        positionX: 'right'
                    });
                    seance.SELECTED = true ;
                    $scope.CheckSelected(item);
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
        }else{
            $http({
                method: 'DELETE',
                url: apiUrl + 'FormaCampAPI/SeancesIntervenants/'+item.ID_INTERVENANT+'/'+seance.ID_SEANCE,
                headers: {'Content-Type': undefined}
            }).then(function (response) {
                if(response.data == true){
                    const wrapper = '<p>Supprimée avec succès</p>';
                    Notification.warning({
                        message: wrapper,
                        delay: 2000,
                        positionY: 'bottom',
                        positionX: 'right'
                    });
                    seance.SELECTED = false;
                    item.AllSelected = false;
                    item['Selected-'+seance.ID_TYPE_SEANCE] = false;
                    $scope.CheckSelected(item);
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
        }

    }
    $scope.ToggleSeances = function (id,type,intervenant){

        var data_seances = [];
        var method = 'POST';
            if(type === 'all'){
                if(intervenant.AllSelected){
                    $scope.liste_types_seances.forEach(function (v){
                        intervenant['Selected-'+v.ID_TYPE_SEANCE] = false;
                    });
                    intervenant.AllSelected = false;
                    method = 'DELETE';
                    intervenant.modules.forEach(function (module){
                        module.seances_intervenants.forEach(function (seance){
                            seance.SELECTED = false;
                            data_seances.push({ID_SEANCE:seance.ID_SEANCE,ID_INTERVENANT:intervenant.ID_INTERVENANT})
                        });
                    });
                }else{
                    $scope.liste_types_seances.forEach(function (v){
                        intervenant['Selected-'+v.ID_TYPE_SEANCE] = true;
                    });
                    intervenant.AllSelected = true;
                    intervenant.modules.forEach(function (module){
                        module.seances_intervenants.forEach(function (seance){
                            seance.SELECTED = true;
                            data_seances.push({ID_SEANCE:seance.ID_SEANCE,ID_INTERVENANT:intervenant.ID_INTERVENANT})
                        });
                    });
                }



            }else{

                if(intervenant['Selected-'+type]){
                     intervenant['Selected-'+type] = false;
                        method = 'DELETE';
                    intervenant.modules.forEach(function (module){
                        module.seances_intervenants.forEach(function (seance){
                            if(seance.ID_TYPE_SEANCE === type){
                                seance.SELECTED = false;
                                data_seances.push({ID_SEANCE:seance.ID_SEANCE,ID_INTERVENANT:intervenant.ID_INTERVENANT})
                            }
                        })
                    })
                }else{
                    intervenant['Selected-'+type] = true;
                    intervenant.modules.forEach(function (module){
                        module.seances_intervenants.forEach(function (seance){
                            if(seance.ID_TYPE_SEANCE === type){
                                seance.SELECTED = true;
                                data_seances.push({ID_SEANCE:seance.ID_SEANCE,ID_INTERVENANT:intervenant.ID_INTERVENANT})
                            }
                        })
                    })
                }
                for(let i=0;i<$scope.liste_types_seances.length;i++){
                    intervenant.AllSelected = false;
                    if(!intervenant['Selected-'+$scope.liste_types_seances[i].ID_TYPE_SEANCE]){
                        break;
                    }
                    intervenant.AllSelected = true;

                }

            }
            if(method === 'POST'){
                var form_data = new FormData();
                form_data.append('seances', JSON.stringify(data_seances));
                $http({
                    method: 'POST',
                    url: apiUrl + 'FormaCampAPI/SeancesIntervenantsMultiple',
                    data:form_data,
                    headers: {"Content-Type": undefined },
                }).then(function (response) {
                    if(response.data == true){
                        const wrapper = '<p>Ajoutée avec succès</p>';
                        Notification.success({
                            message: wrapper,
                            delay: 2000,
                            positionY: 'bottom',
                            positionX: 'right'
                        });
                        $scope.CheckSelected(intervenant);
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
            }else{
                $http({
                    method: 'DELETE',
                    url: apiUrl + 'FormaCampAPI/SeancesIntervenants/'+JSON.stringify(data_seances),
                    headers: {'Content-Type': undefined}
                }).then(function (response) {
                    if(response.data == true){
                        const wrapper = '<p>Supprimée avec succès</p>';
                        Notification.warning({
                            message: wrapper,
                            delay: 2000,
                            positionY: 'bottom',
                            positionX: 'right'
                        });
                        $scope.CheckSelected(intervenant);
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
            }
    }
    $scope.CheckSelected = function (item){
        var seances = _.pluck(item.modules,'seances_intervenants').flat();
        $scope.liste_types_seances.forEach(function (type){
            var filtered = seances.filter(function (seance){
                return seance.ID_TYPE_SEANCE === type.ID_TYPE_SEANCE && moment(seance.DATE).isSameOrAfter(item.DEBUT) && moment(seance.DATE).isSameOrBefore(item.FIN);
            })
            var index = filtered.map(function (seance){
                return seance.SELECTED;
            }).indexOf(false)
            item['Selected-'+type.ID_TYPE_SEANCE] = !(index>-1);
        })

        for(let i=0;i<$scope.liste_types_seances.length;i++){
            item.AllSelected = false;
            if(!item['Selected-'+$scope.liste_types_seances[i].ID_TYPE_SEANCE]){
                break;
            }
            item.AllSelected = true;

        }
    }

    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
