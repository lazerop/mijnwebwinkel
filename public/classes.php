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
}