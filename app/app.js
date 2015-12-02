(
    function(){
      "use strict";
        var app = angular.module("DsManager",
            [
                "app.constant",
                "app.routes",
                "app.common",
                "app.directives"
            ]
        );

        //UcFirst
        app.filter('capitalize',
            function(){
                return function(input){
                    return (!!input) ? input.charAt(0).toUpperCase()+input.substr(1).toLowerCase() : "";
                }
            }
        );
    }
)();