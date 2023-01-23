app.controller('EvaluationController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams){

    $scope.connected = false;
    $scope.ins = {email:''};
    $scope.rate = 0;
    $scope.max = 5;
    $scope.Passed = true;
    $scope.methods = {
        'hoveringOver' : function(value){
            $scope.hoveringOver(value)
        },
        'Noter' : function(quest){
            $scope.Noter(quest)
        },
    }

    $scope.hoveringOver = function(value) {
        $scope.overStar = value;
        $scope.percent = 100 * (value / $scope.max);
    };
    function liste_quests(){
        $http({
            method: 'GET',
            url: apiUrl + 'Evaluation/Quest/'+$routeParams.ref,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            if (response.data === false){
                $window.location.href = '/';
            }else if(response.data.result === true){
                $scope.Passed = true;
                $scope.liste_quests =  response.data.data;
                $scope.session =  response.data.session;
                $scope.apprenant =  response.data.apprenant;
            } else{
                $scope.Passed = false;
                $scope.liste_quests =  response.data.data;
                $scope.session =  response.data.session;
                $scope.apprenant =  response.data.apprenant;
            }

        });
    }
    liste_quests();
    $scope.Noter = function (e,quest,note){
        $('note-'+quest.ID_QUEST).removeClass('active');
        $(e.currentTarget).addClass('active');
        quest.reponse = note;

    }
    $scope.Save = function () {
        let form_data = new FormData();
        let api = 'Evaluation/Quest';
        form_data.append('quests', JSON.stringify($scope.liste_quests));
        form_data.append('REF', $routeParams.ref);
        $http({
            method: 'POST',
            url: apiUrl + api,
            data:form_data,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            if(response.data === true){
                liste_quests();
                const wrapper = '<p>Enregistré avec succès</p>';
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
        });
    }
});
