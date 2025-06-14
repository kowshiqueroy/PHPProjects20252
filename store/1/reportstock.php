<?php
include 'header.php';
?>

<div class="container-fluid py-5">
    <div class="shadow-lg rounded p-4 bg-light" style="backdrop-filter: blur(10px); border-radius: 15px;">
        <h3 class="mb-4 text-primary text-center ">
            Stock Report <?php echo date('d/m/Y h:i:s A'); ?>
        </h3>

        <input type="text" id="search-keyword" onkeyup="filter()" class="form-control mb-3 shadow-sm rounded-pill noprint"
            placeholder="Search by type or product name.." style="max-width: 400px; margin: 0 auto;"/>

        <div class="table-responsive">
            <table class="table table-hover text-center rounded overflow-hidden" style="border-radius: 10px;">
                <thead class="table-dark">
                    <tr>
                        <th>Type</th>
                        
                        <th>Product</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <?php
                    $sql = "SELECT t.name AS type, u.name AS unit, p.name AS productname, SUM(p.stock) AS stock
                            FROM product p
                            JOIN type t ON p.type = t.id
                            JOIN unit u ON p.unit = u.id
                            WHERE p.company = '".$_SESSION['company']."'
                            GROUP BY t.name, u.name, p.name
                            ORDER BY t.name, u.name, p.name";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr class='table-light border-bottom'>
                                <td>".$row['type']."</td>
                              
                                <td>".$row['productname']."</td>
                                <td>".$row['stock']." ".$row['unit']."</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filter() {
            var input = document.getElementById("search-keyword").value.toUpperCase();
            var table = document.getElementById("table-body");
            var tr = table.getElementsByTagName("tr");

            for (var i = 0; i < tr.length; i++) {
                tr[i].style.display = "none";
                for (var j = 0; j < 3; j++) {
                    var td = tr[i].getElementsByTagName("td")[j];
                    if (td) {
                        var txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(input) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>
</div>

<?php
include 'footer.php';
?>