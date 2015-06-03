$( document ).ready(function() {
    /**
    /* Display Facebook albums
    **/

    // At beginning albums are hidden
    $("#userFacebookAlbums").hide();

    $("#uploadActionNav").click(function(){
        $("#userFacebookAlbums").fadeIn(400);
    });

    $("#hideAlbumsAction").click(function(){
        $("#userFacebookAlbums").fadeOut(400);
    });
});