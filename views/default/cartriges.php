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

<?php /*if(isset($_POST['submit'])) echo $messages;*/ ?>
                <?php if(user::checkAdmin() == true): ?> 
                    <p class="text-center">
                            <a href="http://<?php echo DOMEN; ?>/cartriges/action/?act=out" class="btn btn-warning"><i class="fa fa-sign-out" aria-hidden="true"></i> Замена</a>
                            <a href="http://<?php echo DOMEN; ?>/cartriges/action/?act=in" class="btn btn-success"><i class="fa fa-sign-in" aria-hidden="true"></i> Доставка</a>
                            <a href="http://<?php echo DOMEN; ?>/cartriges/orders" class="btn btn-inverse"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Заказ</a>
                    </p>
                <?php endif; ?> 
		</br>
<?php include ROOT . TMPL . 'footer.php'; ?>