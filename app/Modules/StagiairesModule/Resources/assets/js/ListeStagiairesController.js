app.controller('ListeStagiairesController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */

    /**
     * VAR data table (limit data..)
     * */
    $scope.data_limit = "10";
    $scope.infiniteLimit = 5;
    $scope.liste_data = [];
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
    /**
     * data list function
     * */
    function data_list(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Stagiaires',
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_data =  response.data;
            $scope.current_grid = 1;
            $scope.filter_data = $scope.data_limit;
            $scope.entire = $scope.liste_data.length;
        });
    }
    data_list();

    /**
     * Photo input click
     * */
    $scope.Photo = function(id){
        document.getElementById(id).click()
    }

    $scope.GoTo = function (path){
        $location.path(path);
    }
    $scope.Edit = function (id){
        $location.path('GestionDonnees/ModifStagiaires/'+id);
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
                    url: apiUrl + 'FormaCampAPI/Stagiaires/'+id,
                    headers: {'Content-Type': undefined}
                }).then(function (response) {
                    if(response.data == true){
                        data_list();
                        const wrapper = '<p>Supprimé avec succès</p>';
                        Notification.success({
                            message: wrapper,
                            delay: 2000,
                            positionY: 'bottom',
                            positionX: 'left'
                        });
                    }else{
                        const wrapper = '<p>Erreur</p>';
                        Notification.error({
                            message: wrapper,
                            delay: 2000,
                            positionY: 'bottom',
                            positionX: 'left'
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
