'use strict';

(function () {
    angular
        .module('webcart')
        .controller('CartCtrl', CartCtrl);

    function CartCtrl ($scope, $http, restLocation, session) {
        $http.get(restLocation + '/cart/' + session.loggedin_user_id).then(function (data) {
            $scope.orders = data.data;

            $scope.order_grand_total = 0;
            $scope.orders.forEach(function(order) {
              order.total_price = parseFloat(order.price_before_tax) * (parseFloat(order.tax_percentage) / 100 + 1);

                $scope.order_grand_total += order.total_price;
            });


        });

    }
})();

