'use strict';

angular.module('fuel').controller('checksController', function ($scope, $state, $sce, stateFactory, restFactory, $stateParams) {
    restFactory.Checks.get(function(result) {
        $scope.checks = result.checks;
        if($stateParams['id']) {
            $scope.check = _.find($scope.checks, function(check) {
                return check.id === $stateParams['id'];
            });
            restFactory.Checks.getVouchers({id: $stateParams['id']}, function(result) {
                $scope.check.vouchers = result.vouchers;
            });
        }
    });

    $scope.message = stateFactory.getMessage();
    var link = stateFactory.getLink();
    if(link) {
        $scope.link = $sce.trustAsHtml(link);
    }

    $scope.addCheck = function() {
        console.log($scope.check);
        restFactory.addCheck($scope.check);
        $state.go('checksIndex');
        stateFactory.addMessage('success');
    }
});