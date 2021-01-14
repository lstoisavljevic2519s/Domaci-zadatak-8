<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <main class="container">
    <form action="code/Domaci.php" method="POST">
      <div class="form-group">
        <label for="">Email</label>
        <input required type="email" class="form-control" name="email">
      </div>
      <div class="form-group">
        <label for="">Tip Korisnika</label>
        <select required name="type" id="">
          <option value="admin" selected>Admin</option>
          <option value="regular">Obican Korisnik</option>
        </select>
      </div>

      <div class="form-group">
        <label for="">Sifra</label>
        <input required type="password" class="form-control" name="password">
      </div>
      <div class="form-group">
        <label for="">Potrvrda Sifre</label>
        <input required type="password" class="form-control" name="passwordConf">
      </div>
      <div class="form-group">
        <label for="">Pol</label>
        <select required name="pol" id="">
          <option value="Z">Zensko</option>
          <option value="M">Musko</option>
        </select>
      </div>
      <div class="form-group">
        <label for="">Broj Telefona</label>
        <input type="number" class="form-control" name="brTel">
      </div>
      <div class="form-group">
        <label required for="">Adresa</label>
        <input type="text" class="form-control" name="adress">
      </div>
      <input type="submit" name="register" value="register">
    </form>
  </main>
</body>
</html>