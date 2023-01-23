app.controller('CrudLieuxFormationController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */

    $scope.step = 1;

    $scope.ins = {
        NOM:'',
        DESCRIPTION:'',
        EQUIPEMENT:'',
        CAPACITE:'',
        PRIX_DEMI:'',
        PRIX_JOURNEE:'',
        NUM_VOIE:'',
        ID_REPETITION:'0',
        ID_TYPE_VOIE:'0',
        LIBELLE_VOIE:'',
        ZIP:'',
        VILLE:'',
        PAYS:'',
        LIEU_SERVICE:'',
        REGLEMENT:'',
        DESCRIPTION_MOYEN:'',
        NOM_CONTACT:'',
        TEL_CONTACT:'',
        EMAIL_CONTACT:'',
        NOTE:''
    }
    function datainit(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/LieuxDeFormation/'+($routeParams.id || $scope.ins.ID_LIEU_FORMATION),
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.ins =  response.data;
            $scope.ins.ID_ORGANISME =  response.data.ID_ORGANISME?response.data.ID_ORGANISME:'0';
            $scope.ins.ID_REPETITION =  response.data.ID_REPETITION?response.data.ID_REPETITION:'0';
            $scope.ins.ID_TYPE_VOIE =  response.data.ID_TYPE_VOIE?response.data.ID_TYPE_VOIE:'0';
        });

    }
    if($routeParams.id != undefined){
        datainit()
    }

    new Inputmask({"mask": "(999) 9999-9999"}).mask($('#tel_contact'));
    new Inputmask("decimal", { rightAlign: false }).mask($('#prix'));
    new Inputmask("decimal", { rightAlign: false }).mask($('#prix_j'));
    new Inputmask({"mask": "9", "repeat": 10}).mask($('#capacite'));

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

    liste_organismes();
    liste_indices();
    liste_type_voie();

    $scope.Save = function (){

            var form_data = new FormData();
            if($routeParams.id != undefined || $scope.ins.ID_LIEU_FORMATION != undefined){
                form_data.append('_method' , 'PUT')
                var api = 'FormaCampAPI/LieuxDeFormation/'+$scope.ins.ID_LIEU_FORMATION;
            }else{
                var api = 'FormaCampAPI/LieuxDeFormation';
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
                    $scope.ins.ID_LIEU_FORMATION = response.data.id;
                    datainit()
                    // $location.path('GestionDonnees/LieuxDeFormation')
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
