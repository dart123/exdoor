<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27.10.2017
 * Time: 14:12
 */
?>

<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.09.17
 * Time: 17:12
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
