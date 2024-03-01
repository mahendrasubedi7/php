<?php
require './../../middleware/authenticated.php';
require './../../connection/database.php';



if(isset($_GET['id']))
{
    $id = $_GET['id'];
    if($id && is_numeric($id))
    {
        $select_query = "SELECT * FROM tasks WHERE id=$id";
        $select_result = mysqli_query($conn,$select_query);
        if($select_result->num_rows === 1)
        {
            $task = mysqli_fetch_assoc($select_result);
        }else{
            header("Location:index.php");
        }
    }else{
        header("Location:index.php");
    }
}else{
    header("Location:index.php");
}

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
                if (isset($_POST['save'])) {
                    $title = $_POST['title'] ?? '';
                    $description = $_POST['description'] ?? '';
                    $time = $_POST['time'] ?? '';

                   if(isset($_FILES['image']) && $_FILES['image']['name']!="" && $title!="" && $description!="" && $time!="")
                   {
                        $image = $_FILES['image'];

                        $image_name = $image['name'];
                        $image_size = $image['size'];

                        $exploded_data = explode('.', $image_name);
                        $extension = strtolower(end($exploded_data));

                        if ($extension == 'png' || 
                            $extension == 'jpeg' || 
                            $extension == 'jpg') {
                        if ($image_size > 0 && $image_size < 2097152) {
                                $image_name = md5($image['name'] . 
                                    time() . $_SESSION['user']['id']) . "." . $extension;
                                unlink('../../uploads/'.$task['image']);
                        if (move_uploaded_file($image['tmp_name'],
                         '../../uploads/' . $image_name)) {
                                   
                           $update_query = "UPDATE tasks SET title='$title',description='$description',time='$time',image='$image_name' WHERE id=$id";
                    $update_result = mysqli_query($conn,$update_query);


                                } else {
                                    echo "File upload failed";
                                }
                            } else {
                                echo "File should be less than 2 MB";
                            }
                        } else {
                            echo "Unsupported file typed";
                        }
                   }
                   else if($title!="" && $description!="" && $time!=""){
                    $update_query = "UPDATE tasks SET title='$title',description='$description',time='$time' WHERE id=$id";
                    $update_result = mysqli_query($conn,$update_query);
                   }else{
                    echo "All fields are required";
                   }
                }

                ?>
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Title <b>*</b></label>
                        <input type="text" class="form-control" name="title" 
                        id="title" value="<?php echo $task['title']; ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description <b>*</b></label>
                        <textarea class="form-control" name="description"
                         id="description"><?php echo $task['description'] ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="image" class="form-label">Image <b>*</b></label>
                        <input type="file" class="form-control" name="image" id="image" 
                        value="<?php echo $task['image']; ?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="time" class="form-label">time <b>*</b></label>
                        <input type="time" class="form-control" name="time" id="time" 
                        value="<?php echo $task['time']; ?>">
                    </div>
                    <button type="submit" name="save" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>

</html>