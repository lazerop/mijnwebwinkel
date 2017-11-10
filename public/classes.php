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

        $ret_value = User::selectByQuery("SELECT COUNT(*) FROM user WHERE name =:name AND password=:password", array(
            "name" => $username,
            "password" => md5($password . $GLOBALS['password_salt'])
        ));

        return $ret_value[0]['COUNT(*)'] != "0";
    }

    public static function setLoggedIn($username) {
        User::query("UPDATE user SET logged_in = :logged_in WHERE name =:name", array(
            "logged_in" => true,
            "name" => $username
        ));
    }

    public static function setLoggedOut($username) {
        User::query("UPDATE user SET logged_in = :logged_in WHERE name =:name", array(
            "logged_in" => false,
            "name" => $username
        ));
    }
}