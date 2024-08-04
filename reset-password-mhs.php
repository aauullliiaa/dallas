<?php
require 'src/db/functions.php';

$message = '';
$alert_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nim = htmlspecialchars($_POST['nim']);
  $password1 = $_POST['password1'];
  $password2 = $_POST['password2'];

  list($message, $alert_type) = resetPasswordMahasiswa($db, $nim, $password1, $password2);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!-- CSS -->
  <link rel="stylesheet" href="src/css/style.css" />
  <!-- Favicon -->
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
</head>

<body class="password d-flex align-items-center justify-content-center">
  <div class="container" style="max-width: 600px">
    <div class="card p-3">
      <div class="card-body">
        <div class="row text-center mb-3">
          <h2>Reset Password</h2>
        </div>
        <?php if ($message): ?>
          <div class="alert alert-<?php echo $alert_type; ?>" role="alert">
            <?php echo $message; ?>
          </div>
        <?php endif; ?>
        <form action="" method="post">
          <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="text" name="nim" id="nim" class="form-control" required maxlength="18" />
          </div>
          <div class="mb-3">
            <label for="password1" class="form-label">Password Baru</label>
            <input type="password" name="password1" id="password1" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="password2" class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="password2" id="password2" class="form-control" required />
          </div>
          <div class="mt-2">
            <div class="col submit-button text-center">
              <button type="submit" class="btn btn-light">
                Reset Password
              </button>
            </div>
          </div>
        </form>
        <div class="mt-2">
          <div class="col submit-button text-center">
            <a href="login-mahasiswa.php"><button class="btn btn-light">Kembali</button></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>