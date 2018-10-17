<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author andrey
 */
class user {
    //put your code here
    
    /*public static function register($name, $password, $email){
        
        $db = Db::getConnection();
        
        $sql = 'INSERT INTO user (name, password, email) VALUES (:name, :password, :email)';
        
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        
        return $result->execute();
        
    }*/
    
    public static function checkAuth(){
        if(isset($_SESSION['user_id'])) return true;
        else return false;
    }
    
    public static function checkAdmin(){
        if(isset($_SESSION['user_id']) && ($_SESSION['department'] == "Отдел информационных технологий")) return true;
        else return false;
    }
    
   /* public static function checkName($name){
        
        if(strlen($name) >= 2){
            return true;
        }
        return false;
    }
    
    public static function checkPassword($password){
        
        if(strlen($password) >= 6){
            return true;
        }
        return false;
    }
    
    public static function checkEmail($email){
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }
    
    public static function checkEmailExists($email){
        
        $db = Db::getConnection();
        
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';
        
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();
        
        if($result->fetchColumn())
            return true;
        return false;
    }
    
    public static function checkUserData($email, $password){
        
        $db = Db::getConnection();
        
        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';
        
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_INT);
        $result->execute();
        
        $user = $result->fetch();
        if($user){
            return $user['id'];
        }
        return false;
    }
    
    public static function checkLogged(){
        
        if($_SESSION['user']){
            return $_SESSION['user'];
        }
        
        header("location: /user/login/");
    }

        public static function auth($userId){

        $_SESSION['user'] = $userId;
    }
    
    public static function isGuest(){
        if(isset($_SESSION['user'])){
            return false;
        }
        return true;
    }
    
    public static function getUserById($id) {
        if ($id){
            
            $db = Db::getConnection();
            
            $sql = 'SELECT * FROM user WHERE id = :id';
            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();
            
            return $result->fetch();
        }
    }
    
    public static function edit($id, $name, $password, $email){
        
        $db = DB::getConnection();
        
        $sql = 'UPDATE user SET name=:name, password=:password, email=:email WHERE id=:id';
        
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_INT);
        $result->bindParam(':email', $email, PDO::PARAM_INT);
         return $result->execute();
    }*/
    
}
