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
<title>Tim Berners-Lee Computer Lab</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<!-- Top Background Image Wrapper -->
<div class="bgded overlay" style="background-image:url('images/backgrounds/nixonbuilding.jpeg');">
  <div class="wrapper row1">
    <?php include 'banner.php'; ?>
  </div>
  <div class="wrapper row2">
    <div id="breadcrumb" class="hoc clear">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="timberners-lee.php">Tim Berners-Lee Computer Lab</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- End Top Background Image Wrapper -->
<div class="wrapper row3">
  <main class="hoc container clear">
    <!-- main body -->
    <div class="content" align='center'>
      <div class="roomtitle">
        <h1>Tim Berners-Lee Computer Lab</h1>
      </div>

      <p>The Tim Berners-Lee Computer Lab is one of the 3 computer labs located in the ICT department in the senior school.</p>

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
              // rooms details are retrieved from room table in db
              $user = DB::getInstance()->get('room', array('roomID', '=', '2'));
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
              <td>2</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div>
        <h2> Pictures </h2>
        <img src="images/rooms/timberners-lee.jpg" alt="" style="width:456px;height:342px;">
        <br><br>
        <img src="images/rooms/timberners-lee3.jpg" alt="" style="width:456px;height:342px;">
        &nbsp;&nbsp;&nbsp;
        <img src="images/rooms/timberners-lee2.jpg" alt="" style="width:456px;height:342px;">
      </div>
    </div>
    <!-- / main body -->
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
