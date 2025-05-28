
    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Book Haven. All rights reserved.</p>
    </footer>

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




                    





                });
            });
        });
    </script>

</body>
</html>