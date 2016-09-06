(function () {
    "use strict";

    angular.module("DsManager")
        .controller(
            "LeagueRoundDetailsController",
            [
                "Common",
                "$stateParams",
                LeagueRoundDetailsController
            ]);

    function LeagueRoundDetailsController(Common, $stateParams) {
        var vm = this;
        vm.round = {};

        Common.Get
        (
            "leagues/" + $stateParams.leagueId + "/rounds/" + $stateParams.roundId
        ).then(
            function (data) {
                if (Common.isDebug()) console.log(data.data);
                vm.round = data.data;
            },
            function (data) {
                console.log(data);
            }
        );
    }

})();