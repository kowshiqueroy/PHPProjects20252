<?php
require_once '../conn.php';
require_once 'header.php';
?>

<div class="card p-1 text-center">Settings</div>



            <div class="d-flex two-columns gap-3 mt-3">
                <div class="card p-3 flex-fill">

<?php
$sql = "SELECT * FROM companyinfo WHERE id = 1";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $companyname = $_POST['companyname'];
    $tagline = $_POST['tagline'];
    $favicon = $_POST['favicon'];
    $logo = $_POST['logo'];
    $banner = $_POST['banner'];
    $offertag = $_POST['offertag'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $bank = $_POST['bank'];

    $sql = "SELECT * FROM companyinfo WHERE id = 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $sql = "UPDATE companyinfo SET companyname='$companyname', tagline='$tagline', favicon='$favicon', logo='$logo', banner='$banner', offertag='$offertag', phone='$phone', email='$email', address='$address', bank='$bank' WHERE id = 1";
    } else {
        $sql = "INSERT INTO companyinfo (id, companyname, tagline, favicon, logo, banner, offertag, phone, email, address, bank) VALUES (1, '$companyname', '$tagline', '$favicon', '$logo', '$banner', '$offertag', '$phone', '$email', '$address', '$bank')";
    }
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<form method="post" action="">
    <?php
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    ?>
    <div class="mb-3">
        <label for="companyname" class="form-label">Company Name</label>
        <input type="text" class="form-control" id="companyname" name="companyname" value="<?php echo $row['companyname']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="tagline" class="form-label">Tagline</label>
        <input type="text" class="form-control" id="tagline" name="tagline" value="<?php echo $row['tagline']; ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="offertag" class="form-label">Offer Tag</label>
        <input type="text" class="form-control" id="offertag" name="offertag" value="<?php echo $row['offertag']; ?>" required>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required>
        </div>
        <div class="col">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="bank" class="form-label">Bank Details</label>
        <input type="text" class="form-control" id="bank" name="bank" value="<?php echo $row['bank']; ?>" required>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label for="favicon" class="form-label">Favicon</label>
            <div class="input-group">
                <div class="me-3">
                    <?php
                        $faviconPath =  $row['favicon'];
                        if (file_exists($faviconPath)) {
                            echo '<img src="' . $faviconPath . '" height="50" width="50">';
                        } else {
                            echo '<div class="border border-dark p-2" style="width:50px; height:50px;"></div>';
                        }
                    ?>
                </div>
                <select class="form-select" id="favicon" name="favicon" required>
                    <?php
                        $sql2 = "SELECT id, name, link FROM photos ORDER BY id DESC";
                        $result2 = $conn->query($sql2);
                        if ($result2->num_rows > 0) {
                            while($row2 = $result2->fetch_assoc()) {
                                echo "<option value='" . $row2['link'] . "' " . (($row['favicon'] == $row2['link']) ? "selected" : "") . ">" . $row2['id'] . " - " . $row2['name'] . "</option>";
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col">
            <label for="logo" class="form-label">Logo</label>
            <div class="input-group">
                <div class="me-3">
                    <?php
                        $logoPath =  $row['logo'];
                        if (file_exists($logoPath)) {
                            echo '<img src="' . $logoPath . '" height="50" width="50">';
                        } else {
                            echo '<div class="border border-dark p-2" style="width:50px; height:50px;"></div>';
                        }
                    ?>
                </div>
                <select class="form-select" id="logo" name="logo" required>
                    <?php
                        $sql2 = "SELECT id, name, link FROM photos ORDER BY id DESC";
                        $result2 = $conn->query($sql2);
                        if ($result2->num_rows > 0) {
                            while($row2 = $result2->fetch_assoc()) {
                                echo "<option value='" . $row2['link'] . "' " . (($row['logo'] == $row2['link']) ? "selected" : "") . ">" . $row2['id'] . " - " . $row2['name'] . "</option>";
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col">
            <label for="banner" class="form-label">Banner</label>
            <div class="input-group">
                <div class="me-3">
                    <?php
                        $bannerPath =  $row['banner'];
                        if (file_exists($bannerPath)) {
                            echo '<img src="' . $bannerPath . '" height="50" width="50">';
                        } else {
                            echo '<div class="border border-dark p-2" style="width:50px; height:50px;"></div>';
                        }
                    ?>
                </div>
                <select class="form-select" id="banner" name="banner" required>
                    <?php
                        $sql2 = "SELECT id, name, link FROM photos ORDER BY id DESC";
                        $result2 = $conn->query($sql2);
                        if ($result2->num_rows > 0) {
                            while($row2 = $result2->fetch_assoc()) {
                                echo "<option value='" . $row2['link'] . "' " . (($row['banner'] == $row2['link']) ? "selected" : "") . ">" . $row2['id'] . " - " . $row2['name'] . "</option>";
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <?php
    } else {
    ?>
    <div class="mb-3">
        <label for="companyname" class="form-label">Company Name</label>
        <input type="text" class="form-control" id="companyname" name="companyname" placeholder="Company Name" required>
    </div>
    <div class="mb-3">
        <label for="tagline" class="form-label">Tagline</label>
        <input type="text" class="form-control" id="tagline" name="tagline" placeholder="Tagline" required>
    </div>
    
    <div class="mb-3">
        <label for="offertag" class="form-label">Offer Tag</label>
        <input type="text" class="form-control" id="offertag" name="offertag" placeholder="Offer Tag" required>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
        </div>
        <div class="col">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
    </div>
    <div class="mb-3">
        <label for="bank" class="form-label">Bank Details</label>
        <input type="text" class="form-control" id="bank" name="bank" placeholder="Bank Details" required>
    </div>

    <div class="row mb-3">
        <div class="col">
            <label for="favicon" class="form-label">Favicon</label>
            <div class="input-group">
                <div class="me-3">
                    <select class="form-select" id="favicon" name="favicon" required>
                        <?php
                            $sql2 = "SELECT id, name, link FROM photos ORDER BY id DESC";
                            $result2 = $conn->query($sql2);
                            if ($result2->num_rows > 0) {
                                while($row2 = $result2->fetch_assoc()) {
                                    echo "<option value='" . $row2['link'] . "'>" . $row2['id'] . " - " . $row2['name'] . "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col">
            <label for="logo" class="form-label">Logo</label>
            <div class="input-group">
                <div class="me-3">
                    <select class="form-select" id="logo" name="logo" required>
                        <?php
                            $sql2 = "SELECT id, name, link FROM photos ORDER BY id DESC";
                            $result2 = $conn->query($sql2);
                            if ($result2->num_rows > 0) {
                                while($row2 = $result2->fetch_assoc()) {
                                    echo "<option value='" . $row2['link'] . "'>" . $row2['id'] . " - " . $row2['name'] . "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col">
            <label for="banner" class="form-label">Banner</label>
            <div class="input-group">
                <div class="me-3">
                    <select class="form-select" id="banner" name="banner" required>
                        <?php
                            $sql2 = "SELECT id, name, link FROM photos ORDER BY id DESC";
                            $result2 = $conn->query($sql2);
                            if ($result2->num_rows > 0) {
                                while($row2 = $result2->fetch_assoc()) {
                                    echo "<option value='" . $row2['link'] . "'>" . $row2['id'] . " - " . $row2['name'] . "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <input type="submit" value="Submit" class="btn btn-primary">
</form>


                </div>
                
            </div>



<?php
require_once 'footer.php';
?>