app.controller('CrudSuiviApprenantsSessionsController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$uibModal,$routeParams,$timeout){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */
    $scope.data_limit = "10";
    $scope.infiniteLimit = 5;
    $scope.liste_data = [];
    $scope.selected_certif = [];
    $scope.selected_attest = [];
    $scope.methods = {
        "SendCertif": function (apprenant){
            return $scope.SendCertif(apprenant);
        },
        "DownloadCertif": function (apprenant){
            return $scope.DownloadCertif(apprenant);
        },
        "SendAttestation": function (apprenant){
            return $scope.SendAttestation(apprenant);
        },
        "DownloadAttestation": function (apprenant){
            return $scope.DownloadAttestation(apprenant);
        }
    }
    /**
     * data list function
     * */
    function data_list(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Apprenants/Session/'+$routeParams.session_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_data =  response.data;
            $scope.current_grid = 1;
            $scope.filter_data = $scope.data_limit;
            $scope.entire = $scope.liste_data.length;
        });
    }
    data_list();

    $scope.SendCertif = function (apprenant){
        $('#send-loading').css('display','block')
        var form_data = new FormData();
        form_data.append('ID_SESSION',$routeParams.session_id);
        form_data.append('ID_APPRENANT',apprenant.ID_APPRENANT);

        $http({
            method: 'POST',
            url: apiUrl + 'Certificat',
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

    $scope.DownloadCertif = function (apprenant){
        $window.open(apiUrl + 'Certificat/'+$routeParams.session_id+'/'+apprenant.ID_APPRENANT, '_blank')
    }

    $scope.SendAttestation = function (apprenant){
        $('#send-loading').css('display','block')
        var form_data = new FormData();

        form_data.append('ID_SESSION',$routeParams.session_id);
        form_data.append('ID_APPRENANT',apprenant.ID_APPRENANT);

        $http({
            method: 'POST',
            url: apiUrl + 'Attestation',
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

    $scope.DownloadAttestation = function (apprenant){
        $window.open(apiUrl + 'Attestation/'+$routeParams.session_id+'/'+apprenant.ID_APPRENANT, '_blank')
    }

    $scope.SendCertifMultiple = function (apprenants){
        $('#send-loading').css('display','block')
        var form_data = new FormData();
        form_data.append('ID_SESSION',$routeParams.session_id);
        form_data.append('apprenants',JSON.stringify(apprenants));

        $http({
            method: 'POST',
            url: apiUrl + 'Certificat',
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

    $scope.DownloadCertifMultiple = function (apprenants){
        $window.open(apiUrl + 'Certificat/'+$routeParams.session_id+'/'+apprenants, '_blank')
    }

    $scope.SendAttestationMultiple = function (apprenants){
        $('#send-loading').css('display','block')
        var form_data = new FormData();
        form_data.append('ID_SESSION',$routeParams.session_id);
        form_data.append('apprenants',JSON.stringify(apprenants));

        $http({
            method: 'POST',
            url: apiUrl + 'Attestation',
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

    $scope.DownloadAttestationMultiple = function (apprenants){
        $window.open(apiUrl + 'Attestation/'+$routeParams.session_id+'/'+apprenants, '_blank')
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


    $scope.isChecked = function(selected) {
        return selected.length === $scope.liste_data.length;
    };

    $scope.toggleAllCertif = function(list) {
        var data = _.pluck(list,'ID_APPRENANT');
        if ($scope.selected_certif.length === data.length) {
            $scope.selected_certif = [];
        } else {
            $scope.selected_certif = data.slice(0);
        }
    };
    $scope.toggleAllAttest = function(list) {
        var data = _.pluck(list,'ID_APPRENANT');
        if ($scope.selected_attest.length === data.length) {
            $scope.selected_attest = [];
        } else {
            $scope.selected_attest = data.slice(0);
        }
    };

$timeout(function () {
    $(function(){
        $('svg.radial-progress').each(function( index, value ) {
            $(this).find($('circle.complete')).removeAttr( 'style' );
            percent = $(value).data('percentage');
            radius = $(this).find($('circle.complete')).attr('r');
            circumference = 2 * Math.PI * radius;
            strokeDashOffset = circumference - ((percent * circumference) / 100);
            $(this).find($('circle.complete')).animate({'stroke-dashoffset': strokeDashOffset}, 1250);
        });
    });
},1000)
    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
