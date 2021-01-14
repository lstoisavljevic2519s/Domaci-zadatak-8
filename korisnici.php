<?php
  require_once 'code/Domaci.php';
  $users = Domaci::showUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <main class="container">
    <?php 
      foreach($users as $user) {
        ?>
        <div class="user">
          <p><?php echo $user->email; ?></p>
          <p><?php echo $user->type;?></p>
          <p><?php echo $user->pol; ?></p>
          <p><?php echo $user->gender;?></p>
          <p><?php echo $user->password;?></p>
          <p><?php echo $user->adress;?></p>
          <p><?php echo $user->broj_telefona;?></p>
          <?php 
            if($user->type == 'admin') {
              ?>
                <div class="actions">
                <a href="index.php?page=userEdit&id=<?php echo $user->id ?>">Azuriraj</a>
                <div class="delete">
                  <form action="models/User.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user->id ?>">
                    <input type="submit" name="deleteUser" value="Delete">
                  </form>
                </div>
                </div>
              <?php
            }
          ?>
        </div>
        <?php
      }
    ?>
  </main>
</body>
</html>