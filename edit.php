<?php
    include 'model.php';
    $id = $_POST['id'];
    $model = new Model();
    $row = $model->edit($id);
    if (!empty($row)) { ?>
        <form id="form" action="post">
            <div>
                <input type="hidden" id="edit_id" value="<?php echo $row['id'] ?>">
            </div>
            <div class="form-group">
                <label for="">Title</label>
                <input type="text" id="edit_title" class="form-control" value="<?php echo $row['title']; ?>">
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" id="edit_description" cols="" rows="3" class="form-control" ><?php echo $row['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="edit_authorId">Choose an author:</label>
                <select id="edit_authorId">
                  <?php
                    $authors = $model->fetchAuthors();
                    foreach ($authors as $author) {
                        echo "<option value='{$author['id']}'>{$author['forename']} {$author['surname']}</option>";
                    }
                  ?>
                </select>
              </div>
        </form>
    <?php
    }
?>