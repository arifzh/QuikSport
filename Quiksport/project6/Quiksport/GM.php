<?php
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$page_title = 'Profile Page';

require ('../mysqli_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link href = About-Us/GM.css type = "text/css" rel = "stylesheet"/>
</head>

<body>
  <section>
    <div class="row">
      <h1>Our Team</h1>
    </div>
    <div class="row">
      <!-- Column 1-->
      <div class="column">
        <div class="card">
          <div class="img-container">
            <img src="About-Us/amshar.jpeg" />
          </div>
          <br><h3>Khaizuran Amshar</h3>
        </div>
      </div>
      <!-- Column 3-->
      <div class="column">
        <div class="card">
          <div class="img-container">
            <img src="About-Us/arif.jpeg" />
          </div>
          <br><h3>Arif Fahmi</h3>
        </div>
      </div>
       <!-- Column 4-->
       <div class="column">
        <div class="card">
          <div class="img-container">
            <img src="About-Us/Khairul2.jpeg" />
          </div>
          <br><h3>Khairul Aqib</h3>
        </div>
      </div>
       <!-- Column 4-->
       <div class="column">
        <div class="card">
          <div class="img-container">
            <img src="About-Us/akid.jpeg" />
          </div>
          <br><h3>Akid Danish</h3>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
