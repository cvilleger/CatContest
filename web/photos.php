<?php require_once 'include/header.php';
      require_once '../Bootstrap.php' ?>

<body>
<?php require_once 'include/nav.php'; ?>

<?php if(!empty($_SESSION)): ?>
<h1>Récupérez votre photo</h1>

<!-- Facebook Albums -->
<div id="userFacebookAlbums">
    <?php
        $FacebookAuthService = new FacebookAuthService();
    ?>
</div>

<?php else : ?>
    <?php header("location: /login.php" ); ?>
<?php endif; ?>

<?php require_once 'include/footer.php'; ?>

</body>
</html>
