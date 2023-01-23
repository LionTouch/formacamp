app.controller('CrudFormateursController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */

    $scope.step = 1;
    $scope.ins = {
        ID_ORGANISME: '',
        NOM: '',
        PRENOM: '',
        CIVILITE: 1,
        EMAIL: '',
        CODE_INTERNE: '',
        NATIONALITE: '',
        NOM_NAISS: '',
        VILLE_NAISS: '',
        DATE_NAISS: null,
        ID_LANGUE: 1,
        DEPARTEMENT_NAISS: '',
        ADRESSE: '',
        ZIP: '',
        VILLE: '',
        PAYS: '',
        TELEPHONE: '',
        NUM_SEC_SOCIALE: '',
        NUM_DECLARATION: '',
        NUM_SIRET: '',
        NUM_ASSURANCE: '',
        STATUT: 1,
        TARIF: '0',
        ID_TYPE_TARIF: 1,
        TVA: '',
        NUM_COMPTE: '',
        BIO: '',
        DIPLOMES: '',
        NOTE: '',
        ID_CLIENT: '0',
        NOTE_COMPETENCES: '',
        COMPETENCES: ''
    }


    function datainit(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Formateurs/'+($routeParams.id || $scope.ins.ID_FORMATEUR),
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.ins =  response.data;
            $scope.ins.ID_ORGANISME =  response.data.ID_ORGANISME?response.data.ID_ORGANISME:'0';
            $scope.ins.CIVILITE =  response.data.CIVILITE?response.data.CIVILITE:'0';
            $scope.ins.ID_CLIENT =  response.data.ID_CLIENT?response.data.ID_CLIENT:'0';
            $scope.ins.DATE_NAISS = $scope.ins.DATE_NAISS!= null ? moment($scope.ins.DATE_NAISS,'yyyy-MM-DD').toDate():null;

        });

    }
    if($routeParams.id != undefined){
       datainit();
    }

    new Inputmask({"mask": "(999) 9999-9999"}).mask($('#telephone'));
    new Inputmask("decimal", { rightAlign: false }).mask($('#tarif'));
    new Inputmask("decimal", { rightAlign: false }).mask($('#tva'));

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
            url: apiUrl + 'FormaCampAPI/StatutsFormateurs',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_statuts = response.data;
        });
    }
    function liste_type_tarif(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/TypeTarif',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_type_tarif = response.data;
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

    liste_organismes();
    liste_statuts();
    liste_clients();
    liste_civilite();
    liste_langues();
    liste_type_tarif();

    $scope.Save = function (){
        if(($scope.ins.email.length == 0) || ($scope.ins.password == undefined && ($routeParams.id == undefined || $scope.ins.ID_FORMATEUR == undefined))){
            $scope.step = 1;
        }else {
            var form_data = new FormData();
            if ($routeParams.id != undefined || $scope.ins.ID_FORMATEUR != undefined) {
                form_data.append('_method', 'PUT')
                var api = 'FormaCampAPI/Formateurs/' + $scope.ins.ID_FORMATEUR;
            } else {
                var api = 'FormaCampAPI/Formateurs';
            }
            Object.keys($scope.ins).forEach(function (k) {
                if ($scope.ins[k] != null) {
                    form_data.append(k, $scope.ins[k]);
                }

            });
            if ($scope.ins.DATE_NAISS != null) {
                form_data.set('DATE_NAISS', moment($scope.ins.DATE_NAISS).format('yyyy-MM-DD'));
            }


            $http({
                method: 'POST',
                url: apiUrl + api,
                data: form_data,
                headers: {"Content-Type": undefined},
            }).then(function (response) {
                if (response.data.result == true) {
                    const wrapper = '<p>Enregistré avec succès</p>';
                    Notification.success({
                        message: wrapper,
                        delay: 2000,
                        positionY: 'bottom',
                        positionX: 'right'
                    });
                    $scope.ins.ID_FORMATEUR = response.data.id;
                    datainit();
                    $location.path('GestionDonnees/Formateurs')
                } else {
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


    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
