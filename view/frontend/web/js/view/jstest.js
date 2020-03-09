define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
    $.widget('mageplaza.testmodal', {

        _create: function () {
            this.initPopup();
        },
        /**
         * Init popup
         * Popup will automatic open
         */
        initPopup: function () {
            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: 'This is some Modal',
                buttons: []
            };
            this.getPosts();
            modal(options, $('#jstest'));
            $('#jstest').modal('openModal');

        },
        getPosts: function () {
            $.get('https://jsonplaceholder.typicode.com/posts?userId=1', function(data){
               data.forEach(function(post) {
                   console.log(post);
                   $('#jstest').append('<li>'+post.title+'</li>')
               });
            });
        }

    });
    return $.mageplaza.testmodal;
});