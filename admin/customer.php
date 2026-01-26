<?php
include('con.php');
session_start();
if (!isset($_SESSION['admin'])) {
    header("location:login.php");
    exit();
}

 if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // $sel = "SELECT * FROM register WHERE u_id='$id'";
    // $sel_qu = mysqli_query($con,$sel);

    $del = "DELETE FROM register WHERE u_id='$id'";
    $del_qu = mysqli_query($con,$del);
    if($del_qu){
        echo "<script>alert('Deleted')</script>";
    }
    else{
        echo "<script>alert('Some error')</script>";
    }
 }
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        body {
            scroll-behavior: smooth;
        }

        header {
            background-color: black;
            height: 70px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        header h1 {
            color: white;
            font-size: 3rem;
        }

        article {
            background-color: firebrick;
            height: 660px;
            width: 20%;
        }

        article ul {
            display: flex;
            flex-direction: column;
        }

        article li {
            list-style: none;
            padding: 40px 40px;
            background-color: white;
            border-radius: 30% 30%;
            margin: 5% 5%;
        }

        article a {
            text-decoration: none;
            color: black;
        }

        article a:hover {
            border-bottom: solid 2px firebrick;
            transition: all 0.5s ease-in;
        }

        a.active {
            color: firebrick;
            text-decoration: line;
        }
/* 
        form h1 {
            color: black;
            position: relative;
            float: right;
            margin-top: -40%;
            margin-right: 10%;
            font-size: 2rem;
            text-decoration: underline;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 140%;
            height: 30px;
            padding: 10px 30px;
            margin: 3%;
            font-size: 1rem;
            border-radius: 6px;
        }

        #addbtn {
            margin-left: 40.5%;
            padding: 10px 40px;
            font-size: 1rem;
            border-radius: 7px;
            background: firebrick;
            color: white;
            position: absolute;
            bottom: 5%;
        }

        .main {
            justify-content: center;
            align-items: center;
            float: right;
            margin: -35% 40%;
        }

        input:focus {
            outline: none;
            border-color: firebrick;
        }

        #addbtn:hover {
            transition: 0.5s;
            background: white;
            color: black;
            transform: translateY(-10px);
        }*/

        table {
            margin: -40% 35%;
        }

        th,
        td {
            padding: 15px 20px;
        }
        #up{
            margin-top:40%;
        }
        #updatebtn{
            margin-left: 40.5%;
            padding: 10px 40px;
            font-size: 1rem;
            border-radius: 7px;
            background: firebrick;
            color: white;
            position: absolute;
            bottom: -78%;
        }
        #updatebtn:hover{
            transition: 0.5s;
            background: white;
            color: black;
            transform: translateY(-10px);
        } 
        
        td .green{
            background:green;
            text-decoration:none;
            color:white;
            padding:5px 10px;
            border-radius:5px;
        }
        td .red{
            background:firebrick;
            text-decoration:none;
            color:white;
            padding:5px 10px;
            border-radius:5px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Welcome to Pro Dashboard</h1>
    </header>
    <article>
        <ul>
            <li><a href="product.php">Product Management</a></li>
            <li><a href="customer.php" class="active">Customer Management</a></li>
            <li><a href="#">Sales Management</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </article>
 

    <div>
        <table align="center" border="5">
            <tr>
                <th>User Id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Confirm Password</th>
                <th>Action</th>
            </tr>

            <?php
            $sel = "SELECT * FROM register";
            $query_sel = mysqli_query($con, $sel);

            while ($result = mysqli_fetch_array($query_sel)) {
                ?>
                <tr>
                    <td><?php echo $result['u_id'] ?></td>
                    <td><?php echo $result['username'] ?></td>
                    <td><?php echo $result['email'] ?></td>
                    <td><?php echo $result['password'] ?></td>
                    <td><?php echo $result['confirm_password'] ?></td>
                    <td><a href="customer.php?id=<?php echo $result['u_id']; ?>" class="red">Remove</a></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</body>

</html>
