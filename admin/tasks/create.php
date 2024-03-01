<?php 
require './../../middleware/authenticated.php';
require './../../connection/database.php';

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
    <div class="container my-5 py-5">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <?php
                if(isset($_POST['save']))
                {
                    $title = $_POST['title'] ??'';
                    $description= $_POST['description'] ??'';
                    $image= $_FILES['image'] ??'';
                    $time= $_POST['time'] ??'';

                 if($title!=''&&$description!="" && $image['name'] !="" && $time !=""){

                    $image_name =$image['name'];
                    $image_size =$image['size'];

                    $exploded_data= explode('.',$image_name);
                    $extension =strtolower(end($exploded_data));
                    
                    if($extension=='png' || $extension=='jpeg' || $extension =='jpg')
                    {
                       if($image_size>0 && $image_size<2097152)
                       {
                        $image_name=md5($image['name'].time().$_SESSION['user']['id']) . "." . $extension;
                        if(move_uploaded_file($image['tmp_name'],'../../uploads/' .$image_name))
                        
                        {
                            $insert_query ="INSERT INTO task(title,description,image,time) 
                            VALUES('$title','$description','$image_name','$time')";
                        $insert_result =mysqli_query($conn,$insert_query);

                        }else{
                            echo"file uploade failed";
                        }
                       }else{
                        echo"File should be less than 2mb";
                       }

                    }else{
                        echo"unsupported file type";
                    }

                 }else{
                    echo"All field are required";
                 }
                }





                ?>
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Title <b>*</b></label>
                        <input type="text" class="form-control" name="title" id="title">
                    </div>
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description <b>*</b></label>
                        <textarea  class="form-control" name="description" id="description"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="image" class="form-label">Image <b>*</b></label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <div class="form-group mb-3">
                        <label for="time" class="form-label">time <b>*</b></label>
                        <input type="time" class="form-control" name="time" id="time">
                    </div>
                    <button type="submit" name="save" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>