<?php require_once 'include/header.php';
      require_once '../Bootstrap.php' ?>

<body>
<?php require_once 'include/nav.php'; ?>

<?php if(!empty($_SESSION)): ?>
<h1>Choisissez votre album photo</h1>

<!-- Facebook Albums -->
<div id="userFacebookAlbums">
    <div id="add-picture-from-facebook" class="wrapperAlbums">
        <a href="#wrapper-modal-window">
            <img src="public/img/envoyer-ma-photo.png" alt="Envoyer ma photo">
        </a>
    </div>
    <?php
        $FacebookAuthService = new FacebookAuthService();
        $facebookAlbums = $FacebookAuthService->getFacebookAlbums();
        foreach($facebookAlbums as $facebookAlbum){
            if(isset($facebookAlbum->cover_photo)){
                $facebookAlbumPicture = $FacebookAuthService->getFacebookAlbumPicture($facebookAlbum->cover_photo)['images'];
                $facebookPicture = $facebookAlbumPicture[2];
                echo "<a href='/photos.php?id=" . $facebookAlbum->id . "'>" ;
                echo "<div class='wrapperAlbums' data-fbid='" . $facebookAlbum->id ."'>
				<span class='albumFacebookTitle'>". $facebookAlbum->name ."</span>
                    <img src='". $facebookPicture->source . "'>
                  </div></a>" ;
            }
        }
    ?>
</div>
<!-- Modal window -->
<div id="wrapper-modal-window">
    <i id="hideAlbumsAction" class="fa fa-times fa-2"></i>
    <div id="content-modal-window">
        <span class="title">Lien URL de mon image : </span>
        <form action="#" method="post">
            <label>Télécharger</label><br>
            <input type="text" name="input-url"><br>
            <button type="submit" name="submit" class="button button-red" style="margin-top: 1%">Uploader</button>
        </form>
    </div>
</div>
    <?php
        if(isset($_POST['input-url'])){
            $url = $_POST['input-url'];
            $res = $FacebookAuthService->postPhotoWithMsg($url);
            $pictureId = $res['id'];
            $facebookPhoto = $FacebookAuthService->getFacebookPhoto($pictureId);
            $UserRepository = new UserRepository();
            $UserRepository->updateUserPicture($pictureId, $facebookPhoto);
            echo '<script type="application/javascript">';
            echo 'window.location.href = / ';
            echo '</script>';
        }

    ?>
<?php else : ?>
    <?php header("location: /login.php" ); ?>
<?php endif; ?>

<?php require_once 'include/footer.php'; ?>

</body>
</html>
