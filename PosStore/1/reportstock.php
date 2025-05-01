<?php
include 'header.php';
?>



<div class="container-fluid py-5">



    <h3>Stock Report</h3>
    <input type="text" id="search-keyword" onkeyup="filter()" placeholder="Search by type or product name..">
    <table class="table table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>Type</th>
                <th>Unit</th>
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
            echo "<tr><td>".$row['type']."</td><td>".$row['unit']."</td><td>".$row['productname']."</td><td>".$row['stock']."</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <script>
    function filter() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-keyword");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-body");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            tr[i].style.display = "none";
            for (var j = 0; j < 3; j++) {
                td = tr[i].getElementsByTagName("td")[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
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