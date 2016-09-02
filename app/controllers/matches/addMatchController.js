(function () {
        "use strict";

        angular.module("DsManager")
            .controller(
                "AddMatchController",
                [
                    "Common",
                    "$scope",
                    "$stateParams",
                    AddMatchController
                ]);

        function AddMatchController(Common,
                                    $scope,
                                    $stateParams) {
            var vm = this;
            vm.newMatch = {};
            vm.matches = [];

            if ($stateParams.homeId !== undefined && $stateParams.awayId !== undefined) {
                Common.Post
                (
                    "matches",
                    {
                        home_team_id: $stateParams.homeId,
                        away_team_id: $stateParams.awayId
                    }
                ).then(
                    function (data) {
                        if (Common.isDebug()) console.log(data.data);
                        vm.newMatch = data.data;
                        Common.Get
                        (
                            "matches"
                        ).then(
                            function(data){
                                if(Common.isDebug()) console.log(data.data);
                                vm.matches = data.data;
                            },
                            function(data){
                                console.log(data);
                            }
                        );
                    },
                    function (data) {
                        console.log(data.data);
                    }
                );
            } else {
                Common.Get
                (
                    "matches"
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
    })();