
    <!-- Footer -->
    <footer>
        <p>&copy; 2025 kowshiqueroy@gmail.com. All rights reserved.</p>

        <?php
         if(isset($_SESSION['username'])) {
            echo "<p>Logged in as ".$_SESSION['username']."</p>";
             $session_id=$_SESSION['username'];
        }?>
    </footer>
    <?php
        
      

       
$sql = "SELECT * FROM visitors WHERE session_id = '$session_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // If the session_id exists, increment the hits
    $sql = "UPDATE visitors SET hits = hits + 1 WHERE session_id = '$session_id'";
    if (!$conn->query($sql)) {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // If the session_id does not exist, insert a new record
    $sql = "INSERT INTO visitors (session_id, hits) VALUES ('$session_id', 1)";
    if (!$conn->query($sql)) {
        echo "Error inserting record: " . $conn->error;
    }
}?>
    <script>
        document.querySelectorAll(".add-to-cart").forEach(button => {
            button.addEventListener("click", () => {
                fetch("addtocart.php", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${button.id}`
                })
                .then(response => response.text())
                .then(message => {

                    document.getElementById("top-message").style.display = "block";

                    console.log(message);
                  



                    





                });
            });
        });
    </script>

</body>
</html>