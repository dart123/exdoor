<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 24.09.17
 * Time: 18:16
 */
?>


<script>
    $(document).ready( function () {
        $('#search_partners').autocomplete({

            serviceUrl:'/ajax/search_users',
            minChars:4,
            noCache: false,
            triggerSelectOnValidInput: false,
            onSearchStart:
                function () {

                },
            onSelect:
                function(suggestion){
                    if( suggestion.type == 'company' )
                        window.location.href = '/company/id' + suggestion.data.id;
                    else if( suggestion.type == 'user' )
                        window.location.href = '/partners/' + suggestion.data.id;
                    else if( suggestion.type == 'show_all' )
                        window.location.href = suggestion.url;
                    else if( suggestion.type == 'not_found' )
                        $('#search_partners').val("").focus();
                    else if( suggestion.type == 'delimiter' ) {
                        $('#search_partners').focus();
                    }


                },
            formatResult:
                function(suggestion, currentValue){

                    var output = '';

                    if( suggestion.type == 'company' ) {

                        if( suggestion.logo )
                            output += '<div class="suggestion--avarat-container"> <img src="/uploads/companies/'+ suggestion.data.id +'/logo/80x80_' + suggestion.logo + '" class="suggestion--avarat-container--image" > </div>';
                        else
                            output += '<div class="suggestion--avarat-container"><i class="fa fa-users"></i></div>';

                        output += '<span class="search search--news--date">' + suggestion.value + '</span> ';
                        output += '<span class="search search--news--date">' + suggestion.city + '</span> <br>';
                        output += suggestion.description;

                        return ( output );
                    }
                    else if( suggestion.type == 'user' ) {

                        if( suggestion.avatar )
                            output += '<div class="suggestion--avarat-container"> <img src="/uploads/users/'+ suggestion.data.id +'/avatar/180x180_' + suggestion.avatar + '" class="suggestion--avarat-container--image" > </div>';
                        else
                            output += '<div class="suggestion--avarat-container"><i class="fa fa-user"></i></div>';

                        output += '<span class="search search--news--date">' + suggestion.value + '</span> ';
                        output += '<span class="search search--news--date">' + suggestion.city + '</span> <br>';

                        if( suggestion.status )
                            output += suggestion.status;
                        else
                            output += "&nbsp;";

                        output += '<div class="search--right-col">';
                        if( suggestion.rating ) {
                            output += '<div class="company-profile__rating-level rate__lvl rate__lvl--'+ suggestion.rating +'"></div><br>';
                        }
                        if( suggestion.company ) {
                            output += '<span class="search search--user_company">' + suggestion.company.short_name + '</span>';

                        }
                        output += '</div>';



                        return (output);
                    }

                    else if( suggestion.type == 'delimiter' )
                        return ('<span class="search search--delimiter">' + suggestion.name + '</span>');
                    else if( suggestion.type == 'show_all' )
                        return ('<span class="search search--show-all"><span>Показать все результаты</span></span>');
                    else if( suggestion.type == 'not_found' )
                        return ('<span class="search search--not-found">Совпадений не найдено</span>');

                }
        });
    })
</script>

