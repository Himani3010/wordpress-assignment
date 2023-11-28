;(function($) {
    'use strict';
    let loaderHtml = '';
    var CODE_CHALLENGE ={
        initialize: function() {
            self = this;
            console.log(rcc);
            loaderHtml = '<img src="'+rcc.loaderUrl+'" />';
            $('#book-list-filters').on( 'submit', this.book.reload );
        },
        book: {
            reload: function(e) {
                e.preventDefault();
                $('tbody').html(loaderHtml);
                console.log($(this).serialize());
                $.ajax({
                    'type'  :   'GET',
                    'url'   :   rcc.ajaxUrl,
                    data    :   $(this).serialize(),
                    success : function(res) {   
                        if( res.success ) {
                            console.log(res.data);
                            $('tbody').html(res.data);
                        }
                    }
                });
            }
        }
    }
    $(function() {
        CODE_CHALLENGE.initialize();
    });
})(jQuery);