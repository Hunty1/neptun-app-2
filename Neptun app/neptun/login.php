<?php
// Kapcsolódás az adatbázishoz
$servername = "localhost";
$username = "root";
$password = "";
$database = "neptun";

$conn = new mysqli($servername, $username, $password, $database);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}
error_reporting(0);  // Kikapcsolja az összes hibaüzenet megjelenítését
ini_set('display_errors', 0);  // Megakadályozza a hibák megjelenítését

// Bejelentkezési adatok
$username_input = $_POST['username'];
$password_input = $_POST['password'];

// SQL lekérdezés a bejelentkezési adatok ellenőrzésére
$sql = "SELECT * FROM user WHERE username = '$username_input' AND password = '$password_input'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Sikeres bejelentkezés, átirányítás a courses.php oldalra
    header("Location: courses.html");
    exit();
} else {
    // Sikertelen bejelentkezés, hibaüzenet és form vissza
    echo "
    <html>
    <head>
        <title>Bejelentkezés</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background-color: #f5f5f5;
            }

            div {
                background-color: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                width: 300px;
            }

            h1 {
                text-align: center;
            }

            form {
                display: flex;
                flex-direction: column;
            }

            input {
                margin: 10px 0;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            button {
                padding: 10px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            button:hover {
                background-color: #45a049;
            }

            #error-message {
                color: red;
                margin-top: 10px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div>
            <h1>Bejelentkezés</h1>
            <form action='login.php' method='POST'>
                <input type='text' name='username' placeholder='Felhasználónév' required>
                <input type='password' name='password' placeholder='Jelszó' required>
                <button type='submit'>Bejelentkezés</button>
            </form>
           
        </div>
    </body>
    </html>
    ";
}

$conn->close();
?>
