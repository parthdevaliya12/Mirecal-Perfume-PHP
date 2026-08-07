<?php
include('con.php.php');
session_start();
if (!isset($_SESSION['admin'])) {
    header("location:login.php");
    exit();
}

$msg = "";
$msg_type = "";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $del = "DELETE FROM register WHERE u_id='$id'";
    if (mysqli_query($con, $del)) {
        echo "<script>window.location='customer.php';</script>";
        exit();
    } else {
        $msg = "Error removing customer.";
        $msg_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Management – Mirecal</title>
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
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .topbar h1 { font-family: 'Cormorant Garamond', serif; font-size: 2.2rem; color: var(--cream); }

        .toast-msg { padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-size: 0.9rem; }
        .toast-msg.error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #ef4444; }

        .table-card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th { background: rgba(201,168,76,0.1); color: var(--gold); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; padding: 14px; text-align: left; }
        td { padding: 14px; border-bottom: 1px solid var(--border); color: var(--text); font-size: 0.9rem; }
        tr:hover td { background: rgba(255,255,255,0.02); }
        
        .btn-delete { background: rgba(239,68,68,0.15); color: #ef4444; border: 1px solid rgba(239,68,68,0.3); padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; }
        
        /* Security warning */
        .sec-warning { font-size: 0.75rem; color: #f59e0b; background: rgba(245,158,11,0.1); padding: 4px 8px; border-radius: 4px; display: inline-block; margin-bottom: 16px; border: 1px solid rgba(245,158,11,0.3); }
    </style>
</head>
<body>

    <aside>
        <div class="sidebar-header">
            <h2>Mire<span>cal</span></h2>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="product.php">Product Management</a></li>
                <li><a href="customer.php" class="active">Customer Management</a></li>
                <li><a href="#">Sales Management</a></li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <a href="logout.php">← Logout</a>
        </div>
    </aside>

    <main>
        <div class="topbar">
            <h1>Customer Management</h1>
        </div>

        <?php if(!empty($msg)): ?>
            <div class="toast-msg <?php echo $msg_type; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>

        <div class="sec-warning">⚠ Note: Passwords are shown in plaintext as inherited from original project architecture.</div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email Address</th>
                        <th>Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sel = "SELECT * FROM register ORDER BY u_id DESC";
                    $query_sel = mysqli_query($con, $sel);

                    while ($result = mysqli_fetch_array($query_sel)) {
                        echo "<tr>
                            <td>#{$result['u_id']}</td>
                            <td style='color:var(--cream);font-weight:500'>{$result['username']}</td>
                            <td>{$result['email']}</td>
                            <td style='font-family:monospace;color:var(--text-dim)'>{$result['password']}</td>
                            <td>
                                <a href='customer.php?id={$result['u_id']}' class='btn-delete' onclick='return confirm(\"Are you sure you want to remove this customer?\")'>Remove</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
