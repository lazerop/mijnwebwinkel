<?php

class DBObject {

    protected static function selectByQuery($query, $values = null) {
        $db = $GLOBALS['main_db'];

        $sth = $db->prepare($query);

        $sth->execute($values);

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    protected static function query($query, $values = null) {
        $db = $GLOBALS['main_db'];

        $sth = $db->prepare($query);

        $sth->execute($values);
    }

}

class Product extends DBObject {
    public static function getAll() {
        return Product::selectByQuery("SELECT * FROM product");
    }

    public static function orderByUser($product_id, $user_id) {

        // Method to order a product for a user. At this point it just order 1, and can be called more then once to order more
        Product::query("INSERT INTO `order` (product_id, user_id) VALUES (:product_id, :user_id)", array(
            "product_id" => $product_id,
            "user_id" => $user_id
        ));
    }
}

class User extends DBObject {
    public static function checkCredentials($username, $password) {
        return User::selectByQuery("SELECT * FROM user WHERE name =:name AND password=:password", array(
            "name" => $username,
            "password" => md5($password . $GLOBALS['password_salt'])
        ));

    }

    public static function setLoggedIn($user_id) {
        User::query("UPDATE user SET logged_in = :logged_in WHERE id =:id", array(
            "logged_in" => true,
            "id" => $user_id
        ));
    }

    public static function setLoggedOut($username) {
        User::query("UPDATE user SET logged_in = :logged_in WHERE name =:name", array(
            "logged_in" => false,
            "name" => $username
        ));
    }

    public static function isLoggedIn($user_id) {
        $user = User::selectByQuery("SELECT * FROM user WHERE id=:id AND logged_in=:logged_in", array(
            "id" => $user_id,
            "logged_in" => true
        ));

        if (sizeof($user) > 0) {
            return true;
        } else {
            return false;
        }
    }
}