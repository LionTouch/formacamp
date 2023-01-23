app.controller('SuiviActivitesController',function($scope,$http,apiUrl,$location,CurrentUser,Notification,$compile,$templateRequest) {

    /**
     * data list function
     * */
    $scope.data_limit = 10;
    $scope.before = null;
    $scope.after = null;
    function data_list(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/SuiviFactures',
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_data =  response.data;
            $scope.current_grid = 1;
            $scope.filter_data = $scope.data_limit;
            $scope.entire = $scope.liste_data.length;
        });
    }
    data_list();
})
