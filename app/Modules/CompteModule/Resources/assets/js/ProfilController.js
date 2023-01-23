app.controller('ProfilController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams) {
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */

    $http({
        method: 'GET',
        url: apiUrl + 'FormaCampAPI/Profil/Get/'+CurrentUser.ID_USER,
        headers: {'Content-Type': undefined}
    }).then(function (response) {
        $scope.ins =  response.data;
    });
    $scope.Edit = function (id){
        $location.path('GestionCompte/Profil/'+id);
    }
    $scope.ShowProfil = true;
    $scope.ShowCertif = false;
    $scope.ShowRegle = false;
    $scope.ShowConfig = false;
    $scope.ShowContent = function (content,e){
        switch (content) {
            case 'profil':
                $scope.ShowProfil = true;
                $scope.ShowCertif = false;
                $scope.ShowRegle = false;
                $scope.ShowConfig = false;
                break;
            case 'certif':
                $scope.ShowProfil = false;
                $scope.ShowCertif = true;
                $scope.ShowRegle = false;
                $scope.ShowConfig = false;
                break;
            case 'regle':
                $scope.ShowProfil = false;
                $scope.ShowCertif = false;
                $scope.ShowRegle = true;
                $scope.ShowConfig = false;
                break;
            case 'config':
                $scope.ShowProfil = false;
                $scope.ShowCertif = false;
                $scope.ShowRegle = false;
                $scope.ShowConfig = true;
                break;
        }
    }
})
