<?php

    include 'model.php';
    $model = new Model();
    $row = $model->read($_POST['id']);
    if (!empty($row)) { ?>
        <p>Title - <?php echo $row['title']; ?></p>
        <p>Description - <?php echo $row['description']; ?></p>
        <p>Author - <?php echo "{$row['forename']} {$row['surname']}" ?></p>
    <?php
    }

?>