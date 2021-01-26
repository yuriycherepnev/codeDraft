<?php
$show_img = base64_encode($account['avatar']);
?>
<section id="user" class="user flex-row space-evenly" data-id="<?php echo $account['id']; ?>">
    <article class="myPage">
        <h2 class="h2">My Page</h2>
        <p class="p"><?php echo $account['name']; ?> <?php echo $account['second_name']; ?></p>
        <div>
            <img src='data:image/jpeg;base64,<?php echo $show_img ?>' alt="my photo">
        </div>
        <?php
        if ($account['access'] == 'owner') { ?>
            <div id="edit">
                <form class="edit" method="post">
                    <button class="" name="" value="">edit</button>
                </form>
            </div>
        <?php } ?>
    </article>
<?php
if ($account['access'] == 'owner') { ?>
    <article id="form">
        <h2 class="h2">Upload image</h2>
        <form id="addImg" method="post" enctype="multipart/form-data">
            <input id="selectImgInput" type="file" name="img_upload">
            <label id="selectImgLabel" for="selectImgInput">select a picture...</label>
            <input id="upload" type="submit" name="upload" value="upload">
        </form>
        <div id="message"></div>
    </article>
<?php } ?>
</section>
<div class="line"></div>
<!-- Поле для вывода изображений из БД -->
<section class="images">
<?php
if ($images !== []) {
    foreach ($images as $image) {
        $show_img = base64_encode($image['image']);
        ?>
        <div class="img"><img src='data:image/jpeg;base64,<?php echo $show_img ?>' alt="">
            <div class="flex-row flex-end">
                <a href="/Page/downloadImg/<?php echo $image['id'] ?>">download</a>
        <?php
        if ($account['access'] == 'owner') { ?>
            <form class="delete" method="post">
                <button class="deleteButton" name="delete" value="<?php echo $image['id'] ?>">delete</button>
            </form>
        <?php } ?>
            </div>
        </div>
<?php } } else {
        if ($account['access'] == 'owner') { ?>
            <div class="message"><p>There are no pictures in your library. You can add them by uploading pictures.</p></div>
            <div class="img"><img src=/assets/img/emptyImage.jpg alt=""></div>
            <?php
        } else { ?>
            <div class="message"><p>The user has no pictures in the library yet.</p></div>
            <div class="img"><img src=/assets/img/emptyImage.jpg alt=""></div>

<?php
        }
    }

?>
</section>
<script type="text/javascript" src="/assets/js/myPage.js"></script>
</main>
</body>
</html>