(
    function() {
        "use strict";

        angular.module("DsManager")
            .controller(
                "LeagueRoundDetailsController",
                [
                    "Common",
                    "$stateParams",
                    LeagueRoundDetailsController
                ]);

        function LeagueRoundDetailsController(
            Common,
            $stateParams
        )
        {
            var vm = this;
            vm.matches = [];

            Common.Get
            (
                "leagues/"+$stateParams.leagueId+"/rounds/"+$stateParams.roundId+"/matches"
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