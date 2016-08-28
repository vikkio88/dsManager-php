(
    function() {
        "use strict";

        angular.module("DsManager")
            .controller(
                "SimulateMatchController",
                [
                    "Common",
                    "$scope",
                    "$stateParams",
                    SimulateMatchController
                ]);

        function SimulateMatchController(
            Common,
            $scope,
            $stateParams
        )
        {
            var vm = this;
            vm.match = {};

            Common.Put
            (
                "matches/"+$stateParams.matchId+"/simulate"
            ).then(
                function(data){
                    if(Common.isDebug()) console.log(data.data);
                    vm.match = data.data;
                },
                function(data){
                    console.log(data);
                }
            );
        }

    }
)();