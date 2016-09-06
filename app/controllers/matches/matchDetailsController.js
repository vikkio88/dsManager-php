(function () {
    "use strict";

    angular.module("DsManager")
        .controller(
            "MatchDetailsController",
            [
                "Common",
                "$scope",
                "$stateParams",
                MatchDetailsController
            ]);

    function MatchDetailsController(Common, $scope, $stateParams) {
        var vm = this;
        vm.match = {};

        Common.Get
        (
            "matches/" + $stateParams.matchId + "/result"
        ).then(
            function (data) {
                if (Common.isDebug()) console.log(data.data);
                vm.match = data.data;
            },
            function (data) {
                console.log(data);
            }
        );
    }

})();