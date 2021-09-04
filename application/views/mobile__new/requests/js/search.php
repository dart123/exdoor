<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 21/10/2018
 * Time: 11:52
 */

?>


<script>
    $(document).ready( function () {
        $('#search_requests').autocomplete({

            serviceUrl:'/ajax/search_requests',
            minChars:2,
            noCache: false,
            onSearchStart:
                function () {

                },
            onSelect:
                function(suggestion){
                    if( suggestion.type == 'suggestion' )
                        window.location.href = '/requests/' + suggestion.request_id;
                    else if( suggestion.type == 'show_all' )
                        window.location.href = suggestion.url;
                    else if ( suggestion.type == 'not_found' ) {
                        $('#search_news').val("").focus();
                    }
                },
            formatResult:
                function(suggestion, currentValue){
                    console.log(suggestion);
                    if( suggestion.type == 'suggestion')
                        return ('<span class="search search--news--date">' + suggestion.date + '</span> ' + '<span class="search search--news--date">' + suggestion.request_type + '</span> ' + 'Заявка #' + suggestion.request_id + ' (' + suggestion.value + ')' );
                    else if( suggestion.type == 'not_found')
                        return ('<span class="search search--not-found">Совпадений не найдено</span>');
                },

        });
    })
</script>

