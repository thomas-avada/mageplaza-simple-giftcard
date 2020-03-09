define([
    'jquery',
    'ko'
], function ($, ko) {
    var postsData = ko.observableArray([
        {id: 1, title: 'Lorem ipsum lora the tun jus'},
        {id: 2, title: 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo'},
        {id: 3, title: 'Duis aute irure dolor in reprehenderit in voluptate velit esse'},
        {id: 4, title: 'Cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non'}
    ]);
    return {
        posts: postsData
    }
});