<?php include('layouts/header.php'); ?>
<div class="mainbar">
    <div class="article">
        <h2><span>Список категорий</h2>
        <?foreach($categories as $category):?>
        <a href="/category?id=<?=$category['l']?>"><?=$category['ti']?></a>
        <br>
        <?endforeach;?>
        <div class="clr"></div>

    </div>
</div>
<?php include('layouts/footer.php'); ?>
