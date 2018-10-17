<?php include ROOT . TMPL . 'header.php'; ?>
		<table class="table table-bordered">
			<caption><h2>Количество картриджей</h2> </caption>
			<thead>
				<tr>
                                    <?php for($i = 0; $i < count($summ_cart); $i++):?>
                                        <th><?php echo $summ_cart[$i]['name']; ?></th>
                                    <?php endfor;?>
				</tr>
			</thead>
			<tbody>
				<tr align="center">
                                    <?php for($i = 0; $i < count($summ_cart); $i++):?>
                                    <th <?php echo Cartriges::colorRow($summ_cart[$i]['value']); ?>><?php echo $summ_cart[$i]['value']; ?></th>
                                    <?php endfor;?>
				</tr>
			</tbody>
		</table>
                <?php if(user::checkAdmin() == true): ?> 
                    <p class="text-center">
                            <a href="http://<?php echo DOMEN; ?>/cartriges/action/?act=out" class="btn btn-warning"><i class="fa fa-sign-out" aria-hidden="true"></i> Замена</a>
                            <a href="http://<?php echo DOMEN; ?>/cartriges/action/?act=in" class="btn btn-success"><i class="fa fa-sign-in" aria-hidden="true"></i> Доставка</a>
                            <a href="http://<?php echo DOMEN; ?>/cartriges/orders" class="btn btn-inverse"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Заказ</a>
                    </p>
                <?php endif; ?> 
		</br>
		<hr>
		<h2><p class="text-center">Вас интересуют эти принтеры? </p></h2>
		<div class="row">
		  <!-- 1 Изображение -->
		                    <?php foreach ($printList as $print): ?>
                    <div class="col-sm-6 col-md-4">
                          <div class="thumbnail">
                              <?php if($print['img'] != ""): ?>
                                    <img src="<?php echo $print['img']; ?>" class="img" alt="...">
                               <?php else: ?>
                                    <img src="img/not_img_print.png" class="img" alt="...">
                              <?php endif; ?>
                            <div class="caption">
                                  <h3><?php echo $print['name']; ?>
                                    <?php if($print['color'] == 1): ?>
                                        <img src="/img/rgb.png" alt="" />
                                    <?php endif; ?>
                                  </h3> 
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
  
		</div>
<?php include ROOT . TMPL . 'footer.php'; ?>