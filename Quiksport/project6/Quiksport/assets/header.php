<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="assets/CSS/style.css" type="text/css" media="screen" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
    <!-- Header Section -->
    <div id="header">
        <h1 id="logo">QuikSport</h1>
        <header>
        <nav class="menu">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="Events.php">Events</a></li>
                <li><a href="Profile.php<?php echo isset($user_id) ? '?id=' . $user_id : ''; ?>">Profile</a></li>
                <li><a href="GM.php">About Us</a></li>
            </ul>
        </nav>
    </header>
    </div>

    

    <!-- Main Content Section -->
    <div id="content">
        <!-- Start of the page-specific content. -->
    </div>
</body>
</html>
