app.controller('CrudEmargementSessionsController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$uibModal,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */
    $scope.liste_emargements = [];
    $scope.liste_intervenants = [];
    $scope.liste_apprenants = [];
    $scope.liste_modules = [];
    $scope.selected = [];
    /**
     * data list function
     * */
    function liste_intervenants(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Intervenants/Session/'+$routeParams.session_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_intervenants =  response.data;
        });
    }
    function liste_apprenants(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Apprenants/Session/'+$routeParams.session_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_apprenants =  response.data;
        });
    }
    function liste_modules(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Modules/Session/'+$routeParams.session_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_modules =  response.data;
        });
    }

    liste_intervenants();
    liste_apprenants();
    liste_modules();
    $scope.Exist = function (intervenants,id){
        var data = _.pluck(intervenants, 'ID_INTERVENANT');
        return data.includes(id);
    }
    $scope.SelectAll = function (){
        if($scope.liste_emargements.length === $scope.liste_apprenants.length){
            $scope.liste_emargements = [];
        }else{
            $scope.liste_emargements = _.pluck($scope.liste_apprenants, 'ID_APPRENANT');
        }

    }
    $scope.Download = function (ids){
        $window.open(apiUrl + 'Emargement/'+$routeParams.session_id+'/'+ids, '_blank')
    }
    $scope.Send = function (ids){
        $('#send-loading').css('display','block')
        var form_data = new FormData();
        form_data.append('ID_SESSION',$routeParams.session_id);
        form_data.append('apprenants',ids);

        $http({
            method: 'POST',
            url: apiUrl + 'Emargement',
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
    }
    $scope.InterPresent = function (seances,id){
        var data = _.pluck(seances, 'ID_INTERVENANT');
        return data.includes(id);
    }
    $scope.ApprePresent = function (seances,id){
        var data = _.pluck(seances, 'ID_APPRENANT');
        return data.includes(id);
    }
    $scope.CheckApprenant = function (emargements,id_seance,id){

        var data = _.pluck(emargements, 'ID_APPRENANT');
        if(data.includes(id)){
            $http({
                method: 'DELETE',
                url: apiUrl + 'FormaCampAPI/EmargementApprenants/'+id_seance+'/'+id,
                headers: {"Content-Type": undefined },
            }).then(function (response) {
                if(response.data == true){
                    const wrapper = '<p>Supprimé avec succès</p>';
                    Notification.warning({
                        message: wrapper,
                        delay: 2000,
                        positionY: 'bottom',
                        positionX: 'right'
                    });
                    var index = emargements.map(function(e) { return e.ID_APPRENANT; }).indexOf(id);
                    emargements.splice(index,1)
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
            var form_data = new FormData();
            form_data.append('ID_SEANCE',id_seance);
            form_data.append('ID_APPRENANT',id);
            $http({
                method: 'POST',
                url: apiUrl + 'FormaCampAPI/EmargementApprenants',
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
                    emargements.push({'ID_SEANCE':id_seance,'ID_APPRENANT':id});
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

    }
    $scope.CheckIntervenant = function (emargements,id_seance,id){
        var data = _.pluck(emargements, 'ID_INTERVENANT');
        if(data.includes(id)){
            $http({
                method: 'DELETE',
                url: apiUrl + 'FormaCampAPI/EmargementIntervenants/'+id_seance+'/'+id,
                data:form_data,
                headers: {"Content-Type": undefined },
            }).then(function (response) {
                if(response.data == true){
                    const wrapper = '<p>Supprimé avec succès</p>';
                    Notification.warning({
                        message: wrapper,
                        delay: 2000,
                        positionY: 'bottom',
                        positionX: 'right'
                    });
                    var index = emargements.map(function(e) { return e.ID_INTERVENANT; }).indexOf(id);
                    emargements.splice(index,1)
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
            var form_data = new FormData();
            form_data.append('ID_SEANCE',id_seance);
            form_data.append('ID_INTERVENANT',id);
            $http({
                method: 'POST',
                url: apiUrl + 'FormaCampAPI/EmargementIntervenants',
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
                    emargements.push({'ID_SEANCE':id_seance,'ID_INTERVENANT':id});
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

    }


    $scope.toggle = function (item, list) {
        var idx = list.indexOf(item);
        if (idx > -1) {
            list.splice(idx, 1);
        }
        else {
            list.push(item);
        }
    };

    $scope.exists = function (item, list) {
        return list.indexOf(item) > -1;
    };


    $scope.isChecked = function() {
        return $scope.selected.length === $scope.liste_apprenants.length;
    };

    $scope.toggleAll = function(list) {
        var data = _.pluck(list,'ID_APPRENANT');
        if ($scope.selected.length === data.length) {
            $scope.selected = [];
        } else if ($scope.selected.length === 0 || $scope.selected.length > 0) {
            $scope.selected = data.slice(0);
        }
    };
    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
