<?php include('layouts/header.php'); ?>

<form action="/install/third-step-form" method="POST">
    <textarea name="keywords">Список ключевиков через запятую</textarea>
    <br><br>
    <input hidden name="pass" value="<?=$_REQUEST['pass']?>">
    <input hidden name="dor_name" value="<?=$_REQUEST['dor_name']?>">
    <br><br>
    <input type="submit">
</form>
<?php include('layouts/footer.php'); ?>

