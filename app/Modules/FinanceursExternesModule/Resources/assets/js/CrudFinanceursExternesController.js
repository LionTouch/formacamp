app.controller('CrudFinanceursExternesController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */

    $scope.step = 1;


    $scope.ins = {
        ID_ORGANISME:'',
        NOM:'',
        ADRESSE:'',
        ZIP:'',
        VILLE:'',
        PAYS:'',
        TELEPHONE:'',
        FAX:'',
        ID_TYPE_FINANCEUR:1,
        EMAIL:'',
        CODE_INTERNE:'',
        SIRET:'',
        ID_LANGUE:1,
        NOTE:'',
        NUM_COMPTE_CLIENT:''

    }

    function datainit(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/FinanceursExternes/'+($routeParams.id || $scope.ins.ID_FINANCEUR),
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.ins =  response.data;
            $scope.ins.ID_LANGUE =  response.data.ID_LANGUE?response.data.ID_LANGUE:1;
            $scope.ins.ID_TYPE_FINANCEUR =  response.data.ID_TYPE_FINANCEUR?response.data.ID_TYPE_FINANCEUR:1;
            $scope.ins.ID_ORGANISME =  response.data.ID_ORGANISME?response.data.ID_ORGANISME:'0';

        });
    }
    if($routeParams.id != undefined){
        datainit()

    }

    new Inputmask({"mask": "(999) 9999-9999"}).mask($('#telephone'));
    new Inputmask({"mask": "(999) 9999-9999"}).mask($('#fax'));
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
    function liste_type_financeurs(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/TypeFinanceur',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_type_financeurs = response.data;

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



    liste_organismes();
    liste_type_financeurs();
    liste_langues();

    $scope.Save = function (){
        var form_data = new FormData();
        if($routeParams.id != undefined || $scope.ins.ID_FINANCEUR != undefined){
            form_data.append('_method' , 'PUT');
            var api = 'FormaCampAPI/FinanceursExternes/'+$scope.ins.ID_FINANCEUR;
        }else{
            var api = 'FormaCampAPI/FinanceursExternes';
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
                $scope.ins.ID_FINANCEUR = response.data.id;
                datainit();
                $location.path('GestionDonnees/FinanceursExternes')
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
