<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 25.09.17
 * Time: 9:51
 */
?>

<script>
    $(document).ready( function () {
        $('#search_offers').autocomplete({

            serviceUrl:'/ajax/search_offers',
            minChars:4,
            noCache: false,
            triggerSelectOnValidInput: false,
            onSearchStart:
                function () {

                },
            onSelect:
                function(suggestion){

                    if ( suggestion.type == 'suggestion' ) {
                        window.location.href = '/offers/' + suggestion.data.type +'/' + suggestion.data.id;
                    }
                    else if ( suggestion.type == 'not_found' )
                        $('#search_offers').val("").focus();

                },
            formatResult:
                function(suggestion, currentValue){

                    var output = '';

                    if( suggestion.type == 'suggestion') {
                        console.log( suggestion );
                        if( suggestion.offer_img )
                            output += '<div class="suggestion--avarat-container"> <img src="/uploads/offers/'+ suggestion.offer_id +'/small_' + suggestion.offer_img + '" class="suggestion--avarat-container--image" > </div>';
                        else
                            output += '<div class="suggestion--avarat-container"><i class="fa fa-picture-o"></i></div>';

                        output += '<span class="search search--news--date">' + suggestion.data.date + '</span> ' + '<span class="search search--news--date">' + suggestion.offer_type + '</span> ' + '<span class="search search--news--date">' + suggestion.data.category_text + '</span> ' + suggestion.data.title + '<br>';
                        output += suggestion.description;

                        return ( output );
                    }

                    else if( suggestion.type == 'show_all' )
                        return ('<span class="search search--show-all"><span>Показать все результаты</span></span>');
                    else if( suggestion.type == 'not_found')
                        return ('<span class="search search--not-found">Совпадений не найдено</span>');
                }
        });
    })
</script>
