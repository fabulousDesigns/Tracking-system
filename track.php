<?php
include_once('./config/config.php');
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

?>

<?php
include_once("header.php");
?>

<body class="text-white">
    <div class="container">
        <div class="navigation">
            <h6 class="welcome">Welcome <?php echo htmlspecialchars($_SESSION["first_name"]); ?></h6>
            <ul class="nav__menu">
                <li>
                    <a href="logout.php" name="logout" class="btn-logout">logout</a>
                </li>
            </ul>
        </div>
        <form class="row domain-search">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <h2 class="form-title">Track Your <strong>Cargo Now</strong></h2>
                        <p>Enter your Tracking number Here</p>
                    </div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="search" class="form-control" placeholder="Enter your Tracking Number" />
                            <span class="input-group-addon"><input type="submit" value="Search" class="btn btn-primary" /></span>
                        </div>
                        <p>
                            ex <strong>123456789</strong>
                        </p>
                    </div>
                </div>
            </div>
        </form>

    </div>
</body>

</html>