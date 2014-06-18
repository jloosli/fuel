'use strict';

angular.module('fuel').controller('checksController', function ($scope, $state, stateFactory, restFactory, $stateParams) {
    restFactory.Checks.get(function(result) {
        $scope.checks = result.checks;
    });

    $scope.message = stateFactory.getMessage();

    $scope.addCheck = function() {
        console.log($scope.check);
        restFactory.addCheck($scope.check);
        $state.go('checksIndex');
        stateFactory.addMessage('success');
    }

    if($stateParams['id']) {
        $scope.check = {
            check_num : 1234
        };
    }
});