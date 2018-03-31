<div class="mainbar">
    <?php foreach ($posts as $post): ?>
        <div class="article">
            <a href="/post?id=<?=$post['lk']?>"><h2><?=$post['ti']?></h2></a>
            <p class="infopost">Posted <span class="date">on <?=$post['d']?></span> by <a href="/users/<?=$post['a']['id']?>"><?=$post['a']['n']?></a>&nbsp  <a href="#" class="com">Comments <span><?=$post['cc']?></span></a></p>
            <div class="clr"></div>
<!--            <div class="img"><img src="images/img1.jpg" width="198" height="188" alt="" class="fl" /></div>-->
            <div class="post_content">
                <p><?=$post['tx']?></p>
            </div>
            <div class="clr"></div>
        </div>
    <?php endforeach; ?>
    <?php include('pagination.php'); ?>
</div>