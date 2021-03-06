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
                    console.log( suggestion );
                    if( suggestion.type == 'company' ) {

                        if( suggestion.logo )
                            output += '<div class="suggestion--avarat-container"> <img src="/uploads/companies/'+ suggestion.data.id +'/logo/80x80_' + suggestion.logo + '" class="suggestion--avarat-container--image" > </div>';
                        else
                            output += '<div class="suggestion--avarat-container"><i class="fa fa-users"></i></div>';

                        output += '<span class="search search--news--date">' + suggestion.value + '</span><br>';

                        if( suggestion.data.rating ) {
                            output += '<span class="company-profile__rating-level rate__lvl rate__lvl--'+ parseInt( suggestion.data.rating ) +'"></span>';
                        }

                        output += '<span class="search search--news--date">??. ' + suggestion.city + '</span> <br>';



                        output += suggestion.description;

                        return ( output );
                    }
                    else if( suggestion.type == 'user' ) {

                        if( suggestion.avatar )
                            output += '<div class="suggestion--avarat-container"> <img src="/uploads/users/'+ suggestion.data.id +'/avatar/180x180_' + suggestion.avatar + '" class="suggestion--avarat-container--image" > </div>';
                        else
                            output += '<div class="suggestion--avarat-container"><i class="fa fa-user"></i></div>';

                        output += '<span class="search search--news--date">' + suggestion.value + '</span><br>';

                        if( suggestion.rating ) {
                            output += '<span class="company-profile__rating-level rate__lvl rate__lvl--'+ suggestion.rating +'"></span>';
                        }

                        output += '<span class="search search--news--date">??. ' + suggestion.city + '</span> <br>';

                        if( suggestion.company ) {
                            output += '<span class="search search--news--date">????????????????: ' + suggestion.company.short_name + '</span>';

                        }



                        return (output);
                    }

                    else if( suggestion.type == 'delimiter' )
                        return ('<span class="search search--delimiter">' + suggestion.name + '</span>');
                    else if( suggestion.type == 'show_all' )
                        return ('<span class="search search--show-all"><span>???????????????? ?????? ????????????????????</span></span>');
                    else if( suggestion.type == 'not_found' )
                        return ('<span class="search search--not-found">???????????????????? ???? ??????????????</span>');

                }
        });
    })
</script>

