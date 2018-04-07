<?php include('layouts/header.php'); ?>

<form action="/install/second-step" method="POST">
    <input name="dor_name" placeholder="название доргена">
    <input name="dor_host" placeholder="доменное имя доргена">
    <br><br>
    <select name="category_id">
        <? foreach($categories as $category): ?>
        <option value="<?=$category['_id']?>"><?=$category['n']?></option>
        <? endforeach; ?>
        <option disabled selected>Категория доргена</option>
    </select>
    <input hidden name="pass" value="<?=$_REQUEST['pass']?>">
    <br><br>
    <input type="submit">
</form>
<?php include('layouts/footer.php'); ?>

