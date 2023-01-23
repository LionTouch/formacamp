app.controller('CrudSessionsController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams,$timeout, $q, $log){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */

    $scope.querySearch   = querySearch;

    $scope.newState = newState;

    function newState(state) {
        alert("Sorry! You'll need to create a Constitution for " + state + " first!");
    }

    // ******************************
    // Internal methods
    // ******************************

    /**
     * Search for states... use $timeout to simulate
     * remote dataservice call.
     */
    function querySearch (query,items) {
        return  query ? items.filter(createFilterFor(query)) : items;
    }
    /**
     * Create filter function for a query string
     */
    function createFilterFor(query) {
        var lowercaseQuery = query.toLowerCase();

        return function filterFn(state) {
            return (state.NOM.toLowerCase().indexOf(lowercaseQuery) === 0);
        };

    }

    let date = new Date();
    date.setHours(0);
    date.setMinutes(0);
    date.setSeconds(0);
    date.setMilliseconds(0);
    $scope.liste_organismes = [];
    $scope.liste_clients = [];
    $scope.liste_actions = [];
    $scope.liste_diplomes = [];
    $scope.liste_domaines = [];
    $scope.liste_lieux = [];

    $scope.session = {
        ID_ORGANISME:"",
        NOM:"",
        ID_CLIENT:0,
        ID_LIEU_FORMATION:0,
        TYPE_CLIENT:"0",
        TRAITANCE:0,
        ID_ACTION:0,
        ID_DOMAINE:0,
        ID_DIPLOME:"0",
        TITRE_VISE:"",
        DEBUT:date,
        FIN:date
    };

    function liste_organismes(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Organismes',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_organismes = response.data;
        });
    }
    function liste_clients(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Clients',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_clients = response.data;

        });
    }
    function liste_lieux(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/LieuxDeFormation',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_lieux = response.data;
            $scope.session.ID_LIEU_FORMATION = $scope.liste_lieux.length>0?$scope.liste_lieux[0].ID_LIEU_FORMATION:0;
        });
    }
    function liste_actions(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Actions',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_actions = response.data;
            $scope.session.ID_ACTION = $scope.liste_actions.length>0?$scope.liste_actions[0].ID_ACTION:0;

        });
    }
    function liste_domaines(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Domaines',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_domaines = response.data;
            $scope.session.ID_DOMAINE = $scope.liste_domaines.length>0?$scope.liste_domaines[0].ID_DOMAINE:0;
        });
    }
    function liste_diplomes(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Diplomes',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_diplomes = response.data;
            $scope.session.ID_DIPLOME = $scope.liste_diplomes.length>0?$scope.liste_diplomes[0].ID_DIPLOME:0;

        });
    }
    liste_clients();
    liste_organismes();
    liste_actions();
    liste_diplomes();
    liste_domaines();
    liste_lieux();
    if($location.url().split("/")[2] === 'Ajout'){
        $scope.session.TYPE = 1;
    }else{
        $scope.session.TYPE = 0;
    }
    if($routeParams.session_id != undefined){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Sessions/'+$routeParams.session_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.session =  response.data;
            $scope.session.DEBUT = moment($scope.session.DEBUT).toDate();
            $scope.session.FIN = moment($scope.session.FIN).toDate();
            $scope.selectedOrganisme = $scope.liste_organismes.filter(function (v){
                return v.ID_ORGANISME === $scope.session.ID_ORGANISME;
            })[0];
            $scope.selectedDomaine = $scope.liste_domaines.filter(function (v){
                return v.ID_DOMAINE === $scope.session.ID_DOMAINE;
            })[0];
            $scope.selectedAction = $scope.liste_actions.filter(function (v){
                return v.ID_ACTION === $scope.session.ID_ACTION;
            })[0];
            $scope.selectedLieu = $scope.liste_lieux.filter(function (v){
                return v.ID_LIEU_FORMATION === $scope.session.ID_LIEU_FORMATION;
            })[0];
            $scope.selectedDiplome = $scope.liste_diplomes.filter(function (v){
                return v.ID_DIPLOME === $scope.session.ID_DIPLOME;
            })[0];
            $scope.selectedClient = $scope.liste_clients.filter(function (v){
                return v.ID_CLIENT === $scope.session.ID_CLIENT;
            })[0];
        });

    }


    $scope.Save = function (){
        var form_data = new FormData();
        if($scope.session.ID_SESSION != undefined){
            form_data.append('_method' , 'PUT')
            var api = 'FormaCampAPI/Sessions/'+$scope.session.ID_SESSION;
        }else{
            var api = 'FormaCampAPI/Sessions';
        }
        Object.keys($scope.session).forEach(function(k){
            if($scope.session[k] != null){
                form_data.append(k, $scope.session[k]);
            }

        });
        form_data.set('DEBUT', moment($scope.session.DEBUT).format('yyyy-MM-DD HH:mm:ss'));
        form_data.set('FIN', moment($scope.session.FIN).format('yyyy-MM-DD HH:mm:ss'));

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
                $location.path('/Sessions/'+response.data.id+'/Modules');
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


    $scope.step = 1;
    $scope.GoToStep = function (step,e){
        $('.tabs').removeClass('active');
        $(e.currentTarget).addClass('active');
        $scope.step = step;
    }
    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */

});
