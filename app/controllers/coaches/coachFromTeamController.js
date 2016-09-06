(function () {
    "use strict";

    angular.module("DsManager")
        .controller(
            "CoachFromTeamController",
            [
                "Common",
                "$scope",
                "$stateParams",
                CoachFromTeamController
            ]);

    function CoachFromTeamController(Common, $scope, $stateParams) {
        var vm = this;
        vm.coach = {};

        Common.Get
        (
            "teams/" + $stateParams.teamId + "/coach"
        ).then(
            function (data) {
                if (Common.isDebug()) console.log(data.data);
                vm.coach = data.data[0].coach;
            },
            function (data) {
                console.log(data);
            }
        );
    }

})();