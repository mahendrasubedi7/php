<?php
 require'../connection/database.php';
 ?>
 
 <!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Title</title>
</head>

<body>
    <div class="container my-5 py-5 ">
        <div class="card" style="max-width: 600px; margin:auto">
            <div class="card-header">Register to continue</div>
            <div class="card-body">
                <?php

                if (isset($_POST['register'])) {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $password_confirmation = $_POST['password_confirmation'];

                    if ($name != "" && $email != "" && $password != "" && $password_confirmation != "") {
                        if ($password === $password_confirmation) {
                            $select_query="SELECT * FROM users WHERE email='$email'";
                            $select_result =mysqli_query($conn,$select_query);

                         } if($select_result->num_rows=== 0){
                         $password = password_hash($password,PASSWORD_BCRYPT);
                           $insert_query ="INSERT INTO users(name,email,password) VALUES('$name','$email','$password')";
                            
                            $insert_result =mysqli_query($conn,$insert_query);

                            
                        } else {
                ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Email already exists</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>All fields are required!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                <?php
                    }
                }

                ?>
                <form action="#" method="post">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name <b>*</b></label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email <b>*</b></label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password <b>*</b></label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password <b>*</b></label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <button type="submit" name="register" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>

</html>