<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Books</title>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-5">
              <h1 class="text-center">Books</h1>
              <hr style="height: 1px; color:black;background-color:black;">
            </div>
        </div>
        <div class="row">
          <div class="col-md-5 mx-auto">
            <h2 class="text-center">Insert a book:</h2>
            <form action="" method="post" id="form">
              <div id="result"></div>
              <div class="form-group">
                <label for="">Title</label>
                <input type="text" id="title" class="form-control">
              </div>
              <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" id="description" cols="" rows="3" class="form-control"></textarea>
              </div>
              <div class="form-group">
                <label for="authors">Choose an author:</label>
                <select id="selectedAuthorId">
                  <?php
                    include "model.php";
                    $model = new Model();
                    $authors = $model->fetchAuthors();
                    foreach ($authors as $author) {
                        echo "<option value='{$author['id']}'>{$author['forename']} {$author['surname']}</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" id="submit" class="btn btn-outline-primary">Submit</button>
              </div>
            </form>
            <h2 class="text-center">Insert an author:</h2>
            <form action="" method="post" id="formAuthor">
              <div id="resultAuthor"></div>
              <div class="form-group">
                <label for="">Forename</label>
                <input type="text" id="forename" class="form-control">
              </div>
              <div class="form-group">
                <label for="">Surname</label>
                <input type="text" id="surname" class="form-control">
              </div>
              <div class="form-group">
                <button type="submit" id="submitAuthor" class="btn btn-outline-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 mt-1">
            <div id="show"></div>
            <div id="fetch"></div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="readModal" tabindex="-1" aria-labelledby="readModalTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="readModalTitle">Record</h5>
          </div>
          <div class="modal-body">
            <div id="read_data"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalTitle">Edit Record</h5>
          </div>
          <div class="modal-body">
            <div id="edit_data"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="update">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    <script>
      $(document).on("click", "#submit", function(e) {
        e.preventDefault();
        var title = $("#title").val();
        var description = $("#description").val();
        var selectedAuthorId = $("#selectedAuthorId").val();
        var submit = $("#submit").val();
        $.ajax({
          url: "insert.php",
          type: "post",
          data: {
            title:title,
            description:description,
            submit:submit,
            selectedAuthorId:selectedAuthorId
          },
          success: function(data) {
            fetch();
            $("#result").html(data);
          }
        });
        $("#form")[0].reset();
        $("#form")[1].reset();
      });

      $(document).on("click", "#submitAuthor", function(e) {
        e.preventDefault();
        var forename = $("#forename").val();
        var surname = $("#surname").val();
        var submitAuthor = $("#submitAuthor").val();
        $.ajax({
          url: "insertAuthor.php",
          type: "post",
          data: {
            forename:forename,
            surname:surname,
            submitAuthor:submitAuthor
          },
          success: function(data) {
            fetch();
            $("#resultAuthor").html(data);
          }
        });
        $("#formAuthor")[0].reset();
        $("#formAuthor")[1].reset();
      });

      // Fetch books
      function fetch() {
        $.ajax({
          url: 'fetch.php',
          type: 'post',
          success: function(data) {
            $("#fetch").html(data)
          }
        });
      }

      // Delete books
      $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        if (window.confirm('Do you want to delete the record?')) {
          var id = $(this).attr('value');
          $.ajax({
            url: "delete.php",
            type: "post",
            data: {
              id:id
            },
            success: function(data) {
              fetch();
              $("#show").html(data);
            }
          });
        }
        else {
          return false;
        }
      });

      // Read books
      $(document).on('click', '#read', function(e) {
        e.preventDefault();
        var id = $(this).attr('value');
        $.ajax({
          url: 'read.php',
          type: 'post',
          data: {
            id:id
          },
          success: function(data) {
            $('#read_data').html(data);
          }
        })
      });

      // Edit books
      $(document).on('click', '#edit', function(e) {
        e.preventDefault();
        var id = $(this).attr('value');
        $.ajax({
          url: 'edit.php',
          type: 'post',
          data: {
            id:id
          },
          success: function(data) {
            $('#edit_data').html(data);
          }
        });
      });

      // Update books
      $(document).on("click", "#update", function(e){
        e.preventDefault();
        var edit_id = $("#edit_id").val();
        var edit_title = $("#edit_title").val();
        var edit_description = $("#edit_description").val();
        var edit_authorId = $("#edit_authorId").val();
        var update = $("#update").val();
        $.ajax({
          url: "update.php",
          type: "post",
          data: { 
            edit_id:edit_id,
            edit_title:edit_title,
            edit_description:edit_description,
            edit_authorId:edit_authorId,
            update:update
          },
          success: function(data){
            fetch();
            $("#show").html(data);
          }
        });
      });
    </script>
  </body>
</html>