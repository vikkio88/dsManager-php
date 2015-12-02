(
    function() {
        "use strict";

        angular.module("DsManager")
            .controller(
                "PlayerDetailsController",
                [
                    "Common",
                    "$scope",
                    "$stateParams",
                    PlayerDetailsController
                ]);

        function PlayerDetailsController(
            Common,
            $scope,
            $stateParams
        )
        {
            var vm = this;
            vm.player = {};

            Common.Get
            (
                "players/"+$stateParams.playerId
            ).then(
                function(data){
                    if(Common.isDebug()) console.log(data.data);
                    vm.player = data.data;
                },
                function(data){
                    console.log(data);
                }
            );
        }

    }
)();