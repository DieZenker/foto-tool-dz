
    $( document ).ready(function() {
    $('.create-album-btn').click(function (e) {
    e.preventDefault();
    showCreateAlbum();
    return false;
});
});

    function showCreateAlbum(){
    var iconOffset = $('.create-album-btn').offset();

    var topNavHeight = $('.main-header').outerHeight(true);

    var $createAlbumWrapper = $('#create-album-wrapper');
    $createAlbumWrapper.css('top', iconOffset['top'] + topNavHeight);
    $createAlbumWrapper.css('left', iconOffset['left']);

    $('#create-album-wrapper').toggle();
}
