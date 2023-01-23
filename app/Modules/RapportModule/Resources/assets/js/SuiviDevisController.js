app.controller('SuiviDevisController',function($scope,$http,apiUrl,$location,CurrentUser,Notification,$compile,$templateRequest,$window) {

    /**
     * data list function
     * */
    $scope.data_limit = 10;
    $scope.before = null;
    $scope.after = null;
    function data_list(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/SuiviDevis',
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_data =  response.data;
            $scope.current_grid = 1;
            $scope.filter_data = $scope.data_limit;
            $scope.entire = $scope.liste_data.length;
        });
    }
    data_list();

    $scope.Download = function (id) {
        $window.open(apiUrl + 'Devis/'+id, '_blank');
    }

    $scope.Send = function (session) {
        if(session.EMAIL_CLIENT){
            $('#send-loading').css('display','block')
            var form_data = new FormData();
            form_data.append('ID_SESSION',session.ID_SESSION);
            form_data.append('EMAIL',session.EMAIL_CLIENT);

            $http({
                method: 'POST',
                url: apiUrl + 'Devis',
                data:form_data,
                headers: {"Content-Type": undefined },
            }).then(function (response) {
                if(response.data == true){
                    const wrapper = '<p>Envoyé avec succès</p>';
                    Notification.success({
                        message: wrapper,
                        delay: 2000,
                        positionY: 'bottom',
                        positionX: 'right'
                    });
                }else{
                    const wrapper = '<p>Erreur</p>';
                    Notification.error({
                        message: wrapper,
                        delay: 2000,
                        positionY: 'bottom',
                        positionX: 'right'
                    });
                }
                $('#send-loading').css('display','none')
            });
        }else{
            const wrapper = '<p>Veuillez verifier email client!</p>';
            Notification.warning({
                message: wrapper,
                delay: 2000,
                positionY: 'bottom',
                positionX: 'right'
            });
        }
    }
})
