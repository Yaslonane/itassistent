<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ldap
 *
 * @author azashchepkin
 */
class Ldap {
    
   /*
    public function __construct() {
        $this->ldaphost = LDAP_HOST;
        $this->ldapport = LDAP_PORT;
        $this->base = LDAP_BASE;
        $this->filter = LDAP_FILTER;
        $this->domain = LDAP_DOMAIN;
    }*/
    //put your code here
    public static function LdapAuth($username, $pass){
        
        $paramsPath = ROOT.'/config/ldap_config.php';
        $params = include($paramsPath);

        $login = $username.$params['ldap_domain'];
        $password = $pass;
        //подсоединяемся к LDAP серверу
        $ldap = ldap_connect($params['ldap_host'], $params['ldap_port']) or die("Cant connect to LDAP Server");
         //Включаем LDAP протокол версии 3
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        if ($ldap){
            // Пытаемся войти в LDAP при помощи введенных логина и пароля
            $bind = ldap_bind($ldap,$login,$password);
            if ($bind)
                  {
                  // Проверим, является ли пользователь членом указанной группы.
                  $result = ldap_search($ldap,$params['ldap_base'],$params['ldap_filter'].$username);//"(||(memberOf=".$memberof.")(".$filter.$username."))"
                  // Получаем количество результатов предыдущей проверки
                  $result_ent = ldap_get_entries($ldap,$result);
                  //return $result_ent;
            }
            else
                  {
                  return ('Вы ввели неправильный логин или пароль. попробуйте еще раз<br /> <a href="index.php">Вернуться назад</a>');
            }
      }
      
      // Если пользователь найден, то пропускаем его дальше и перебрасываем на main.php
      if ($result_ent['count'] != 0)
            {
            $_SESSION['user_id'] = $username;
            $_SESSION['name_en'] = $result_ent[0]['cn'][0];
            $_SESSION['name'] = $result_ent[0]['extensionattribute1'][0];
            $_SESSION['surname'] = $result_ent[0]['extensionattribute2'][0];
            $_SESSION['middle_name'] = $result_ent[0]['extensionattribute3'][0];
            $_SESSION['full_name'] = $result_ent[0]['extensionattribute4'][0];
            $_SESSION['city'] = $result_ent[0]['l'][0];
            $_SESSION['position'] = $result_ent[0]['title'][0];
            $_SESSION['department'] = $result_ent[0]['extensionattribute7'][0];
            $_SESSION['mail'] = $result_ent[0]['mail'][0];
            $_SESSION['phone'] = $result_ent[0]['telephonenumber'][0];
            $_SESSION['georol'] = $result_ent[0]['renaissancegeorole'][0];
            $_SESSION['photo'] = $result_ent[0]['jpegphoto'][0];
			/*Фото из ad 
			$photo = $result_ent[0]['jpegphoto'][0];
			$img = imagecreatefromstring($photo); 
			header("Content-type: image/jpeg");
			imagejpeg($img,NULL,100);	
			echo "<img src=/index.php />";
			
			echo "<pre>";
			var_dump($result_ent);
			echo "</pre>";*/
            //header('Location: main.php');
            //exit;
      }
      else
            {
            die('К сожалению, вам доступ закрыт<br /> <a href="index.php">Вернуться назад</a>');
      }
    }
    
}
