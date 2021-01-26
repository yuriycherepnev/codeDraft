<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>code-draft.com</title>
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image">
    <link rel="stylesheet" href="../assets/css/form.css">
</head>

<body>

<main class="flex-row space-center">
<section class="flex-column space-center align-items-center">
    <nav class="nav">
        <a href="/Main/Page">Main</a>
    </nav>
<form method="post" name="auth" id="form">
  <div class="input">
    <input type="text" class="field" id="email" name="email" placeholder="Enter your email">
  </div>
  <div class="input">
    <input type="password" class="field" id="password" name="password" placeholder="Enter your password">
  </div>
  <div class="input">
    <button id="button">Enter</button>
  </div>
  <p><span id="span_response">Don't have an account?</span> - <a href="/Main/register">registration</a>!</p>
  <div id="response"></div>
</form>

</section>
</main>
<script type="text/javascript" src="/assets/js/auth.js"></script>
</body>
</html>

