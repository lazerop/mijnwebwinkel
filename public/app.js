'use strict';

(function() {
    angular
        .module('webcart', [])
        .run(function () {
        })

        .config(function () {
        })

        .value('restLocation', 'http://localhost:8080')

        .value('session', {
            'loggedin_user_id': 1,
            'valid': true
        })
})();
