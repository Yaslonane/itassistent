<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImagesController
 *
 * @author adm_azashchepkin
 */
class ImagesController {
    //put your code here
    public function actionUpload(){
        
        $_SESSION['link'] = $_SERVER['HTTP_REFERER'];
        
        if(isset($_POST['upload'])) {
            $id_prn = $_POST['print_id'];
            if(!Images::checkAndDeleteImg($id_prn)) echo "Ошибка загрузки изображения";// проверка наличия изображения у принтера и удаление из файловой системы
            else{ 
                $link_img = Images::uploadImg($_POST);

                if($link_img == "Error upload image") echo "Ошибка загрузки изображения";
                else{
                    if(!Images::updatePrintImg($id_prn, $link_img)) echo "Ошибка загрузки изображения";
                    else header("Location: ".$_SESSION['link']); 
                }
            }
            /*
            echo "<pre>";
            var_dump($_SESSION);
            echo "<br />----------------------<br />";
            var_dump($_POST);
            echo "<br />----------------------<br />";
            var_dump($_FILES);
            echo "</pre>";
             * 
             * 
             * array(13) {
                ["link"]=>
                string(35) "http://prints.local/printer/edit/49"
                ["user_id"]=>
                string(12) "azashchepkin"
                ["name_en"]=>
                string(19) "Zashchepkin, Andrey"
                ["name"]=>
                string(16) "Защепкин"
                ["surname"]=>
                string(12) "Андрей"
                ["middle_name"]=>
                string(26) "Александрович"
                ["full_name"]=>
                string(56) "Защепкин Андрей Александрович"
                ["city"]=>
                string(10) "Курск"
                ["position"]=>
                string(62) "Специалист технической поддержки"
                ["department"]=>
                string(60) "Отдел информационных технологий"
                ["mail"]=>
                string(25) "azashchepkin@rencredit.ru"
                ["phone"]=>
                string(5) "15000"
                ["georol"]=>
                string(16) "GR.RC.Курск"
              }

              ----------------------
              array(2) {
                ["print_id"]=>
                string(2) "49"
                ["upload"]=>
                string(0) ""
              }

              ----------------------
              array(1) {
                ["img"]=>
                array(5) {
                  ["name"]=>
                  string(13) "error wfm.png"
                  ["type"]=>
                  string(9) "image/png"
                  ["tmp_name"]=>
                  string(39) "C:\OpenServer\userdata\temp\php5D63.tmp"
                  ["error"]=>
                  int(0)
                  ["size"]=>
                  int(50663)
                }
              }
             */
        }
        
        return true;
        
    }
}
