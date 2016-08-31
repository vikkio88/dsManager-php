(function () {
    "use strict";
    var directives = angular.module("app.directives",
        []
    );
    // Functional
    directives.directive('eatClickIf', ['$parse', '$rootScope',
        function($parse, $rootScope) {
            return {
                // this ensure eatClickIf be compiled before ngClick
                priority: 100,
                restrict: 'A',
                compile: function($element, attr) {
                    var fn = $parse(attr.eatClickIf);
                    return {
                        pre: function link(scope, element) {
                            var eventName = 'click';
                            element.on(eventName, function(event) {
                                var callback = function() {
                                    if (fn(scope, {$event: event})) {
                                        // prevents ng-click to be executed
                                        event.stopImmediatePropagation();
                                        // prevents href
                                        event.preventDefault();
                                        return false;
                                    }
                                };
                                if ($rootScope.$$phase) {
                                    scope.$evalAsync(callback);
                                } else {
                                    scope.$apply(callback);
                                }
                            });
                        },
                        post: function() {}
                    }
                }
            }
        }
    ]);
    //Utils
    directives.directive('pagination', function () {
        return {
            restrict: 'AE',
            replace: false,
            templateUrl: 'app/views/common/pagination.html'
        }
    });

    directives.directive('textfilterfull', function () {
        return {
            restrict: 'AE',
            replace: false,
            templateUrl: 'app/views/common/textfilterfull.html'
        }
    });
    directives.directive('roundimagesample', function () {
        return {
            rescrict: 'AE',
            replace: false,
            templateUrl: 'app/views/common/roundimagesample.html'
        }
    });
    // Common
    directives.directive('flagIcon', function () {
       return {
           restrict: 'AE',
           replace: false,
           scope: {
               nationality:"=nationality"
           },
           templateUrl: 'app/views/common/shared/flagIcon.html'
       }
    });

    // Template directives
    directives.directive('singleteamh2', function () {
            return {
                restrict: 'AE',
                replace: false,
                scope:{
                    team : '=team'
                },
                templateUrl: 'app/views/common/team/singleTeamH2.html'
            }
        }
    );

    directives.directive('scorersList', function () {
            return {
                restrict: 'AE',
                replace: false,
                scope:{
                    scorers : '=scorers'
                },
                templateUrl: 'app/views/common/match/scorersList.html'
            }
        }
    );

    directives.directive('teamCompleteRoster', function () {
            return {
                restrict: 'AE',
                replace: false,
                scope:{
                    team : '=team'
                },
                templateUrl: 'app/views/common/team/teamCompleteRoster.html'
            }
        }
    );

    directives.directive('teamSmallRoster', function () {
            return {
                restrict: 'AE',
                replace: false,
                scope:{
                    team : '=team'
                },
                templateUrl: 'app/views/common/team/teamSmallRoster.html'
            }
        }
    );
})();