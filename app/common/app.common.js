(function () {
    "use strict";
    var common = angular.module("app.common",
        []
    );

    common.factory("Common", function (config, $http) {
        return {
            isDebug: function () {
                return config.env == "DEBUG";
            },
            Get: function (uri) {
                return $http.get(
                    config.apiUrl + uri
                );
            },
            Put: function (uri, body) {
                return $http.put(
                    config.apiUrl + uri,
                    JSON.stringify(body)
                );
            },
            Post: function (uri, body) {
                return $http.post(
                    config.apiUrl + uri,
                    JSON.stringify(body)
                );
            }
        }
    });

})();