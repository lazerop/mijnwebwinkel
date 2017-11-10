'use strict';

(function () {
    angular
        .module('webcart')
        .controller('ProductsCtrl', ProductsCtrl);

    function ProductsCtrl ($scope, $http, restLocation) {
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
        }
    }
})();
