<?php require_once 'include/header.php'; ?>
<?php require_once '../Bootstrap.php' ?>

<body>
<?php require_once 'include/nav.php'; ?>

<?php if(!empty($_SESSION)): ?>

<h1>Récupérez votre photo</h1>

<!-- Facebook Albums -->
<div id="userFacebookAlbums">
    <div id="add-picture-from-facebook" class="wrapperAlbums">
        <a href="#wrapper-modal-window">
            <img src="public/img/envoyer-ma-photo.png" alt="Envoyer ma photo">
        </a>
    </div>
    <div class="wrapperAlbums"><img src="public/img/chat1.jpg"><span class="albumFacebookTitle">Nom album</span></div>
    <div class="wrapperAlbums"><img src="public/img/chat2.jpg"><span class="albumFacebookTitle">Nom album</span></div>
    <div class="wrapperAlbums"><img src="public/img/chat3.jpg"><span class="albumFacebookTitle">Nom album</span></div>
</div>

<!-- Modal window -->
<div id="wrapper-modal-window">
    <i id="hideAlbumsAction" class="fa fa-times fa-2"></i>
    <div id="content-modal-window">
        <span class="title">Où est mon image ?</span>
        <form action="#" type="POST">
            <label>Télécharger</label><br>
            <input type="file" name="file-input"><br>
            <label>Lien</label><br>
            <input type="text" name="link-input"><br>
            <button type="submit" class="button button-red" style="margin-top: 1%">Uploader</button>
        </form>
    </div>
</div>

<?php endif ?>

<?php require_once 'include/footer.php'; ?>

</body>
</html>
