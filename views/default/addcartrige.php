<?php include ROOT . TMPL . 'header.php'; ?>
<table class="table table-condensed">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>activ</th>
            <th>list printers</th>
        </tr>
    </thead>
    <tbody>
        <?php for($i=0; $i < count($cartriges); $i++):  ?>
        <tr>
            <td> <?php echo $cartriges[$i]['id']; ?> </td>
            <td> <?php echo $cartriges[$i]['name']; ?> </td>
            <!--<td> <?php //echo $cartriges[$i]['action']; ?> </td>-->
            
            <td><a href="<?php DOMEN; ?>/cartriges/add/public/<?php echo $cartriges[$i]['id']; ?>" > <i <?php echo ($cartriges[$i]['action'] == 0) ? 'class="fa fa-times"  style="font-size:20px; color:#cc0000 "' : "class='fa fa-check'"; ?>></i></a></td>
            
            <td><?php if(is_array($cartriges[$i]['print_list'])): ?>
                    <?php foreach($cartriges[$i]['print_list'] as $prn_lst): ?>
                        <a href='/printer/<?php echo $prn_lst['id']; ?>'><span class="label <?php echo ($prn_lst['id_status'] == 1) ? "label-default" : "label-danger"; ?>"><?php echo $prn_lst['name']; ?></span></a>   
                    <?php endforeach; ?>
                <?php else: ?>
                        <h4> <?php echo $cartriges[$i]['print_list']; ?></h4>
                <?php endif; ?> 
            </td>
        </tr>
        <?php endfor;  ?>
    </tbody>
</table>
		</br>

                <hr>
    <div class="row">
        <div class="col-md-5">           
        <H2>Добавить новый картридж</H2>
            <form action="" method="post">
                <table>
                    <thead><tr>
                        <th>
                            Введите имя картриджа
                        </th>
                        <th>
                            Активный
                        </th>
                    </tr></thead>
                    <tr>
                        <td><input type="text" class="form-control" name="name" placeholder="Name" value=""></td>
                        <td><input type="checkbox" class="form-control" name="action" value="1" checked></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit" name="addcartrige" class="btn btn-primary">Добавить</button></td>
                    </tr>
                </table>
            </form>
        </div>            
        <div class="col-md-7">           
            <H2>Движение картриджей</H2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Номер</th>
                        <th>Пользователь</th>
                        <th>Дата</th>
                        <th>Картридж</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($cartrridges_history as $cart):?>
                        <tr>
                            <td><?php echo $cart['id']; ?></td>
                            <td><?php echo $cart['user']; ?></td>
                            <td><?php echo Date::changeLocaleDate(date("d F Y", $cart['date'])); ?></td>
                            <td><?php echo $cart['name']; ?></td>
                            <td><?php echo $cart['action']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>            
    </div>            
  
  
<?php include ROOT . TMPL . 'footer.php'; ?>