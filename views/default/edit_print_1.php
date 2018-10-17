<?php include ROOT . TMPL . 'header.php'; ?>

    <div class="row">
        <div class="col-md-4">
                <?php if($print['img'] != ""): ?>
                    <img class="img-responsive" src="/img/<?php echo $print['img']; ?>" alt="...">
                <?php else: ?>
                    <img class="img-responsive" src="/img/print.png" alt="...">
                <?php endif; ?>
                    <br><button type="submit" class="btn btn-primary">Сменить изображение</button>
        </div>
        <div class="col-md-8">
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
            <?php if(!is_array($print['functions'])): ?>
                функций нет
                <table class="table">
                    <tbody id="dynamic">
                        <tr>
                            <td>
                                <select class='select form-control' name="id_functions">
                                    <option disabled selected>Выберите функцию</option>
                                    <?php foreach($functions as $fn): ?>
                                        <option value="<?php echo $fn['id']; ?>"><?php echo $fn['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <button type="button" class="add">+</button>
                                <button type="button" class="del">-</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php else: ?>
            <table class="table">
                <tbody id="dynamic">
                 <!-- ЭТА СТРОКА БУДЕТ ШАБЛОНОМ ДЛЯ ВНОВЬ СОЗДАВАЕМЫХ //-->
                 <?php for($i=0; $i < count($print['functions']); $i++): ?>
                    <tr>
                        <td>
                            <select class='select form-control' name="id_functions">
                                <option disabled selected>Выберите функцию</option>
                                <?php foreach($functions as $fn): ?>
                                    <option value="<?php echo $fn['id']; ?>" <?php if($print['functions'][$i]['id'] == $fn['id']) echo "selected"; ?>><?php echo $fn['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    <td>
                        <button type="button" class="add">+</button>
                        <button type="button" class="del">-</button>
                    </td>
                    </tr>
                <?php endfor; ?>
                    <!-- конец СТРОКи БУДЕТ ШАБЛОНОМ ДЛЯ ВНОВЬ СОЗДАВАЕМЫХ //-->
                </tbody>
            </table>
            <?php endif; ?>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>

                       
                        <hr>
                        <br>
<?php include ROOT . TMPL . 'footer.php'; ?>