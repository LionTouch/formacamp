app.controller('CrudClientsController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */

    $scope.step = 1;

    $scope.ins = {
        ID_ORGANISME:'',
        ID_TYPE_CLIENT:'',
        NOM:'',
        GROUPE:'',
        CODE_INTERNE:'',
        ADRESSE:'',
        ZIP:'',
        VILLE:'',
        PAYS:'',
        EMAIL:'',
        TELEPHONE:'',
        SITE:'',
        NUM_TVA:'',
        NUM_SIRET:'',
        CODE_APE:'',
        ID_LANGUE:1,
        ETAT:'',
        NOTE:'',
        NUM_COMPTE_CLIENT:'',
        NUM_COMPTE_TVA:'',
        OPCO:'',
        NUM_OPCO:'',
        EFFECTIF:'',
        IDCC:'',
        NACE:''

    }

    function datainit(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Clients/'+($routeParams.id || $scope.ins.ID_CLIENT),
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.ins =  response.data;
            $scope.ins.CIVILITE =  response.data.CIVILITE?response.data.CIVILITE:'0';
            $scope.ins.ID_CLIENT =  response.data.ID_CLIENT?response.data.ID_CLIENT:'0';
            $scope.ins.ID_ORGANISME =  response.data.ID_ORGANISME?response.data.ID_ORGANISME:'0';
            $scope.ins.ID_TYPE_CLIENT =  response.data.ID_TYPE_CLIENT?response.data.ID_TYPE_CLIENT:'1';
        });
    }

    if($routeParams.id != undefined){
       datainit();
    }

    new Inputmask({"mask": "(999) 9999-9999"}).mask($('#telephone'));
    new Inputmask("decimal", { rightAlign: false }).mask($('#effectif'));
    $scope.GoToStep = function (step){
        $scope.step = step;
    }

    function liste_clients_type(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/ClientsType',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_clients_type = response.data;
            if(response.data.length>0 && $routeParams.id == undefined){
                $scope.ins.ID_TYPE_CLIENT = response.data[0].ID_TYPE_CLIENT;
            }
        });
    }
    function liste_organismes(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Organismes',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_organismes = response.data;
            if(response.data.length>0 && $routeParams.id == undefined){
                $scope.ins.ID_ORGANISME = response.data[0].ID_ORGANISME;
            }

        });
    }
    function liste_langues(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Langues',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_langues = response.data;
        });
    }

    liste_langues();
    liste_organismes();
    liste_clients_type();

    $scope.Save = function (){
        var form_data = new FormData();
        if($routeParams.id != undefined || $scope.ins.ID_CLIENT != undefined){
            form_data.append('_method' , 'PUT')
            var api = 'FormaCampAPI/Clients/'+$scope.ins.ID_CLIENT;
        }else{
            var api = 'FormaCampAPI/Clients';
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
            if(response.data.result == true){
                const wrapper = '<p>Enregistré avec succès</p>';
                Notification.success({
                    message: wrapper,
                    delay: 2000,
                    positionY: 'bottom',
                    positionX: 'right'
                });
                $scope.ins.ID_CLIENT = response.data.id;
                datainit();
                $location.path('GestionDonnees/Clients')
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
