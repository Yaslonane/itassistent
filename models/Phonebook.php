<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Phonebook
 *
 * @author adm_azashchepkin
 */
class Phonebook {
    //put your code here
    public static function gelAllPhoneList($is_activ = 1){
        
        $db = Db::getConnection();
        $arr_dep = Array();
        
        if($is_activ == 1){
            $result = $db->query('SELECT id, department FROM dep');
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $i = 0;
            while($row = $result->fetch()){
                $arr_dep[$i]['id'] = $row['id'];
                $arr_dep[$i]['department'] = $row['department'];
                $i++;
            for($j = 0; count($arr_dep)>$j; $j++){
                $phonelist[$arr_dep[$j]['department']] = self::getPhoneInDepartment($arr_dep[$j]['id'], $is_activ);
            }
            }
            }else{
            $phonelist = self::getPhoneInDepartment(0, $is_activ);
        }
        
        return $phonelist;
    }
    
    private static function getPhoneInDepartment($id_department = 0, $is_activ = 1){
        $db = Db::getConnection();
        $id = intval($id_department);
        $list = [];
        $sql = "SELECT book.id AS id, book.name AS name, book.mac_address AS mac, book.number AS number, book.post AS post, book.parent_post_id AS parent_id, book.subordination_id AS subordination, book.activ AS activ, dep.department AS department
                FROM book
                LEFT JOIN dep
                ON book.department_id = dep.id";
        if($id_department != 0){
            $sql .= " WHERE book.department_id = ".$id;
        }
        if($is_activ == 1){
            $sql .= " AND book.activ = 1";
        }
        $sql .= " ORDER BY book.department_id, book.subordination_id, book.post;";
        
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while($row = $result->fetch()){
            if($row == NULL) break;
            foreach($row as $key=>$value){
                $list[$i][$key] = $value;
            }
            $i++;
        }
        
        return $list;
    }
    
    public static function gerResultSearch($searching, $is_adm = 0){
        
        $db = Db::getConnection();
        $list = false;
        $sql = "SELECT book.id AS id, book.name AS name, book.mac_address AS mac, book.number AS number, book.post AS post, book.activ AS activ, dep.department AS department
                FROM book
                LEFT JOIN dep
                ON book.department_id = dep.id
                WHERE book.number LIKE '%".$searching."%' OR book.name LIKE '%".$searching."%' OR book.mac_address LIKE '%".$searching."%' ";
        if($is_adm == 0) $sql .= " ORDER BY  book.department_id, book.subordination_id, book.post;";
        else $sql .= " ORDER BY book.activ, book.number;";
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while($row = $result->fetch()){
            if($row == NULL) break;
            foreach($row as $key=>$value){
                $list[$i][$key] = $value;
            }
            $i++;
        }
        
        return $list;
    }
    
    public static function getExcelList(){
        include ROOT.'/lib/phpexcel/PHPExcel.php';
        $phone_list = self::gelAllPhoneList();
        
        $excel = new PHPExcel();
        $excelRead = PHPExcel_IOFactory::createReader('Excel2007');
        $excel = $excelRead->load('phonebook.xlsx');
        $excel->setActiveSheetIndex(0);
        
        # массив с параметрами
        $arHeadStyle = array(
                'background'=> array(
                    'color' => array('rgb' => 'ff0000')
                ),
                'font'  => array(
                    'bold'  => true,
                    'color' => array('rgb' => '778899'),
                    'size'  => 13,
                    'name'  => 'Verdana'
                    )
            );
        
        $i = 2;
        
        foreach($phone_list as $key => $value){
            
            $excel->getActiveSheet()->mergeCells("A".$i.":C".$i."");
            $excel->getActiveSheet()->setCellValue('A'.$i,$key);
            $excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($arHeadStyle);
            $i++;
            for($j = 0; count($value) > $j; $j++){
                $excel->getActiveSheet()->setCellValue('A'.$i,$value[$j]['name'])
                                        ->setCellValue('B'.$i,$value[$j]['number'])
                                        ->setCellValue('C'.$i,$value[$j]['post']);
                $i++;
            }
            
        }
        
        //Отдаем на скачивание
        header("Content-Type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=Телефонный Справочник на ".date("d-m-Y").".xlsx");

        $Writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        
        return $Writer->save('php://output');
        
    }
    
