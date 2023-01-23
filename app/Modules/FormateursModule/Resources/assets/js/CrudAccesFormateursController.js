app.controller('CrudAccesFormateursController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams,$anchorScroll){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */


    $scope.ins = {}
    $scope.scrollTop = function (){
        $anchorScroll()
    }


    if($routeParams.id != undefined){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/CompteAccesCategorie',
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_categories =  response.data;
            $http({
                method: 'GET',
                url: apiUrl + 'FormaCampAPI/CompteAcces/'+$routeParams.id,
                headers: {'Content-Type': undefined}
            }).then(function (response) {
                $scope.liste_categories.forEach(function (categ){
                    categ.modules.forEach(function (v){
                        if(response.data.includes(v.ID_MODULES)){
                            v.selected = true;
                        }
                    })
                })
            });
        });


    }

    $scope.Save = function (){
        var form_data = new FormData();
        if($routeParams.id != undefined){
            form_data.append('_method' , 'PUT')
            var api = 'FormaCampAPI/CompteAcces/'+$routeParams.id;
        }else{
            var api = 'FormaCampAPI/CompteAcces';
            form_data.set('ID_USER', $routeParams.id);
        }

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
                $location.path('GestionDonnees/Formateurs')
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
