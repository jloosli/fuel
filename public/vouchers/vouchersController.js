'use strict';

angular.module('fuel').controller('vouchersController', function ($scope, $state, stateFactory, restFactory) {
    restFactory.Checks.getOpen(function (results) {
        $scope.openChecks = _.map(results.checks, function (val) {
            var template = _.template("<%= check_no %> - $<%= remaining %> remaining");
            var remaining = (parseInt(val.amount) - parseInt(val.total_issued));
            val['label'] = template({check_no: val.check_no, remaining: remaining});
            val['remaining'] = remaining;
            return val;
        });
    });

    $scope.availableVouchers = function () {
        if ($scope.openChecks && $scope.voucher && $scope.voucher.check_id) {
            var current = _.find($scope.openChecks, function (check) {
                return check.id === $scope.voucher.check_id;
            });
            var available = current.remaining / 10;
            return _.range(1, available + 1);
        }
        return [];
    };

    $scope.message = stateFactory.getMessage();

    $scope.addVoucher = function () {
        var ids = '';
        restFactory.Checks.addVouchers({
            id:        $scope.voucher.check_id,
            issued_to: $scope.voucher.issued_to,
            vouchers:  $scope.voucher.vouchers
        }, function (result) {
            ids = result.meta.ids
            $state.go('checksIndex');
            var msg = 'Vouchers Added.';
            stateFactory.addMessage(msg);
            stateFactory.addLink('/vouchers/print/' + ids , "Download Vouchers", true);
        });

    }
});