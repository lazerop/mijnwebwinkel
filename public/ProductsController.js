'use strict';

(function () {
    angular
        .module('webcart')
        .controller('ProductsCtrl', ProductsCtrl);

    function ProductsCtrl ($scope, $http, restLocation, session) {
        $http.get(restLocation + '/products').then(function (data) {
            $scope.products = data.data
        });

        $scope.showProductDetails = function (product_id) {
            $scope.products.forEach(function(product) {
              if (product.id === product_id) {
                  $scope.selectedProduct = product;
                  $scope.productSelected = true;
              }
            });
        };

        $scope.backToAllProducts = function() {
            $scope.productSelected = false;
        };

        $scope.orderProduct = function (product_id) {
            // Need to authenticate to order
            var user_id = session.loggedin_user_id;

            $http.get(restLocation + '/product/' + product_id + '/order/' + user_id).then(
                function(data) {
                    console.log(data);
                }, function (data) {
                    console.log('error ordering');
                    console.log(data);
                });
        }
    }
})();
