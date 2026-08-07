<?php
include("con.php");
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic sanitization
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);

    $sel = "SELECT * FROM register WHERE email='$email' AND password='$password'";
    $query = mysqli_query($con, $sel);

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        $_SESSION['user'] = $data;
        // Redirect via JS to avoid headers-already-sent issue
        echo "<script>window.location.href='index.php';</script>";
        exit();
    } else {
        $login_error = "Invalid email or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Login – Mirecal Perfumes</title>
   <meta name="description" content="Sign in to your Mirecal account to shop luxury perfumes">
   <link rel="stylesheet" href="css/bootstrap.css">
   <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
   <style>
      *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
      :root {
         --black: #0A0A0F; --dark: #12121A; --card: #1A1A2E;
         --gold: #C9A84C; --gold-lt: #E8CC7A; --cream: #F5EDD6;
         --text: #B8B8C8; --text-dim: #6B6B8A;
         --border: rgba(201,168,76,0.2); --border-h: rgba(201,168,76,0.6);
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
      }

      /* Background glow */
      body::before {
         content: '';
         position: fixed;
         top: -200px; left: -200px;
         width: 600px; height: 600px;
         background: radial-gradient(circle, rgba(201,168,76,0.1) 0%, transparent 70%);
         border-radius: 50%;
         animation: glowPulse 5s ease-in-out infinite;
      }
      body::after {
         content: '';
         position: fixed;
         bottom: -200px; right: -200px;
         width: 500px; height: 500px;
         background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 70%);
         border-radius: 50%;
         animation: glowPulse 7s ease-in-out infinite reverse;
      }
      @keyframes glowPulse {
         0%,100% { transform: scale(1); }
         50% { transform: scale(1.15); }
      }

      /* Card */
      .login-card {
         background: var(--card);
         border: 1px solid var(--border);
         border-radius: 20px;
         padding: 52px 48px;
         width: 100%;
         max-width: 440px;
         position: relative;
         z-index: 1;
         animation: fadeInUp 0.7s ease;
         box-shadow: 0 30px 80px rgba(0,0,0,0.6), 0 0 40px rgba(201,168,76,0.08);
      }

      .brand-logo {
         display: flex;
         align-items: center;
         gap: 12px;
         margin-bottom: 36px;
      }
      .brand-logo img {
         width: 44px; height: 44px;
         border-radius: 50%;
         border: 2px solid var(--gold);
         object-fit: cover;
      }
      .brand-logo span {
         font-family: 'Cormorant Garamond', serif;
         font-size: 1.5rem;
         font-weight: 700;
         color: var(--cream);
         letter-spacing: 3px;
         text-transform: uppercase;
      }
      .brand-logo span em { color: var(--gold); font-style: normal; }

      .login-card h2 {
         font-family: 'Cormorant Garamond', serif;
         font-size: 2rem;
         font-weight: 700;
         color: var(--cream);
         margin-bottom: 6px;
      }
      .login-card .subtitle {
         font-size: 0.88rem;
         color: var(--text-dim);
         margin-bottom: 32px;
      }

      .form-group { margin-bottom: 20px; }
      .form-label {
         display: block;
         font-size: 0.72rem;
         font-weight: 600;
         letter-spacing: 1.5px;
         text-transform: uppercase;
         color: var(--text-dim);
         margin-bottom: 8px;
      }
      .form-input {
         width: 100%;
         background: rgba(255,255,255,0.04);
         border: 1px solid var(--border);
         color: var(--cream);
         padding: 13px 16px;
         border-radius: 10px;
         font-size: 0.95rem;
         font-family: 'Inter', sans-serif;
         outline: none;
         transition: border-color 0.3s ease, box-shadow 0.3s ease;
      }
      .form-input:focus {
         border-color: var(--gold);
         box-shadow: 0 0 0 3px rgba(201,168,76,0.1);
      }
      .form-input::placeholder { color: var(--text-dim); }

      .error-msg {
         background: rgba(239,68,68,0.1);
         border: 1px solid rgba(239,68,68,0.3);
         color: #ef4444;
         padding: 12px 16px;
         border-radius: 8px;
         font-size: 0.85rem;
         margin-bottom: 20px;
      }

      .btn-login {
         width: 100%;
         background: var(--gold);
         color: var(--black);
         border: 2px solid var(--gold);
         padding: 14px;
         border-radius: 10px;
         font-size: 0.85rem;
         font-weight: 700;
         letter-spacing: 2px;
         text-transform: uppercase;
         cursor: pointer;
         font-family: 'Inter', sans-serif;
         transition: all 0.3s ease;
         margin-top: 8px;
      }
      .btn-login:hover {
         background: transparent;
         color: var(--gold);
         box-shadow: 0 6px 24px rgba(201,168,76,0.3);
         transform: translateY(-2px);
      }

      .signup-link {
         text-align: center;
         margin-top: 24px;
         font-size: 0.88rem;
         color: var(--text-dim);
      }
      .signup-link a {
         color: var(--gold);
         font-weight: 600;
         text-decoration: none;
         transition: color 0.3s ease;
      }
      .signup-link a:hover { color: var(--gold-lt); }

      @keyframes fadeInUp {
         from { opacity: 0; transform: translateY(24px); }
         to   { opacity: 1; transform: translateY(0); }
      }

      @media (max-width: 480px) {
         .login-card { padding: 36px 24px; margin: 20px; }
      }
   </style>
</head>
<body>
   <div class="login-card">
      <div class="brand-logo">
         <img src="images/logo.jpeg" alt="Mirecal">
         <span>Mire<em>cal</em></span>
      </div>

      <h2>Welcome Back</h2>
      <p class="subtitle">Sign in to your account to continue</p>

      <?php if (!empty($login_error)): ?>
         <div class="error-msg">⚠ <?php echo $login_error; ?></div>
      <?php endif; ?>

      <form method="post" id="loginForm">
         <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-input" placeholder="you@example.com" required>
         </div>
         <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
         </div>
         <button type="submit" name="submit" class="btn-login">Sign In</button>
      </form>

      <div class="signup-link">
         Don't have an account? <a href="register.php">Create Account</a>
      </div>
   </div>
</body>
</html>
