var app = angular.module('app', ['ngRoute', 'ngResource', 'ngAnimate', 'ngCookies', 'ui-notification', 'ui.bootstrap','ngSanitize', 'ui.select','dndLists', 'ngIdle', 'infinite-scroll','ngMaterial']);

// app.factory('socket', function () {
//     return  io.connect('https://bundle.lion-touch.com:8443', {secure: true});
// });

app.factory('apiUrl', function ($location) {
    return  $location.protocol()+'://'+$location.host()+'/';
});
app.factory('CurrentUser', function ($cookies) {
    if($cookies.get('user'))
    {
        return  JSON.parse($cookies.get('user'));
    }else{
        return false;
    }
});


app.run(function($rootScope,$route,$http,$timeout,$location,$window,apiUrl,$cookies,Idle) {
 Idle.watch();
    // moment.locale('fr');
    /*if($cookies.get('user') === undefined){
        document.getElementById('logout').click();
    }*/
    $http.get(apiUrl+'auth_check').then(function (response) {
        if(response.data.auth_check==false){
            $cookies.remove('user');
            document.getElementById('logout').click();
        }
    })

    $rootScope.$on("$routeChangeSuccess", function (currentRoute, previousRoute) {
        $rootScope.page_title = $route.current.page_title;
    });

    $rootScope.$on("$routeChangeStart", function(currentRoute, next){

        $rootScope.LocationPath = $location.url();
        var permitted = false;
        if(next.$$route.permissions.length>0){
            if($cookies.get('user')){
                var RoleUser = JSON.parse($cookies.get('user')).TYPE

            }else{
                document.getElementById('logout').click();
            }
            if(RoleUser){

                angular.forEach(next.$$route.permissions, function(permission, index){
                    if (RoleUser.indexOf(permission) >= 0){
                        permitted = true;
                        return permitted;
                    }
                });
            }else{
                angular.forEach(next.$$route.permissions, function(permission, index){
                    if (permission =='visitor'){
                        permitted = true;
                        return permitted;
                    }
                });

            }

            if (!permitted){
                currentRoute.preventDefault();
                $location.path("/");
            }
        }else{
            permitted = true;
        }



    });
});

