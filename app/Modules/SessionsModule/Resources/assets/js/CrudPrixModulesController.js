app.controller('CrudPrixModulesController',function($scope,$http,apiUrl,CurrentUser,Notification,$rootScope){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */

    $scope.PrixModule = 1;
    $scope.ins = {};
    $scope.module = {};
    $scope.liste_gestionnaires = [];
    $scope.$watch('gestionnaires', function(gestionnaires) {
        $scope.liste_gestionnaires = gestionnaires;
    })
    $scope.$watch('data', function(module) {
        if(module !== undefined){
            $scope.module = module;
            $scope.$watch('types_prix', function(types_prix) {
                if(types_prix !== undefined){
                    $scope.$watch('tarifs_prix', function(tarifs_prix) {
                        if(tarifs_prix !== undefined){
                            let prix = module.prix.filter(function (p){
                                return p.ID_TYPE_PRIX === 1;
                            })[0]

                            $scope.ins = {
                                ID_PRIX:prix ? prix.ID_PRIX : undefined,
                                ID_MODULE:module.ID_MODULE,
                                NOM:prix ? prix.NOM : '',
                                ID_TYPE_PRIX:prix ? prix.ID_TYPE_PRIX : 1,
                                ID_TARIF:prix ? prix.ID_TARIF : 1,
                                PRIX:prix ? prix.PRIX : 0,
                                TVA:prix ? prix.TVA : 0
                            }
                            $scope.ShowDelete = $scope.ins.ID_PRIX !== undefined;

                        }
                    });
                }
            });
        }
    });

    $scope.ChangePrixModule = function (id,module,e){

        $(e.currentTarget).closest('.nav-link').removeClass('active');
        $(e.currentTarget).addClass('active');
        $scope.PrixModule = id;
        let prix = module.prix.filter(function (p){
            return p.ID_TYPE_PRIX === id;
        })[0]

        $scope.ins = {
            ID_PRIX:prix ? prix.ID_PRIX : undefined,
            ID_MODULE:module.ID_MODULE,
            NOM:prix ? prix.NOM : '',
            ID_TYPE_PRIX:id,
            ID_TARIF:prix ? prix.ID_TARIF : 1,
            PRIX:prix ? prix.PRIX : 0,
            TVA:prix ? prix.TVA : 0
        }

        $scope.ShowDelete = $scope.ins.ID_PRIX !== undefined;

    }



    $scope.Save = function (){
        let form_data = new FormData();
        let api;
        if($scope.ins.ID_PRIX !== undefined){
            form_data.append('_method' , 'PUT')
             api = 'FormaCampAPI/PrixModules/'+$scope.ins.ID_PRIX;
        }else{
             api = 'FormaCampAPI/PrixModules';
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
            if(response.data === true){
                $scope.ShowDelete = true;
                $http({
                    method: 'GET',
                    url: apiUrl + 'FormaCampAPI/PrixModules/Module/'+$scope.ins.ID_MODULE,
                    headers: {"Content-Type": undefined },
                }).then(function (response) {
                    $scope.module.prix = response.data;

                    let prix = response.data.filter(function (p){
                        return p.ID_TYPE_PRIX === $scope.PrixModule;
                    })[0]

                    $scope.ins = {
                        ID_PRIX:prix.ID_PRIX,
                        ID_MODULE:module.ID_MODULE,
                        NOM:prix.NOM,
                        ID_TYPE_PRIX:$scope.PrixModule,
                        ID_TARIF:prix.ID_TARIF,
                        PRIX:prix.PRIX,
                        TVA:prix.TVA
                    }

                });
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

    $scope.Delete = function (module){

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
                    url: apiUrl + 'FormaCampAPI/PrixModules/'+$scope.ins.ID_PRIX,
                    headers: {'Content-Type': undefined}
                }).then(function (response) {
                    if(response.data){
                        $http({
                            method: 'GET',
                            url: apiUrl + 'FormaCampAPI/PrixModules/Module/'+$scope.ins.ID_MODULE,
                            headers: {"Content-Type": undefined },
                        }).then(function (response) {
                            $scope.module.prix = response.data;
                        });
                        $scope.ShowDelete = false;
                        $scope.ins = {
                            ID_PRIX: undefined,
                            ID_MODULE:module.ID_MODULE,
                            NOM: '',
                            ID_TYPE_PRIX:$scope.PrixModule,
                            ID_TARIF:1,
                            PRIX:0,
                            TVA:0
                        }
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
