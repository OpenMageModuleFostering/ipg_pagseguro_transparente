var IpagarePagSeguroDiretoOrderView = Class.create({

    initialize : function() {
        $$('h4.head-payment-method')[0].up('div').addClassName('entry-edit-head-ipagare').removeClassName('entry-edit-head');
        $$('div.entry-edit-head-ipagare')[0].down('h4').removeClassName('head-payment-method');
    }
    
});