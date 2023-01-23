app.controller('CrudProgrammesSessionsController',function($scope,$http,apiUrl,CurrentUser,Notification,$routeParams, $location, $cookies){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    $scope.tab = 1;
    $scope.GoToTab = function (tab){
        $scope.tab = tab;
    }
    $scope.programme = {};
    $scope.liste_data = [];
    $scope.ShowProgramme = false;
    $scope.SelectedProgramme = 0;
    function data(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Programmes',
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_data =  response.data;
        });
    }
    function programme(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Programmes/Session/'+$routeParams.session_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            if(response.data.ID_PROGRAMME != undefined){
                $scope.programme =  response.data;
                $scope.ShowProgramme = true;
            } else {
                $scope.programme = {};
                $scope.ShowProgramme = false;
                data();
            }
        });
    }
    programme();

    $scope.SelectProgramme = function (id,e){
        $scope.SelectedProgramme = id;
        $('.programme').removeClass('active')
        $(e.currentTarget).addClass('active');
    }
    $scope.Save = function (){
        let form_data = new FormData();
        let api = 'FormaCampAPI/Sessions/Programme/'+$routeParams.session_id;
        form_data.append('_method' , 'PUT')
        form_data.append('ID_PROGRAMME', $scope.SelectedProgramme);
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
                $scope.SelectedProgramme = 0;
                $scope.ShowProgramme = true;
                programme();
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
    $scope.AddProgramme = function (){
        if($scope.ShowProgramme){
            $scope.SelectedProgramme = 0;
            let form_data = new FormData();
            let api = 'FormaCampAPI/Sessions/Programme/'+$routeParams.session_id;
            form_data.append('_method' , 'PUT')
            form_data.append('ID_PROGRAMME', null);
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
                    $scope.ShowProgramme = true;
                    programme();
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
        }else{
            $cookies.put('redirect_to','Sessions/'+$routeParams.session_id+'/Programme')
            $location.path('/Bibliotheque/Programmes/Ajout');
        }

    }
    $scope.EditProgramme = function (){
        $cookies.put('redirect_to','Sessions/'+$routeParams.session_id+'/Programme')
        $location.path('/Bibliotheque/Programmes/'+$scope.programme.ID_PROGRAMME);
    }
    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
