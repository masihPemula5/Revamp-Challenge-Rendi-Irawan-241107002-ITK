<?php
session_start();
include 'db.php';

$client_id = '276617149835-tu30ido5i0rn1q8jnmm6nnkiouqk7jja.apps.googleusercontent.com';
$redirect_uri = 'http://localhost/UAS/google-login.php';
$scope = 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile';

$login_url = "https://accounts.google.com/o/oauth2/auth?" . http_build_query([
    'response_type' => 'code',
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'scope' => $scope,
    'access_type' => 'offline'
]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style/landing.css">
    <title>Landing Page</title>
</head>
<body>
    <!-- Buttons -->
    <div class="buttons">
        <button onclick="openModal('loginModal')">Login</button>
        <button onclick="openModal('registerModal')">Register</button>
    </div>

    <!-- Welcome Text -->
    <div class="text">
        <h1>
            WELCOME!
            <?php if (isset($_SESSION['username'])): ?>
                <span class="username">- <?= htmlspecialchars($_SESSION['username']) ?></span>
               
            <?php endif; ?>
        </h1>
        <?php if (!isset($_SESSION['username'])): ?>
            <h3>Daftar dan login untuk akses fitur CRUD seperti dibawah ini.</h3>
        <?php endif; ?>
    </div>

    <?php if (!isset($_SESSION['username'])): ?>
        <div class="img">
        <img src="style/foto.png" alt="">
    </div>
    <?php endif; ?>
    
    <!-- Delete Account Button -->
    <?php if (isset($_SESSION['username'])): ?>
        <button id="delete-account-btn" class="delete-account-btn">Hapus Akun</button>
    <?php endif; ?>

    <!-- Modal Login -->
    <div id="loginModal" class="modal">
        <div id="form" class="modal-content">
            <span class="close" onclick="closeModal('loginModal')">&times;</span>
            <h2>Login</h2>
            <form  method="POST" action="login.php">
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" autocomplete="off" >
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Password" autocomplete="off">
                    <span id="eye-icon" class="eye-icon">🙈</span>
                </div>
                <button type="submit" class="btn">Login</button>
                <br>
                <br>
                 <center><p class="p" >Atau</p></center>
                <hr>
                <br>
                <a href="<?php echo $login_url; ?>" class="btn-google">
        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo">
        Login dengan Google
    </a>
            </form>
        </div>
    </div>

    <!-- Modal Register -->
    <div id="registerModal" class="modal">
        <div id="formRegister" class="modal-content">
            <span class="close" onclick="closeModal('registerModal')">&times;</span>
            <h2>Register</h2>
            <form method="POST" action="register.php">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username" autocomplete="off" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" autocomplete="off" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password-register" name="password" placeholder="Password" autocomplete="off" required>
                    <span id="eye-icon-register" class="eye-icon">🙈</span>
                </div>
                <button type="submit" class="btn">Daftar</button>
                <br>
                <br>
                 <center><p class="p" >Atau</p></center>
                <hr>
                <br>
                <a href="<?php echo $login_url; ?>" class="btn-google">
        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo">
        Login dengan Google
    </a>
            </form>
        </div>
    </div>

  

   <script src="animation.js"></script>
</body>
</html>