    public static function changeIsActiv($id){
        
        $db = Db::getConnection();
        $result = $db->query('SELECT * FROM book WHERE id='.$id);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        
        $activ = $row['activ'];
        
        if($activ == 0) {$activ = 1;}
        else {$activ = 0;}
        
        $stmt = $db->prepare("UPDATE book SET activ = :activ WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':activ', $activ);
        $stmt->execute();
        return true;
    }
    
    public static function getElementByID($id){
        $id = intval($id);
        $db = Db::getConnection();
        
        $sql = "SELECT book.id AS id, book.name AS name, book.mac_address AS mac, book.number AS number, book.post AS post, book.parent_post_id AS parent_id, book.subordination_id AS subordination, book.department_id AS department, book.activ AS activ, book.login AS login
                FROM book
                WHERE book.id=".$id.";";
        
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        
        return $row;
    } 
    
    public static function getSubordination(){

        $db = Db::getConnection();
        
        $sql = "SELECT * FROM subordination;";
        
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
        while($row = $result->fetch()){
            if($row == NULL) break;
            foreach($row as $key=>$value){
                $list[$i][$key] = $value;
            }
            $i++;
        }
        
        return $list;
    } 
    
    public static function getParents(){

        $db = Db::getConnection();
        
        $sql = "SELECT id, name FROM book WHERE subordination_id IN (1,2,3,4) AND activ = 1;";
        
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
        while($row = $result->fetch()){
            if($row == NULL) break;
            foreach($row as $key=>$value){
                $list[$i][$key] = $value;
            }
            $i++;
        }
        
        return $list;
    } 
    
    public static function getDepatmnents(){

        $db = Db::getConnection();
        
        $sql = "SELECT id, department FROM dep;";
        
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
        while($row = $result->fetch()){
            if($row == NULL) break;
            foreach($row as $key=>$value){
                $list[$i][$key] = $value;
            }
            $i++;
        }
        
        return $list;
    }
    
    public static function save($data) {
        $db = Db::getConnection();
        /*array(11) {
            ["id"]=>
            string(1) "1"
            ["name"]=>
            string(27) "Токарева Олеся"
            ["number"]=>
            string(5) "15005"
            ["mac"]=>
            string(15) "SEP001D70FCF8B8"
            ["parent_id"]=>
            string(1) "0"
            ["subord"]=>
            string(1) "1"
            ["department"]=>
            string(1) "1"
            ["login"]=>
            string(65) "intranet.rencredit.ru/my/Person.aspx?accountname=rccf%5Cotokareva"
            ["post"]=>
            string(18) "  Директор"
            ["activ"]=>
            string(2) "on"
            ["save"]=>
            string(0) ""
          }*/
        $id = filter_input(INPUT_POST, 'id');
        $name = filter_input(INPUT_POST, 'name');
        $number = filter_input(INPUT_POST, 'number');
        $mac = filter_input(INPUT_POST, 'mac');
        $parent_id = filter_input(INPUT_POST, 'parent_id');
        $subord = filter_input(INPUT_POST, 'subord');
        $department = filter_input(INPUT_POST, 'department');
        $login = filter_input(INPUT_POST, 'login');
        $post = filter_input(INPUT_POST, 'post');
        $activ = filter_input(INPUT_POST, 'activ');
        $activ == NULL ? $activ = 0 : $activ =1; 
 
        $stmt = $db->prepare("UPDATE book SET name=:name, number=:number, mac_address=:mac, parent_post_id=:parent_id, subordination_id=:subord, department_id=:department, login=:login, post=:post, activ=:activ WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':mac', $mac);
        $stmt->bindParam(':parent_id', $parent_id);
        $stmt->bindParam(':subord', $subord);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':post', $post);
        $stmt->bindParam(':activ', $activ);

        return $stmt->execute();
    }
}
