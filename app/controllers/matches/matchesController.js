(function () {
    "use strict";

    angular.module("DsManager")
        .controller(
            "MatchesController",
            [
                "Common",
                "$scope",
                "$stateParams",
                MatchesController
            ]);

    function MatchesController(Common, $scope, $stateParams) {
        var vm = this;
        vm.matches = [];

        Common.Get
        (
            "matches"
        ).then(
            function (data) {
                if (Common.isDebug()) console.log(data.data);
                vm.matches = data.data;
            },
            function (data) {
                console.log(data);
            }
        );
    }

})();