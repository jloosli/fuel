'use strict';

angular.module('fuel').factory('stateFactory', function($window) {
    var state = {},
        message = '',
        linkText = '',
        link = '',
        autolink = false;


    state.addMessage = function(msg, duration) {
        duration = duration || 5000;
        message = msg;
    };

    state.getMessage = function() {
        return message;
    };

    state.addLink = function(theLink, theLabel, auto) {
        link = theLink;
        linkText = theLabel;
        autolink = !!auto;
    };

    state.getLink = function() {
        if(link === '') return false;
        if(autolink) {
            $window.open(link,'_blank');
            autolink = false;
        }
        var thelink = '<a target="_blank" href="' + link + '">' + linkText + '</a>';
        linkText = link = '';
        return thelink;
    };
    return state;
});
