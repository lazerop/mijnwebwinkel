'use strict';

(function () {
    angular
        .module('webcart')
        .controller('ContentCtrl', ContentCtrl);

    function ContentCtrl ($scope, $rootScope, restLocation, session, $http, $timeout) {
        $scope.messages = {};
        $scope.cartOpen = false;

        $http.get(restLocation + '/cart/' + session.loggedin_user_id + '/size').then(
            function(data) {$scope.cart_size = data.data});

        $rootScope.$on('product ordered', function(event, args) {
            // Add temporary message
            var messages = $scope.messages;
            var timestamp = Date.now();

            messages[timestamp] = 'Product ' + args['product']['name'] + ' added to cart';

            $timeout(function () {
                delete messages[timestamp];
            }, 3000);

            // Add 1 to cart
            $scope.cart_size++

        });

        $scope.openCart = function() {
            $scope.cartOpen = true;
        };

        $scope.closeCart = function() {
            $scope.cartOpen = false;
        };
}
})();

