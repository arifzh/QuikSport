<?php 
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$page_title = 'Events Page';
include('assets/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Page</title>

    <link rel="stylesheet" href="assets/css/styles.css"> 

</head>
<body>
<div class="container1">
<?php
    $events = [
        [
            'image' => 'images/Event2.jpg',
            'location' => 'Kajang',
            'title' => 'Mixed Double Opens',
            'date' => '1st April 2025',
            'time' => '12:00 P.M.',
            'hosted' => 'Mr San',
            'contact' => "015559231"
        ],
        [
            'image' => 'images/event3.jpg',
            'location' => 'Batu Pahat',
            'title' => 'Mens Single & Double',
            'date' => '21st March 2025',
            'time' => '5:30 P.M. ',
            'hosted' => 'Mr Meow',
            'contact' => "015215562"
        ],
        [
            'image' => 'images/event4.jpg',
            'location' => 'Bukit Mertajam',
            'title' => 'Open Tournament',
            'date' => '1st April 2025',
            'time' => '12:00 P.M.',
            'hosted' => 'Ms Minji',
            'contact' => "0159349231"
        ],
        [
            'image' => 'images/event5.jpg',
            'location' => 'Kuala Lumpur',
            'title' => 'Mixed Double Opens',
            'date' => '3rd - 4th April 2025 5th - 9th April 2025',
            'time' => '12:00 P.M.',
            'hosted' => 'Mr Pepero',
            'contact' => "0122402213"
        ],
        [
            'image' => 'images/event6.jpg',
            'location' => 'Bukit Bintang',
            'title' => 'Mixed Double Opens',
            'date' => '1st April 2025',
            'time' => '12:00 P.M.',
            'hosted' => 'Mr Fahmi',
            'contact' => "0127821492"
        ],
        [
            'image' => 'images/event7.jpg',
            'location' => 'Kota Damansara',
            'title' => 'Female Tournament',
            'date' => '30th March 2030',
            'time' => '6:00 P.M.',
            'hosted' => 'Mr Tom H.',
            'contact' => "0195543217"
        ]
    ];

    foreach ($events as $events) {
        echo '
        <div class="card">
            <img src="' . $events['image'] . '" alt="' . $events['title'] . '">
            <div class="card-content">
                <h3>' . $events['title'] . '</h3>
                <p>' . "Location : " . $events['location'] . '</p>
                <p>' . "Date : " . $events['date'] . '</p>
                <p>' . "Time : " . $events['time'] . '</p>
                <p>' . "Hosted By : " . $events['hosted'] . '</p>
                <p>' . "Contact Number : " . $events['contact'] . '</p>
            </div>
        </div>
        ';
    }?>

</div>
</body>
</html>

<?php include('assets/footer.php');?>