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
            <span class="text-white desktop-items">Username</span>
            <span class="text-white small desktop-items">Admin Role</span>
            <button class="btn btn-danger">Logout</button>
        </div>
    </nav>

    <div class="menu-box p-3" id="menuBox">
        <button class="btn btn-secondary w-100" id="closeMenu">Close</button>
        <ul>
        <span class="text-white small">Username Admin Role</span>
        
            <li><a href="#">Home</a></li>
            <li><a href="#">Settings</a></li>
            <li>
                <a href="#">Reports ▼</a>
                <ul class="list-unstyled ms-3">
                    <li><a href="#">Monthly</a></li>
                    <li><a href="#">Yearly</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="container mt-3">
        <div class="content">
            <div class="card p-3">Content Area</div>




            
            <div class="d-flex two-columns gap-3 mt-3">
                <div class="card p-3 flex-fill">Div 1</div>
                <div class="card p-3 flex-fill">Div 2</div>
            </div>






            <table class="table table-striped mt-3">
                <thead class="table-dark">
                    <tr><th>ID</th><th>Name</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>Demo</td><td></td></tr>
                </tbody>
            </table>
            <button class="btn btn-secondary mt-2" id="toggleActions">Toggle Actions</button>
            <form class="mt-3">
                <select class="form-select select2">
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                </select>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#menuToggle").click(function () {
                $("#menuBox").toggleClass("show");
            });
            $("#closeMenu").click(function () {
                $("#menuBox").removeClass("show");
            });
           
            $(".select2").select2();
        });
    </script>
</body>
</html>