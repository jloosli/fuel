'use strict';

angular.module('fuel').controller('checksController', function ($scope, $state, stateFactory, restFactory) {
    $scope.checks = [1, 2, 3, 4, 5, 6, 7, 8];
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
});