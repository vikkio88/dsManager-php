(
    function() {
        "use strict";

        angular.module("DsManager")
            .controller(
                "SimulateLeagueRoundController",
                [
                    "Common",
                    "$stateParams",
                    SimulateLeagueRoundController
                ]);

        function SimulateLeagueRoundController(
            Common,
            $stateParams
        )
        {
            var vm = this;
            vm.matches = [];

            Common.Put
            (
                "leagues/"+$stateParams.leagueId+"/rounds/"+$stateParams.roundId+"/simulate"
            ).then(
                function(data){
                    if(Common.isDebug()) console.log(data.data);
                    vm.matches = data.data;
                },
                function(data){
                    console.log(data);
                }
            );
        }

    }
)();