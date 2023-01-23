app.controller('CrudAdminsController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */

    $scope.step = 1;
    let date = new Date();
    date.setHours(0);
    date.setMinutes(0);
    date.setSeconds(0);
    date.setMilliseconds(0);
    $scope.ins = {
        ID_ORGANISME:'',
        PHOTO:'',
        email:'',
        password:'',
        DATE:'',
        UPDATE_DATE:'',
        NOM:'',
        PRENOM:'',
        COULEUR_MARQUE:'',
        TELEPHONE:'',
        NUM_VOIE:'',
        ID_REPETITION:'0',
        ID_TYPE_VOIE:'0',
        LIBELLE_VOIE:'',
        ZIP:'',
        VILLE:'',
        PAYS:'',
        LIEU_SERVICE:'',
        ID_FUSEAU_HORAIRE:'0',
        REGLEMENT:0,
        DESCRIPTION:'',
        RESUME_CERTIF:'',
        HDM:date,
        HFM:date,
        HD:date,
        HF:date,
        FONCTION:0,
        NUM_DEC:'',
        REGION_ACQUISITON:'',
        NUM_DPC:'',
        ID_FORM_JURIDIQUE:'0',
        SIRET:'',
        CODE_APE_NAF:'',
        CAPITAL_SOCIAL:'',
        EXONERATION:0,
        MICRO_ENTREPRISE:0,
        FACTURATION:0,
        ID_MONNAIE:'0',
        SIGLE_TAXE:'',
        NUM_TVA:'',
        TAUX_TVA:'',
        DATE_CLOTURE_COMTBLE:'',
        CODE_JOURNAL:'',
        COMPTE_CLIENT:'',
        COMPTE_TVA:'',
        COMPTE_PRODUIT_BPF:'',
        COMPTE_PRODUIT_FORMATION:'',
        COMPTE_PRODUIT_CONSULTING:'',
        COMPTE_FRAIS_BPF:'',
        COMPTE_FRAIS_FORMATION:'',
        COMPTE_FRAIS_CONSULTING:'',
        COMPTE_OUTILS_BPF:'',
        COMPTE_OUTILS_FORMATION:'',
        COMPTE_OUTILS_CONSULTING:'',
        CODE_BANQUE:'',
        CODE_GUICHET:'',
        NUM_COMPTE_BANQUE:'',
        RIB:'',
        IBAN:'',
        BIC:''
    }
    function datainit(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Utilisateurs/'+($routeParams.id || $scope.ins.ID_USER),
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.ins =  response.data;
            $scope.ins.ID_ORGANISME =  response.data.ID_ORGANISME?response.data.ID_ORGANISME:'0';
            $scope.ins.ID_REPETITION =  response.data.ID_REPETITION?response.data.ID_REPETITION:'0';
            $scope.ins.ID_TYPE_VOIE =  response.data.ID_TYPE_VOIE?response.data.ID_TYPE_VOIE:'0';
            $scope.ins.ID_FUSEAU_HORAIRE =  response.data.ID_FUSEAU_HORAIRE?response.data.ID_FUSEAU_HORAIRE:'0';
            $scope.ins.ID_FORM_JURIDIQUE =  response.data.ID_FORM_JURIDIQUE?response.data.ID_FORM_JURIDIQUE:'0';
            $scope.ins.ID_MONNAIE =  response.data.ID_MONNAIE?response.data.ID_MONNAIE:'0';

            $scope.ins.HD = $scope.ins.HD != null ? moment($scope.ins.HD,"HH:mm:ss").toDate():date;
            $scope.ins.HDM = $scope.ins.HDM != null ? moment($scope.ins.HDM,"HH:mm:ss").toDate():date;
            $scope.ins.HF = $scope.ins.HF != null ? moment($scope.ins.HF,"HH:mm:ss").toDate():date;
            $scope.ins.HFM = $scope.ins.HFM != null ? moment($scope.ins.HFM,"HH:mm:ss").toDate():date;
            $scope.ins.DATE_CLOTURE_COMTBLE = $scope.ins.DATE_CLOTURE_COMTBLE!= null ? moment($scope.ins.DATE_CLOTURE_COMTBLE,'yyyy-MM-dd').toDate():date;
        });

    }


    if($routeParams.id != undefined){
        datainit();
    }

    new Inputmask({"mask": "(999) 9999-9999"}).mask($('#telephone'));
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
        });
    }
    function liste_indices(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Repetitions',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_indices = response.data;
        });
    }
    function liste_type_voie(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/TypeVoie',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_type_voie = response.data;
        });
    }
    function liste_form_juridique(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/FormJuridique',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_form_juridique = response.data;
        });
    }
    function liste_monnaie(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Monnaie',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_monnaie = response.data;
        });
    }
    function liste_fuseaux(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/FuseauxHoraire',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_fuseaux = response.data;
        });
    }
    liste_organismes();
    liste_indices();
    liste_type_voie();
    liste_form_juridique();
    liste_monnaie();
    liste_fuseaux()
    $scope.Save = function (){
        if(($scope.ins.email.length == 0) || ($scope.ins.password == undefined && ($routeParams.id == undefined || $scope.ins.ID_USER == undefined))){
            $scope.step = 1;
        }else{
            var form_data = new FormData();
            if($routeParams.id != undefined || $scope.ins.ID_USER != undefined){
                form_data.append('_method' , 'PUT')
                var api = 'FormaCampAPI/Utilisateurs/'+$scope.ins.ID_USER;
            }else{
                var api = 'FormaCampAPI/Utilisateurs';
            }
            Object.keys($scope.ins).forEach(function(k){
                if($scope.ins[k] != null){
                    form_data.append(k, $scope.ins[k]);
                }

            });
            if($scope.ins.DATE_CLOTURE_COMTBLE){
                form_data.set('DATE_CLOTURE_COMTBLE', moment($scope.ins.DATE_CLOTURE_COMTBLE).format('yyyy-MM')+'-01');
            }
            form_data.set('HD', moment($scope.ins.HD).format('HH:mm:ss'));
            form_data.set('HDM', moment($scope.ins.HDM).format('HH:mm:ss'));
            form_data.set('HF', moment($scope.ins.HF).format('HH:mm:ss'));
            form_data.set('HFM', moment($scope.ins.HFM).format('HH:mm:ss'));


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
                    $scope.ins.ID_USER = response.data.id;
                    datainit();
                    $location.path('GestionDonnees/Utilisateurs')
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
    $scope.ClickUpload = function(id){
        document.getElementById(id).click();
    };
    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
