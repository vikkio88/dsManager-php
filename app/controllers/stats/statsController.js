(function () {
    "use strict";

    angular.module("DsManager")
        .controller(
            "StatsController",
            [
                "Common",
                StatsController
            ]);

    function StatsController(Common) {
        var vm = this;
        vm.stats = {};

        Common.Get
        (
            "statistics"
        ).then(
            function (data) {
                if (Common.isDebug()) console.log(data.data);
                vm.stats = data.data;
            },
            function (data) {
                console.log(data);
            }
        );
    }

})();