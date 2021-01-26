<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>code-draft.com</title>
    <link rel="shortcut icon" href="/assets/img/icon.png" type="image">
    <link rel="stylesheet" type="text/css" href="/assets/css/main.css">
</head>
<body class="body">
<main class="main_page flex-row space-center">
<section class="flex-column space-center align-items-center">
  <h2>Welcome to code-draft.com</h2>
  <p>The code draft is my little project on which I practice my
      developer skills. On this site you can register, create your account,
      upload your favorite pictures, look at the pages of other users and
      download images if you like them. For all comments and suggestions,
      you can write to me by mail:
      <a href="mailto:yuriy.cherepnev@gmail.com">yuriy.cherepnev@gmail.com</a></p>
    <nav>
        <?php if (($_SESSION['email'] !== NULL)) { ?>
        <a href="/Page/Account/<?php echo $_SESSION['id'];?>">My page</a>
        <?php } else { ?>
        <a href="/Page/Users">Login without registration</a>
        <?php } ?>
        <a href="/Main/auth">Authorization</a>
        <a href="/Main/register">Registration</a>
    </nav>
</section>
</main>
</body>
</html>