app.config(function($locationProvider, $routeProvider, $qProvider,$compileProvider,$sceDelegateProvider,KeepaliveProvider, IdleProvider) {
    IdleProvider.idle(7170);
    IdleProvider.timeout(30);
    KeepaliveProvider.interval(7200);

    IdleProvider.interrupt('keydown wheel mousedown touchstart touchmove scroll');
    $sceDelegateProvider.resourceUrlWhitelist([
        // Allow same origin resource loads.
        'self',
        'http://fonts.gstatic.com/**',
        'https://docs.google.com/**',
        'https://www.facebook.com/**',
        'https://view.officeapps.live.com/**'
    ]);
    $compileProvider.imgSrcSanitizationWhitelist(/^\s*(https?|local|data|chrome-extension):/);

    $qProvider.errorOnUnhandledRejections(false);
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });
    /**
     * Routes: DashBoard
     * */
    $routeProvider.
    when("/Dashboard",{
        templateUrl:"app/Modules/DashboardModule/Resources/views/index.html",
        page_title:'FormaCamp - Dashboard',
        permissions:['super_users','Admin','User']
    }).
    when("/Agenda",{
        templateUrl:"app/Modules/AgendaModule/Resources/views/index.html",
        page_title:'FormaCamp - Agenda',
        permissions:['super_users','Admin','User']
    }).
    when("/Organismes",{
        templateUrl:"app/Modules/DashboardModule/Resources/views/index.html",
        page_title:'FormaCamp - Organismes',
        permissions:['super_users']
    }).

    when("/Evaluation/:ref",{
        templateUrl:"app/Modules/Evaluations/Resources/views/index.html",
        page_title:'FormaCamp - Evaluations',
        permissions:[]
    }).
    when("/Bibliotheque/Programmes",{
        templateUrl:"app/Modules/ProgrammesModule/Resources/views/liste_programmes.html",
        page_title:'FormaCamp - Programmes',
        permissions:['Admin','User']
    }).
    when("/Bibliotheque/Programmes/Ajout",{
        templateUrl:"app/Modules/ProgrammesModule/Resources/views/crud_programmes.html",
        page_title:'FormaCamp - Programmes',
        permissions:['Admin','User']
    }).
    when("/Bibliotheque/Programmes/:id",{
        templateUrl:"app/Modules/ProgrammesModule/Resources/views/crud_programmes.html",
        page_title:'FormaCamp - Programmes',
        permissions:['Admin','User']
    }).
    when("/Sessions",{
        templateUrl:"app/Modules/SessionsModule/Resources/views/liste_sessions.html",
        page_title:'FormaCamp - Sessions',
        permissions:['Admin','User']
    }).
    when("/Sessions/Ajout",{
        templateUrl:"app/Modules/SessionsModule/Resources/views/add_sessions.html",
        page_title:'FormaCamp - Ajout Sessions',
        permissions:['Admin','User']
    }).
    when("/Sessions/AjoutProjet",{
        templateUrl:"app/Modules/SessionsModule/Resources/views/add_sessions.html",
        page_title:'FormaCamp - Ajout Projets',
        permissions:['Admin','User']
    }).
    when("/Sessions/:session_id",{
        templateUrl:"app/Modules/SessionsModule/Resources/views/add_sessions.html",
        page_title:'FormaCamp - Sessions',
        permissions:['Admin','User']
    }).
    when("/Sessions/:session_id/Modules",{
        templateUrl:"app/Modules/SessionsModule/Resources/views/liste_modules.html",
        page_title:'FormaCamp - Modules Session',
        permissions:['Admin','User']
    }).
    when("/Sessions/:session_id/Modules/:module_id/Dates&Prix",{
        templateUrl:"app/Modules/SessionsModule/Resources/views/crud_modules.html",
        page_title:'FormaCamp - Dates&Prix Module',
        permissions:['Admin','User']
    }).
    when("/Sessions/:session_id/Intervenants",{
        templateUrl:"app/Modules/SessionsModule/Resources/views/crud_intervenants.html",
        page_title:'FormaCamp - Sessions',
        permissions:['Admin','User']
    }).
    when("/Sessions/:session_id/Apprenants",{
        templateUrl:"app/Modules/SessionsModule/Resources/views/crud_apprenants.html",
        page_title:'FormaCamp - Sessions',
        permissions:['Admin','User']
    }).
    when("/Sessions/:session_id/Programme",{
        templateUrl:"app/Modules/SessionsModule/Resources/views/crud_programme.html",
        page_title:'FormaCamp - Sessions',
        permissions:['Admin','User']
    }).
    when("/Sessions/:session_id/Evaluations",{
        templateUrl:"app/Modules/SessionsModule/Resources/views/crud_evaluations.html",
        page_title:'FormaCamp - Evaluations',
        permissions:['Admin','User']
    }).
    when("/Sessions/:session_id/Suivi",{
        templateUrl:"app/Modules/SessionsModule/Resources/views/crud_suivi.html",
        page_title:'FormaCamp - Evaluations',
        permissions:['Admin','User']
    }).
    when("/Sessions/:session_id/Emargements",{
        templateUrl:"app/Modules/SessionsModule/Resources/views/crud_emargement.html",
        page_title:'FormaCamp - Emargements',
        permissions:['Admin','User']
    }).
    when("/Sessions/:session_id/Programme",{
        templateUrl:"app/Modules/SessionsModule/Resources/views/crud_programme.html",
        page_title:'FormaCamp - Programme',
        permissions:['Admin','User']
    }).
        /**
         * Routes: Données
         * 1-Utilisateurs
         * 2-Organismes
         * 3-Stagiaires
         * 4-Clients
         * 5-Formateurs
         * 6-Financeurs externes
         * 7-Lieux de formations
         * 8-Salles
         * */

        when("/GestionDonnees/Utilisateurs",{
            templateUrl:"app/Modules/AdminsModule/Resources/views/liste_admins.html",
            page_title:'FormaCamp - Utilisateurs',
            permissions:['Admin']
        }).
    when("/GestionDonnees/AjoutUtilisateurs",{
        templateUrl:"app/Modules/AdminsModule/Resources/views/crud_admins.html",
        page_title:'FormaCamp - Ajouter Utilisateur',
        permissions:['Admin']
    }).
    when("/GestionDonnees/ModifUtilisateurs/:id",{
        templateUrl:"app/Modules/AdminsModule/Resources/views/crud_admins.html",
        page_title:'FormaCamp - Modifier Utilisateur',
        permissions:['Admin']
    }).
    when("/GestionDonnees/CompteAccesUtilisateurs/:id",{
        templateUrl:"app/Modules/AdminsModule/Resources/views/crud_acces.html",
        page_title:'FormaCamp - Comptes d\'accès utilisateur',
        permissions:['Admin']
    }).


    when("/GestionDonnees/Organismes",{
        templateUrl:"app/Modules/OrganismesModule/Resources/views/liste_organismes.html",
        page_title:'FormaCamp - Organismes',
        permissions:['Admin']
    }).
    when("/GestionDonnees/AjoutOrganismes",{
        templateUrl:"app/Modules/OrganismesModule/Resources/views/crud_organismes.html",
        page_title:'FormaCamp - Ajouter Organisme',
        permissions:['Admin']
    }).
    when("/GestionDonnees/ModifOrganismes/:id",{
        templateUrl:"app/Modules/OrganismesModule/Resources/views/crud_organismes.html",
        page_title:'FormaCamp - Modifier Organisme',
        permissions:['Admin']
    }).




    when("/GestionDonnees/Stagiaires",{
        templateUrl:"app/Modules/StagiairesModule/Resources/views/liste_stagiaires.html",
        page_title:'FormaCamp - Stagiaires',
        permissions:['Admin','Stagiaires']
    }).
    when("/GestionDonnees/AjoutStagiaires",{
        templateUrl:"app/Modules/StagiairesModule/Resources/views/crud_stagiaires.html",
        page_title:'FormaCamp - Ajouter Stagiaire',
        permissions:['Admin','Stagiaires']
    }).
    when("/GestionDonnees/ModifStagiaires/:id",{
        templateUrl:"app/Modules/StagiairesModule/Resources/views/crud_stagiaires.html",
        page_title:'FormaCamp - Modifier Stagiaire',
        permissions:['Admin','Stagiaires']
    }).


    when("/GestionDonnees/Clients",{
        templateUrl:"app/Modules/ClientsModules/Resources/views/liste_clients.html",
        page_title:'FormaCamp - Clients',
        permissions:['Admin','Clients']
    }).
    when("/GestionDonnees/AjoutClients",{
        templateUrl:"app/Modules/ClientsModules/Resources/views/crud_clients.html",
        page_title:'FormaCamp - Ajouter Client',
        permissions:['Admin','Clients']
    }).
    when("/GestionDonnees/ModifClients/:id",{
        templateUrl:"app/Modules/ClientsModules/Resources/views/crud_clients.html",
        page_title:'FormaCamp - Modifier Clients',
        permissions:['Admin','Clients']
    }).



    when("/GestionDonnees/Formateurs",{
        templateUrl:"app/Modules/FormateursModule/Resources/views/liste_formateurs.html",
        page_title:'FormaCamp - Formateurs',
        permissions:['Admin']
    }).
    when("/GestionDonnees/AjoutFormateurs",{
        templateUrl:"app/Modules/FormateursModule/Resources/views/crud_formateurs.html",
        page_title:'FormaCamp - Ajouter Formateur',
        permissions:['Admin']
    }).
    when("/GestionDonnees/ModifFormateurs/:id",{
        templateUrl:"app/Modules/FormateursModule/Resources/views/crud_formateurs.html",
        page_title:'FormaCamp - Modifier Formateur',
        permissions:['Admin']
    }).
    when("/GestionDonnees/CompteAccesFormateurs/:id",{
        templateUrl:"app/Modules/FormateursModule/Resources/views/crud_acces.html",
        page_title:'FormaCamp - Comptes d\'accès formateur',
        permissions:['Admin']
    }).

    when("/GestionDonnees/FinanceursExternes",{
        templateUrl:"app/Modules/FinanceursExternesModule/Resources/views/liste_financeurs.html",
        page_title:'FormaCamp - Financeurs Externes',
        permissions:['Admin']
    }).
    when("/GestionDonnees/AjoutFinanceursExternes",{
        templateUrl:"app/Modules/FinanceursExternesModule/Resources/views/crud_financeurs.html",
        page_title:'FormaCamp - Ajouter Financeur Externe',
        permissions:['Admin']
    }).
    when("/GestionDonnees/ModifFinanceursExternes/:id",{
        templateUrl:"app/Modules/FinanceursExternesModule/Resources/views/crud_financeurs.html",
        page_title:'FormaCamp - Modifier Financeur Externe',
        permissions:['Admin']
    }).

    when("/GestionDonnees/LieuxDeFormation",{
        templateUrl:"app/Modules/LieuxFormationModule/Resources/views/liste_lieux_formation.html",
        page_title:'FormaCamp - Lieux De Formation',
        permissions:['Admin']
    }).
    when("/GestionDonnees/AjoutLieuxDeFormation",{
        templateUrl:"app/Modules/LieuxFormationModule/Resources/views/crud_lieux_formation.html",
        page_title:'FormaCamp - Ajouter Lieux De Formation',
        permissions:['Admin']
    }).
    when("/GestionDonnees/ModifLieuxDeFormation/:id",{
        templateUrl:"app/Modules/LieuxFormationModule/Resources/views/crud_lieux_formation.html",
        page_title:'FormaCamp - Modifier Lieux De Formation',
        permissions:['Admin']
    }).

    when("/GestionDonnees/Salles",{
        templateUrl:"app/Modules/SallesModule/Resources/views/liste_salles.html",
        page_title:'FormaCamp - Salles',
        permissions:['Admin']
    }).

    when("/GestionDonnees/Domaines",{
        templateUrl:"app/Modules/DomainesModule/Resources/views/liste_domaines.html",
        page_title:'FormaCamp - Domaines de formation',
        permissions:['Admin']
    }).
    when("/GestionDonnees/Diplomes",{
        templateUrl:"app/Modules/DiplomesModule/Resources/views/liste_diplomes.html",
        page_title:'FormaCamp - Diplomes de formation',
        permissions:['Admin']
    }).
    when("/GestionDonnees/Actions",{
        templateUrl:"app/Modules/ActionsFormationModule/Resources/views/liste_actions.html",
        page_title:'FormaCamp - Actions de formation',
        permissions:['Admin']
    }).


        /**
         * Routes: Compte
         * 1-Profil
         * 2-Mon abonnement
         * 3-Comptes d'accès
         * 4-Extranet
         * 5-Catalogue en ligne
         * 6-Modeles de documents
         * 7-Modeles d'emails
         * 8-Modele de listes des taches
         * 9-Gestion des compétences
         * */

        /** 1-Profil **/
        when("/GestionCompte/Profil",{
            templateUrl:"app/Modules/CompteModule/Resources/views/profil.html",
            page_title:'FormaCamp - Profil',
            permissions:['Admin']
        }).
    when("/GestionCompte/Profil/:id",{
        templateUrl:"app/Modules/CompteModule/Resources/views/crud_profil.html",
        page_title:'FormaCamp - Modifier Profil',
        permissions:['Admin']
    }).
        /** 2-Mon abonnement1-Profil **/
        when("/GestionCompte/MonAbonnement",{
            templateUrl:"app/Modules/CompteModule/Resources/views/abonnement.html",
            page_title:'FormaCamp - Mon abonnement',
            permissions:['Admin']
        }).

        // when("/GestionCompte/AjoutCompteAcces",{
        //     templateUrl:"app/Modules/CompteModule/Resources/views/crud_acces.html",
        //     page_title:'FormaCamp - Ajouter Comptes d\'accès',
        //     permissions:['Admin']
        // }).
        // when("/GestionCompte/ModifCompteAcces/:id",{
        //     templateUrl:"app/Modules/CompteModule/Resources/views/crud_acces.html",
        //     page_title:'FormaCamp - Modifier Comptes d\'accès',
        //     permissions:['Admin']
        // }).
        /** 4-Extranet1-Profil **/
        when("/GestionCompte/Extranet",{
            templateUrl:"app/Modules/CompteModule/Resources/views/extranet.html",
            page_title:'FormaCamp - Extranet',
            permissions:['Admin']
        }).
        /** 5-Catalogue en ligne1-Profil **/
        when("/GestionCompte/CatalogueEnLigne",{
            templateUrl:"app/Modules/CompteModule/Resources/views/catalogue.html",
            page_title:'FormaCamp - Catalogue en ligne',
            permissions:['Admin']
        }).
        /** 6-Modeles de documents **/
        when("/GestionCompte/ModelesDeDocuments",{
            templateUrl:"app/Modules/CompteModule/Resources/views/documents.html",
            page_title:'FormaCamp - Modèles de documents',
            permissions:['Admin']
        }).
        /** 7-Modeles d'emails **/
        when("/GestionCompte/ModelesEmails",{
            templateUrl:"app/Modules/CompteModule/Resources/views/emails.html",
            page_title:'FormaCamp - Modèles d\'emails',
            permissions:['Admin']
        }).
        /** 8-Modele de listes des taches **/
        when("/GestionCompte/ModelesListeTaches",{
            templateUrl:"app/Modules/CompteModule/Resources/views/liste_taches.html",
            page_title:'FormaCamp - Modèles de listes des tâches',
            permissions:['Admin']
        }).
        /** 9-Gestion des compétences **/
        when("/GestionCompte/GestionCompetences",{
            templateUrl:"app/Modules/CompteModule/Resources/views/competences.html",
            page_title:'FormaCamp - Gestion des compétences',
            permissions:['Admin']
        }).


        /**
         * Routes: Rapport d'activité
         * 1-Suivi de l'activité
         * 2-Suivi des factures
         * 3-Suivi des devis
         * 4-Bilan Pédagogique
         * 5-Suivi Qualité
         * 6-Incidents Qualité
         * */

        /** 1-Suivi de l'activité **/
        when("/RapportActivite/SuiviActivite",{
            templateUrl:"app/Modules/RapportModule/Resources/views/activites.html",
            page_title:'FormaCamp - Suivi de l\'activité',
            permissions:['Admin']
        }).

        /** 2-Suivi des factures **/
        when("/RapportActivite/SuiviFactures",{
            templateUrl:"app/Modules/RapportModule/Resources/views/conventions.html",
            page_title:'FormaCamp - Suivi des factures',
            permissions:['Admin']
        }).

        /** 3-Suivi des devis **/
        when("/RapportActivite/SuiviDevis",{
            templateUrl:"app/Modules/RapportModule/Resources/views/devis.html",
            page_title:'FormaCamp - Suivi des devis',
            permissions:['Admin']
        }).

        /** 4-Bilan Pédagogique **/
        when("/RapportActivite/BilanPedagogique",{
            templateUrl:"app/Modules/RapportModule/Resources/views/pedagogiques.html",
            page_title:'FormaCamp - Bilan Pédagogique',
            permissions:['Admin']
        }).

        /** 5-Suivi Qualité **/
        when("/RapportActivite/SuiviQualite",{
            templateUrl:"app/Modules/CompteModule/Resources/views/competences.html",
            page_title:'FormaCamp - Suivi Qualité',
            permissions:['Admin']
        }).

        /** 6-Incidents Qualité **/
        when("/RapportActivite/IncidentQualite",{
            templateUrl:"app/Modules/CompteModule/Resources/views/competences.html",
            page_title:'FormaCamp - Incidents Qualité',
            permissions:['Admin']
        }).


        /**
         * Routes: Suivi commercial
         * 1-Suivi
         * 2-Inscriptions catalogue
         * */

        /** 1-Suivi **/
        when("/SuiviCommercial",{
            templateUrl:"app/Modules/SuiviModule/Resources/views/liste_suivi.html",
            page_title:'FormaCamp - Suivi',
            permissions:['Admin']
        }).
    when("/SuiviCommercial/AjoutSuiviClient",{
        templateUrl:"app/Modules/SuiviModule/Resources/views/crud_suivi.html",
        page_title:'FormaCamp - Ajouter Suivi Client',
        permissions:['Admin']
    }).
    when("/SuiviCommercial/AjoutSuiviParticulier",{
        templateUrl:"app/Modules/SuiviModule/Resources/views/crud_suivi_p.html",
        page_title:'FormaCamp - Ajouter Suivi Formateur',
        permissions:['Admin']
    }).
    when("/SuiviCommercial/ModifSuiviClient/:id",{
        templateUrl:"app/Modules/SuiviModule/Resources/views/crud_suivi.html",
        page_title:'FormaCamp - Ajouter Suivi Client',
        permissions:['Admin']
    }).
    when("/SuiviCommercial/ModifSuiviParticulier/:id",{
        templateUrl:"app/Modules/SuiviModule/Resources/views/crud_suivi_p.html",
        page_title:'FormaCamp - Ajouter Suivi Formateur',
        permissions:['Admin']
    }).
        /** 2-Inscriptions catalogue **/
        when("/SuiviCommercial/InscriptionsCatalogue",{
            templateUrl:"app/Modules/SuiviModule/Resources/views/liste_catalogue.html",
            page_title:'FormaCamp - Inscriptions catalogue',
            permissions:['Admin']
        }).

        /**
         * Routes: Notifications
         * */
        when("/Notifications",{
            templateUrl:"app/Modules/CompteModule/Resources/views/competences.html",
            page_title:'FormaCamp - Notifications',
            permissions:['Admin']
        }).
        /**
         * Routes: Messagerie
         * */
        when("/Messagerie",{
            templateUrl:"app/Modules/MessagerieModule/Resources/views/inbox.html",
            page_title:'FormaCamp - Messagerie',
            permissions:['Admin']
        }).
    when("/Messagerie/NouveauMessage",{
        templateUrl:"app/Modules/MessagerieModule/Resources/views/send.html",
        page_title:'FormaCamp - Nouveau Messagerie',
        permissions:['Admin']
    }).
        /**
         * Routes: 404 not found
         * */

        when("/Contrat",{
            templateUrl:"app/Modules/SessionsModule/Resources/views/contrat.html",
            page_title:'FormaCamp - Contrat',
            permissions:['Admin']
        }).
        when("/Devis",{
            templateUrl:"app/Modules/SessionsModule/Resources/views/devis.html",
            page_title:'FormaCamp - Devis',
            permissions:['Admin']
        }).
        when("/Emargement",{
            templateUrl:"app/Modules/SessionsModule/Resources/views/emargement.html",
            page_title:'FormaCamp - Emargement',
            permissions:['Admin']
        }).
        otherwise({
            templateUrl:"app/Modules/DashboardModule/Resources/views/404.html",
            page_title:' FormaCamp - 404'
        })
});
app.filter('json_array', function() {
    return function(input) {
        return JSON.parse(input);
    }
});
app.filter('beginning_data', function() {
    return function(input, begin) {
        if (input) {
            begin = +begin;
            return input.slice(begin);
        }
        return [];
    }
});
app.filter('date_between', function() {
    return function(items,start,end) {
        var result = [];
        items.forEach(function (item) {
            if(moment(item.DATE).isSameOrAfter(start) && moment(item.DATE).isSameOrBefore(end)){
                result.push(item);
            }
        })
        return  result;
    };
});
app.filter('date_search', function() {
    return function(items,start,end) {

        if(items != undefined){
            var result = [];
            if( start != null && end == null){
                items.forEach(function (item) {
                    if(moment(item.DEBUT).isSameOrAfter(start)){
                        result.push(item);
                    }
                })
            }
            if(start == null && end != null){
                items.forEach(function (item) {
                    if(moment(item.FIN).isSameOrBefore(end)){
                        result.push(item);
                    }
                })
            }
            if(start != null && end != null){
                items.forEach(function (item) {
                    if(moment(item.DEBUT).isSameOrAfter(start) && moment(item.FIN).isSameOrBefore(end)){
                        result.push(item);
                    }
                })
            }
            if(start == null && end == null){
                return items;
            }
            return  result;
        }else{
            return items;
        }

    };
});

