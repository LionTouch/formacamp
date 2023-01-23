app.controller('CrudStagiairesController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */

    $scope.step = 1;

    $scope.ins = {
        ID_ORGANISME:'',
        CIVILITE:'0',
        NOM:'',
        PRENOM:'',
        ADRESSE:'',
        ZIP:'',
        VILLE:'',
        PAYS:'',
        TELEPHONE:'',
        TELEPHONE_2:'',
        CODE:'',
        NATIONALITE:'',
        NOM_NAISS:'',
        VILLE_NAISS:'',
        REGION_NAISS:'',
        DATE_NAISS:null,
        PHOTO:'',
        STATUT:'0',
        ID_CLIENT:'0',
        FONCTION:'',
        NOTES:'',
        MENTION:'',
        NUM_COMPTE_CLIENT:'',
        NUM_COMPTE_TVA:'',
        NUM_SEC:'',
        CATEG_SOC:'',
        NATURE_CONTRAT_TRAV:'',
        SALAIRE_HORAIRE_BRUT:'',
        HANDICAP:0,
        ID_LANGUE:'0',
        EMAIL:'',

    }
    function datainit(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Stagiaires/'+($routeParams.id || $scope.ins.ID_STAGIAIRE),
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.ins =  response.data;
            $scope.ins.ID_ORGANISME =  response.data.ID_ORGANISME?response.data.ID_ORGANISME:'0';
            $scope.ins.CIVILITE =  response.data.CIVILITE?response.data.CIVILITE:'0';
            $scope.ins.STATUT =  response.data.STATUT?response.data.STATUT:'0';
            $scope.ins.ID_CLIENT =  response.data.ID_CLIENT?response.data.ID_CLIENT:'0';
            $scope.ins.ID_LANGUE =  response.data.ID_LANGUE?response.data.ID_LANGUE:'0';
            $scope.ins.DATE_NAISS =  response.data.DATE_NAISS?moment(response.data.DATE_NAISS).toDate():null;

        });
    }

    if($routeParams.id != undefined){
        datainit();
    }

    new Inputmask({"mask": "(999) 9999-9999"}).mask($('#telephone'));
    new Inputmask({"mask": "(999) 9999-9999"}).mask($('#telephone2'));
    new Inputmask("decimal", { rightAlign: false }).mask($('#salaire'));
    // new Inputmask({"mask": "9999.99"}, { numericInput: true }).mask($('#salaire'));
    $scope.GoToStep = function (step){
        $scope.step = step;
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
    function liste_statuts(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Statuts',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_statuts = response.data;
        });
    }

    function liste_entreprises(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Clients',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_entreprises = response.data;
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
    function liste_civilite(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Civilites',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_civilites = response.data;
        });
    }
    function liste_clients(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Clients',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_clients = response.data;
        });
    }

    liste_organismes();
    liste_statuts();
    liste_entreprises();
    liste_civilite();
    liste_langues();
    liste_clients();

    $scope.Save = function (){
        var form_data = new FormData();
        if($routeParams.id != undefined || $scope.ins.ID_STAGIAIRE != undefined){
            form_data.append('_method' , 'PUT')
            var api = 'FormaCampAPI/Stagiaires/'+$scope.ins.ID_STAGIAIRE;
        }else{
            var api = 'FormaCampAPI/Stagiaires';
        }
        Object.keys($scope.ins).forEach(function(k){
            if($scope.ins[k] != null){
                form_data.append(k, $scope.ins[k]);
            }

        });
        if($scope.ins.DATE_NAISS != null){
            form_data.set('DATE_NAISS', moment($scope.ins.DATE_NAISS).format('YYYY-MM-DD'));
        }


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
                $scope.ins.ID_STAGIAIRE = response.data.id;
                datainit();
                $location.path('GestionDonnees/Stagiaires')
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
    $scope.ClickUpload = function(id){
        document.getElementById(id).click();
    };
    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
