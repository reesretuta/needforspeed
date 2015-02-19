$(function(){
    var $publicPictureModal = $('#picture-public-modal');
    $publicPictureModal.modal('show');
    $publicPictureModal.find('.close').on('click', function() {
        $publicPictureModal.modal('hide');
    });

    if(typeof isMobile === 'undefined') {
        $publicPictureModal.find('.dismiss-ctr').on('click', function() {
            $publicPictureModal.modal('hide');
        });
    } else if(!isMobile) {
        $publicPictureModal.find('.dismiss-ctr').on('click', function() {
            $publicPictureModal.modal('hide');
        });
    }
});