app.controller('CrudSallesController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams){
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
    if($routeParams.id != undefined){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Utilisateurs/'+$routeParams.id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.ins =  response.data;
        });

    }

    $scope.GoToStep = function (step,e){
        $('.tabs').removeClass('active');
        $(e.currentTarget).addClass('active');
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

    liste_organismes();

    $scope.Save = function (){
        if(($scope.ins.email.length == 0) || ($scope.ins.password == undefined && $routeParams.id == undefined)){
            $('.nav-user').removeClass('active')
            $scope.step = 1;
        }else{
            var form_data = new FormData();
            if($routeParams.id != undefined){
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
            form_data.set('ID_ORGANISME', $scope.ins.ID_ORGANISME);
            form_data.set('HD', moment($scope.ins.HD).format('HH:mm:ss'));
            form_data.set('HDM', moment($scope.ins.HDM).format('HH:mm:ss'));
            form_data.set('HF', moment($scope.ins.HF).format('HH:mm:ss'));
            form_data.set('HFM', moment($scope.ins.HFM).format('HH:mm:ss'));

            if(photo.getFiles().length>0){
                form_data.append('PHOTO',  photo.getFiles()[0].data);
            }

            if(certif.getFiles().length>0){
                var i =0;
                certif.getFiles().forEach(function (value){
                    if(!value.meta.ID_CERTIF){
                        form_data.append('REF'+i,  value.data);
                        form_data.append('TITRE'+i,  value.data.meta.name);
                    }
                    i++;
                })

            }

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

    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