app.filter('date_filter', function() {
    return function(text) {
        // moment.locale('fr');
        var date =moment(text).format('LLLL');
        date = date[0].toUpperCase() + date.slice(1);
        return  date;
    };
});
app.filter('date_filter_sh', function() {
    return function(text) {
        // moment.locale('fr');
        var date =moment(text).format('dddd Do MMMM YYYY');
        date = date[0].toUpperCase() + date.slice(1);
        return  date;
    };
});
app.filter('date_filter_fr', function() {
    return function(text) {
        var date =moment(text).format('DD-MM-YYYY');
        date = date[0].toUpperCase() + date.slice(1);
        return  date;
    };
});
app.filter('hhmm', function() {
    return function(text) {
        return  moment(text,"HH:mm:ss").format('HH:mm');
    };
});
app.filter('date_filter_chart', function() {
    return function(text) {
        // moment.locale('fr');
        var date =moment(text).format('MMMM YYYY');
        date = date[0].toUpperCase() + date.slice(1);
        return  date;
    };
});
app.filter('trustAsResourceUrl', ['$sce', function($sce) {
    return function(val) {
        return $sce.trustAsResourceUrl(val);
    };
}]);
app.filter('trustAsHtml', function($sce) {
    return function(html) {
        return $sce.trustAsHtml(html);
    };
});
app.filter('time_message', function myDateFormat($filter) {
    return function (text) {
        var time;
        var tempdate = new Date(text);
        let now = moment.utc().subtract('hours',1);
        let duration = moment.duration(now.diff(tempdate));
        if(duration._data.months==0){
            if(duration._data.days==0){
                if(duration._data.hours==0) {
                    if(duration._data.minutes==0){
                        if(duration._data.seconds==0){
                            time=""+duration._data.milliseconds+' Milliseconde(s)';
                        }else{
                            time=""+duration._data.seconds+' Seconde(s)';
                        }
                    }else{
                        time=""+duration._data.minutes+' Minute(s)';
                    }
                }else{
                    time=""+duration._data.hours+' heures(s)';
                }
            }else{
                if(duration._data.days>1 && duration._data.days<7 ){
                    time=""+duration._data.days+' Jour(s)';
                }else{
                    time=moment(tempdate).format('LLLL');
                }

            }
        }else{
            time=moment(tempdate).format('LLLL');
        }
        return time;
    }
});
app.directive('fileInput', ['$parse', function ($parse) {
    return {
        scope: {
            input: "=",
            preview: "="
        },
        link: function(scope, element, attributes) {

            element.bind("change", function(changeEvent) {
                if(changeEvent.target.files[0]){
                    scope.input = changeEvent.target.files[0];
                    var reader = new FileReader();
                    reader.onload = function(loadEvent) {
                        scope.$apply(function() {
                            scope.preview = loadEvent.target.result;
                        });
                    }
                    reader.readAsDataURL(scope.input);
                    scope.name = scope.input.name;
                    scope.size = scope.input.size;
                }

            });
        }
    }
}])

