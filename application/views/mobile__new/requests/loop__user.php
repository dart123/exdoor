<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.04.2018
 * Time: 18:46
 */


if( $requests && is_array($requests)) {
    $pre_requests   = array_slice( $requests, 0, 5);
    $post_requests  = array_slice( $requests, 5);
} else {
    $pre_requests   = false;
    $post_requests  = false;
}

?>

<div class="requests__col is-rounded is-box-shadow requests__col__user_<?php echo $id;?>" <?php if(
                                                                                            $id != $this->session->user
                                                                                            &&
                                                                                            $page_content["filter_saved"]
                                                                                            &&
                                                                                            property_exists($page_content["filter_saved"],'employers__to_show')
                                                                                            &&
                                                                                            (
                                                                                                (
                                                                                                    is_array($page_content["filter_saved"]->employers__to_show)
                                                                                                    &&
                                                                                                    !in_array($id, $page_content["filter_saved"]->employers__to_show)
                                                                                                )
                                                                                                ||
                                                                                                $page_content["filter_saved"]->employers__to_show == NULL

                                                                                            )

                                                                                            ):?>style="display: none" <?php endif;?>  <?php if( isset($ex_employer) && $ex_employer):?>style="opacity: 0.5"<?php endif;?>>
    <!-- От кого заявки -->
    <div class="my-partners__row write-msg">
        <div class="my-partners__lcell">

            <?php if( $avatar ):?>
                <a href="/partners/<?php echo $id;?>" class="my-partners__image  my-partners__image--image_exists my-partners__image__requests_list my-partners__image-sm is-rounded">
                    <img src="/uploads/users/<?php echo $id;?>/avatar/80x80_<?php echo $avatar;?>" class="img-responsive">
                </a>
            <?php else:?>

                <a href="/partners/<?php echo $id;?>" class="my-partners__image my-partners__image__requests_list my-partners__image-sm is-rounded">

                </a>

            <?php endif;?>


            <div class="my-partners__content-sm">
                <a href="/partners/<?php echo $id;?>" class="my-partners__name is-blue-link"><b><span><?php echo $name;?> <?php echo $second_name;?> <?php echo $last_name;?></span></b></a>

                <div class="requests__list__employers_block__rating_and_counts">
                    <?php if ($rating):?>
                        <div class="my-partners__rating-level rate__lvl rate__lvl--<?php echo intval( $rating);?>"></div> <span class="is-grey-text">/</span>
                    <?php endif;?>

                    <?php if( $requests ):?>
                        <div class="my-partners__requests_found is-grey-text">Найдено заявок: <span id="js__user-<?php echo $id;?>__requests_found"><?php echo count($requests);?></span></div>
                    <?php else:?>
                        <div class="my-partners__request is-grey-text">Заявки отсутствуют</span></div>
                    <?php endif;?>
                </div>


                <?php if( $post_requests ):?>
                    <a href="" class="requests__slide-list-down js__requests_list__show_all_header js__show_all_requests_<?php echo $id;?>" data-user-id="<?php echo $id;?>">
                        <div class="is-blue-link">
                            <i class="fa fa-long-arrow-down"></i>
                            <span>Показать все</span>
                        </div>
                    </a>
                    <a href="" class="requests__slide-list-up slide-hidden js__requests_list__hide_all_header js__hide_all_requests_<?php echo $id;?>" data-user-id="<?php echo $id;?>">
                        <div class="is-blue-link">
                            <i class="fa fa-long-arrow-up"></i>
                            <span>Свернуть список</span>
                        </div>
                    </a>
                <?php endif;?>


            </div>
        </div>
        <?php if( $id != $this->session->user):?>
            <div class="my-partners__rcell">
                <div>
                    <a href="#" class="js-partner__open_chat  is-blue-link pointer" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                        <i class="fa fa-envelope i-left-15"></i>
                        <span class="m-hide">Написать сообщение</span>
                    </a>
                </div>
            </div>
        <?php endif;?>
    </div>
    <!-- Список заявок от этого человека -->

    <div class="section-user-request__block ajax__requests_container ajax__requests_container__user_<?php echo $id;?> ajax__request_list__<?php echo $id;?>__<?php echo $page_content['sub_menu']['selected'];?>">
        <?php
        if($pre_requests):
            foreach ( $pre_requests as $key => $req ):
                $this->load->view('mobile/requests/loop__block', $req);
            endforeach;
        endif;
        ?>

        <div class="request__wrapper ajax__requests_container ajax__requests_container__user_<?php echo $id;?>_hidden is-hidden" >
            <?php if( $post_requests ):
                foreach ( $post_requests as $key => $req ):
                    $this->load->view('mobile/requests/loop__block', $req);
                endforeach;
            endif; ?>
        </div>
        <a href="" class="ajax__requests_container_<?php echo $id;?>_user__show-more requests__open requests__slide-list is-blue-link js-more-history is-last-item <?php if( !$post_requests ):?>is-hidden<?php endif;?>"  data-user-id="<?php echo $id;?>" >
            <span>Показать еще</span>
        </a>

        <div class="new-req-items new-req-items__<?php echo $id;?>" style="display: none"></div>

    </div>
    <!-- -->
</div>
