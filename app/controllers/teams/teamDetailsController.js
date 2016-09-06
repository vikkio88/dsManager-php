(function () {
    "use strict";

    angular.module("DsManager")
        .controller(
            "TeamDetailsController",
            [
                "Common",
                "$scope",
                "$stateParams",
                TeamDetailsController
            ]);

    function TeamDetailsController(Common, $scope, $stateParams) {
        $scope.orderByField = 'id';
        $scope.reverseSort = false;

        var vm = this;
        vm.team = {};
        vm.team.roster = [];

        Common.Get
        (
            "teams/" + $stateParams.teamId
        ).then(
            function (data) {
                if (Common.isDebug()) console.log(data.data);
                vm.team = data.data[0];
            },
            function (data) {
                console.log(data);
            }
        );
    }

})();