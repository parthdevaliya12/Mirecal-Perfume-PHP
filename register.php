<?php
include("con.php");

$register_error = '';
$register_success = '';

if (isset($_POST['submit'])) {
    $u  = mysqli_real_escape_string($con, $_POST['username']);
    $e  = mysqli_real_escape_string($con, $_POST['email']);
    $p  = $_POST['password'];
    $cp = $_POST['con_password'];

    if ($p !== $cp) {
        $register_error = "Passwords do not match. Please try again.";
    } else {
        // Check if email already exists
        $check = "SELECT * FROM register WHERE email='$e'";
        $check_q = mysqli_query($con, $check);
        if (mysqli_num_rows($check_q) > 0) {
            $register_error = "An account with this email already exists.";
        } else {
            $reg = "INSERT INTO register(username, email, password, confirm_password) VALUES ('$u','$e','$p','$cp')";
            $reg_query = mysqli_query($con, $reg);
            if ($reg_query) {
                echo "<script>window.location.href='login.php';</script>";
                exit();
            } else {
                $register_error = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Register – Mirecal Perfumes</title>
   <meta name="description" content="Create your Mirecal account to shop luxury perfumes">
   <link rel="stylesheet" href="css/bootstrap.css">
   <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
   <style>
      *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
      :root {
         --black: #0A0A0F; --dark: #12121A; --card: #1A1A2E;
         --gold: #C9A84C; --gold-lt: #E8CC7A; --cream: #F5EDD6;
         --text: #B8B8C8; --text-dim: #6B6B8A;
         --border: rgba(201,168,76,0.2);
      }
      body {
         font-family: 'Inter', sans-serif;
         background: var(--black);
         color: var(--text);
         min-height: 100vh;
         display: flex;
         align-items: center;
         justify-content: center;
         position: relative;
         overflow: hidden;
         padding: 30px 16px;
      }
      body::before {
         content: '';
         position: fixed;
         top: -200px; right: -200px;
         width: 600px; height: 600px;
         background: radial-gradient(circle, rgba(201,168,76,0.1) 0%, transparent 70%);
         border-radius: 50%;
         animation: glowPulse 5s ease-in-out infinite;
      }
      @keyframes glowPulse { 0%,100%{transform:scale(1);} 50%{transform:scale(1.15);} }

      .register-card {
         background: var(--card);
         border: 1px solid var(--border);
         border-radius: 20px;
         padding: 52px 48px;
         width: 100%;
         max-width: 480px;
         position: relative;
         z-index: 1;
         animation: fadeInUp 0.7s ease;
         box-shadow: 0 30px 80px rgba(0,0,0,0.6), 0 0 40px rgba(201,168,76,0.08);
      }
      .brand-logo {
         display: flex; align-items: center; gap: 12px; margin-bottom: 36px;
      }
      .brand-logo img {
         width: 44px; height: 44px; border-radius: 50%;
         border: 2px solid var(--gold); object-fit: cover;
      }
      .brand-logo span {
         font-family: 'Cormorant Garamond', serif;
         font-size: 1.5rem; font-weight: 700;
         color: var(--cream); letter-spacing: 3px; text-transform: uppercase;
      }
      .brand-logo span em { color: var(--gold); font-style: normal; }

      .register-card h2 {
         font-family: 'Cormorant Garamond', serif;
         font-size: 2rem; font-weight: 700; color: var(--cream); margin-bottom: 6px;
      }
      .register-card .subtitle {
         font-size: 0.88rem; color: var(--text-dim); margin-bottom: 32px;
      }

      .form-group { margin-bottom: 18px; }
      .form-label {
         display: block; font-size: 0.72rem; font-weight: 600;
         letter-spacing: 1.5px; text-transform: uppercase;
         color: var(--text-dim); margin-bottom: 8px;
      }
      .form-input {
         width: 100%;
         background: rgba(255,255,255,0.04);
         border: 1px solid var(--border);
         color: var(--cream); padding: 13px 16px; border-radius: 10px;
         font-size: 0.95rem; font-family: 'Inter', sans-serif;
         outline: none; transition: border-color 0.3s, box-shadow 0.3s;
      }
      .form-input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,0.1); }
      .form-input::placeholder { color: var(--text-dim); }

      .error-msg {
         background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3);
         color: #ef4444; padding: 12px 16px; border-radius: 8px;
         font-size: 0.85rem; margin-bottom: 20px;
      }

      .btn-register {
         width: 100%; background: var(--gold); color: var(--black);
         border: 2px solid var(--gold); padding: 14px; border-radius: 10px;
         font-size: 0.85rem; font-weight: 700; letter-spacing: 2px;
         text-transform: uppercase; cursor: pointer; font-family: 'Inter', sans-serif;
         transition: all 0.3s ease; margin-top: 8px;
      }
      .btn-register:hover {
         background: transparent; color: var(--gold);
         box-shadow: 0 6px 24px rgba(201,168,76,0.3); transform: translateY(-2px);
      }

      .signin-link {
         text-align: center; margin-top: 24px; font-size: 0.88rem; color: var(--text-dim);
      }
      .signin-link a { color: var(--gold); font-weight: 600; text-decoration: none; }
      .signin-link a:hover { color: var(--gold-lt); }

      @keyframes fadeInUp {
         from { opacity:0; transform: translateY(24px); }
         to   { opacity:1; transform: translateY(0); }
      }
      @media (max-width: 480px) { .register-card { padding: 36px 24px; } }
   </style>
</head>
<body>
   <div class="register-card">
      <div class="brand-logo">
         <img src="images/logo.jpeg" alt="Mirecal">
         <span>Mire<em>cal</em></span>
      </div>

      <h2>Create Account</h2>
      <p class="subtitle">Join Mirecal to discover luxury fragrances</p>

      <?php if (!empty($register_error)): ?>
         <div class="error-msg">⚠ <?php echo $register_error; ?></div>
      <?php endif; ?>

      <form method="post" id="regForm" onsubmit="return validateForm()">
         <div class="form-group">
            <label class="form-label" for="username">Full Name</label>
            <input type="text" id="username" name="username" class="form-input" placeholder="Your name" required>
         </div>
         <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-input" placeholder="you@example.com" required>
         </div>
         <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-input" placeholder="Create a password" required>
         </div>
         <div class="form-group">
            <label class="form-label" for="con_password">Confirm Password</label>
            <input type="password" id="con_password" name="con_password" class="form-input" placeholder="Repeat your password" required>
         </div>
         <button type="submit" name="submit" class="btn-register">Create Account</button>
      </form>

      <div class="signin-link">
         Already have an account? <a href="login.php">Sign In</a>
      </div>
   </div>

   <script>
      // Fix: moved out of DOMContentLoaded so it's globally accessible from onsubmit
      function validateForm() {
         var password = document.getElementById('password').value;
         var con_password = document.getElementById('con_password').value;
         if (password !== con_password) {
            var errDiv = document.querySelector('.error-msg');
            if (!errDiv) {
               errDiv = document.createElement('div');
               errDiv.className = 'error-msg';
               document.getElementById('regForm').before(errDiv);
            }
            errDiv.textContent = '⚠ Passwords do not match.';
            return false;
         }
         return true;
      }
   </script>
</body>
</html>
