<?php include('layouts/header.php'); ?>

<form action="/install/second-step" method="POST">
    <input name="dor_name" placeholder="доменное имя доргена">
    <br><br>
    <select name="category_id">
        <? foreach($categories as $category): ?>
        <option value="<?=$category['_id']?>"><?=$category['n']?></option>
        <option disabled selected>Категория доргена</option>
        <? endforeach; ?>
    </select>
    <input hidden name="pass" value="<?=$_REQUEST['pass']?>">
    <br><br>
    <input type="submit">
</form>
<?php include('layouts/footer.php'); ?>

