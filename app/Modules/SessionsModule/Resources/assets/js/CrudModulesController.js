app.controller('CrudModulesController',function($scope,$http,apiUrl,CurrentUser,Notification,$compile,$templateRequest,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */

    // document.addEventListener('DOMContentLoaded', function() {
    //     console.log('loaded')
    // })
    var calendar;
    $scope.PrixModule = 1;
    let date = new Date();
    date.setHours(0);
    date.setMinutes(0);
    date.setSeconds(0);
    date.setMilliseconds(0);
    $scope.insDate = {
        START:'',
        END:''
    };
    $scope.insPrix = {
        ID_MODULE:$routeParams.module_id
    };
    $scope.SelectedRange = {};
    $scope.module = {};
    $scope.liste_seances = [];
    $scope.liste_types_seances = [];
    $scope.salles = [];
    $scope.seances = [];
    $scope.liste_gestionnaires = [];
    $scope.liste_salles = [];
    $scope.liste_tarifs_prix = [];
    $scope.liste_types_prix = [];
    $scope.liste_users = [];
    function data_module() {
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Modules/'+$routeParams.module_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.module = response.data;
            $scope.insDate = {
                START:moment(response.data.FIN).startOf('day')._d,
                END:moment(response.data.FIN).startOf('day')._d
            };
            var prix = $scope.module.prix.filter(function (p){
                return p.ID_TYPE_PRIX === 1;
            })[0];
            $scope.insPrix = {
                ID_MODULE:$routeParams.module_id,
                ID_PRIX:prix ? prix.ID_PRIX : undefined,
                NOM:prix ? prix.NOM : '',
                ID_TYPE_PRIX:prix ? prix.ID_TYPE_PRIX : 1,
                ID_TARIF:prix ? prix.ID_TARIF : 1,
                PRIX:prix ? prix.PRIX : 0,
                TVA:prix ? prix.TVA : 0
            };
            $scope.liste_seances = response.data.seances;
        });
    }
    function liste_salles(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Salles',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.salles = response.data;
        });
    }
    function liste_users(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/ListGestionnaire',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_gestionnaires = response.data;

        });
    }
    function liste_types_seances(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/TypesSeancesModules',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_types_seances = response.data;
            if(response.data.length>0){
                $scope.DEBUT = response.data[0].DEBUT;
                $scope.FIN = response.data[0].FIN;
            }
        });
    }
    function liste_tarifs_prix(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/TarifPrixModules',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_tarifs_prix = response.data;
        });
    }
    function liste_types_prix(){
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/TypesPrixModules',
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            $scope.liste_types_prix = response.data;
            $scope.PrixModule = response.data[0].ID_TYPE_PRIX;
        });
    }
    data_module();
    liste_salles();
    liste_users();
    liste_types_seances();
    liste_tarifs_prix();
    liste_types_prix();

    $scope.seanceMethodes = {
        'DeleteSeance' : function(index){
            $scope.DeleteSeance(index)
        },'ChangeTypeSeance' : function(type_seance){
            $scope.ChangeTypeSeance(type_seance)
        },'ReinitTime' : function(seance,type){
            $scope.ReinitTime(seance,type)
        }
    }


    $scope.ChangeTypeSeance = function (type_seance) {
        $scope.insDate.ID_TYPE_SEANCE = type_seance.ID_TYPE_SEANCE;
        $scope.DEBUT = type_seance.DEBUT;
        $scope.FIN = type_seance.FIN;
    }
    $(document).ready(function() {
        setTimeout(()=>{
            var dataCalendar = $scope.liste_seances;
            var e = document.getElementById("calendar");
            calendar = new FullCalendar.Calendar(e, {
                plugins: ['interaction',"timeGrid", "dayGrid", "list"],
                locale: "fr",
                timeZone: "UTC",
                validRange: {
                    start: $scope.module.DEBUT,
                    end: moment($scope.module.FIN).add(1, 'd').format('yyyy-MM-DD')
                },
                height: 550,
                defaultView: "dayGridMonth",
                editable: false,
                eventLimit: true,
                selectable:true,
                unselectAuto:false,
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek"
                },
                events:dataCalendar,
                select: function(info) {
                    $scope.SelectedRange = info;
                    var seances = $scope.liste_seances.filter(function (seance){
                        return moment(seance.start).format("YYYY-MM-DD") >= moment(info.start).format("YYYY-MM-DD") && moment(seance.end).format("YYYY-MM-DD") < moment(info.end).format("YYYY-MM-DD")
                    });
                    console.log(seances)
                    if(seances.length>0){
                        $scope.seances = seances;
                    }else{
                        $scope.seances = [
                            {
                                ID_SEANCE:0,
                                ID_MODULE:$scope.module.ID_MODULE,
                                ID_TYPE_SEANCE:$scope.liste_types_seances[0].ID_TYPE_SEANCE,
                                ID_SALLE:$scope.salles[0].ID_SALLE,
                                HD:$scope.liste_types_seances[0].DEBUT,
                                HF:$scope.liste_types_seances[0].FIN,
                                MIN:$scope.liste_types_seances[0].DEBUT,
                                MAX:$scope.liste_types_seances[0].FIN,
                                DATE:0
                            }
                        ]
                    }

                    $scope.insDate.START = moment(info.start).startOf('day')._d;
                    $scope.insDate.END = moment(info.end).startOf('day').subtract(1, "days")._d;

                    $scope.$apply();
                },
                eventClick: function(info) {
                }
            });
            calendar.render();
        },2000)


    });


    $scope.ReinitTime = function (seance,type){
        if(type == 'hf'){
            if(moment(seance.HF,'HH:mm').isSameOrBefore(moment(seance.HD,'HH:mm'))) {
                seance.HF = moment(seance.HD,'HH:mm').add(30, 'm').toDate();
                const wrapper = '<p>Heure fin minimal' +moment(seance.HD,'HH:mm').format('HH:mm')+'</p>';
                Notification.warning({
                    message: wrapper,
                    delay: 2000,
                    positionY: 'bottom',
                    positionX: 'right'
                });
            }
            if(moment(seance.HF,'HH:mm').isAfter(moment(seance.MAX,'HH:mm'))) {
                seance.HF = moment(seance.MAX,'HH:mm').toDate();
                const wrapper = '<p>Heure fin maximal' +seance.MAX+'</p>';
                Notification.warning({
                    message: wrapper,
                    delay: 2000,
                    positionY: 'bottom',
                    positionX: 'right'
                });
            }
        }else{
            if(moment(seance.HD,'HH:mm').isBefore(moment(seance.MIN,'HH:mm'))) {
                seance.HD =  moment(seance.MIN,'HH:mm').toDate();
                const wrapper = '<p>Heure debut minimal' +seance.MIN+'</p>';
                Notification.warning({
                    message: wrapper,
                    delay: 2000,
                    positionY: 'bottom',
                    positionX: 'right'
                });
            }

            if(moment(seance.HD,'HH:mm').isSameOrAfter(moment(seance.HF,'HH:mm'))) {
                seance.HD = moment(seance.HF,'HH:mm').subtract(30,'m').toDate();
                const wrapper = '<p>Heure debut maximal' +moment(seance.HF,'HH:mm').format('HH:mm')+'</p>';
                Notification.warning({
                    message: wrapper,
                    delay: 2000,
                    positionY: 'bottom',
                    positionX: 'right'
                });
            }

        }


    }
    $scope.AddSeance = function (e){
        $scope.seances.push({
            ID_SEANCE:0,
            ID_MODULE:$scope.module.ID_MODULE,
            ID_TYPE_SEANCE:$scope.liste_types_seances[0].ID_TYPE_SEANCE,
            ID_SALLE:$scope.salles[0].ID_SALLE,
            HD:$scope.liste_types_seances[0].DEBUT,
            HF:$scope.liste_types_seances[0].FIN,
            MIN:$scope.liste_types_seances[0].DEBUT,
            MAX:$scope.liste_types_seances[0].FIN,
            DATE:0
        })
    }

    $scope.DeleteSeance = function (index){

        if($scope.seances[index].ID_SEANCE != 0){
            swal({
                title: "Êtes-vous sûr de vouloir supprimer?",
                text: "Pour confirmer veuillez sélectionner votre choix.NB:Ce ne seras plus disponible",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass:'btn-ns-outline',
                cancelButtonClass:'btn-ns-outline-light',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Supprimer",
                cancelButtonText: "Annuler",
                closeOnConfirm: true,
                closeOnCancel: false
            }, function(isConfirm){
                if (isConfirm) {
                    $http({
                        method: 'DELETE',
                        url: apiUrl + 'FormaCampAPI/Seances/'+$scope.seances[index].ID_SEANCE,
                        headers: {'Content-Type': undefined}
                    }).then(function (response) {
                        if(response.data){

                            var event = calendar.getEventById($scope.seances[index].ID_SEANCE);
                            event.remove();
                            $scope.seances.splice(index,1);
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
                    $scope.$apply()
                } else {
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
        }else{
            $scope.seances.splice(index,1);
        }

    }

    $scope.SaveSeances = function (start,end){
        let form_data = new FormData();
        let api= 'FormaCampAPI/Seances';
        let dates = [];
        var debut = moment(start);
        $scope.seances.forEach(function (seance){
            seance.HD = moment(seance.HD,'HH:mm').format('HH:mm');
            seance.HF = moment(seance.HF,'HH:mm').format('HH:mm');
        })
        while (debut.isSameOrBefore(moment(end))) {
            dates.push(debut.format('YYYY-MM-DD'));
            debut.add(1, 'days');
        }
        form_data.append('seances', JSON.stringify($scope.seances));
        form_data.append('dates', JSON.stringify(dates));

        $http({
            method: 'POST',
            url: apiUrl + api,
            data:form_data,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            if(response.data === true){
                $http({
                    method: 'GET',
                    url: apiUrl + 'FormaCampAPI/Seances/Module/'+$scope.module.ID_MODULE,
                    headers: {'Content-Type': undefined}
                }).then(function (response) {
                    $scope.liste_seances = response.data;
                    $scope.seances = response.data.filter(function (seance){
                        return moment(seance.start).format("YYYY-MM-DD") >= moment($scope.SelectedRange.start).format("YYYY-MM-DD") && moment(seance.end).format("YYYY-MM-DD") < moment($scope.SelectedRange.end).format("YYYY-MM-DD")
                    });
                    calendar.removeAllEvents();
                    calendar.addEventSource(
                        {
                            events: response.data
                        });
                    calendar.refetchEvents();
                });
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
    $scope.Close = function () {
        $scope.seances = [];
        // anime({
        //     targets: '#calendar'+$scope.module.ID_MODULE,
        //     width: '100%',
        //     duration: 750,
        //     easing: 'easeInOutQuad'
        // });
        // anime({
        //     targets: '#date_crud'+$scope.module.ID_MODULE,
        //     width: '0%',
        //     opacity:0,
        //     duration: 750,
        //     easing: 'easeInOutQuad'
        // });
    }

    $scope.ChangePrixModule = function (id,module,e){

        $(e.currentTarget).closest('.nav-link').removeClass('active');
        $(e.currentTarget).addClass('active');
        $scope.PrixModule = id;
        let prix = module.prix.filter(function (p){
            return p.ID_TYPE_PRIX === id;
        })[0]

        $scope.insPrix = {
            ID_PRIX:prix ? prix.ID_PRIX : undefined,
            ID_MODULE:module.ID_MODULE,
            NOM:prix ? prix.NOM : '',
            ID_TYPE_PRIX:id,
            ID_TARIF:prix ? prix.ID_TARIF : 1,
            PRIX:prix ? prix.PRIX : 0,
            TVA:prix ? prix.TVA : 0
        }

        $scope.ShowDelete = $scope.insPrix.ID_PRIX !== undefined;

    }
    $scope.ChangeTarif = function (id,e){

        $('.tarif').removeClass('active');
        $(e.currentTarget).addClass('active');
        $scope.insPrix.ID_TARIF = id;

    }
    $scope.SavePrix = function (){
        let form_data = new FormData();
        let api;
        if($scope.insPrix.ID_PRIX !== undefined){
            form_data.append('_method' , 'PUT')
            api = 'FormaCampAPI/PrixModules/'+$scope.insPrix.ID_PRIX;
        }else{
            api = 'FormaCampAPI/PrixModules';
        }
        Object.keys($scope.insPrix).forEach(function(k){
            if($scope.insPrix[k] != null){
                form_data.append(k, $scope.insPrix[k]);
            }

        });

        $http({
            method: 'POST',
            url: apiUrl + api,
            data:form_data,
            headers: {"Content-Type": undefined },
        }).then(function (response) {
            if(response.data === true){
                $scope.ShowDelete = true;
                $http({
                    method: 'GET',
                    url: apiUrl + 'FormaCampAPI/PrixModules/Module/'+$scope.insPrix.ID_MODULE,
                    headers: {"Content-Type": undefined },
                }).then(function (response) {
                    $scope.module.prix = response.data;

                    let prix = response.data.filter(function (p){
                        return p.ID_TYPE_PRIX === $scope.PrixModule;
                    })[0]

                    $scope.insPrix = {
                        ID_PRIX:prix.ID_PRIX,
                        ID_MODULE:module.ID_MODULE,
                        NOM:prix.NOM,
                        ID_TYPE_PRIX:$scope.PrixModule,
                        ID_TARIF:prix.ID_TARIF,
                        PRIX:prix.PRIX,
                        TVA:prix.TVA
                    }

                });
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

    $scope.DeletePrix = function (module){

        swal({
            title: "Êtes-vous sûr de vouloir supprimer?",
            text: "Pour confirmer veuillez sélectionner votre choix.NB:Ce ne seras plus disponible",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass:'btn-ns-outline',
            cancelButtonClass:'btn-ns-outline-light',
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Supprimer",
            cancelButtonText: "Annuler",
            closeOnConfirm: true,
            closeOnCancel: false
        }, function(isConfirm){
            if (isConfirm) {

                $http({
                    method: 'DELETE',
                    url: apiUrl + 'FormaCampAPI/PrixModules/'+$scope.insPrix.ID_PRIX,
                    headers: {'Content-Type': undefined}
                }).then(function (response) {
                    if(response.data){
                        $http({
                            method: 'GET',
                            url: apiUrl + 'FormaCampAPI/PrixModules/Module/'+$scope.insPrix.ID_MODULE,
                            headers: {"Content-Type": undefined },
                        }).then(function (response) {
                            $scope.module.prix = response.data;
                        });
                        $scope.ShowDelete = false;
                        $scope.insPrix = {
                            ID_PRIX: undefined,
                            ID_MODULE:module.ID_MODULE,
                            NOM: '',
                            ID_TYPE_PRIX:$scope.PrixModule,
                            ID_TARIF:1,
                            PRIX:0,
                            TVA:0
                        }
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
    }

    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
