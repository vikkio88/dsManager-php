(function () {
    "use strict";

    angular.module("DsManager")
        .controller(
            "LeaguesController",
            [
                "Common",
                "$stateParams",
                LeaguesController
            ]);

    function LeaguesController(Common, $stateParams) {
        var vm = this;
        vm.leagues = [];

        Common.Get
        (
            "leagues"
        ).then(
            function (data) {
                if (Common.isDebug()) console.log(data.data);
                vm.leagues = data.data;
            },
            function (data) {
                console.log(data);
            }
        );
    }

})();