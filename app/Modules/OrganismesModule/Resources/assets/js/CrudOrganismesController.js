app.controller('CrudOrganismesController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams){
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
        LOGO:'',
        DATE:'',
        UPDATE_DATE:'',
        NOM:'',
        ID_ENTREPRISE_LINKEDIN:'',
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
            url: apiUrl + 'FormaCampAPI/Organismes/'+($routeParams.id || $scope.ins.ID_ORGANISME),
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.ins =  response.data;
            $scope.ins.ID_REPETITION =  response.data.ID_REPETITION?response.data.ID_REPETITION:'0';
            $scope.ins.ID_TYPE_VOIE =  response.data.ID_TYPE_VOIE?response.data.ID_TYPE_VOIE:'0';
            $scope.ins.ID_FUSEAU_HORAIRE =  response.data.ID_FUSEAU_HORAIRE?response.data.ID_FUSEAU_HORAIRE:'0';
            $scope.ins.ID_FORM_JURIDIQUE =  response.data.ID_FORM_JURIDIQUE?response.data.ID_FORM_JURIDIQUE:'0';
            $scope.ins.ID_MONNAIE =  response.data.ID_MONNAIE?response.data.ID_MONNAIE:'0';

            $scope.ins.HD = $scope.ins.HD != null ? moment($scope.ins.HD,"HH:mm:ss").toDate():date;
            $scope.ins.HDM = $scope.ins.HDM != null ? moment($scope.ins.HDM,"HH:mm:ss").toDate():date;
            $scope.ins.HF = $scope.ins.HF != null ? moment($scope.ins.HF,"HH:mm:ss").toDate():date;
            $scope.ins.HFM = $scope.ins.HFM != null ? moment($scope.ins.HFM,"HH:mm:ss").toDate():date;
            pickr.setColor($scope.ins.COULEUR_MARQUE);

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

    const pickr = new Pickr({
        el: '.rui-colorpicker',
        container: 'body',
        theme: 'classic',
        closeOnScroll: false,
        appClass: 'custom-class',
        useAsButton: false,
        padding: 8,
        inline: false,
        autoReposition: true,
        sliders: 'v',
        disabled: false,
        lockOpacity: false,
        outputPrecision: 0,
        comparison: true,
        default: '#42445a',
        defaultRepresentation: 'HEX',
        showAlways: false,
        closeWithKey: 'Escape',
        position: 'bottom-middle',
        adjustableNumbers: true,
        swatches: [
            'rgba(244, 67, 54, 1)',
            'rgba(233, 30, 99, 0.95)',
            'rgba(156, 39, 176, 0.9)',
            'rgba(103, 58, 183, 0.85)',
            'rgba(63, 81, 181, 0.8)',
            'rgba(33, 150, 243, 0.75)',
            'rgba(3, 169, 244, 0.7)',
            'rgba(0, 188, 212, 0.7)',
            'rgba(0, 150, 136, 0.75)',
            'rgba(76, 175, 80, 0.8)',
            'rgba(139, 195, 74, 0.85)',
            'rgba(205, 220, 57, 0.9)',
            'rgba(255, 235, 59, 0.95)',
            'rgba(255, 193, 7, 1)'
        ],

        components: {
            preview: true,
            opacity: true,
            hue: true,

            interaction: {
                hex: true,
                rgba: true,
                hsva: true,
                input: true,
                clear: true,
                save: true
            }
        }
    });


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
    liste_indices();
    liste_type_voie();
    liste_form_juridique();
    liste_monnaie();
    liste_fuseaux()

    $scope.Save = function (){

            var form_data = new FormData();
            if($routeParams.id != undefined || $scope.ins.ID_ORGANISME != undefined){
                form_data.append('_method' , 'PUT')
                var api = 'FormaCampAPI/Organismes/'+$scope.ins.ID_ORGANISME;
            }else{
                var api = 'FormaCampAPI/Organismes';
            }
            Object.keys($scope.ins).forEach(function(k){
                if($scope.ins[k] != null){
                    form_data.append(k, $scope.ins[k]);
                }

            });
            form_data.set('DATE_CLOTURE_COMTBLE', moment($scope.ins.DATE_CLOTURE_COMTBLE).format('yyyy-MM')+'-01');
            form_data.set('HD', moment($scope.ins.HD).format('HH:mm:ss'));
            form_data.set('HDM', moment($scope.ins.HDM).format('HH:mm:ss'));
            form_data.set('HF', moment($scope.ins.HF).format('HH:mm:ss'));
            form_data.set('HFM', moment($scope.ins.HFM).format('HH:mm:ss'));
            form_data.set('COULEUR_MARQUE', pickr.getColor().toHEXA());

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
                    $scope.ins.ID_ORGANISME = response.data.id;
                    // logo.reset();
                    datainit();
                    $location.path('GestionDonnees/Organismes')
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
