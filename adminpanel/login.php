<?php
session_start();
require('koneksi.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main {
            height: 100vh;
            background-image: url('../image/fotobgadmin.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .login-box {
            background-color: rgba(255, 255, 255, 0.9);
        }
    </style>
</head>
<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="login-box p-5 border rounded shadow" style="min-width: 300px;">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div>
                    <button class="btn btn-success form-control" type="submit" name="loginbtn">Login</button>
                </div>
            </form>
        </div>

        <div class="mt-3">
            <?php
                if (isset($_POST['loginbtn'])) {
                    $username = htmlspecialchars($_POST['username']);
                    $password = htmlspecialchars($_POST['password']);

                    $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
                    $countdata = mysqli_num_rows($query);

                    if ($countdata > 0) {
                        $data = mysqli_fetch_assoc($query);
                        
                        if ($password === $data['password']) {
                           $_SESSION['username'] = $data['username'];
                           $_SESSION['login'] = true;
                           header('location: index.php');
                        } else {
                            echo "
                                <div class='alert alert-warning' role='alert'>
                                    Password salah
                                </div>
                            ";
                        }                        
                    } else {
                        echo "
                            <div class='alert alert-warning' role='alert'>
                                Username tidak ditemukan!
                            </div>
                        ";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