app.directive("contenteditable", function () {
    return {
        restrict: "A",
        require: "ngModel",
        link: function (scope, element, attrs, ngModel) {
            // read is the main handler, invoked here by the blur event
            function read() {
                // Keep the newline value for substitutin
                // when cleaning the <br>
                var newLine = String.fromCharCode(10);
                // Firefox adds a <br> for each new line, we replace it back
                // to a regular '\n'
                var formattedValue = element.html().replace(/<br>/ig,newLine).replace(/\r/ig,'').replace(/&amp;/g, '').replace(/&nbsp;/g, '');
                // update the model
                ngModel.$setViewValue(formattedValue);
                // Set the formated (cleaned) value back into
                // the element's html.
                element.text(formattedValue);
            }

            ngModel.$render = function () {
                element.html(ngModel.$viewValue || "");
            };

            element.bind("blur", function () {

                scope.$apply(read);
            });
            element.bind("paste", function(e){

                e.preventDefault();
                document.execCommand('inserttext', false, e.clipboardData.getData('text/plain'));
            });
        }
    };
});
app.directive('sendMessage', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.sendMessage);
                });

                event.preventDefault();
            }
        });
    };
});
app.directive('folder', function() {
    return {
        restrict : 'AE',
        scope: {
            subHeight: '=?subHeight',
            item: '=data',
            diplomes: '=diplomesData',
            actions: '=actionsData',
            dataClass: '=classData',
            dataTypes: '=typesData',
            methods : '=?'
        },
        templateUrl: function(element, attrs) {
            return attrs.templateUrl;
        },
        controller: function($scope) {

            this.ExpandFolder = function  ExpandFolder(){

                if( this.TypeFolder == $scope.item.TypeFolder || this.TypeFolder == undefined) {

                    if (this.folder.began) {

                        this.folder.reverse();
                        if (
                            this.folder.progress === 100 &&
                            this.folder.direction === "reverse"
                        ) {
                            this.folder.completed = false;
                        }
                    }

                    if (this.folder.paused) {
                        this.folder.play();
                    }

                }

                if(this.TypeFolder == $scope.item.TypeFolder){
                    this.TypeFolder = undefined;
                }else{
                    this.TypeFolder = $scope.item.TypeFolder;
                }


            }

        },
        controllerAs: 'animationCtrl',
        link: function(scope, element, attr, ctrl) {
            scope.methods = scope.methods || {};
            scope.subHeight = scope.subHeight || 90;
            var el = element[0];
            ctrl.folder = anime.timeline({
                easing: "easeOutCubic",
                autoplay: false
            });

            setTimeout(function (){
                var e_height = scope.subHeight * el.querySelectorAll(".js_folder-item").length;

                ctrl.folder .add({
                    targets: el.querySelector("#js_folder-content"),
                    height: [0, e_height],
                    duration: 350
                }).add(
                    {
                        targets: el.querySelector("#js_folder-summary-amount"),
                        opacity: [1, 0],
                        duration: 400
                    },
                    "-=350"
                )
                    .add(
                        {
                            targets: el.querySelector("#js_folder-collapse-button"),
                            opacity: [0, 1],
                            duration: 400
                        },
                        "-=300"
                    )
                    .add(
                        {
                            targets: el.querySelector("#js_folder-collapse-button-icon"),
                            duration: 300,
                            translateX: ["-50%", "-50%"],
                            translateY: ["-50%", "-50%"],
                            rotate: ["0deg", "180deg"]
                        },
                        "-=400"
                    ).add(
                    {
                        targets: el.querySelectorAll(".js_folder-item"),
                        translateY: [20, 0],
                        opacity: [0, 1],
                        duration: 300,
                        delay: (el, i, l) => i * 120
                    },
                    "-=275"
                )  ;
            },500)

        }
    };
});
app.directive('folderModule', function() {
    return {
        restrict : 'AE',
        scope: {
            subHeight: '=?',
            data: '=module',
            gestionnaires: '=gestionnaires',
            types_seances: '=typesSeances',
            types_prix: '=typesPrix',
            tarifs_prix: '=tarifsPrix',
            salles: '=salles',
            dataClass: '=classData',
            methods : '=?'
        },
        templateUrl: function(element, attrs) {
            return attrs.templateUrl;
        },
        controller: function($scope) {

            this.ExpandFolder = function  ExpandFolder(){

                if( this.TypeFolder == $scope.data.TypeFolder || this.TypeFolder == undefined) {

                    if (this.folder.began) {

                        this.folder.reverse();
                        if (
                            this.folder.progress === 100 &&
                            this.folder.direction === "reverse"
                        ) {
                            this.folder.completed = false;
                        }
                    }

                    if (this.folder.paused) {
                        this.folder.play();
                    }

                }

                if(this.TypeFolder == $scope.data.TypeFolder){
                    this.TypeFolder = undefined;
                }else{
                    this.TypeFolder = $scope.data.TypeFolder;
                }


            }

        },
        controllerAs: 'animationCtrl',
        link: function(scope, element, attr, ctrl) {
            scope.methods = scope.methods || {};
            scope.subHeight = scope.subHeight || 90;
            var el = element[0];
            ctrl.folder = anime.timeline({
                easing: "easeOutCubic",
                autoplay: false
            });

            setTimeout(function (){
                var e_height = scope.subHeight * el.querySelectorAll(".js_folder-item").length;

                ctrl.folder .add({
                    targets: el.querySelector("#js_folder-content"),
                    height: [0, e_height],
                    duration: 350
                }).add(
                    {
                        targets: el.querySelector("#js_folder-summary-amount"),
                        opacity: [1, 0],
                        duration: 400
                    },
                    "-=350"
                )
                    .add(
                        {
                            targets: el.querySelector(".js_folder-collapse-button"),
                            opacity: [0, 1],
                            duration: 400
                        },
                        "-=300"
                    )
                    .add(
                        {
                            targets: el.querySelector("#js_folder-collapse-button-icon"),
                            duration: 300,
                            translateX: ["-50%", "-50%"],
                            translateY: ["-50%", "-50%"],
                            rotate: ["0deg", "180deg"]
                        },
                        "-=400"
                    ).add(
                    {
                        targets: el.querySelectorAll(".js_folder-item"),
                        // translateY: [20, 0],
                        opacity: [0, 1],
                        duration: 300,
                        delay: (el, i, l) => i * 120
                    },
                    "-=275"
                )  ;
            },500)

        }
    };
});
app.directive( 'ngSeance', function () {
    return {
        scope: {
            seance:'=seance',
            index: '=index',
            salles: '=salles',
            types_seances: '=typesSeances',
            methods : '=?'
        },
        restrict: 'AE',
        templateUrl: function(element, attrs) {
            return attrs.templateUrl;
        },
        controllerAs: 'seanceCtrl',
        controller: function ( $scope, $element ,$attrs) {
            // $scope.$watchCollection('seance',function (seance){
            //     $scope.callback(seance);
            // })

        },
        link:function (scope){
            scope.methods = scope.methods || {};
        }
    };
});

