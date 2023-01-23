app.controller('ListeSessionsController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$uibModal,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */
    $scope.data_limit = "10";
    $scope.infiniteLimit1 = 5;
    $scope.infiniteLimit2 = 5;
    $scope.infiniteLimit3 = 5;
    $scope.infiniteLimit4 = 5;
    $scope.liste_data = [];
    $scope.searchType = '';

    /**
     * data list function
     * */
    function data_list(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Sessions',
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_data =  response.data;
            $scope.current_grid = 1;
            $scope.filter_data = $scope.data_limit;
            $scope.entire = $scope.liste_data.length;
        });
    }


    data_list();


    $scope.loadMore = function(data,limit) {
        if(data.length > limit){
            limit += 5;
        }
    }, 1000;
    $scope.folderMethodes = {
        'Gerer' : function(id){
            $scope.Gerer(id)
        },
        'Evaluer' : function(id){
            $scope.Evaluer(id)
        },
        'Edit' : function(id){
            $scope.Edit(id)
        },
        'Delete' : function(id){
            $scope.Delete(id)
        },
        'Devis' : function(id){
            $scope.Devis(id)
        },
        'SendDevis' : function(session){
            $scope.SendDevis(session)
        },
        'Contrat' : function(id){
            $scope.Contrat(id)
        },
        'SendContrat' : function(session){
            $scope.SendContrat(session)
        },
        'Suivi' : function(id){
            $scope.Suivi(id)
        },
        'Emargement' : function(id){
            $scope.Emargement(id)
        }
    }
    $scope.Filter = function (type,e){
        $('.searchFilter').removeClass('active');
        if (type == $scope.searchType){
            $scope.searchType = '';

        }else{
            $(e.currentTarget).addClass('active');
            $scope.searchType = type;
        }
    }
    /**
     * Photo input click
     * */
    $scope.Photo = function(id){
        document.getElementById(id).click()
    }

    $scope.GoTo = function (path){
        $location.path(path);
    }




    $scope.Gerer = function (id){
        $location.path('Sessions/'+id+'/Modules');
    }
    $scope.Evaluer = function (id){
        $location.path('Sessions/'+id+'/Evaluations');
    }
    $scope.Edit = function (id) {
        $location.path('Sessions/'+id)
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
                    url: apiUrl + 'FormaCampAPI/Sessions/'+id,
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


    $scope.Suivi = function (id) {
        $location.path('Sessions/'+id+'/Suivi');
    }
    $scope.Emargement = function (id) {
        $location.path('Sessions/'+id+'/Emargement');
    }
    $scope.Devis = function (id) {
        $window.open(apiUrl + 'Devis/'+id, '_blank');
    }
    $scope.SendDevis = function (session) {
        if(session.EMAIL_CLIENT){
            $('#send-loading').css('display','block')
            var form_data = new FormData();
            form_data.append('ID_SESSION',session.ID_SESSION);
            form_data.append('EMAIL',session.EMAIL_CLIENT);

            $http({
                method: 'POST',
                url: apiUrl + 'Devis',
                data:form_data,
                headers: {"Content-Type": undefined },
            }).then(function (response) {
                if(response.data == true){
                    const wrapper = '<p>Envoyé avec succès</p>';
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
                $('#send-loading').css('display','none')
            });
        }else{
            const wrapper = '<p>Veuillez verifier email client!</p>';
                Notification.warning({
                    message: wrapper,
                    delay: 2000,
                    positionY: 'bottom',
                    positionX: 'right'
                });
        }
    }
    $scope.Contrat = function (id) {
        $window.open(apiUrl + 'Contrat/'+id, '_blank');
    }
    $scope.SendContrat = function (session) {
        if(session.EMAIL_CLIENT){
            $('#send-loading').css('display','block')
            var form_data = new FormData();
            form_data.append('ID_SESSION',session.ID_SESSION);
            form_data.append('EMAIL',session.EMAIL_CLIENT);

            $http({
                method: 'POST',
                url: apiUrl + 'Contrat',
                data:form_data,
                headers: {"Content-Type": undefined },
            }).then(function (response) {
                if(response.data == true){
                    const wrapper = '<p>Envoyé avec succès</p>';
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
                $('#send-loading').css('display','none')
            });
        }else{
            const wrapper = '<p>Veuillez verifier email client!</p>';
                Notification.warning({
                    message: wrapper,
                    delay: 2000,
                    positionY: 'bottom',
                    positionX: 'right'
                });
        }

    }
    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
