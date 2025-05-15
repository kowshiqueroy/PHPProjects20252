<?php
require_once '../conn.php';
require_once 'header.php';
?>

<div class="card p-1 text-center">
    <h1>Home</h1>
</div>


<style>


.browser {
    width: 80%;
    max-width: 900px;
    border: 2px solid #ccc;
    border-radius: 10px;
    overflow: hidden;
    background: white;
    margin: 20px auto;
}

.browser-header {
    background: #ddd;
    padding: 10px;
    display: flex;
    align-items: center;
}

.buttons span {
    display: inline-block;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 5px;
}

.red { background: red; }
.yellow { background: yellow; }
.green { background: green; }

.url-bar {
    flex-grow: 1;
    text-align: center;
    font-weight: bold;
}

.browser-content {
    padding: 20px;
}

.img-container img {
    width: 100%;
    max-width: 200px;
}

footer {
    text-align: center;
    padding: 10px;
    background: #ddd;
}
</style>
<div class="browser">
    <div class="browser-header">
        <div class="buttons">
            <span class="red"></span>
            <span class="yellow"></span>
            <span class="green"></span>
        </div>
       
               
           
        <div class="url-bar"> <?php
                    $sql = "SELECT favicon FROM companyinfo WHERE id = 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo '<img src="' . $row['favicon'] . '" alt="Company Favicon" width="15" height="15">';
                    }
                ?> <?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?></div>
    </div>

    <div class="browser-content">
        <header class="d-flex justify-content-between align-items-center">
            <div class="img-container">
                <?php
                    $sql = "SELECT companyname, tagline, logo FROM companyinfo WHERE id = 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo '<img src="' . $row['logo'] . '" alt="Company Logo">';
                    }
                ?>
            </div>
            <div class="company-info">
                <?php
                    $sql = "SELECT companyname, tagline FROM companyinfo WHERE id = 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo '<h1>' . $row['companyname'] . '</h1>';
                        echo '<p>' . $row['tagline'] . '</p>';
                    }
                ?>
            </div>
        </header>
        
        <main>
            <div class="d-flex justify-content-between">
                <section class="company-info">
                    <?php
                        $sql = "SELECT offertag, phone, email, address, bank FROM companyinfo WHERE id = 1";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo '<p><strong>Offer Tag:</strong> ' . $row['offertag'] . '</p>';
                            echo '<p><strong>Phone:</strong> ' . $row['phone'] . '</p>';
                            echo '<p><strong>Email:</strong> ' . $row['email'] . '</p>';
                            echo '<p><strong>Address:</strong> ' . $row['address'] . '</p>';
                            echo '<p><strong>Bank:</strong> ' . $row['bank'] . '</p>';
                        }
                    ?>
                </section>
                <section class="banner w-50 h-50">
                    <?php
                        $sql = "SELECT banner FROM companyinfo WHERE id = 1";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo '<img src="' . $row['banner'] . '" alt="Company Banner" width="300px" height="100%">';
                        }
                    ?>
                </section>
            </div>
            
            
            
          
        </main>

        <footer>
            <p>&copy; 2025 kowshiqueroy - All rights reserved.</p>
        </footer>
    </div>
</div>



<?php
require_once 'footer.php';
?>
