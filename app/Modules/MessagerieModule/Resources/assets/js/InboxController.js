app.controller('InboxController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location) {

    $scope.data_limit = 10;
    $scope.ShowMail = 1;
    $scope.liste_data = [];
    $scope.openMail = {
        subject:'',
        from:'',
        to:'',
        date:'',
        body:'',
    };

    $scope.unseen = 0;
    $scope.GoTo = function (path){
        $location.path(path);
    }
    $http({
        method: 'GET',
        url: apiUrl + 'FormaCampAPI/Messagerie/Signature',
        headers: {'Content-Type': undefined}
    }).then(function (response) {
        $scope.signature = response.data.SIGNATURE;
        $rootScope.$broadcast('signature',$scope.signature);
    });

    $rootScope.$on('signatureNew',function (evt,data) {
        $scope.signature = data;
    });
    function liste_data(){
        $('.send-loading').css('display','block')
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Messagerie/Inbox',
            headers: {'Content-Type': undefined}
        }).then(function (response) {
             $('.send-loading').css('display','none')
            $scope.liste_data =  response.data;
            $scope.current_grid = 1;
            $scope.filter_data = $scope.data_limit;
            $scope.entire = $scope.liste_data.length;
            $scope.unseen = $scope.liste_data.filter(function (v) {
                return v.seen ===0;
            }).length;

        });
    }
    liste_data()
    function liste_data_sent(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Messagerie/Sent',
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_data_sent =  response.data;
            $scope.current_grid = 1;
            $scope.filter_data = $scope.data_limit;
            $scope.entire = $scope.liste_data.length;

        });
    }
    liste_data_sent();
    function liste_data_corbeille(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Messagerie/Corbeille',
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.liste_data_corbeille =  response.data;
            $scope.current_grid = 1;
            $scope.filter_data = $scope.data_limit;
            $scope.entire = $scope.liste_data.length;

        });
    }
    liste_data_corbeille();
    $scope.ReadMail = function (mail,box){
        $('.send-loading').css('display','block')
        if($scope.openMail.number != mail.number){
            $http({
                method: 'GET',
                url: apiUrl + 'FormaCampAPI/Messagerie/'+mail.reference+'/'+box,
                headers: {'Content-Type': undefined}
            }).then(function (response) {
                 $('.send-loading').css('display','none')
                $scope.openMail = response.data;
                $scope.openMail.reference = mail.reference;
                jQuery('.read-mail').addClass('show');

                $rootScope.$broadcast('openMail',$scope.openMail)

            });
        }else{
            jQuery('.email-app-details').addClass('show');
        }



    }
    $scope.CloseMail = function (){
        jQuery('.email-app-details').removeClass('show');
        $rootScope.$broadcast('signature',$scope.signature);
    }
    $scope.ReloadData = function () {
        liste_data();
        liste_data_sent();
        liste_data_corbeille();
    }
    $scope.ActiveMail = function (mail,e){
        $scope.ShowMail = mail;
        $scope.CloseMail();
        $('.mail').removeClass('active');
        $(e.currentTarget).addClass('active');
    }
    $scope.NewMail = function (){
        $scope.CloseMail();
        jQuery('.new-mail').addClass('show');
    }
    $scope.ShowSignature = function (){
        $scope.CloseMail();
        $('.mail').removeClass('active');
        $('.signature-link').addClass('active');
        jQuery('.signature-mail').addClass('show');
    }
    $scope.OpenAttachment = function (file){
        let pdfWindow = window.open("")
        pdfWindow.document.write("<iframe width='100%' height='100%' src='data:application/pdf;base64, " + encodeURI(file) + "'></iframe>")
    }

    $scope.FileType = function (ext) {
        switch (ext.toLowerCase()) {
            case 'jpg':
            case 'gif':
            case 'bmp':
            case 'png':
                return 'Image';
            case 'm4v':
            case 'avi':
            case 'mpg':
            case 'mp4':
                return 'Video';
            case 'wma':
            case 'wav':
            case 'ogg':
            case 'mp3':
                return 'Audio';
            default:
                return 'Application';
        }

    }
})
