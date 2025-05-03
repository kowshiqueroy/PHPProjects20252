<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #121212;
            color: white;
            font-family: Arial, sans-serif;
        }
        .message {
            font-size: 22px;
            color: #ff4d4d;
            margin-bottom: 20px;
        }
        .brand {
            font-size: 42px;
            font-weight: bold;
            color: #00ff9f;
            text-transform: uppercase;
            animation: fadeIn 1.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <meta http-equiv="refresh" content="2;url=index.php" />
</head>
<body>
    <div class="message">Logging out...</div>
    <div class="brand">PoSStore</div>
</body>
</html>