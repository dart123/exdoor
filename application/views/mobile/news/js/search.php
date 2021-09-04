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
        $('#search_news').autocomplete({

            serviceUrl:'/ajax/search_news',
            minChars:4,
            noCache: false,
            triggerSelectOnValidInput: false,
            onSearchStart:
                function () {

                },
            onSelect:
                function(suggestion){
                    if( suggestion.type == 'suggestion' )
                        window.location.href = '/news/' + suggestion.data.id;
                    else if( suggestion.type == 'show_all' )
                        window.location.href = suggestion.url;
                    else if ( suggestion.type == 'not_found' ) {
                        $('#search_news').val("").focus();
                    }
                },
            formatResult:
                function(suggestion, currentValue){
                    console.log( suggestion );

                    var output = '';
                    if( suggestion.type == 'suggestion') {

                        if( suggestion.avatar )
                            output += '<div class="suggestion--avarat-container"> <img src="/uploads/users/'+ suggestion.author_id +'/avatar/80x80_' + suggestion.avatar + '" class="suggestion--avarat-container--image" > </div>';
                        else
                            output += '<div class="suggestion--avarat-container"><i class="fa fa-user"></i></div>';

                        output += '<span class="search search--news--date">' + suggestion.date + '</span> ' + '<span class="search search--news--date">' + suggestion.data.author_name + '</span> <span style="display:block">' + suggestion.value + '...</span>';

                        return (output);
                    }
                    else if( suggestion.type == 'show_all' )
                        return ('<span class="search search--show-all"><span>Показать все результаты</span></span>');
                    else if( suggestion.type == 'not_found')
                        return ('<span class="search search--not-found">Совпадений не найдено</span>');


                },

        });
    })
</script>


