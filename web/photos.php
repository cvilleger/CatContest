<?php require_once 'include/header.php';
      require_once '../Bootstrap.php' ?>

<body>
<?php require_once 'include/nav.php'; ?>

<?php if(!empty($_SESSION)): ?>
<h1>Récupérez votre photo</h1>

<!-- Facebook Albums -->
<div id="userFacebookAlbums">
    <?php
    if(!isset($_GET['id'])){
        header("location: /" );
    }

    $album_id = $_GET['id'];
    $FacebookAuthService = new FacebookAuthService();
    $facebookPhotos = $FacebookAuthService->getFacebookPhotos($album_id);

    foreach($facebookPhotos as $facebookPhoto){
        $pictureId = $facebookPhoto->id;
        $pictureLink = $facebookPhoto->picture;
        $pictureDate = new DateTime($facebookPhoto->created_time);
        echo "<div class='wrapperAlbums' data-fbid='" . $facebookPhoto->id ."'>
				<span class='albumFacebookTitle'>". $pictureDate->format('Y-m-d') ."</span>
                    <img src='". $pictureLink . "'>
                  </div>" ;
    }

    ?>
</div>

<?php else : ?>
    <?php header("location: /login.php" ); ?>
<?php endif; ?>

<?php require_once 'include/footer.php'; ?>

</body>
</html>
