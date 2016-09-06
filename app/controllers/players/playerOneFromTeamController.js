(function () {
    "use strict";

    angular.module("DsManager")
        .controller(
            "PlayerOneFromTeamController",
            [
                "Common",
                "$scope",
                "$stateParams",
                PlayerOneFromTeamController
            ]);

    function PlayerOneFromTeamController(Common, $scope, $stateParams) {
        var vm = this;
        vm.player = {};

        Common.Get
        (
            "teams/" + $stateParams.teamId + "/players/" + $stateParams.playerId
        ).then(
            function (data) {
                if (Common.isDebug()) console.log(data.data);
                vm.player = data.data[0];
            },
            function (data) {
                console.log(data);
            }
        );
    }

})();