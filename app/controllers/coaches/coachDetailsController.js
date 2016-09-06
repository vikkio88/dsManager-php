(function () {
    "use strict";

    angular.module("DsManager")
        .controller(
            "CoachDetailsController",
            [
                "Common",
                "$scope",
                "$stateParams",
                CoachDetailsController
            ]);

    function CoachDetailsController(Common, $scope, $stateParams) {
        var vm = this;
        vm.coach = {};

        Common.Get
        (
            "coaches/" + $stateParams.coachId
        ).then(
            function (data) {
                if (Common.isDebug()) console.log(data.data);
                vm.coach = data.data;
            },
            function (data) {
                console.log(data);
            }
        );
    }

})();