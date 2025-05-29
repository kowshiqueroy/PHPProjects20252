</div>
    </div>
<?php
        
$user=$_SESSION['username'];
$sql = "SELECT * FROM visitors WHERE session_id = '$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // If the session_id exists, increment the hits
    $sql = "UPDATE visitors SET hits = hits + 1 WHERE session_id = '$user'";
    if (!$conn->query($sql)) {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // If the session_id does not exist, insert a new record
    $sql = "INSERT INTO visitors (session_id, hits) VALUES ('$user', 1)";
    if (!$conn->query($sql)) {
        echo "Error inserting record: " . $conn->error;
    }
}?>
    <script>
        $(document).ready(function () {
            $("#menuToggle").click(function () {
                $("#menuBox").toggleClass("show");
            });
            $("#closeMenu").click(function () {
                $("#menuBox").removeClass("show");
            });
           
         



        });
    </script>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            tags: true
        });

        
            $(".select2edit").select2({
                tags: true
            });
    });
</script>


<script>
    $(document).ready(function() {
        $('.select2n').select2({
           
        });
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  

    <!-- Template Javascript -->
    <script src="js/main.js"></script>


   
</body>
</html>