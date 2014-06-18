'use strict';

angular.module('fuel').factory('stateFactory', function() {
    var state = {};
    var message = '';

    state.addMessage = function(msg, duration) {
        duration = duration || 5000;
        message = msg;
    };

    state.getMessage = function() {
        return message;
    };
    return state;
});
