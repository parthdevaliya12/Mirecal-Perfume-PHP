<?php
include('con.php.php');  // note: admin has its own con file
session_start();
if(isset($_POST['submit'])){
    $u = mysqli_real_escape_string($con, $_POST['username']);
    $p = mysqli_real_escape_string($con, $_POST['password']);

    $sele  = "SELECT * FROM admin WHERE username='$u' AND password='$p'";
    $query = mysqli_query($con, $sele);
    if(mysqli_num_rows($query) > 0){
        $data = mysqli_fetch_array($query);
        $_SESSION['admin'] = $data;
        header("location:dashboard.php");
        exit();
    } else {
        $admin_error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Admin Login – Mirecal</title>
   <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
   <style>
      *{ margin:0; padding:0; box-sizing:border-box; }
      :root{ --black:#0A0A0F; --card:#1A1A2E; --gold:#C9A84C; --gold-lt:#E8CC7A; --cream:#F5EDD6; --text:#B8B8C8; --text-dim:#6B6B8A; --border:rgba(201,168,76,0.2); }
      body{
         font-family:'Inter',sans-serif; background:var(--black); color:var(--text);
         min-height:100vh; display:flex; align-items:center; justify-content:center;
         position:relative; overflow:hidden;
      }
      body::before{
         content:''; position:fixed; top:-150px; right:-150px; width:500px; height:500px;
         background:radial-gradient(circle,rgba(201,168,76,0.1) 0%,transparent 70%); border-radius:50%;
         animation:glow 5s ease-in-out infinite;
      }
      @keyframes glow{ 0%,100%{transform:scale(1);} 50%{transform:scale(1.15);} }
      .admin-card{
         background:var(--card); border:1px solid var(--border); border-radius:20px;
         padding:52px 48px; width:100%; max-width:420px; position:relative; z-index:1;
         animation:fadeUp 0.7s ease; box-shadow:0 30px 80px rgba(0,0,0,0.7);
      }
      @keyframes fadeUp{ from{opacity:0;transform:translateY(20px);} to{opacity:1;transform:translateY(0);} }
      .admin-badge{
         display:inline-block; background:rgba(201,168,76,0.12); border:1px solid rgba(201,168,76,0.4);
         color:var(--gold); font-size:0.7rem; letter-spacing:3px; text-transform:uppercase;
         padding:5px 16px; border-radius:20px; margin-bottom:20px;
      }
      .admin-card h2{
         font-family:'Cormorant Garamond',serif; font-size:2rem; color:var(--cream); margin-bottom:6px;
      }
      .subtitle{ font-size:0.88rem; color:var(--text-dim); margin-bottom:32px; }
      .form-group{ margin-bottom:18px; }
      .form-label{ display:block; font-size:0.72rem; font-weight:600; letter-spacing:1.5px; text-transform:uppercase; color:var(--text-dim); margin-bottom:8px; }
      .form-input{
         width:100%; background:rgba(255,255,255,0.04); border:1px solid var(--border);
         color:var(--cream); padding:13px 16px; border-radius:10px; font-size:0.95rem;
         font-family:'Inter',sans-serif; outline:none; transition:border-color 0.3s, box-shadow 0.3s;
      }
      .form-input:focus{ border-color:var(--gold); box-shadow:0 0 0 3px rgba(201,168,76,0.1); }
      .form-input::placeholder{ color:var(--text-dim); }
      .error-msg{ background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#ef4444; padding:12px 16px; border-radius:8px; font-size:0.85rem; margin-bottom:20px; }
      .btn-login{
         width:100%; background:var(--gold); color:var(--black); border:2px solid var(--gold);
         padding:14px; border-radius:10px; font-size:0.85rem; font-weight:700; letter-spacing:2px;
         text-transform:uppercase; cursor:pointer; font-family:'Inter',sans-serif;
         transition:all 0.3s; margin-top:8px;
      }
      .btn-login:hover{ background:transparent; color:var(--gold); box-shadow:0 6px 24px rgba(201,168,76,0.3); transform:translateY(-2px); }
      @media(max-width:480px){ .admin-card{ padding:36px 24px; margin:20px; } }
   </style>
</head>
<body>
   <div class="admin-card">
      <span class="admin-badge">Admin Portal</span>
      <h2>Welcome Back</h2>
      <p class="subtitle">Sign in to the Mirecal admin panel</p>

      <?php if (!empty($admin_error)): ?>
         <div class="error-msg">⚠ <?php echo $admin_error; ?></div>
      <?php endif; ?>

      <form method="post">
         <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-input" placeholder="Admin username" required>
         </div>
         <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-input" placeholder="Enter password" required>
         </div>
         <button type="submit" name="submit" class="btn-login">Sign In</button>
      </form>
   </div>
</body>
</html>