(
    function() {
        "use strict";
        var app_routes = angular.module("app.routes",
            [
                "ui.router",
                "ncy-angular-breadcrumb"
            ]
        );

        app_routes.config(
            [
                "$stateProvider",
                "$urlRouterProvider",
                "$locationProvider",
                function(
                    $stateProvider,
                    $urlRouterProvider,
                    $locationProvider
                )
                {
                    /*
                    Unfortunately laravel router makes this unable to work
                    $locationProvider.html5Mode({
                        enabled: true,
                        requireBase: false
                    });
                    */

                    //Hashbang
                    $locationProvider.hashPrefix("!");

                    $urlRouterProvider.otherwise("/teams");

                    $stateProvider
                    //Ping
                        .state("ping",
                            {
                                url:"/ping",
                                templateUrl: "app/views/sampleView.html",
                                controller: "SampleController as vm",
                                ncyBreadcrumb: {
                                    label: 'Ping'
                                }
                            }
                        )
                        //Teams
                        .state("teams",
                            {
                                url:"/teams",
                                templateUrl: "app/views/teams/teamsListView.html",
                                controller: "TeamsController as vm",
                                ncyBreadcrumb: {
                                    label: 'Teams'
                                }
                            }
                        )
                        .state("teamOne",
                            {
                                url:"/teams/:teamId",
                                templateUrl: "app/views/teams/teamDetails.html",
                                controller: "TeamDetailsController as vm",
                                ncyBreadcrumb: {
                                    parent: 'teams',
                                    label: 'Team Details'
                                }
                            }
                        )


                    ;
                }]
        );

    }
)();