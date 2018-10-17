<?php include ROOT . TMPL . 'header.php'; ?>
<style>
	#player4 {
	//max-width: 35rem;
	margin-left: auto;
	margin-right: auto;
	margin-bottom: 50px;
}
	</style>
<div class="container col-xs-5">
    <div id="player4" class="aplayer"></div>
</div>	
<div class="col-xs-offset-1 col-xs-5">
        
                <div id="display">
                    <table class="table">
                        <tr>
                            <th>Название</th>
                            <th> Слушать </td>
                            <th>Слушателей<br>сейчас</th>
                            <th>Композиция</th>
                        </tr>
                    <?php foreach($statistic as $stat): ?>
                        <tr>
                            <td><?php echo $stat['stream']; ?></td>
                            <td><a target=_blanc href='http://dsk7681:8000<?php echo $stat['stream']; ?>m3u'><img border='0' width='24' src='http://dsk7681/frame/images/radio1.gif'></a></td>
                            <td><?php echo $stat['quantity_listens']; ?></td>
                            <td><?php echo $stat['title']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                         </table>
                </div> 
       
    
    </br>
    <script>
    function mode()
    {
            // Очищаем нужный элемент страницы
        $.ajax({
            url: "http://<?php echo DOMEN ?>/radio/statistics/",
            cache: false,
            success: function(data) 
            {
                $('#display').html(data);
            }
        });
    }

    var timeInterval = 5000;
    setInterval(mode, timeInterval);
    </script>
</di>	
<script src="<?php echo LIB; ?>/player/APlayer.min.js"></script>
<script>
    var ap4 = new APlayer({
        element: document.getElementById('player4'),
        narrow: false,
        autoplay: false,
        showlrc: false,
        theme: '#ad7a86',
        music: [
                <?php foreach($radioList as $list): ?>
                    {
                        title: '<?php echo substr($list[0],1); ?>',
                        author: "<?php echo $list[3]; ?>",
                        url: "http://dsk7681:8000<?php echo $list[0]; ?>",
                        pic: 'http://dsk7681/player/img/<?php echo $list[0]; ?>.jpg'
                    },
                <?php endforeach; ?>
        ]
    });
    ap4.init();
</script>

<?php include ROOT . TMPL . 'footer.php'; ?>
