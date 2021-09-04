<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 25/10/2018
 * Time: 14:53
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
            case "employers":
                $(".js--change-content--employers-container").show();
                break;
            case "requests":
                $(".js--change-content--requests-container").show();
                break;
        }

    });
</script>

