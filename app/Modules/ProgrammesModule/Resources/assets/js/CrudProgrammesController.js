app.controller('CrudProgrammesController',function($scope,$http,apiUrl,CurrentUser,Notification,$routeParams, $location, $cookies){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    $scope.tab = 1;
    $scope.GoToTab = function (tab){
        $scope.tab = tab;
    }
    $scope.formations = [];
    $scope.programme = {
        TITRE:'',
        DESCRIPTION:'',
        RESULTAT:'',
        OBTENTION:'',
        CERTIFICATION:'',
        VALIDITE:'',
        objectifs:[],
        formations:[],
        potentiels:[],
        prerequis:[],

    };
    function data(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Programmes/'+$routeParams.id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.programme =  response.data;
        });
    }
    if($routeParams.id != undefined){
        data();
    }

    $scope.AddObjectif = function (){
        $scope.programme.objectifs.push({
            INDX:$scope.programme.objectifs.length,
            ID_OBJECTIF:0,
            TEXT:''
        })

    }
    $scope.AddPotentiel = function (){

        $scope.programme.potentiels.push({
            INDX:$scope.programme.potentiels.length,
            ID_POTENTIEL:0,
            TEXT:''
        })

    }
    $scope.AddPrerequi = function (){

        $scope.programme.prerequis.push({
            INDX:$scope.programme.prerequis.length,
            ID_PREREQUIS:0,
            TEXT:''
        })

    }
    $scope.AddFormation = function (){
        $scope.programme.formations.push({
            INDX:$scope.programme.formations.length,
            ID_FORMATION:0,
            TEXT:'',
            sous_formations: [
                {
                    INDX:0,
                    ID_SUB_FORMATION:0,
                    ID_FORMATION:0,
                    TEXT:''
                }
            ]
        })
    }
    $scope.AddSousFormation = function (formation){
        formation.sous_formations.push({
            INDX:$scope.programme.formations.length,
            ID_SUB_FORMATION:0,
            ID_FORMATION:formation.ID_FORMATION,
            TEXT:''
        })
    }

    $scope.DeleteObjectif = function (index){
        $scope.programme.objectifs.splice(index,1);
    }
    $scope.DeletePotentiel = function (index){
        $scope.programme.potentiels.splice(index,1);
    }
    $scope.DeletePrerequi = function (index){
        $scope.programme.prerequis.splice(index,1);
    }
    $scope.DeleteFormation = function (index){
        $scope.programme.formations.splice(index,1);
    }
    $scope.DeleteSousFormation = function (formation,index){
        formation.sous_formations.splice(index,1);
    }

    $scope.Save = function (){
        let form_data = new FormData();
        if($routeParams.id != undefined){
            form_data.append('_method' , 'PUT')
            var api = 'FormaCampAPI/Programmes/'+$routeParams.id;
        }else{
            var api = 'FormaCampAPI/Programmes';
        }
        Object.keys($scope.programme).forEach(function(k){
            if($scope.programme[k] != null){
                if(typeof $scope.programme[k] == 'object'){
                    form_data.append(k, JSON.stringify($scope.programme[k]));
                }else{
                    form_data.append(k, $scope.programme[k]);
                }

            }
        });
        if($cookies.get('redirect_to') != undefined){
            form_data.append('ID_SESSION',$cookies.get('redirect_to').split('/')[1]);
        }

        $http({
            method: 'POST',
            url: apiUrl + api,
            data:form_data,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            if(response.data === true){
                const wrapper = '<p>Enregistré avec succès</p>';
                Notification.success({
                    message: wrapper,
                    delay: 2000,
                    positionY: 'bottom',
                    positionX: 'right'
                });
                if($cookies.get('redirect_to') != undefined){
                    $location.path($cookies.get('redirect_to'));
                    $cookies.remove('redirect_to')
                }else{
                    $location.path('Bibliotheque/Programmes/');
                }

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
