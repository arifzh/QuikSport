<?php 
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$page_title = "Home Page";
include('assets/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

    <!-- Logout Button -->
    <div class="logout-container">
        <?php if ($user_id): ?>
            <a href="logout.php" class="logout-btn">Logout</a>
        <?php endif; ?>
    </div>

    <!-- Background Image and Text -->
    <img src="picture/homepagee.jpg" alt="Background" class="background-image">
    <div class="centered"><h1 id="text">Get Active, book your games now</h1></div>
    <div class="centered2"><h2 id="text1">From favourites like badminton to trendy, play all kinds of sports!</h2></div>
  
    <h1 style="text-align: center;">Let's Explore Venues!</h1>

    <div class="container1">
    <?php
    // Sample data
    $venues = [
        [
            'image' => 'picture/badminton1.jpg',
            'title' => 'Re Serve Sport',
            'location' => 'Kajang, Selangor',
            'type' => 'Badminton'
        ],
        [
            'image' => 'picture/badminton2.jpg',
            'title' => 'HOPC (House of Badminton Court)',
            'location' => 'Seri Kembangan, Selangor',
            'type' => 'Badminton'
        ],
        [
            'image' => 'picture/badminton3.jpg',
            'title' => 'KL Badminton Town @ Maluri',
            'location' => 'Kuala Lumpur, Federal Territory of Kuala Lumpur',
            'type' => 'Badminton'
        ],
        [
            'image' => 'picture/badminton4.jpg',
            'title' => 'AG Badminton @ Balakong',
            'location' => 'Seri Kembangan, Selangor',
            'type' => 'Badminton'
        ],
        [
            'image' => 'picture/badminton5.jpg',
            'title' => 'Badminton Paradise Bukit Mertajam',
            'location' => 'Bukit Mertajam, Pulau Pinang',
            'type' => 'Badminton'
        ],
        [
            'image' => 'picture/badminton6.jpg',
            'title' => 'Badminton Arena',
            'location' => 'Batu Pahat, Johor Darul Ta’zim',
            'type' => 'Badminton'
        ]
    ];

    // Loop through the venues and create cards
    foreach ($venues as $venue) {
        echo '
        <div class="card">
            <img src="' . $venue['image'] . '" alt="' . $venue['title'] . '">
            <div class="card-content">
                <h3>' . $venue['title'] . '</h3>
                <p>' . $venue['type'] . '</p>
                <p>' . $venue['location'] . '</p>
            </div>
            <div class="card-actions">
    <a href="bookingPage.php?user_id=<?php echo htmlspecialchars($id); ?>" class="book-btn">Book Now</a>
</div>
        </div>
        ';
    }
    ?>
    </div>
</body>

</html>

<?php include('assets/footer.php');?>
