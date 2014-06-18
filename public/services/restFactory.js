'use strict';

angular.module('fuel').factory('restFactory', function($resource) {
    var factory = {};

    factory.Checks = $resource('/api/checks/:id', {id: '@id'},{
        getVouchers: {url: '/api/checks/:id/vouchers'},
        getOpen: {url: '/api/checks/open'},
        addVouchers: {url: '/api/checks/:id/vouchers', 'method': 'POST'}
    });
    factory.Vouchers = $resource('/api/vouchers/:id', {id: '@id'});
    return factory;
});