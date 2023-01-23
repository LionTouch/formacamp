app.controller('CrudEvaluationsSessionsController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */

    $scope.step = 1;
    $scope.liste_quests = [];
    $scope.liste_apprenants = []
    $scope.selected = [];
    $scope.ShowPublic = false;
    let old_quests = [];
    $scope.apprenantMethodes = {
        'Afficher' : function(ref){
            $scope.Afficher(ref)
        }
    }
    $scope.questMethodes = {
        'AddQuest' : function(type){
            $scope.AddQuest(type)
        },
        'RemoveQuest' : function(quest,index){
            $scope.RemoveQuest(quest,index)
        },
        'AddReponse' : function(quest){
            $scope.AddReponse(quest)
        },
        'RemoveReponse' : function(quest,reponse,index){
            $scope.RemoveReponse(quest,reponse,index)
        },
        'AddSubQuest' : function(quest){
            $scope.AddSubQuest(quest)
        },
        'RemoveSubQuest' : function(quest,sub_quest,index){
            $scope.RemoveSubQuest(quest,sub_quest,index)
        }
    }
    if($routeParams.session_id != undefined){
        liste_quests()
    }

    function liste_quests(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Quest/'+$routeParams.session_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.ShowPublic = response.data.length>0;
            $scope.liste_quests =  response.data;

            old_quests = angular.copy($scope.liste_quests);
        });
    }
    function liste_types_quests(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/QuestTypes',
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_types_quests =  response.data;
        });
    }
    function liste_models(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Quest',
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_models =  response.data;
        });
    }
    function liste_apprenants(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Apprenants/Session/'+$routeParams.session_id,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_apprenants = response.data;

        });
    }
    function liste_apprenants_passed(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Apprenants/Evaluation/'+$routeParams.session_id,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_apprenants_passed = response.data;

        });
    }
    $scope.Afficher = function (ref){
        // $location.path("Evaluation/"+ref);

        $window.open("Evaluation/"+ref);
    }

    $scope.GoToStep = function (step,e){
        $('.tabs').removeClass('active');
        $(e.currentTarget).addClass('active');
        $scope.step = step;
    }
    $scope.AddQuest = function (type){
        const liste_quests = [
            {
                TEXT:'Question',
                ID_TYPE:1,
                sub_quests:[],
                reponses:[
                    {
                        TEXT:'Réponse'
                    },
                    {
                        TEXT:'Réponse'
                    },
                ]
            },
            {
                TEXT:'Question',
                ID_TYPE:2,
                sub_quests:[],
                reponses:[
                    {
                        TEXT:'Réponse'
                    },
                    {
                        TEXT:'Réponse'
                    },
                ]
            },
            {
                TEXT:'Question',
                ID_TYPE:3,
                sub_quests:[],
                reponses:[],

            },
            {
                TEXT:'Question',
                ID_TYPE:4,
                sub_quests:[
                    {
                        TEXT:'Question'
                    },
                    {
                        TEXT:'Question'
                    }
                ],
                reponses:[
                    {
                        TEXT:'Réponse'
                    },
                    {
                        TEXT:'Réponse'
                    },
                ]

            },
            {
                TEXT:'Question',
                ID_TYPE:5,
                sub_quests:[],
                reponses:[]
            },
            {
                TEXT:'Question',
                ID_TYPE:6,
                sub_quests:[],
                reponses:[]
            }
        ];
        old_quests = angular.copy($scope.liste_quests);
        $scope.liste_quests.push(liste_quests[type-1]);
    }
    $scope.RemoveQuest = function (quest,index){
        old_quests = angular.copy($scope.liste_quests);
        $scope.liste_quests.splice(index-1,1);
    }

    $scope.AddReponse = function (quest){
        console.log(quest)
        old_quests = angular.copy($scope.liste_quests);
        quest.reponses.push({TEXT:'Réponse'});
    }
    $scope.RemoveReponse = function (quest,reponse,index){
        old_quests = angular.copy($scope.liste_quests);
        quest.reponses.splice(index,1);
    }

    $scope.AddSubQuest = function (quest){
        old_quests = angular.copy($scope.liste_quests);
        quest.sub_quests.push({TEXT:'Question'});
    }
    $scope.RemoveSubQuest = function (quest,sub_quest,index){
        old_quests = angular.copy($scope.liste_quests);
        quest.sub_quests.splice(index,1);
    }

    $scope.LoadModel = function (model){
        old_quests = angular.copy($scope.liste_quests);
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Quest/'+model.ID_SESSION,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_quests =  response.data;
        });

    }

    $scope.Annuler = function (){
        $scope.liste_quests = old_quests;
    }
    $scope.Delete = function (){
        $scope.liste_quests = [];
    }

    $scope.Save = function (){
        if($scope.liste_quests.length>0){
            let form_data = new FormData();
            let api = 'FormaCampAPI/Quest';
            form_data.append('quests', JSON.stringify($scope.liste_quests));
            form_data.append('ID_SESSION', $routeParams.session_id);
            $http({
                method: 'POST',
                url: apiUrl + api,
                data:form_data,
                headers: {"Content-Type": undefined },
            }).then(function (response) {
                if(response.data === true){
                    liste_quests();
                    liste_models();
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
        }else{
            $http({
                method: 'DELETE',
                url: apiUrl + 'FormaCampAPI/Quest/'+$routeParams.session_id,
                headers: {'Content-Type': undefined}
            }).then(function (response) {
                if (response.data) {
                    const wrapper = '<p>Enregistré avec succès</p>';
                    Notification.success({
                        message: wrapper,
                        delay: 2000,
                        positionY: 'bottom',
                        positionX: 'right'
                    });
                }
            })
        }
    }
    $scope.toggle = function (item, list) {
        var idx = list.indexOf(item);
        if (idx > -1) {
            list.splice(idx, 1);
        }
        else {
            list.push(item);
        }
    };

    $scope.exists = function (item, list) {
        return list.indexOf(item) > -1;
    };


    $scope.isChecked = function(list) {
        if(list !== undefined){
            return list.length>0 && $scope.selected.length === list.length;
        }else{
            return false;
        }
    };

    $scope.toggleAll = function(list) {
        var data = _.pluck(list,'ID_APPRENANT');
        if ($scope.selected.length === data.length) {
            $scope.selected = [];
        } else if ($scope.selected.length === 0 || $scope.selected.length > 0) {
            $scope.selected = data.slice(0);
        }
    };
    $scope.Publier = function (list){
console.log(list)
            var form_data = new FormData();
            var apprenants = $scope.liste_apprenants.filter(function (apprenant){
                return list.includes(apprenant.ID_APPRENANT);
            })

            form_data.append('apprenants',JSON.stringify(apprenants));

            $http({
                method: 'POST',
                url: apiUrl + 'FormaCampAPI/SendEval',
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
            });
        }

    liste_apprenants();
    liste_apprenants_passed();
    liste_models();
    liste_types_quests();

    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
