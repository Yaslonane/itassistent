<?php include ROOT . TMPL . 'header.php'; ?>

    <div class="row">
        <div class="col-md-4">
                <?php if($print['img'] != ""): ?>
                    <img class="img-responsive" src="<?php echo $print['img']; ?>" alt="...">
                <?php else: ?>
                    <img class="img-responsive" src="/img/not_img_print.png" alt="...">
                <?php endif; ?>
                    <!-- Кнопка, вызывающее модальное окно -->
                    <br><a href="#up_img_print" class="btn btn-primary" data-toggle="modal">Сменить изображение</a>  
                    <!-- HTML-код модального окна -->
                    <div id="up_img_print" class="modal fade">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <!-- Заголовок модального окна -->
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Upload image by printer</h4>
                          </div>
                          <!-- Основное содержимое модального окна -->
                          <div class="modal-body">
                            <form enctype="multipart/form-data" action="/imgupload" method="post" name="upload"> 
                                <input name="print_id" type="hidden" value="<?php echo $print['id']; ?>"/>   
                                <input name="img" type="file" />
                          </div>
                          <!-- Футер модального окна -->
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary" name="upload">Сохранить изображение</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    
        </div>
        <div class="col-md-8">
             <?php if(Printer::message() != false): ?>
                <?php if($_SESSION['message'] == "good"): ?>
                    <!-- Сообщение об успешном выполнения действия -->
                    <div class="alert alert-success">
                    <!-- Кнопка для закрытия сообщения, созданная с помощью элемента button -->
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        Изменения сохранены.
                    </div>
            
                <?php else: ?>
                    <!-- Сообщение об ошибке -->
                    <div class="alert alert-danger">
                    <!-- Кнопка для закрытия сообщения, созданная с помощью элемента a -->
                    <a href="#" class="close" data-dismiss="alert">×</a>
                    Неизвестная ошибка при передаче данных.
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <form action="" method="post">
            <h4>ID <strong><?php echo $print['id']; ?></strong></h4><br>
            <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $print['name']; ?>"><br>
            <input type="text" class="form-control" name="unit" placeholder="#Unit" value="<?php echo $print['unit']; ?>"><br>
            <input type="text" class="form-control" name="model" placeholder="Model" value="<?php echo $print['model']; ?>"><br>
            <input type="text" class="form-control" name="sn" placeholder="Серийный" value="<?php echo $print['sn']; ?>"><br>
            <input type="text" class="form-control" name="inventar" placeholder="Инвентарный" value="<?php echo $print['inventar']; ?>"><br>

            <select class="form-control" name="id_floor" >
                    <option selected>Этаж</option>
                    <?php foreach($floor as $fl): ?>
                        <option value="<?php echo $fl['id']; ?>" <?php if($print['id_fl'] == $fl['id']) echo "selected"; ?>><?php echo $fl['name']; ?></option>
                    <?php endforeach; ?>
                        
            </select><br>
            <select class="form-control" name="id_department" >
                    <option selected>Отдел</option>
                    <?php foreach($department as $dp): ?>
                        <option value="<?php echo $dp['id']; ?>" <?php if($print['id_dep'] == $dp['id']) echo "selected"; ?>><?php echo $dp['name']; ?></option>
                    <?php endforeach; ?>
            </select><br>
            <select class="form-control" name="id_cartrige" >
                    <option selected>Картридж</option>
                    <?php foreach($cartrige as $c): ?>
                        <option value="<?php echo $c['id']; ?>" <?php if($print['id_cart'] == $c['id']) echo "selected"; ?>><?php echo $c['name']; ?></option>
                    <?php endforeach; ?>
            </select><br>
            <select class="form-control" name="id_status" >
                    <option selected>Статус</option>
                    <?php foreach($status as $st): ?>
                        <option value="<?php echo $st['id']; ?>" <?php if($print['id_st'] == $st['id']) echo "selected"; ?>><?php echo $st['name']; ?></option>
                    <?php endforeach; ?>
            </select><br>
            <label>Функционал</label>
            
            <table>
                <tr>
                    <td>
                        <select id="src_countries" style="width:270px" class='select form-control' multiple="multiple" size="10">
                                <option disabled selected>Выберите функцию</option>
                                <?php foreach($functions as $fn): ?>
                                    <option value="<?php echo $fn['id']; ?>"><?php echo $fn['name']; ?></option>   <!-- <?php //if($print['functions'][$i]['id'] == $fn['id']) echo "selected"; ?>-->
                                <?php endforeach; ?>                 
                        </select>        
                    </td>
                    <td>
                                        <p><button type="button" id="take" >&gt;&gt;</button></p>
                                        <p><button type="button" id="drop" >&lt;&lt;</button></p>        
                    </td>
                    <td>
                       <select name="id_functions[]" id="dst_countries" style="width:270px" multiple="multiple" size="10" class='select form-control'>
                             <option disabled selected>Выбраные функции</option>
                            <?php if($print['functions'] != "Отсутствует"):?>
                                <?php for($i=0; $i < count($print['functions']); $i++): ?>
                                        <option value="<?php echo $print['functions'][$i]['id']; ?>"><?php echo $print['functions'][$i]['name']; ?></option>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </select>        
                    </td>
                </tr>
            </table>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>

                       
                        <hr>
                        <br>
<?php include ROOT . TMPL . 'footer.php'; ?>