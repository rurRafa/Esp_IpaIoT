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
    <form action="config.php">
      <div class="input-box">
        <input type="text" name="username"  autocomplete="off" required>
        <label for="">Username</label>
      </div>
      <div class="input-box">
        <input type="email" name="email"  autocomplete="off" required>
        <label for="">Email</label>
      </div>
      <div class="input-box">
        <input type="password" name="password"  autocomplete="off" required>
        <label for="">Password</label>
      </div>
        <input type="submit" value="Save">
    </form>
  </div>
  
</body>
</html>
