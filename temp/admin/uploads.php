<?php
require_once '../conn.php';
require_once 'header.php';
?>

<div class="card p-1 text-center">Uploads</div>
<form action="" method="post" enctype="multipart/form-data">
    <div class="mt-3">
        <label for="name" class="form-label">Name:</label>
        <input class="form-control" type="text" name="name" id="name" required>
    </div>
    <div class="mt-3">
        <label for="fileToUpload" class="form-label">Select image to upload:</label>
        <div class="input-group">
            <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" required onchange="previewImage(event)">
            <div class="input-group-append">
                <img width="100" src="" alt="Preview" id="preview" style="border: 1px solid #ccc; padding: 4px;">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Upload Image</button>
</form>

<script>
    function previewImage(event) {
        var image = document.getElementById('preview');
        image.src = URL.createObjectURL(event.target.files[0]);
    }
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $sql = "SELECT * FROM photos WHERE name='$name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Sorry, a photo with this name already exists.";
        $uploadOk = 0;
    }

    $target_dir = "uploads/";
    $timestamp = time();
    $target_file = $target_dir . $timestamp . '.' . strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO photos (name, link) VALUES (?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ss", $name, $link);
                $name = $_POST['name'];
                $link = $target_file;
                $stmt->execute();
                $stmt->close();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            echo "The file has been uploaded with the name " . $timestamp . "." . $imageFileType;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>


<h2>Uploads</h2>

<table class="table">
    <thead class="table-dark">
        <tr><th>ID</th><th>Name</th><th>Photo</th><th>Link</th></tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT id, name, link FROM photos ORDER BY id DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row['id'] . "</td><td>" . $row['name'] . "</td><td><img src='" . $row['link'] . "' width='100' height='100'></td><td><a href='" . $row['link'] . "' target='_blank'>" . $row['link'] . "</a></td></tr>";
                }
            }
        ?>
    </tbody>
</table>




<?php
require_once 'footer.php';
?>