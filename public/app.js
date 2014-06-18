angular.module('fuel', ['ui.bootstrap', 'ui.utils', 'ui.router', 'ngAnimate','ngResource']);

angular.module('fuel').config(function ($stateProvider, $urlRouterProvider) {

    /* Add New States Above */
    $urlRouterProvider.otherwise('/home');
    $stateProvider
        .state('checksIndex', {
            url:         "/checks",
            templateUrl: 'checks/checks-partial/checks-partial.html',
            controller: 'checksController'
        })
        .state('checksAdd', {
            url:         "/checks/add",
            templateUrl: 'checks/checks-partial/checks-add-partial.html',
            controller: 'checksController'
        })
        .state('checkDetails', {
            url:         "/checks/{id:[0-9]+}",
            templateUrl: 'checks/checks-partial/checks-detail-partial.html',
            controller: 'checksController'
        })


});

angular.module('fuel').run(function ($rootScope) {

    $rootScope.safeApply = function (fn) {
        var phase = $rootScope.$$phase;
        if (phase === '$apply' || phase === '$digest') {
            if (fn && (typeof(fn) === 'function')) {
                fn();
            }
        } else {
            this.$apply(fn);
        }
    };

});
