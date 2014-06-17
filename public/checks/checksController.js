'use strict';

angular.module('fuel').controller('checksController', function ($scope, $state, stateFactory, voucherFactory) {
    $scope.checks = [1, 2, 3, 4, 5, 6, 7, 8];

    $scope.message = stateFactory.getMessage();

    $scope.addCheck = function() {
        console.log($scope.check);
//        voucherFactory.addCheck($scope.check);
        $state.go('checksIndex');
        stateFactory.addMessage('success');
    }
});