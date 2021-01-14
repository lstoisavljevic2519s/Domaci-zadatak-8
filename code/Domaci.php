<?php 
class Domaci {
  function registerUser()
  {
    global $conn;
  
    $email = $_POST['email'];
    $type = $_POST['type'];
    $gender = $_POST['pol'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];
    $adresa = $_POST['adress'];
    $broj_telefona = $_POST['brTel'];
  
  
    if (empty($email) || empty($password) || empty($type) || empty($gender) || empty($adresa)) {
      header("Location: ../registracija.php?error=emptyfields&" . $email . "&mail=" . $email);
      exit();
    } else if (!preg_match("/^([a-zA-Z][0-9]{3,16})$/", $email) && (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
      header("Location: ../registracija.php?error=incorrectfields&" . $email . "&mail=" . $email);
      exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header("Location: ../registracija.php?error=emptyfields&" . $email);
      exit();
    } else if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,}$/", $password)) {
      header("Location: ../registracija.php?error=incorrectpassword&" . $email . "&mail=" . $email);
      exit();
    } else if(!preg_match("/^.{3,}$/", $adresa)) {
      header("Location: ../registracija.php?error=emptyusername&&mail=" . $email);
      exit();
    }
    else if ($password !== $passwordConf) {
      header("Location: ../registracija.php?error=passwordsunmatch&" . $email . "&mail=" . $email);
      exit();
    } else {
      $querry = "SELECT email FROM users WHERE email = :email";
      $stat = $conn->prepare($querry);
      if (!$conn->prepare($querry)) {
        header("Location: ../registracija.php?error=sqlfailed");
        exit();
      } else {
        $stat->bindParam(":email", $email);
        $stat->execute();
        $result = $stat->fetch(PDO::FETCH_ASSOC);
        if ($result > 0) {
          header("Location: ../registracija.php?error=userexists");
          exit();
        } else {
          $querry = "INSERT INTO users (email, type, pol, password, adress, broj_telefona) VALUES (:email, :type, :pol, :password, :address, :broj_telefona)";
          $stat = $conn->prepare($querry);
          $userImage = "public/images/assets/notset.jpg";
          if (!$conn->prepare($querry)) {
            header("Location: ../registracija.php?sqlFail");
            exit();
          } else {
            $hashPw = password_hash($password, PASSWORD_DEFAULT);
            $stat->bindParam(":email", $email);
            $stat->bindParam(":type", $type);
            $stat->bindParam(":pol", $gender);
            $stat->bindParam(":password", $password);
            $stat->bindParam(":address", $adresa);
            $stat->bindParam(":broj_telefona", $broj_telefona);
            $stat->execute();
  
            header("Location: ../login.php?register=success");
            exit();
          }
        }
      }
    }
  }

  function showUsers() {
    global $conn;
    $query = "SELECT * FROM users";
    return $conn->query($query)->fetchAll();
  }

  function deleteUser() {
    global $conn;
    $userId = $_POST['user_id'];
    session_start();
    if ($userId == $_SESSION['id']) {
      header("Location: ../korisnici.php&error=notSelf");
    } else {
      $query = "DELETE FROM users WHERE id = :id";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(":id", $userId);
      $stmt->execute();
      header("Location: ../korisnici.php?success=uspeh");
    }
  }

  function loginUser()
  {
    global $conn;
  
    $email = $_POST['email'];
    $password = $_POST['password'];
  
    if (empty($password)) {
      header("Location: ../login.php&error=praznaSifra");
      exit();
    } 
    else if(empty($email)) {
      header("Location: ../login.php&error=prazanEmail");
      exit();
    }
    else {
      $querry = 'SELECT * FROM users WHERE email=:email;';
      $stmt = $conn->prepare($querry);
      if (!$conn->prepare($querry)) {
        header("Location: ../login.php?error=statementNotRead1y");
        exit();
      } else {
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $pwdCheck = password_verify($password, $result["password"]);
        if ($pwdCheck == false) {
          header("Location: ../login.php?error=wrongPwd&email=".$email);
          exit();
        } else if ($pwdCheck == true) {
          session_start();
          $_SESSION['id'] = $result['id'];
          $_SESSION['email'] = $result['email'];
          $_SESSION['type'] = $result['type'];
          $_SESSION['pol'] = $result['pol'];
          $_SESSION['password'] = $result['password'];
          $_SESSION['gender'] = $result['gender'];
          $_SESSION['adress'] = $result['adress'];
          $_SESSION['broj_telefona'] = $result['broj_telefona'];
          header("Location: ../login.php?login=success");
          exit();
        } else {
          header("Location:  ../login.php?error=godKnowsWhatThisIs");
          exit();
        }
        header("Location: ../login.php?error=nouser");
        exit();
      }
    }
  }
}

if (isset($_POST['register'])) {
  include_once '../config/connection.php';
  Domaci::registerUser();
} else if (isset($_POST['login'])) {
  include_once '../config/connection.php';
  Domaci::loginUser();
} else if (isset($_POST['deleteUser'])) {
  include_once '../config/connection.php';
  Domaci::deleteUser();
}