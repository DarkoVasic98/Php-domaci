<?php

    Class Model{
        private $server = "localhost";
        private $username = "root";
        private $password;
        private $db = "phphomework";
        private $conn;

        public function __construct(){
            try {
                $this->conn = new PDO("mysql:host=$this->server;dbname=$this->db", $this->username, $this->password);
            } catch (Exception $e) {
                echo "Connection failed" . e.getMessage();
            }
        }

        public function ret(){
            return $this->conn;
        }

        public function insert(){
            if (isset($_POST['submit'])) {
                if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['selectedAuthorId'])) {
                    if (!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['selectedAuthorId'])) {
                        $title = $_POST['title'];
                        $description = $_POST['description'];
                        $selectedAuthorId = $_POST['selectedAuthorId'];
                        $query = "INSERT INTO books (title, description, authorId) VALUES ('$title', '$description', '$selectedAuthorId')";
                        if ($sql = $this->conn->exec($query)) {
                            echo "
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    Book added successfully!
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            ";
                        }
                        else {
                            echo "
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    Failed to add the book!
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            ";
                        }
                    } else {
                        echo "
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                Empty field(s)!
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        ";
                    }
                }
            }
        }

        public function insertAuthor(){
            if (isset($_POST['submitAuthor'])) {
                if (isset($_POST['forename']) && isset($_POST['surname'])) {
                    if (!empty($_POST['forename']) && !empty($_POST['surname'])) {
                        $forename = $_POST['forename'];
                        $surname = $_POST['surname'];
                        $query = "INSERT INTO authors (forename, surname) VALUES ('$forename', '$surname')";
                        if ($sql = $this->conn->exec($query)) {
                            echo "
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    Author added successfully!
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            ";
                        }
                        else {
                            echo "
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    Failed to add the author!
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            ";
                        }
                    } else {
                        echo "
                            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                Empty field(s)!
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        ";
                    }
                }
            }
        }

        public function fetch() {
            $data = null;
            $stmt = $this->conn->prepare("SELECT books.id, books.title, books.description, authors.forename, authors.surname FROM books JOIN authors on books.authorId = authors.id");
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        }

        public function fetchAuthors() {
            $data = null;
            $stmt = $this->conn->prepare("SELECT * FROM authors");
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        }

        public function read($id) {
            $data = null;
            $stmt = $this->conn->prepare("SELECT books.id, books.title, books.description, authors.forename, authors.surname FROM books JOIN authors on books.authorId = authors.id WHERE books.id='$id'");
            $stmt->execute();
            $data = $stmt->fetch();
            return $data;
        }

        public function delete($id){
            $query = "DELETE FROM books WHERE id = '$id' ";
            if ($sql = $this->conn->exec($query)) {
                echo "
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        Book deleted successfully!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                    ";
            } else {
                echo "
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        Book not deleted!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                ";
            }
        }

        public function edit($id) {
            $data = null;
            $stmt = $this->conn->prepare("SELECT * FROM books WHERE id='$id'");
            $stmt->execute();
            $data = $stmt->fetch();
            return $data;
        }

        public function update($data) {
            $query = "UPDATE books SET title = '$data[edit_title]', description = '$data[edit_description]', authorId = '$data[edit_authorId]'
            WHERE id='$data[edit_id]'";
      
            if ($sql = $this->conn->exec($query)) {
              echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Book updated successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <script>$("#editModal").modal("hide")</script>
                ';
            }else {
              echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Book not updated!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }
          }
    }

?>