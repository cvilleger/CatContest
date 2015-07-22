<?php require_once 'include/header.php';
      require_once '../Bootstrap.php' ?>

<body>
<?php require_once 'include/nav.php'; ?>

<?php if(!empty($_SESSION)): ?>
<h1>Choisissez votre album photo</h1>

<!-- Facebook Albums -->
<div id="userFacebookAlbums">
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
<?php else : ?>
    <?php header("location: /login.php" ); ?>
<?php endif; ?>

<?php require_once 'include/footer.php'; ?>

</body>
</html>
