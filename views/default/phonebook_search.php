<?php include ROOT . TMPL . 'header.php'; ?>
<form action="" method="post">
    <div class="row">
        <div class="col-xs-offset-2 col-xs-7">
            <input type="text" class="form-control" name="searching" placeholder="Напишите фамилию или номер телефона, можно часть..." <?php if(isset($_POST['searching'])) echo "value='".$_POST['searching']."'"; ?>>
        </div>
        <div class="col-xs-3">
            <button type="submit" name="submit" class="btn btn-primary">Выбрать</button>
        </div>
    </div>
</form>
	<br />

<?php if(!isset($value)): ?>
    <div class="panel panel-primary col-xs-offset-4 col-xs-4">
        <div class="panel-heading">
            <h3 class="panel-title">Внимание!</h3>
        </div>
        <div class="panel-body">
            Здесь появится результат поиска
        </div>
    </div>
<?php elseif(isset($value) && !empty($value)): ?>
<div class = "search_result table-responsive">	
<table class="table table-hover text-center" style="vertical-align: middle;">
    <tbody> 
        <?php for($i=0; count($value) > $i; $i++): ?>
        <tr>
            <td style="min-width: 200px; vertical-align: middle;"><?php echo $value[$i]['name']; ?></td>
            <td><?php echo $value[$i]['number']; ?></td>
            <td><?php echo $value[$i]['post']; ?></td>
            <td><?php echo $value[$i]['department']; ?></td>
        </tr>
        <?php endfor; ?>
    </tbody>
</table>
</div>
<?php else: ?>
    <div class="panel panel-danger col-xs-offset-4 col-xs-4">
        <div class="panel-heading">
            <h3 class="panel-title">Error!!!</h3>
        </div>
        <div class="panel-body">
            По введенным параметрам ничего не найдено
        </div>
    </div>
<?php endif; ?>


<?php include ROOT . TMPL . 'footer.php'; ?>

