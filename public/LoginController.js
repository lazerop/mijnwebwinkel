'use strict';

(function () {
    angular
        .module('webcart')
        .controller('LoginCtrl', LoginCtrl);

    function LoginCtrl ($scope, $http, restLocation, $cookies) {

        $scope.login = function () {
            console.log(' login f');

            $http.get(restLocation + '/login/' + $scope.session.username + '/' + $scope.session.password).then(function (data) {
                console.log(data);
                if (data.data) {
                    // $scope.sessionIsValid = true

                    $cookies.loggedin =  'ffff';
                    console.log('cookie set');
                    console.log($cookies.loggedin);
                }
            })
        };

        $scope.sessionIsValid = function () {
            console.log(' sessionIsValid f');
            console.log($cookies.loggedin);

            return $cookies.get('loggedin') === true
        };

        $scope.resetPassword = function () {
            if (!$scope.session.email) return alert('Please enter your email-address');

            // todo: hack: use translation for message, move backend call somewhere else
            $http.post(restLocation + '/resetTokens', {email: $scope.session.email}).then(function () {
                alert('password reset email sent');
                alert('password reset email sent');
            })
        };
    }
})();

