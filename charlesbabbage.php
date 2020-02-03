<!DOCTYPE html>
<!--
Template Name: Geodarn
Author: <a href="http://www.os-templates.com/">OS Templates</a>
Author URI: http://www.os-templates.com/
Licence: Free to use under our free template licence terms
Licence URI: http://www.os-templates.com/template-terms
-->



<html>
<head>
<title>Charles Babbage Computer Lab</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<div class="bgded overlay" style="background-image:url('images/backgrounds/nixonbuilding.jpeg');">
  <div class="wrapper row1">
    <?php
    // banner of links is included
    include 'banner.php';

    ?>
  </div>
  <div class="wrapper row2">
    <div id="breadcrumb" class="hoc clear">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="charlesbabbage.php">Charles Babbage Computer Lab</a></li>
      </ul>
    </div>
  </div>
</div>
<div class="wrapper row3">
  <main class="hoc container clear">
    <div class="content" align='center'>
      <div class="roomtitle" align='center'>
        <h1>Charles Babbage Computer Lab</h1>
      </div>

      <p>The Charles Babbage Computer Lab is one of the 3 computer labs located in the ICT department in the senior school.</p>

      <h1>Facilities</h1>
      <div class="scrollable">
        <table>
          <thead>
            <tr>
              <th>Item</th>
              <th>Quantity</th>

            </tr>
          </thead>
          <tbody align='center'>
            <tr>
              <td>Computers</td>
              <td>
              <?php
              // current rooms information is retrieved from the room table in database
              $user = DB::getInstance()->get('room', array('roomID', '=', '3'));
              foreach($user->results() as $user){
                echo $user->computers;
              }
              ?>
              </td>
            </tr>
            <tr>
              <td>Projectors</td>
              <td>1</td>
            </tr>
            <tr>
              <td>Printers</td>
              <td>1</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div>
        <h2> Pictures </h2>
        <img src="images/rooms/charlesbabbageroom3.jpg" alt="" style="width:456px;height:342px;">
        <br><br>
        <img src="images/rooms/charlesbabbageroom.jpg" alt="" style="width:456px;height:342px;">
        &nbsp;&nbsp;&nbsp;
        <img src="images/rooms/charlesbabbageroom2.jpg" alt="" style="width:456px;height:342px;">
      </div>
    </div>
    <div class="clear"></div>
  </main>
</div>
<?php include 'footer.php'; ?>
<!-- JAVASCRIPTS -->
<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<script src="../layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>
