<?php include ROOT . TMPL . 'header.php'; ?>
<p class="text-center">
    <a href="save" class="btn btn-success btn-lg"><i class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Скачать в excel</a>
</p>
<div class = "table-responsive">		
<table class="table table-hover text-center" style="vertical-align: middle;">
    <thead>
    </thead>
    <tbody>
        <?php foreach($list as $key => $value): ?>
        <tr>
            <th colspan="3" class="success"><?php echo $key ?></th>
        </tr>
        <?php for($i=0; count($value) > $i; $i++): ?>
        <tr>
            <td style="min-width: 200px; vertical-align: middle;"><?php echo $value[$i]['name']; ?></td>
            <td><?php echo $value[$i]['number']; ?></td>
            <td><?php echo $value[$i]['post']; ?></td>
        </tr>
        <?php endfor; ?>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

<?php include ROOT . TMPL . 'footer.php'; ?>