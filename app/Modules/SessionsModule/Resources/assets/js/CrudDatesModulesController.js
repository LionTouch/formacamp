app.controller('CrudDatesModulesController',function($scope,$http,apiUrl,CurrentUser,Notification,$compile,$templateRequest,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    var calendar;
    $scope.PrixModule = 1;
    let date = new Date();
    date.setHours(0);
    date.setMinutes(0);
    date.setSeconds(0);
    date.setMilliseconds(0);
    $scope.ins = {
        START:date,
        END:date
    };
    $scope.liste_seances = [];
    function data_module() {
        $http({
            method: 'GET',
            url: apiUrl + 'FormaCampAPI/Module/'+$routeParams.module_id,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
           $scope.module = response.data;
            $scope.liste_seances = response.data.seances;
        });
    }
    // $scope.salles = [];
    // $scope.liste_types_seances = [];
    $scope.seances = [];
    $scope.seanceMethodes = {
         'DeleteSeance' : function(index){
            $scope.DeleteSeance(index)
        },'ChangeTypeSeance' : function(type_seance){
            $scope.ChangeTypeSeance(type_seance)
        },'ReinitTime' : function(seance,type){
            $scope.ReinitTime(seance,type)
        }
    }
    $scope.module = {};
    $scope.liste_gestionnaires = [];
    $scope.$watch('data', function(module) {
        console.log(module)
        if(module !== undefined){
            $scope.module = module;
            $scope.liste_seances = module.seances;
            $scope.$watch('salles', function(salles) {
                if(salles !== undefined) {
                    $scope.salles = salles;
                }
            })
            $scope.$watch('types_seances', function(types_seances) {
                if(types_seances !== undefined) {
                    $scope.liste_types_seances = types_seances;
                    if(types_seances.length>0){
                        $scope.DEBUT = $scope.liste_types_seances[0].DEBUT;
                        $scope.FIN = $scope.liste_types_seances[0].FIN;
                    }

                }
            })
        }
    })
    $scope.ChangeTypeSeance = function (type_seance) {
        $scope.ins.ID_TYPE_SEANCE = type_seance.ID_TYPE_SEANCE;
        $scope.DEBUT = type_seance.DEBUT;
        $scope.FIN = type_seance.FIN;
    }
    $(document).ready(function () {
        var dataCalendar =   $scope.liste_seances;
        var e = document.getElementById("calendar"+$scope.data.ID_MODULE);
        calendar = new FullCalendar.Calendar(e, {
            plugins: ['interaction',"timeGrid", "dayGrid", "list"],
            locale: "fr",
            timeZone: "UTC",
             validRange: {
                 start: $scope.data.DEBUT,
                 end: moment($scope.data.FIN).add(1, 'd').format('yyyy-MM-DD')
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
                right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
            },
            events:dataCalendar,
            select: function(info) {
                var seances = $scope.liste_seances.filter(function (seance){
                    return moment(seance.start).format("YYYY-MM-DD") >= moment(info.start).format("YYYY-MM-DD") && moment(seance.end).format("YYYY-MM-DD") < moment(info.end).format("YYYY-MM-DD")
                });
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

                $scope.ins.START = moment(info.start).startOf('day')._d;
                $scope.ins.END = moment(info.end).startOf('day').subtract(1, "days")._d;

                $scope.$apply();
                anime({
                    targets: '#calendar'+$scope.module.ID_MODULE,
                    width: '49%',
                    duration: 750,
                    easing: 'easeInOutQuad'
                });
                anime({
                    targets: '#date_crud'+$scope.module.ID_MODULE,
                    width: '49%',
                    opacity:1,
                    duration: 750,
                    easing: 'easeInOutQuad'
                });

            },
            eventClick: function(info) {
            }
        });
         calendar.render()

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

    $scope.Save = function (start,end){
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
                    $scope.seances = response.data;
                    calendar.removeAllEvents();
                    calendar.addEventSource(
                        {
                            events: response.data
                        });
                    calendar.refetchEvents();
                });
                anime({
                    targets: '#calendar'+$scope.module.ID_MODULE,
                    width: '100%',
                    duration: 750,
                    easing: 'easeInOutQuad'
                });
                anime({
                    targets: '#date_crud'+$scope.module.ID_MODULE,
                    width: '0%',
                    opacity:0,
                    duration: 750,
                    easing: 'easeInOutQuad'
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
        anime({
            targets: '#calendar'+$scope.module.ID_MODULE,
            width: '100%',
            duration: 750,
            easing: 'easeInOutQuad'
        });
        anime({
            targets: '#date_crud'+$scope.module.ID_MODULE,
            width: '0%',
            opacity:0,
            duration: 750,
            easing: 'easeInOutQuad'
        });
    }

    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
