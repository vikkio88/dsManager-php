(
    function() {
        "use strict";

        angular.module("DsManager")
            .controller(
                "NewMatchController",
                [
                    "Common",
                    "$scope",
                    "$stateParams",
                    NewMatchController
                ]);

        function NewMatchController(
            Common,
            $scope,
            $stateParams
        )
        {
            var vm = this;
            vm.teams = {};
            $scope.showAway = false;
            $scope.showHome = false;

            Common.Get
            (
                "teams"
            ).then(
                function(data){
                    if(Common.isDebug()) console.log(data.data);
                    vm.teams = data.data;
                },
                function(data){
                    console.log(data);
                }
            );
        }

    }
)();