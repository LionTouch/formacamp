app.controller('AgendaController',function($scope,$http,apiUrl,$location,CurrentUser,Notification,$compile,$templateRequest) {
    var ScheduleList = [];
    var CalendarList = [
        {id:'1',name:'Projets'},
        {id:'2',name:'Planification en cours'},
        {id:'3',name:'Planifiées'},
        {id:'4',name:'Terminées'}
    ];
    // function CalendarInfo() {
    //     this.id = null;
    //     this.name = null;
    // }
    // var calendar;
    // var id = 0;
    //
    // calendar = new CalendarInfo();
    // id = 1;
    // calendar.id = String(id);
    // calendar.name = 'Projets';
    // CalendarList.push(calendar);
    $http({
        method: 'GET',
        url: apiUrl + 'FormaCampAPI/Agenda',
        headers: {'Content-Type': undefined}
    }).then(function (response) {
        ScheduleList = response.data;
    });
    $(document).ready(function () {

        var cal = new tui.Calendar('#calendar', {
            defaultView: 'month',
            theme:{},
            calendars: CalendarList,
            isReadOnly: true,
            taskView: false,    // Can be also ['milestone', 'task']
            scheduleView: true,  // Can be also ['allday', 'time']
            template: {
                monthGridHeaderExceed: function(hiddenSchedules) {
                    return '<span class="weekday-grid-more-schedules">' + hiddenSchedules + ' plus </span>';
                },
                time: function(schedule) {
                    return  '<span class="tui-full-calendar-weekday-schedule-title" style="color:#fff;border-radius: 5px;background:'+schedule.bgColor+'">'+schedule.title+'</span>'
                },
                popupEdit: function() {
                    return 'Modifier';
                },
                popupDetailUser: function(schedule) {
                    return (schedule.attendees || []).map(function(elem){
                        return elem.NOM;
                    }).join(", ");
                },
            },
            useCreationPopup: false,
            useDetailPopup: true,
            month: {
                daynames: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                narrowWeekend: false,
                startDayOfWeek:1,
                workweek:false
            },
            week: {
                daynames: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
                narrowWeekend: false,
                startDayOfWeek:1,
                workweek:false
            }

        });
        cal.on({
            'clickSchedule': function(e) {
                console.log(e);
            }
        })

        // var CalendarList = [];
        function init() {
            // cal.setCalendars(CalendarList);
            setRenderRangeText();
            setSchedules();
        }


        function setSchedules() {
            cal.clear();
            cal.createSchedules(ScheduleList);
            cal.render();
        }
        function currentCalendarDate(format) {
            var currentDate = moment([cal.getDate().getFullYear(), cal.getDate().getMonth(), cal.getDate().getDate()]);

            return currentDate.format(format);
        }
        function setRenderRangeText() {
            var renderRange = document.getElementById('renderRange');
            var options = cal.getOptions();
            var viewName = cal.getViewName();

            var html = [];
            if (viewName === 'day') {
                html.push(currentCalendarDate('YYYY.MM.DD'));
            } else if (viewName === 'month' &&
                (!options.month.visibleWeeksCount || options.month.visibleWeeksCount > 4)) {
                html.push(currentCalendarDate('YYYY.MM'));
            } else {
                html.push(moment(cal.getDateRangeStart().getTime()).format('YYYY.MM.DD'));
                html.push(' ~ ');
                html.push(moment(cal.getDateRangeEnd().getTime()).format(' MM.DD'));
            }
            renderRange.innerHTML = html.join('');
        }

        $scope.onClickMenu = function (action,e) {
            $('.btn-menu-nav').removeClass('active');
            $(e.currentTarget).addClass('active');
            var options = cal.getOptions();
            var viewName = '';

            switch (action) {
                case 'toggle-daily':
                    viewName = 'day';
                    break;
                case 'toggle-weekly':
                    viewName = 'week';
                    break;
                case 'toggle-monthly':
                    options.month.visibleWeeksCount = 0;
                    viewName = 'month';
                    break;
                default:
                    break;
            }

            cal.setOptions(options, true);
            cal.changeView(viewName, true);
            setRenderRangeText();
            setSchedules();
        }

        $scope.onClickNavi = function (action) {
            switch (action) {
                case 'move-prev':
                    cal.prev();
                    break;
                case 'move-next':
                    cal.next();
                    break;
                case 'move-today':
                    cal.today();
                    break;
                default:
                    return;
            }
            setRenderRangeText();
            setSchedules();
        };
        init();
        // var e = document.getElementById("calendar");
        // calendar = new FullCalendar.Calendar(e, {
        //     plugins: ['interaction',"timeGrid", "dayGrid", "list"],
        //     locale: "fr",
        //     timeZone: "UTC",
        //     height: 750,
        //     defaultView: "dayGridMonth",
        //     editable: false,
        //     eventLimit: true,
        //     selectable:true,
        //     unselectAuto:false,
        //     header: {
        //         left: "prev,next today",
        //         center: "title",
        //         right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
        //     },
        //     events: apiUrl + 'FormaCampAPI/Agenda',
        //     eventRender: function(info) {
        //         console.log(info.el)
        //          $(info.el).tooltip({
        //              items:'.fc-day-grid-event',
        //             title: info.event.extendedProps.description,
        //              content: "<h1>"+info.event.extendedProps.description+"</h1>",
        //             placement: "top",
        //             trigger: "hover",
        //             container: "body"
        //         });
        //
        //     },
        //     eventClick: function(info) {
        //         $(info.el).tooltip('hide');
        //         $location.path('Sessions/'+info.event.id);
        //         $scope.$apply();
        //     }
        // });
        // calendar.render();

    });

})