app.directive('ngInputMask', function($timeout) {

    return {
        restrict: 'A',
        link: function (scope, element, attrs, ngModelCtrl) {
            var id=attrs.id?attrs.id:'myDiv';
            var mask=attrs.mask?attrs.mask:'text';

            $timeout(function () {
                new Inputmask(mask, { rightAlign: false }).mask($('#'+id));
            },1000)

        }
    };
});
app.directive("timeInput", function($timeout){
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ctrl) {
            ctrl.$parsers.push(function(data) {
                if (!data)
                    return "";
                return data;
            });

            ctrl.$formatters.push(function(data) {
                if (!data) {
                    return null;
                }
                var d = moment(data,'HH:mm').toDate();

                return d;
            });

        }
    };
});
app.directive("ngDateInput", function(){
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModelController) {
            ngModelController.$parsers.push(function(data) {
                if (!data)
                    return "";
                return data;
            });

            ngModelController.$formatters.push(function(data) {
                if (!data) {
                    return null;
                }

                var d = moment(data,'yyyy-MM-DD').startOf('day').toDate();
                return d;
            });
        }
    };
});

app.directive( 'todoList', function () {
    return {
        scope: {
            ins:'=data',
            index: '=index',
            methods : '=?',
            callback:'&'
        },
        restrict: 'AE',
        templateUrl: function(element, attrs) {
            return attrs.templateUrl;
        },
        controllerAs: 'todoCtrl',
        controller: function ( $scope, $element ,$attrs) {
            $scope.$watchCollection('ins',function (ins){
                $scope.callback(ins);
            })

        },
        link:function (scope){
            scope.methods = scope.methods || {};
        }
    };
});

