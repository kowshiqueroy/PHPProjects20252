<?php
require_once '../conn.php';
require_once 'header.php';
?>

<div class="card p-1 text-center">Visitors</div>

<style>
    .btn-group {
        display: flex;
        justify-content: center;
    }
    .btn-group .btn {
        flex: 1;
    }
</style>

<div class="btn-group">
    <button type="button" class="btn btn-secondary" id="today">Today</button>
    <button type="button" class="btn btn-outline-secondary" id="all">All</button>
</div>

<div class="card p-1 text-center" id="visitors-data"></div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selected = 'today';

        document.querySelectorAll('.btn-group .btn').forEach(function(el) {
            el.addEventListener('click', function() {
                document.querySelectorAll('.btn-group .btn').forEach(function(el2) {
                    el2.classList.remove('btn-secondary');
                    el2.classList.add('btn-outline-secondary');
                });
                el.classList.remove('btn-outline-secondary');
                el.classList.add('btn-secondary');

                selected = el.id;
                updateData();
            });
        });

        function updateData() {
            fetch('visitorsdata.php?selected=' + selected)
                .then(response => response.text())
                .then(data => {
                    document.querySelector('#visitors-data').innerHTML = data;
                })
                .catch(error => console.error('Error fetching data:', error));

            setTimeout(function() {
                setInterval(function() {
                    fetch('visitorsdata.php?selected=' + selected)
                        .then(response => response.text())
                        .then(data => {
                            document.querySelector('#visitors-data').innerHTML = data;
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }, 5000);
            }, 0);
        }

        updateData();
    });
</script>



<?php
require_once 'footer.php';
?>