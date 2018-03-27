<div class="article">
    <h2><span><?=$post['cc']?></span> Responses</h2>
    <div class="clr"></div>
    <?php foreach($comments as $comment): ?>
        <div class="comment"> <a href="#"><img src="<?=$comment['a']['a']?>" width="40" height="40" alt="" class="userpic" /></a>

            <p><a href="#"><?=$comment['a']['n']?></a> Says:<br />
                <?=$comment['d']?></p>
            <p><?=$comment['tx']?></p>
        </div>
    <?php endforeach;?>
</div>