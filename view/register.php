<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>code-draft.com</title>
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image">
    <link rel="stylesheet" href="../assets/css/form.css">
</head>
<body>
<!-- Форма регистрации -->
<main class="flex-row space-center">
    <section class="flex-column space-center align-items-center">
        <nav class="nav"><a href="/Main/Page">Main</a></nav>
<form name="register" id="form" method="post" enctype="multipart/form-data">
    <div class="input">
      <input type="text" class="field" id="name" name="name" placeholder="Name">
    </div>
    <div class="input">
      <input type="text" class="field" id="surname" name="surname" placeholder="Surname">
    </div>
    <div class="input">
      <input type="text" class="field" id="email" name="email" placeholder="Email">
    </div>
    <div class="input">
      <input type="file" class="field" id="imgInput" name="img">
    </div>
    <label id="labelImg" for="imgInput">Avatar</label>
    <div class="input">
      <input type="password" class="field" id="pass" name="password" placeholder="Password">
    </div>
    <div class="input">
      <input type="password" class="field" id="confirm_password" name="confirm_password" placeholder="Confirm password">
    </div>
    <div class="input">
      <button id="button">Registration</button>
    </div>
    <p><span id="span_response">Already have an account?</span> - <a href="/Main/auth">authorization</a>!</p>
    <div id="response"></div>
</form>
</section>
</main>
<script type="text/javascript" src="/assets/js/register.js"></script>
</body>
</html>
