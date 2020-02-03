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
<title>Manage Users</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<div class="bgded overlay" style="background-image:url('images/backgrounds/nixonbuilding.jpeg');">
  <div class="wrapper row1">
    <?php include 'banner.php'; ?>
	<?php
    $user = new User;
    if (!$user->isLoggedIn()) {
       Redirect::to('index.php');
    }
	?>
  </div>
  <div class="wrapper row2">
    <div id="breadcrumb" class="hoc clear">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="managebookings.php">Manage Users</a></li>
      </ul>
    </div>
  </div>
</div>
<?php





?>
<div class="wrapper row3">
  <main class="hoc container clear">
    <div class="content">
      <div class="roomtitle" align="center">
        <h1>Manage Users</h1>
      </div>

      <?php
      // current user groupid is stored
      $currentUser = $user->data()->groupid;
      if ($currentUser == 1) {
        Redirect::to('index.php');
      }
      // current user's ID is stored and user information is retrieved
      $userID = $user->data()->ID;
      $users = DB::getInstance()->query('SELECT * FROM users WHERE groupid = 1');

      ?>

      <div class="scrollable">
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Username</th>
              <th>Email</th>
              <th>Action</th>

            </tr>
          </thead>
          <tbody>
            <!-- User details are outputted in a table -->
            <?php foreach($users->results() as $users){ ?>
            <tr>
              <td> <?php echo $users->name; ?> </td>
              <td> <?php echo $users->username; ?> </td>
              <td> <?php echo $users->email; ?> </td>
              <td> <?php echo "<a href='usermanager.php?admin=" . $users->ID . "'> Make Admin </a> | <a href='userdelete.php?userID=" . $users->ID . "'> Delete User </a> </td>"; ?>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>
<?php include 'footer.php';

if ($_GET) {
  $admin = $_GET['admin'];
  DB::getInstance()->query("UPDATE `users` SET `groupid`=2 WHERE ID = $admin");

}

?>

<!-- JAVASCRIPTS -->
<script src="../layout/scripts/jquery.min.js"></script>
<script src="../layout/scripts/jquery.backtotop.js"></script>
<script src="../layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>
