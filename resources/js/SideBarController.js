app.controller('SideBarController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    $rootScope.$on('IdleStart', function() {
    });
    $rootScope.$on('IdleTimeout', function() {
        document.getElementById('logout').click();
    });


    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
