(
    function() {
        "use strict";

        angular.module("DsManager")
            .controller(
                "LeagueDetailsController",
                [
                    "Common",
                    "$stateParams",
                    LeagueDetailsController
                ]);

        function LeagueDetailsController(
            Common,
            $stateParams
        )
        {
            var vm = this;
            vm.league = {};

            Common.Get
            (
                "leagues/"+$stateParams.leagueId
            ).then(
                function(data){
                    if(Common.isDebug()) console.log(data.data);
                    vm.league = data.data;
                },
                function(data){
                    console.log(data);
                }
            );
        }

    }
)();