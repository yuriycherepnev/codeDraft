<section id="users_list">
<?php
if ($_SESSION['email'] !== NULL) {
  $id = $_SESSION['id'] - 1;
  $avatar = base64_encode($account[$id-1]['avatar']);
?>
  <div class="users flex-row">
    <div class="users_img">
      <a href="/Page/Account/<?echo $account[$id-1]['name'];?>"><img src='data:image/jpeg;base64,<?php echo $avatar ?>' alt="user photo"></a>
    </div>
    <div class="user_info">
        <a href="/Page/Account/<?echo $account[$id-1]['id'];?>"><p><?echo $account[$id-1]['name'], ' ', $account[$id-1]['second_name'];?></p></a>
    <span>About Me lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum</span>
    </div>
  </div>
    <div class="line"></div>
<?php
  unset($account[$id-1]);
}
if ($account !== []) {
  foreach ($account as $user) {
    $avatar = base64_encode($user['avatar']);
?>
  <div class="users flex-row">
    <div class="users_img">
      <a href="/Page/Account/<?echo $user['id'];?>"><img src='data:image/jpeg;base64,<?php echo $avatar ?>' alt="user photo"></a>
    </div>
    <div class="user_info">
      <a href="/Page/Account/<?echo $user['id'];?>"><p><?echo $user['name'], ' ', $user['second_name'];?></p></a>
      <span>About Me lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum</span>
    </div>
  </div>
<?php
  }
} ?>
</section>
</main>
<script type="text/javascript" src="/assets/js/myPage.js"></script>
</body>
</html>

