app.controller('CrudSuiviPController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */

    $scope.ins = {
        ID_SUIVI:'',
        TITRE:'',
        ID_FORMATEUR:'0',
        SITUATION:'0',
        DISPOSITIF:'0',
        LIGNE_PRODUIT:'0',
        LIGNE_STAGIAIRE:'0',
        NBR_STAGIAIRE:'0'
    }
    $scope.insFinanceurs = {
        ID_SUIVI_FINANCEURS:'',
        ID_SUIVI:'',
        ID_FINANCEUR:'0',
        MONTANT:'0',
        REF_ACCORD:'0',
        SUBROGATION:'0',
        DEV_ENTREPRISE:'0',
        COMPTE_FORMATION:'0',
        CPF_TRANSITION:'0',
        CONGE_INDIV:'0',
        CONTRAT_PROF:'0',
        PERIODE_PROF:'0',
        CODE_CPF:'',
        DUREE:''

    }

    if($routeParams.id != undefined){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Suivi/'+$routeParams.id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.ins =  response.data;
            $scope.insFinanceurs = {
                ID_SUIVI_FINANCEURS:response.data.financeurs[0].ID_SUIVI_FINANCEURS,
                ID_SUIVI:response.data.financeurs[0].ID_SUIVI,
                ID_FINANCEUR:response.data.financeurs[0].ID_FINANCEUR,
                MONTANT:response.data.financeurs[0].MONTANT,
                REF_ACCORD:response.data.financeurs[0].REF_ACCORD,
                SUBROGATION:response.data.financeurs[0].SUBROGATION,
                DEV_ENTREPRISE:response.data.financeurs[0].DEV_ENTREPRISE,
                COMPTE_FORMATION:response.data.financeurs[0].COMPTE_FORMATION,
                CPF_TRANSITION:response.data.financeurs[0].CPF_TRANSITION,
                CONGE_INDIV:response.data.financeurs[0].CONGE_INDIV,
                CONTRAT_PROF:response.data.financeurs[0].CONTRAT_PROF,
                PERIODE_PROF:response.data.financeurs[0].PERIODE_PROF,
                CODE_CPF:response.data.financeurs[0].CODE_CPF,
                DUREE:response.data.financeurs[0].DUREE,

            }

        });

    }

    new Inputmask("decimal", { rightAlign: false }).mask($('#montant'));
    new Inputmask("integer", { rightAlign: false }).mask($('#nbr_stagiaire'));
    new Inputmask("decimal", { rightAlign: false }).mask($('#duree'));

    function liste_formateurs(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Formateurs',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_formateurs = response.data;
        });
    }
    function liste_financeurs(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/FinanceursExternes',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_financeurs = response.data;
        });
    }
    liste_formateurs();
    liste_financeurs();

    $scope.Save = function (){
        var form_data = new FormData();
        if($routeParams.id != undefined){
            form_data.append('_method' , 'PUT')
            var api = 'FormaCampAPI/Suivi/'+$scope.ins.ID_SUIVI;
        }else{
            var api = 'FormaCampAPI/Suivi';
        }
        form_data.set('ID_SUIVI', $scope.ins.ID_SUIVI);
        form_data.set('TITRE', $scope.ins.TITRE);
        form_data.set('ID_FORMATEUR', $scope.ins.ID_FORMATEUR);
        form_data.set('SITUATION', $scope.ins.SITUATION);
        form_data.set('DISPOSITIF', $scope.ins.DISPOSITIF);
        form_data.set('LIGNE_PRODUIT', $scope.ins.LIGNE_PRODUIT);
        form_data.set('LIGNE_STAGIAIRE', $scope.ins.LIGNE_STAGIAIRE);
        form_data.set('NBR_STAGIAIRE', $scope.ins.NBR_STAGIAIRE);

        form_data.set('ID_SUIVI', $scope.insFinanceurs.ID_SUIVI);
        form_data.set('ID_FINANCEUR', $scope.insFinanceurs.ID_FINANCEUR);
        form_data.set('MONTANT', $scope.insFinanceurs.MONTANT);
        form_data.set('SUBROGATION', $scope.insFinanceurs.SUBROGATION);
        form_data.set('REF_ACCORD', $scope.insFinanceurs.REF_ACCORD);
        form_data.set('DEV_ENTREPRISE', $scope.insFinanceurs.DEV_ENTREPRISE);
        form_data.set('COMPTE_FORMATION', $scope.insFinanceurs.COMPTE_FORMATION);
        form_data.set('CPF_TRANSITION', $scope.insFinanceurs.CPF_TRANSITION);
        form_data.set('CONGE_INDIV', $scope.insFinanceurs.CONGE_INDIV);
        form_data.set('CONTRAT_PROF', $scope.insFinanceurs.CONTRAT_PROF);
        form_data.set('PERIODE_PROF', $scope.insFinanceurs.PERIODE_PROF);
        form_data.set('CODE_CPF', $scope.insFinanceurs.CODE_CPF);
        form_data.set('DUREE', $scope.insFinanceurs.DUREE);

        $http({
            method: 'POST',
            url: apiUrl + api,
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
                $location.path('SuiviCommercial/Suivi')
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
