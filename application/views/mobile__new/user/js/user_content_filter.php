<?php
/**
 * Created by developer with PhpStorm.
 * Date: 08.09.2018 15:45
 *
 *
 */
?>

<script>
    $(".js--change-content").click(function(event){
        event.preventDefault();

        $(".js--change-content").removeClass("-active");
        $(".js--change-content--container ").hide();

        currentButton   = $(this);
        currentButton.addClass("-active");

        switch( currentButton.data("content") ) {
            case "news":
                $(".js--change-content--news-container").show();
                break;
            case "offers":
                $(".js--change-content--offers-container").show();
                break;
            case "requests":
                $(".js--change-content--requests-container").show();
                break;
        }

    });
</script>
