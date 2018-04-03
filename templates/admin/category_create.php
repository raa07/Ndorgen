<?php include('layouts/header.php'); ?>

<form action="/install/create-category" method="POST">
    <input name="category" placeholder="имя категории">
    <input hidden name="pass" value="<?=$_REQUEST['pass']?>">
    <br><br>
    <input type="submit">
</form>
<?php include('layouts/footer.php'); ?>

