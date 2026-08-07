<?php
session_start();
if(!isset($_SESSION['admin'])){
	header("location:login.php");
	exit();
}
// Get some stats for the dashboard
include('con.php.php');
$prod_count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM product"));
$user_count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM register"));
$order_count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM orders"));
$pending_count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM orders WHERE o_status='Pending'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard – Mirecal</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --black: #0A0A0F; --dark: #12121A; --card: #1A1A2E; --gold: #C9A84C; --gold-lt: #E8CC7A; --cream: #F5EDD6; --text: #B8B8C8; --text-dim: #6B6B8A; --border: rgba(201,168,76,0.2); --border-h: rgba(201,168,76,0.5); }
        body { font-family: 'Inter', sans-serif; background: var(--black); color: var(--text); display: flex; min-height: 100vh; }
        
        /* Sidebar */
        aside { width: 280px; background: var(--dark); border-right: 1px solid var(--border); display: flex; flex-direction: column; }
        .sidebar-header { padding: 30px 24px; border-bottom: 1px solid var(--border); text-align: center; }
        .sidebar-header h2 { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; color: var(--cream); letter-spacing: 2px; text-transform: uppercase; }
        .sidebar-header h2 span { color: var(--gold); }
        .sidebar-menu { padding: 24px 0; flex: 1; }
        .sidebar-menu ul { list-style: none; }
        .sidebar-menu li a { display: block; padding: 14px 30px; color: var(--text-dim); text-decoration: none; font-size: 0.95rem; font-weight: 500; letter-spacing: 1px; transition: all 0.3s; border-left: 3px solid transparent; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { color: var(--gold); background: rgba(201,168,76,0.05); border-left-color: var(--gold); }
        .sidebar-footer { padding: 24px 30px; border-top: 1px solid var(--border); }
        .sidebar-footer a { color: #ef4444; text-decoration: none; font-size: 0.9rem; font-weight: 600; display: inline-block; transition: 0.3s; }
        .sidebar-footer a:hover { color: #f87171; }

        /* Main Content */
        main { flex: 1; padding: 40px; overflow-y: auto; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .topbar h1 { font-family: 'Cormorant Garamond', serif; font-size: 2.2rem; color: var(--cream); }
        .admin-badge { background: rgba(201,168,76,0.1); border: 1px solid var(--border); color: var(--gold); padding: 8px 16px; border-radius: 50px; font-size: 0.8rem; letter-spacing: 1px; text-transform: uppercase; }

        /* Dashboard Cards */
        .grid-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 40px; }
        .stat-card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 24px; transition: 0.3s; }
        .stat-card:hover { border-color: var(--border-h); transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .stat-card .title { font-size: 0.85rem; color: var(--text-dim); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
        .stat-card .value { font-size: 2.5rem; color: var(--cream); font-weight: 600; font-family: 'Cormorant Garamond', serif; }
        .stat-card .value span { color: var(--gold); }

        /* Welcome Section */
        .welcome-panel { background: linear-gradient(135deg, var(--card), var(--dark)); border: 1px solid var(--border); border-radius: 16px; padding: 40px; position: relative; overflow: hidden; }
        .welcome-panel::before { content:''; position:absolute; top:-50px; right:-50px; width:200px; height:200px; background:radial-gradient(circle, rgba(201,168,76,0.15) 0%, transparent 70%); border-radius:50%; }
        .welcome-panel h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; color: var(--cream); margin-bottom: 12px; }
        .welcome-panel p { color: var(--text); font-size: 0.95rem; max-width: 600px; line-height: 1.6; }
    </style>
</head>
<body>
    
    <aside>
        <div class="sidebar-header">
            <h2>Mire<span>cal</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="product.php">Product Management</a></li>
                <li><a href="customer.php">Customer Management</a></li>
                <li><a href="#">Sales Management</a></li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <a href="logout.php">← Logout</a>
        </div>
    </aside>

    <main>
        <div class="topbar">
            <h1>Overview</h1>
            <div class="admin-badge">Admin Mode</div>
        </div>

        <div class="grid-cards">
            <div class="stat-card">
                <div class="title">Total Products</div>
                <div class="value"><?php echo $prod_count; ?></div>
            </div>
            <div class="stat-card">
                <div class="title">Total Customers</div>
                <div class="value"><?php echo $user_count; ?></div>
            </div>
            <div class="stat-card">
                <div class="title">Total Orders</div>
                <div class="value"><?php echo $order_count; ?></div>
            </div>
            <div class="stat-card">
                <div class="title">Pending Orders</div>
                <div class="value"><span><?php echo $pending_count; ?></span></div>
            </div>
        </div>

        <div class="welcome-panel">
            <h3>Welcome to Mirecal Dashboard</h3>
            <p>Manage your luxury fragrance catalog, track orders, and view customer details from this central hub. Use the sidebar to navigate between different management sections.</p>
        </div>
    </main>

</body>
</html>