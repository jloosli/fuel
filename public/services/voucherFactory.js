'use strict';

angular.module('fuel').factory('voucherFactory', function($resource) {
    var factory = {},
        Checks = $resource('/api/checks'),
        Vouchers = $resource('/api/vouchers');

    factory.addCheck = function(check) {
        Checks.amount = check.amount;
        Checks.check_no = check.check_no;
        Checks.date_issued = check.date_issued;
        Checks.$save();
    };

    factory.addVouchers = function() {
        return message;
    };

    factory.verifyVoucher = function(id) {

    };
    return factory;
});