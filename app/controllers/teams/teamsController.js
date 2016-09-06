(function () {
    "use strict";

    angular.module("DsManager")
        .controller(
            "TeamsController",
            [
                "Common",
                "$scope",
                "$stateParams",
                TeamsController
            ]);

    function TeamsController(Common, $scope, $stateParams) {
        var vm = this;
        vm.teams = [];

        Common.Get
        (
            "teams"
        ).then(
            function (data) {
                if (Common.isDebug()) console.log(data.data);
                vm.teams = data.data;
            },
            function (data) {
                console.log(data);
            }
        );
    }

})();