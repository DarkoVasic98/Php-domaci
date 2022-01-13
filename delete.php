<?php 
    include 'model.php';
    $model = new Model();
    $delete = $model->delete($_POST['id'])
?>