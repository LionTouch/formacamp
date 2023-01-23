app.controller('CrudCompteAccesController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams,$anchorScroll){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */

    $scope.step = 1;

    $scope.ins = {}
    $scope.scrollTop = function (){
        $anchorScroll()
    }
    if($routeParams.id != undefined){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/CompteAcces/'+$routeParams.id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.ins =  response.data;

        });

    }
    /**
     * data list categ modules
     * */
    function liste_categories(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/CompteAccesCategorie',
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_categories =  response.data;
        });
    }
    liste_categories();

    $scope.Save = function (){
            var form_data = new FormData();
            if($routeParams.id != undefined){
                form_data.append('_method' , 'PUT')
                var api = 'FormaCampAPI/CompteAcces/'+$scope.ins.ID_ACCES;
            }else{
                var api = 'FormaCampAPI/CompteAcces';
                // form_data.set('password', $scope.ins.password);
            }
            // form_data.set('email', $scope.ins.email);

        var liste_modules = [];
        $scope.liste_categories.forEach(function (categ){
            categ.modules.forEach(function (v){
                if(v.selected){
                    liste_modules.push(v.ID_MODULES)
                }
            })
        })
        form_data.set('modules', JSON.stringify(liste_modules));
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
                    $location.path('GestionCompte/CompteAcces')
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
