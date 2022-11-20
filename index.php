<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="index.css">
  <title>Document</title>
</head>
<body>

  <div class="box">
    
    <h2>Login</h2>

    <form action="form.php">

      <div class="input-box">
        <input type="text" name="name"  autocomplete="off" required>
        <label for="">Meno</label>
      </div>

      <div class="input-box">
        <input type="text" name="surname"  autocomplete="off" required>
        <label for="">Priezvisko</label>
      </div>

      <div class="input-box">
        <input type="number" name="number"  autocomplete="off" required>
        <label for="">Tel. číslo</label>
      </div>

      <div class="input-box">
        <input type="email" name="email"  autocomplete="off" required>
        <label for="">E-mail</label>
      </div>

      <div class="input-box">
        <input type="password" name="password"  autocomplete="off" required>
        <label for="">Heslo</label>
      </div>

      <div class="input-box">
        <input type="password" name="repassword"  autocomplete="off" required>
        <label for="">Heslo znova</label>
      </div>

        <input type="submit" value="Submit Form">
    </form>
  </div>
  
</body>
</html>
