<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Images
 *
 * @author adm_azashchepkin
 */
class Images {
    //put your code here
    public static function uploadImg(){
        
        if (!copy($_FILES['img']['tmp_name'], ROOT.IMG_PRN.$_FILES['img']['name']))
		echo 'Error upload image';
	else
		return  IMG_PRN.$_FILES['img']['name'];
        
    }
    
    public static function updatePrintImg($id_prn, $link_img){
    //формирование запроса и обновление данных в базе
        $db = Db::getConnection();
        //внесение денных об изменениях принтера в бд
        $stmt = $db->prepare("UPDATE print set img=:img WHERE id = :id");
        $stmt->bindParam(':id', $id_prn, PDO::PARAM_INT);
        $stmt->bindParam(':img', $link_img);
        
        return $stmt->execute();
    }
    
    public static function checkAndDeleteImg($id_prn){
        
        $info_prn = Printer::getPrintByIDFullData($id_prn);
        if(!$info_prn['img'] == ""){
            $filename = $info_prn['img'];
            rename(ROOT.$filename, ROOT.$filename."_old"); //переименование старого изображения
            //unlink(ROOT.$filename); //удаление старого изображения
            //echo $info_prn['img'];
            //echo ROOT.$filename."old";
            //var_dump($info_prn['img']);
            return true;
        }else return true;
    }
}
