app.controller('SignatureMessageController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location) {

    var editor;
        ClassicEditor
        .create( document.querySelector( '#editor-signature' ), {
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
            // editor.setData($scope.insSignature);
        })
        .catch( error => {
        });

    $http({
        method: 'GET',
        url: apiUrl + 'FormaCampAPI/Messagerie/Signature',
        headers: {'Content-Type': undefined}
    }).then(function (response) {
        editor.setData(response.data.SIGNATURE)
    });


    $scope.Save = function (){
        var form_data = new FormData();
        form_data.append('signature',editor.getData());
        $http({
            method: 'POST',
            url: apiUrl + 'FormaCampAPI/Messagerie/Signature',
            data:form_data,
            headers: {"Content-Type": undefined }
        }).then(function (response) {
            if(response.data == true){
                const wrapper = '<p>Enregistré avec succès</p>';
                Notification.success({
                    message: wrapper,
                    delay: 2000,
                    positionY: 'bottom',
                    positionX: 'right'
                });
                $rootScope.$broadcast('signatureNew',editor.getData())
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
