app.controller('NewReplyController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location) {
    $rootScope.$on('openMail',function (evt,data){
        $scope.mail = data;
        $scope.ins = {
            To:[],
            Subject:'Re:'+data.subject,
            Message:'',
            references:data.reference
        }
        if($scope.mail.from.address == "formacampt@gmail.com"){
            $scope.mail.to.forEach(function (mail){
                $scope.ins.To.push( mail );
            })
        }else{
            $scope.ins.To.push( $scope.mail.from );
        }
    })

    var editor;
        ClassicEditor
        .create( document.querySelector( '#editor2' ), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', '|',
                    'link', '|',
                    'bulletedList', 'numberedList',
                    'insertTable', '|',
                    'outdent', 'indent', '|',
                    'blockQuote', '|',
                    'undo', 'redo'
                ],
                shouldNotGroupWhenFull: true
            }
        } )
        .then( newEditor => {
            editor = newEditor;
        } )
        .catch( error => {
            console.error( error );
        } );

    $rootScope.$on('signature',function (evt,data){
        $scope.signature = data;
        editor.setData($scope.signature)
    })

    $scope.ins = {
        To:[],
        Subject:'',
        Message:''
    }
    $scope.GoTo = function (path){
        $location.path(path);
    }
    $scope.UploadFile = function (id){
        $('#file2').click()
    }
    $scope.files = [];
    $scope.UpdateFiles = function (element){
        $scope.$apply(function(scope) {

            scope.files = []
            for (var i = 0; i < element.files.length; i++) {
                scope.files.push(element.files[i])
            }
        });

    }
    $scope.RemoveFile = function (file){
        $scope.files = $scope.files.filter(function (value){
            return file.$$hashKey != value.$$hashKey;
        })
    }
    $scope.Send = function (){
        var form_data = new FormData();
        var emails = [];
        $scope.ins.To.forEach(function (v) {
            emails.push({email:v.address,nom:v.name})
        })

        form_data.append('To',JSON.stringify(emails));
        form_data.append('Subject',$scope.ins.Subject);
        form_data.append('references',$scope.ins.references);
        form_data.append('Message',editor.getData());
        var i=0;
        $scope.files.forEach(function (v) {
            form_data.append('file'+i,v);
            i++;
        })

        $http({
            method: 'POST',
            url: apiUrl + 'FormaCampAPI/Messagerie',
            data:form_data,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            if(response.data == true){
                jQuery('.email-app-details').removeClass('show');
                editor.setData($scope.signature);
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

})
