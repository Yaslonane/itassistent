<?php include ROOT . TMPL . 'header.php'; ?>
		<form action="" method="post">
			<div class="row">
				 <div class="col-xs-3">
					<input type="text" class="form-control" name="name" placeholder="Name print" <?php if(isset($_POST['name'])) echo "value='".$_POST['name']."'"; ?>> 
				</div>
				<div class="col-xs-3">
				  <select class="form-control input" name="floor">
					<option value="" selected>Выберите этаж </option>
                                        <?php foreach($floor as $fl): ?>
                                        <option value="<?php echo $fl['id']; ?>" <?php if(isset($_POST['floor']) && $_POST['floor'] == $fl['id']) echo "selected"; ?>><?php echo $fl['name']; ?></option>
                                        <?php endforeach; ?>
				  </select>
				</div>
				<div class="col-xs-3">
					<select class="form-control input" name="cartrige">
					<option value="" selected>Выберите Картридж</option>
					<?php foreach($cartrige as $ct): ?>
                                        <option value="<?php echo $ct['id']; ?>" <?php if(isset($_POST['cartrige']) && $_POST['cartrige'] == $ct['id']) echo "selected"; ?>><?php echo $ct['name']; ?></option>
                                        <?php endforeach; ?>
				  </select>
				</div>
			</div>
			<br>
			<div class="row">
				 <div class="col-xs-3">
					<input type="text" class="form-control" name="unit" placeholder="Number Unit" <?php if(isset($_POST['unit'])) echo "value='".$_POST['unit']."'"; ?>>
				</div>
				<div class="col-xs-3">
				  <select class="form-control input" name="department">
                                        <option value="" selected>Выберите Отдел</option>
					<?php foreach($department as $dp): ?>
                                        <option value="<?php echo $dp['id']; ?>" <?php if(isset($_POST['department']) && $_POST['department'] == $dp['id']) echo "selected"; ?>><?php echo $dp['name']; ?></option>
                                        <?php endforeach; ?>
				  </select>
				</div>
				<div class="col-xs-3">
				  <select class="form-control input" name="status">
                                        <option value="" selected>Выберите Статус</option>
					<?php foreach($status as $st): ?>
                                        <option value="<?php echo $st['id']; ?>" <?php if(isset($_POST['status']) && $_POST['status'] == $st['id']) echo "selected"; ?>><?php echo $st['name']; ?></option>
                                        <?php endforeach; ?>
				  </select>
				</div>
				<div class="col-xs-3">
					<button type="submit" name="submit" class="btn btn-primary">Выбрать</button>
				</div>
			</div>
		</form>
		<hr>
		<br>
                <p>Всего принтеров в работе: <?php echo count($printList);  ?> шт.</p>
		<div class="row">
		  <!-- 1 Изображение -->
                  <?php if($printList == 0) :  ?>
                  
                      <div class="panel panel-warning">
                        <div class="panel-heading">
                          <h3 class="panel-title">Warning!!!</h3>
                        </div>
                        <div class="panel-body text-center">
                            <h3>Принтеров с введенными параментрами не найдено, извините </h3>
                        </div>
                      </div>
                  <?php else : ?>
                  <?php foreach ($printList as $print): ?>
                    <div class="col-sm-6 col-md-4">
                          <div class="thumbnail">
                              <?php if($print['img'] != ""): ?>
                                    <img src="<?php echo $print['img']; ?>" alt="...">
                               <?php else: ?>
                                    <img src="img/not_img_print.png" alt="...">
                              <?php endif; ?>
                            <div class="caption">
                                  <h3><?php echo $print['name']; ?></h3>
                                  <p>Расположение <strong><?php echo $print['id_floor']; ?></strong></p>
                                  <p>Отдел <strong><?php echo $print['id_department']; ?></strong></p>
                                  <p>Юнит <strong><?php echo $print['unit']; ?></strong></p>
                                  <p>Модель <strong><?php echo $print['model']; ?></strong></p>
                                  <p><a href="/printer/<?php echo $print['id']; ?>" class="btn btn-primary" role="button">Подробнее</a> 
                                  <?php if(user::checkAdmin() == true): ?>    
                                    <a href="/printer/edit/<?php echo $print['id']; ?>" class="btn btn-default" role="button">Редактировать</a></p>
                                  <?php endif; ?>
                            </div>
                          </div>
                    </div>
                  <?php endforeach; ?>
                  <?php endif; ?>
		</div>
<?php include ROOT . TMPL . 'footer.php'; ?>