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
        <span class="title">Où est mon image ?</span>
        <form action="#" method="post" enctype="multipart/form-data">
            <label>Télécharger</label><br>
            <input type="file" name="file-input"><br>
            <button type="submit" name="submit" class="button button-red" style="margin-top: 1%">Uploader</button>
        </form>
    </div>
</div>
    <?php
    /*
    if(isset($_FILES['file-input'])) {
        $fileInput = $_FILES['file-input'];

        $error = $fileInput['error']; //check error
        $type = $fileInput['type']; //check type
        $tmp = $fileInput['tmp_name'];
        //$imageSize = getimagesize($tmp);
        $response = $FacebookAuthService->postPhotoWithMsg(realpath($tmp));
        var_dump($response);
    }
    */

    ?>
<?php else : ?>
    <?php header("location: /login.php" ); ?>
<?php endif; ?>

<?php require_once 'include/footer.php'; ?>

</body>
</html>
