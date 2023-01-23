app.controller('CrudProfilController',function($scope,$http,apiUrl,CurrentUser,Notification,$window,$rootScope,$location,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */

    $scope.step = 1;
    let date = new Date();
    date.setHours(0);
    date.setMinutes(0);
    date.setSeconds(0);
    date.setMilliseconds(0);
    $scope.ins = {
        PHOTO:'',
        LOGO_ENTREPRISE:'',
        email:'',
        password:'',
        DATE:'',
        UPDATE_DATE:'',
        NOM:'',
        PRENOM:'',
        NOM:'',
        ID_ENTREPRISE_LINKEDIN:'',
        COULEUR_MARQUE:'',
        TELEPHONE:'',
        NUM_VOIE:'',
        ID_REPETITION:'0',
        ID_TYPE_VOIE:'0',
        LIBELLE_VOIE:'',
        ZIP:'',
        VILLE:'',
        PAYS:'',
        LIEU_SERVICE:'',
        ID_FUSEAU_HORAIRE:'0',
        REGLEMENT:0,
        DESCRIPTION:'',
        RESUME_CERTIF:'',
        HDM:date,
        HFM:date,
        HD:date,
        HF:date,
        FONCTION:0,
        NUM_DEC:'',
        REGION_ACQUISITON:'',
        NUM_DPC:'',
        ID_FORM_JURIDIQUE:'0',
        SIRET:'',
        CODE_APE_NAF:'',
        CAPITAL_SOCIAL:'',
        EXONERATION:0,
        MICRO_ENTREPRISE:0,
        FACTURATION:0,
        ID_MONNAIE:'0',
        SIGLE_TAXE:'',
        NUM_TVA:'',
        TAUX_TVA:'',
        DATE_CLOTURE_COMTBLE:'',
        CODE_JOURNAL:'',
        COMPTE_CLIENT:'',
        COMPTE_TVA:'',
        COMPTE_PRODUIT_BPF:'',
        COMPTE_PRODUIT_FORMATION:'',
        COMPTE_PRODUIT_CONSULTING:'',
        COMPTE_FRAIS_BPF:'',
        COMPTE_FRAIS_FORMATION:'',
        COMPTE_FRAIS_CONSULTING:'',
        COMPTE_OUTILS_BPF:'',
        COMPTE_OUTILS_FORMATION:'',
        COMPTE_OUTILS_CONSULTING:'',
        CODE_BANQUE:'',
        CODE_GUICHET:'',
        NUM_COMPTE_BANQUE:'',
        RIB:'',
        IBAN:'',
        BIC:''
    }
    const photo = Uppy.Core({
        debug: false,
        autoProceed: false,
        restrictions: {
            maxFileSize: 1000000,
            maxNumberOfFiles: 1,
            minNumberOfFiles: 1,
            allowedFileTypes: ['image/*']
        }
    })
    const logo = Uppy.Core({
        debug: false,
        autoProceed: false,
        restrictions: {
            maxFileSize: 1000000,
            maxNumberOfFiles: 1,
            minNumberOfFiles: 1,
            allowedFileTypes: ['image/*']
        }
    })
    const certif = Uppy.Core({
        debug: false,
        autoProceed: false,
        restrictions: {
            maxFileSize: 1000000,
            maxNumberOfFiles: 10,
            minNumberOfFiles: 1,
            allowedFileTypes: ['image/*']
        }
    })
    if($routeParams.id != undefined){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Utilisateurs/'+$routeParams.id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.ins =  response.data;
            $scope.ins.ID_REPETITION =  response.data.ID_REPETITION?response.data.ID_REPETITION:'0';
            $scope.ins.ID_TYPE_VOIE =  response.data.ID_TYPE_VOIE?response.data.ID_TYPE_VOIE:'0';
            $scope.ins.ID_FUSEAU_HORAIRE =  response.data.ID_FUSEAU_HORAIRE?response.data.ID_FUSEAU_HORAIRE:'0';
            $scope.ins.ID_FORM_JURIDIQUE =  response.data.ID_FORM_JURIDIQUE?response.data.ID_FORM_JURIDIQUE:'0';
            $scope.ins.ID_MONNAIE =  response.data.ID_MONNAIE?response.data.ID_MONNAIE:'0';

            $scope.ins.HD = $scope.ins.HD != null ? moment($scope.ins.HD,"HH:mm:ss").toDate():date;
            $scope.ins.HDM = $scope.ins.HDM != null ? moment($scope.ins.HDM,"HH:mm:ss").toDate():date;
            $scope.ins.HF = $scope.ins.HF != null ? moment($scope.ins.HF,"HH:mm:ss").toDate():date;
            $scope.ins.HFM = $scope.ins.HFM != null ? moment($scope.ins.HFM,"HH:mm:ss").toDate():date;
            $scope.ins.DATE_CLOTURE_COMTBLE = $scope.ins.DATE_CLOTURE_COMTBLE!= null ? moment($scope.ins.DATE_CLOTURE_COMTBLE,'yyyy-MM-dd').toDate():date;
            pickr.setColor($scope.ins.COULEUR_MARQUE);
            UppyAddFiles(certif,response.data.certifications)

        });
        certif.on("file-removed",  (file, reason) => {
            swal({
                title: "Êtes-vous sûr de vouloir supprimer?",
                text: "Pour confirmer veuillez sélectionner votre choix.NB:Ce ne seras plus disponible",
                type: "warning",
                confirmButtonClass:'btn-ns-outline',
                cancelButtonClass:'btn-ns-outline-light',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Supprimer",
                cancelButtonText: "Annuler",
                closeOnConfirm: true,
                closeOnCancel: false
            }, function(isConfirm){
                if (isConfirm) {
                    $http({
                        method: 'DELETE',
                        url: apiUrl + 'FormaCampAPI/Certifications/'+file.meta.ID_CERTIF,
                        headers: {'Content-Type': undefined}
                    }).then(function (response) {
                        if(response.data){

                            const wrapper = '<p>Supprimé avec succès</p>';
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
                } else {
                    certif.addFile(file);

                    swal({
                        title: "Annulé",
                        text: "Operation annulée :)",
                        type: "error",
                        confirmButtonClass:'btn-ns-outline',
                        showConfirmButton: true,
                        closeOnConfirm: true,
                    });
                }
            });

        })
            .on('dashboard:file-edit-complete', (file) => {
            if(file != undefined){
                UpdateCertif(file)
            }
        })
    }

    new Inputmask({"mask": "(999) 9999-9999"}).mask($('#telephone'));
    new Inputmask("decimal", { rightAlign: false }).mask($('#tva'));
    $scope.GoToStep = function (step){
        $scope.step = step;
    }

    const pickr = new Pickr({
        el: '.rui-colorpicker',
        container: 'body',
        theme: 'classic',
        closeOnScroll: false,
        appClass: 'custom-class',
        useAsButton: false,
        padding: 8,
        inline: false,
        autoReposition: true,
        sliders: 'v',
        disabled: false,
        lockOpacity: false,
        outputPrecision: 0,
        comparison: true,
        default: '#42445a',
        defaultRepresentation: 'HEX',
        showAlways: false,
        closeWithKey: 'Escape',
        position: 'bottom-middle',
        adjustableNumbers: true,
        swatches: [
            'rgba(244, 67, 54, 1)',
            'rgba(233, 30, 99, 0.95)',
            'rgba(156, 39, 176, 0.9)',
            'rgba(103, 58, 183, 0.85)',
            'rgba(63, 81, 181, 0.8)',
            'rgba(33, 150, 243, 0.75)',
            'rgba(3, 169, 244, 0.7)',
            'rgba(0, 188, 212, 0.7)',
            'rgba(0, 150, 136, 0.75)',
            'rgba(76, 175, 80, 0.8)',
            'rgba(139, 195, 74, 0.85)',
            'rgba(205, 220, 57, 0.9)',
            'rgba(255, 235, 59, 0.95)',
            'rgba(255, 193, 7, 1)'
        ],

        components: {
            preview: true,
            opacity: true,
            hue: true,

            interaction: {
                hex: true,
                rgba: true,
                hsva: true,
                input: true,
                clear: true,
                save: true
            }
        }
    });

    function UppyAddFiles(uppy,data){
        data.forEach(function (v){
            fetch(apiUrl+'public/uploads/certifications/'+v.REF)
                .then((response) => response.blob()) // returns a Blob
                .then((blob) => {
                    uppy.addFile({
                        meta: {ID_CERTIF:v.ID_CERTIF,ID_USER:v.ID_USER,REF:v.REF},
                        name: v.TITRE,
                        type: blob.type,
                        data: blob,
                        remote:true
                    });
                    Object.keys(uppy.state.files).forEach(file => {
                        uppy.setFileState(file, {
                            progress: { uploadComplete: false, uploadStarted: false }
                        })
                    })
                })
        })

    }

    photo.use(Uppy.Dashboard, {
            inline: false,
            target: '#drag-drop-photo',
            trigger: '.rui-profile-photo',
            replaceTargetContent: false,
            showProgressDetails: false,
            note: 'Images only, 1 file',
            height: 470,
            metaFields: [],
            browserBackButtonClose: true
        })
        .use(Uppy.DropTarget, {
            target: '#drag-drop-photo',
        })
        .use(Uppy.StatusBar, {
            target: '.uppy-Dashboard-progressindicators',
            hideUploadButton: true,
            hideAfterFinish: false
        })
        .use(Uppy.Tus, {endpoint: 'FormaCampAPI/Certifications'})
        .use(Uppy.GoogleDrive, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.Dropbox, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.Instagram, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.Facebook, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.OneDrive, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.Webcam, { target: Uppy.Dashboard })
        .on('complete', (result) => {
        })
        .on("file-added", currentFile => {
        }).on("file-removed", currentFile => {
        const img = $('.photo-rui')[0]
        img.src = 'resources/assets/images/avatar-1-profile.png'
        }).on('thumbnail:generated', (file, preview) => {
        const img = $('.photo-rui')[0]
        img.src = preview
    });


    logo.use(Uppy.Dashboard, {
        inline: false,
        target: '#drag-drop-logo',
        trigger: '.rui-profile-logo',
        replaceTargetContent: false,
        showProgressDetails: false,
        note: 'Images only, 1 file',
        height: 470,
        metaFields: [],
        browserBackButtonClose: true
    })
        .use(Uppy.DropTarget, {
            target: '#drag-drop-logo',
        })
        .use(Uppy.StatusBar, {
            target: '#drag-drop-logo .uppy-Dashboard-progressindicators',
            hideUploadButton: true,
            hideAfterFinish: false
        })
        .use(Uppy.Tus, {endpoint: 'FormaCampAPI/Certifications'})
        .use(Uppy.GoogleDrive, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.Dropbox, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.Instagram, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.Facebook, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.OneDrive, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.Webcam, { target: Uppy.Dashboard })
        .on('complete', (result) => {
        })
        .on("file-added", currentFile => {
        }).on("file-removed", currentFile => {
        const img = $('.logo-rui')[0]
        img.src = 'resources/assets/images/avatar-1-profile.png'
    }).on('thumbnail:generated', (file, preview) => {
        const img = $('.logo-rui')[0]
        img.src = preview
    });


    certif.use(Uppy.Dashboard, {
        inline: true,
        target: '#drag-drop-area',
        trigger: '.rui-profile-area',
        replaceTargetContent: false,
        showProgressDetails: false,
        hideCancelButton : true,
        hideUploadButton : true,
        note: 'Images only, max 10 files',
        height: 470,
        metaFields: [{ id: 'name', name: 'Titre', placeholder: 'Titre certification' }],
        browserBackButtonClose: true
    })
        .use(Uppy.DropTarget, {
            target: '#drag-drop-area',
        })
        .use(Uppy.StatusBar, {
            target: '.uppy-Dashboard-progressindicators',
            hideUploadButton: true,
            hideAfterFinish: false
        })
        .use(Uppy.Tus, {endpoint: '#'})
        .use(Uppy.GoogleDrive, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.Dropbox, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.Instagram, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.Facebook, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.OneDrive, { target: Uppy.Dashboard, companionUrl: 'https://api2.transloadit.com/companion', companionAllowedHosts: /\.transloadit\.com$/ })
        .use(Uppy.Webcam, { target: Uppy.Dashboard })
        .on('complete', (result) => {

        })

        .on("file-added", currentFile => {

        })
        .on('thumbnail:generated', (file, preview) => {

        });



    function liste_indices(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Repetitions',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_indices = response.data;
        });
    }
    function liste_type_voie(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/TypeVoie',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_type_voie = response.data;
        });
    }
    function liste_form_juridique(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/FormJuridique',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_form_juridique = response.data;
        });
    }
    function liste_monnaie(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Monnaie',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_monnaie = response.data;
        });
    }
    function liste_fuseaux(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/FuseauxHoraire',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_fuseaux = response.data;
        });
    }
    liste_indices();
    liste_type_voie();
    liste_form_juridique();
    liste_monnaie();
    liste_fuseaux()
    $scope.Save = function (){
        if(($scope.ins.email.length == 0) || ($scope.ins.password == undefined && $routeParams.id == undefined)){
            $('.nav-user').removeClass('active')
            $scope.step = 1;
        }else{
            var form_data = new FormData();
            if($routeParams.id != undefined){
                form_data.append('_method' , 'PUT')
                var api = 'FormaCampAPI/Utilisateurs/'+$scope.ins.ID_USER;
            }else{
                var api = 'FormaCampAPI/Utilisateurs';
            }
            Object.keys($scope.ins).forEach(function(k){
                if($scope.ins[k] != null){
                    form_data.append(k, $scope.ins[k]);
                }

            });
            if($scope.ins.DATE_CLOTURE_COMTBLE){
                form_data.set('DATE_CLOTURE_COMTBLE', moment($scope.ins.DATE_CLOTURE_COMTBLE).format('yyyy-MM')+'-01');
            }
            form_data.set('HD', moment($scope.ins.HD).format('HH:mm:ss'));
            form_data.set('HDM', moment($scope.ins.HDM).format('HH:mm:ss'));
            form_data.set('HF', moment($scope.ins.HF).format('HH:mm:ss'));
            form_data.set('HFM', moment($scope.ins.HFM).format('HH:mm:ss'));
            form_data.set('COULEUR_MARQUE', pickr.getColor().toHEXA());

            if(photo.getFiles().length>0){
                form_data.append('PHOTO',  photo.getFiles()[0].data);
            }
            if(logo.getFiles().length>0){
                form_data.append('LOGO_ENTREPRISE',  logo.getFiles()[0].data);
            }
            if(certif.getFiles().length>0){
                var i =0;
                certif.getFiles().forEach(function (value){
                    if(!value.meta.ID_CERTIF){
                        form_data.append('REF'+i,  value.data);
                        form_data.append('TITRE'+i,  value.data.meta.name);
                    }
                    i++;
                })

            }

            $http({
                method: 'POST',
                url: apiUrl + api,
                data:form_data,
                headers: {"Content-Type": undefined },
            }).then(function (response) {
                if(response.data == true){
                    const wrapper = '<p>Enregistré avec succès</p>';
                    Notification.success({
                        message: wrapper,
                        delay: 2000,
                        positionY: 'bottom',
                        positionX: 'right'
                    });
                    $location.path('GestionDonnees/Utilisateurs')
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


    }
    function UpdateCertif (data){
        let dataSend = {};
        dataSend.ID_USER = data.meta.ID_USER;
        dataSend.ID_CERTIF = data.meta.ID_CERTIF;
        dataSend.REF = data.meta.REF;
        dataSend.TITRE = data.meta.name;
        dataSend._method = 'PUT'
        var api = 'FormaCampAPI/Certifications/'+dataSend.ID_CERTIF;
        $http({
            method: 'POST',
            url: apiUrl + api,
            data: new Blob([JSON.stringify(dataSend)], {
                type: 'application/json'
            }),
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            if(response.data == true){
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

    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
