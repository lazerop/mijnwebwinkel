'use strict';

(function () {
    angular
        .module('webcart')
        .controller('LoginCtrl', LoginCtrl);

    function LoginCtrl ($scope, $http, restLocation, session) {
        $scope.session = {};

        $scope.login = function () {
            console.log(' login f');

            $http.get(restLocation + '/login/' + $scope.session.username + '/' + $scope.session.password).then(
                function (data) {
                    // Successful login
                    if (data.data) {
                        session.valid = true;
                        session.loggedin_user_id = data.data;
                        $scope.error = '';
                    }
                }, function () {
                    // Wrong login
                    $scope.error = 'There was an error logging in. Try again.'
            })
        };

        $scope.sessionIsValid = function () {
            return session.valid;
        };

        $scope.logout = function () {
            session.valid = false;
            session.loggedin_user_id = null;
        };
    }
})();

