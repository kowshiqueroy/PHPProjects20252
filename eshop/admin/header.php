<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <style>
        body { font-family: 'Arial', sans-serif; background: #f8f9fa; }
        .navbar { background: #343a40; color: white; }
        .menu-box {
            width: 250px; position: fixed; left: -260px; top: 0; height: 100vh; 
            background: #212529; color: white; transition: 0.4s ease-in-out; z-index: 999;
            box-shadow: 3px 0px 10px rgba(0,0,0,0.2);
            overflow-y: auto;
            overflow-x: hidden;
            
        }
        .menu-box.show { left: 0; }
        .menu-box span { display: block; text-align: center; }
        .menu-box ul { padding: 10px; }
        .menu-box ul li { padding: 8px 0; list-style: none; }
        .menu-box ul li a { text-decoration: none; color: white; padding: 5px 10px; 
            border-radius: 5px; transition: 0.3s; display: block;
        }
        .menu-box ul li a:hover { background: #495057; }
        .content { margin-left: 20px; padding: 20px; }
        .hidden-buttons { display: none; }
        .card { box-shadow: 0px 0px 10px rgba(0,0,0,0.1); }
        .user-info { display: flex; align-items: center; gap: 15px; }
        @media (max-width: 768px) { 
            .two-columns { flex-direction: column; }
            .desktop-items { display: none; } /* Hide elements on mobile */
            .user-info, #menuToggle { display: block; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark d-flex align-items-center justify-content-between px-3">
        <button class="btn btn-primary" id="menuToggle">☰</button>
        <span class="navbar-brand">Dashboard</span>
        <div class="user-info">
        <span class="text-white small desktop-items"><?php echo $_SESSION['rolename'];?></span>
  
        <button class="btn btn-danger" onclick="window.location.href='../logout.php'">Logout</button>
        </div>
    </nav>

    <div class="menu-box p-3" id="menuBox">
        <button class="btn btn-secondary w-100" id="closeMenu">Close</button>
        <ul>
        <span class="text-white small"><?php echo $_SESSION['username']." (".$_SESSION['id'].") ".$_SESSION['rolename'];?></span>
        
            <li><a href="home.php">Home</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="settings.php">Settings</a></li>
            <li><a href="uploads.php">Uploads</a></li>
            <li>
                <a href="#">Products ▼</a>
                <ul class="list-unstyled ms-3">
                    <li><a href="inproducts.php">IN</a></li>
                  
                    <li><a href="stocks.php">Stock</a></li>
                    <li><a href="productnew.php">New Product</a></li>
                </ul>
           </li>
           <li><a href="outproducts.php">Orders</a></li>
           <li><a href="featured.php">Featured</a></li>
           <li><a href="reviews.php">Reviews</a></li>
           <li><a href="visitors.php">Visitors</a></li>
        </ul>
    </div>
 <div id="top-message" style=" display: none; position: fixed; top: 0; left: 0; width: 100vw; background: #4CAF50; color: white; padding: 10px; z-index: 1000; text-align: center;">
    <p id="top-message-text"></p>
    <div style="margin-top: 10px;">
        <button id="top-message-button" style="background:#ff9800; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 5px;" onclick="window.location.href='#'">Check</button>
    </div>
</div>

 <script>
     setInterval(function(){
        $.ajax({
            url: "notification.php",
            type: "GET",
            success: function(data){
                if (data != 0) {
                   var topMessage = document.getElementById("top-message");
     topMessage.style.opacity = 0;
     topMessage.style.display = "block";
     topMessageText = document.getElementById("top-message-text");
     topMessageText.innerText = `You have New Order`;
     document.getElementById("top-message-button").addEventListener("click", function(){
        window.location.href="outproducts.php";
     });
     var fadeIn = setInterval(function() {
        var val = parseFloat(topMessage.style.opacity);
        if (!(val += 0.1)) topMessage.style.opacity = 0;
        if (val >= 1) {
            clearInterval(fadeIn);
            topMessage.style.opacity = 1;
        } else {
            topMessage.style.opacity = val;
        }
    }, 50);
    setTimeout(function() {
        var fadeOut = setInterval(function() {
            var val = parseFloat(topMessage.style.opacity);
            if (!(val -= 0.1)) topMessage.style.opacity = 1;
            if (val <= 0) {
                clearInterval(fadeOut);
                topMessage.style.opacity = 0;
                topMessage.style.display = "none";
            } else {
                topMessage.style.opacity = val;
            }
        }, 50);
    }, 5000);
                }
            }
        });
    }, 30000);


     

    </script>

    
    <div class="container mt-3">
        <div class="content">
           
            
       