app.directive('ngNav', function($location,CurrentUser,$routeParams,$rootScope,$http,apiUrl) {

    return {
        restrict: 'A',
        link: function (scope, element, attrs, ngModelCtrl) {
            var acces = attrs.acces || '';
            if(acces == ''){
                var permitted = false;
                if(CurrentUser.TYPE.includes('Admin')){
                    permitted = true;
                }
                else if (CurrentUser.TYPE.includes(acces)) {
                    permitted = true;
                }
                if(!permitted){
                    element.remove();
                }
            }
            scope.$on("$routeChangeSuccess", function () {
                var sessionPath = $location.path().toLowerCase().search('sessions/'+$routeParams.session_id);

                if(sessionPath>-1){
                    scope.$watch('session_id',function (session_id){
                        if(session_id != $routeParams.session_id){
                            $rootScope.session_id = $routeParams.session_id;
                            $rootScope.session_name = '';
                            $http.get(apiUrl+'FormaCampAPI/Sessions/'+$rootScope.session_id).then(function (response) {
                                $rootScope.session_name = response.data.NOM;
                                $rootScope.isSessionOpen = true;
                            })
                        }
                    })

                }else{

                    $rootScope.isSessionOpen = false;
                    $rootScope.session_id = undefined;
                    $rootScope.session_name = '';
                }

                var ul =  $location.url().split('/');

                switch(ul[1]){
                    case 'GestionDonnees':
                        $rootScope.isDonneesOpen = true;
                        break;
                    case 'Bibliotheque':
                        $rootScope.isBibliothequeOpen = true;
                        break;
                    case 'RapportActivite':
                        $rootScope.isRapportOpen = true;
                        break;
                }
                var pos =  $location.path().toLowerCase().search(attrs.module.toLowerCase());
                if(pos>-1){
                    element.addClass('active');
                }else{
                    element.removeClass('active');
                }

           });
        }
    };
});
app.directive('checkboxGroup', function() {
    return {
        restrict: 'EA',
        replace: true,
        transclude: true,
        template: '<div ng-transclude></div>',
        require: 'ngModel',
        priority: -1,
        scope: {
            name: '@'
        },
        controller: function($scope, $element, $attrs, $timeout, $rootScope, $compile) {
            var checkboxes, dummyInput, ngModel, update, watcher;
            ngModel = $element.controller('ngModel');
            dummyInput = angular.element("<input style=\"display:none\" type=\"text\" name=\"{{name}}\" ng-model=\"selected\">");
            $element.append(dummyInput);
            $compile(dummyInput)($scope);
            checkboxes = [];
            update = function() {
                $scope.selected = ['', 'selected'][+checkboxes.some(function(scope) {
                    return scope.checked;
                })];
                return $timeout(function() {
                    return $element.attr('class', dummyInput.attr('class'));
                }, 0);
            };
            ngModel.$render = function() {
                return angular.forEach(checkboxes, function(scope) {
                    scope.checked = false;
                    return angular.forEach(ngModel.$viewValue, function(value) {
                        if (scope.value !== value) {
                            return;
                        }
                        scope.checked = true;
                        return update();
                    });
                });
            };
            $timeout(ngModel.$render, 0);
            watcher = function(newValue, oldValue) {
                var arr;
                if (angular.isUndefined(oldValue)) {
                    update();
                }
                if (newValue === oldValue) {
                    return;
                }
                arr = ngModel.$viewValue;
                arr.length = 0;
                checkboxes.forEach(function(scope) {
                    if (scope.checked) {
                        return arr.push(scope.value);
                    }
                });
                return update();
            };
            this.name = $scope.name;
            this.addCheckbox = function(scope) {
                checkboxes.push(scope);
                return scope.$watch("checked", watcher);
            };
            this.removeCheckbox = function(scope) {
                var i;
                i = checkboxes.indexOf(scope);
                if (i === -1) {
                    return;
                }
                return checkboxes.splice(i, 1);
            };
        }
    };
});
app.directive('checkbox', function() {
    return {
        restrict: 'EA',
        replace: true,
        transclude: true,
        require: '^checkboxGroup',
        scope: {
            value: '@'
        },
        template: "<div>" +
            "<input type=\"checkbox\" name=\"{{name}}\" value=\"1\" id=\"{{$id}}\" class=\"form-check-input\" ng-model=\"checked\">" +
            "<label ng-transclude for=\"{{$id}}\" class=\"form-check-label\" ng-class=\"{checked: checked}\">" +
            "</label>" +
            "</div>",
        link: function(scope, element, attrs, ctrl, transclude) {
            scope.name = ctrl.name;
            ctrl.addCheckbox(scope);
            return scope.$on('destory', function() {
                return ctrl.removeCheckbox(scope);
            });
        }
    };
})
app.directive('ngCheckbox', function() {
    return {
        restrict: 'EA',
        replace: true,
        transclude: true,
        require: '^checkboxGroup',
        scope: {
            value: '@',
            disabled: '@'
        },
        template: "<div class='custom-control custom-checkbox'>" +
            "<input ng-disabled=\"{{disabled}}\" type=\"checkbox\" name=\"{{name}}\" value=\"1\" id=\"{{$id}}\" class=\"custom-control-input\" ng-model=\"checked\">" +
            "<label ng-transclude for=\"{{$id}}\" class=\"custom-control-label w-100 border-bottom pl-3\" ng-class=\"{checked: checked}\">" +
            "</label>" +
            "</div>",
        link: function(scope, element, attrs, ctrl, transclude) {
            scope.name = ctrl.name;
            scope.disabled = ctrl.disabled;
            ctrl.addCheckbox(scope);
            return scope.$on('destory', function() {
                return ctrl.removeCheckbox(scope);
            });
        }
    };
})
app.directive( 'ngQuest', function () {
    return {
        scope: {
            quest:'=quest',
            index: '=index',
            methods : '=?'
        },
        restrict: 'AE',
        templateUrl: function(element, attrs) {
            return attrs.templateUrl;
        },
        controllerAs: 'seanceCtrl',
        controller: function ( $scope, $element ,$attrs) {

        },
        link:function (scope){
            scope.methods = scope.methods || {};
        }
    };
});
