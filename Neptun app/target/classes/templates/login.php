<?php
$servername = "localhost";
$username = "root";  // Az adatbázis felhasználója
$password = "";      // Az adatbázis jelszava
$dbname = "neptun";  // Az adatbázis neve

// Csatlakozás az adatbázishoz
$conn = new mysqli($servername, $username, $password, $dbname);

// Ellenőrizzük a kapcsolatot
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// JSON adat fogadása
$data = json_decode(file_get_contents("php://input"));

// Ellenőrizzük, hogy a JSON érvényes-e
if ($data === null) {
    echo json_encode(["message" => "Érvénytelen adatokat kaptunk!"]);
    exit;
}

$username = $data->username;
$password = $data->password;

// Adatbázis lekérdezés
$sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);

// Ellenőrizzük, hogy van-e megfelelő felhasználó
if ($result->num_rows > 0) {
    // Sikeres bejelentkezés
    echo json_encode(["message" => "Sikeres bejelentkezés"]);
} else {
    // Hibás felhasználó vagy jelszó
    echo json_encode(["message" => "Hibás felhasználónév vagy jelszó"]);
}

// Kapcsolat bezárása
$conn->close();
?>



<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <form id="login-form">
        <input type="text" id="username" placeholder="Felhasználónév" required>
        <input type="password" id="password" placeholder="Jelszó" required>
        <button type="submit">Bejelentkezés</button>
    </form>
    <div id="error-message"></div>
</div>

<script>
    document.getElementById('login-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Alapértelmezett form-küldés letiltása

    // Input mezők értékei
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    const errorMessage = document.getElementById('error-message');

    // Ellenőrizzük, hogy mindkét mező ki van-e töltve
    if (!username || !password) {
        errorMessage.textContent = "Kérlek, töltsd ki az összes mezőt!";
        return;
    }

    // Bejelentkezési adatok elküldése a szervernek
    fetch('http://localhost/neptun/login.php', {  // A PHP fájl URL-je
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            username: username,
            password: password
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === "Sikeres bejelentkezés") {
            // Sikeres bejelentkezés, átirányítás a kurzusok oldalra
            window.location.href = "courses.html";
        } else {
            // Hibaüzenet megjelenítése
            errorMessage.textContent = data.message;
        }
    })
    .catch(error => {
        errorMessage.textContent = "Hiba történt: " + error;
    });
});

</script>

</body>
</html>



</script>
</body>
</html>


