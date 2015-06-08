$( document ).ready(function() {
    /**
    /* Display Facebook albums
    **/

    // Hide or show Facebook albums
    $("#userFacebookAlbums").hide();

    $("#uploadActionNav").click(function(){
        $("#userFacebookAlbums").fadeIn(400);
        $("#wrapper-my-picture").hide();
    });

    $("#hideAlbumsAction").click(function(){
        $("#userFacebookAlbums").fadeOut(400);
        $("#wrapper-modal-window").fadeOut(400);
    });

    /**
     * Modal window
     */

    $("#add-picture-from-facebook").click(function(){
        $("#wrapper-modal-window").fadeIn(400);
    });

    /**
     * My picture
     */

    $("#uploadActionNav1").click(function(){
        $("#wrapper-my-picture").fadeIn(400);
        $("#userFacebookAlbums").hide();
        $("#wrapper-modal-window").hide();
    });
});