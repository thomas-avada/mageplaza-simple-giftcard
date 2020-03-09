define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
    $.widget('mageplaza.customergrid', {
        options: {
            url: ''
        },
        _create: function () {
            this.initCustomerGrid();
            this.selectCustomer();
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
                title: 'Customers',
                buttons: []
            };
            modal(options, $('#customer-grid'));
            $('#customer-grid').modal('openModal');

        },
        initCustomerGrid: function () {
            var self = this;

            $("#customer_id").click(function () {
                $.ajax({
                    method: 'POST',
                    url: self.options.url,
                    data: {form_key: window.FORM_KEY},
                    showLoader: true
                }).done(function (response) {
                    $('#customer-grid').html(response);
                    console.log(response);
                    self.initPopup();
                });
            });
        },
        /**
         * Init select customer
         */
        selectCustomer: function () {
            $('body').on('click', '#customer-grid_table tbody tr', function () {
                $("#customer_id").val($(this).find('td:nth-child(2)').text().trim());
                $(".action-close").trigger('click');
            });
        }

    });
    return $.mageplaza.customergrid;
});