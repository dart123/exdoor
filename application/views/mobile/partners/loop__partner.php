<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27.05.2018
 * Time: 19:55
 */
?>

<div class="my-partners__row js__list__partner" data-partner-id="<?php echo $id;?>">
    <div class="my-partners__lcell">
        <a href="/partners/<?php echo $id;?>" class="my-partners__image is-rounded">
            <?php if($avatar):?>
                <img src="/uploads/users/<?php echo $id;?>/avatar/80x80_<?php echo $avatar;?>" alt="">
            <?php endif;?>
        </a>
        <div class="my-partners__content">
            <a href="/partners/<?php echo $id;?>" class="my-partners__name is-blue-link">
                    <span>
                        <b>
                            <?php if ($name && $last_name):
                                echo $name.' '.$last_name;
                            else:
                                echo $phone;
                            endif;?>
                        </b>
                    </span>
            </a>
            <div>
                <?php if ($company):?>
                    <a href="/company/id<?php echo $company->id;?>" class="my-partners__company-name is-grey-link">
                        <span><?php echo $company->short_name;?></span>
                    </a>
                <?php else:?>
                    <a class="my-partners__company-name">
                        <span>Физическое лицо</span>
                    </a>
                <?php endif;?>
            </div>
            <div class="my-partners__status"><?php echo $status;?></div>
            <?php if ($rating):?>
                <div class="company-profile__rating-level rate__lvl rate__lvl--<?php echo intval( $rating );?>"></div>
            <?php endif;?>


            <div class="partner-status partner-status__list">
                <div class="partner-status__lbar">

                    <a href="#" class="js-partner__open_chat is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                        <i class="fa fa-envelope i-left-15"></i>
                        <span>Написать</span>
                    </a>

                </div>
                <div class="partner-status__rbar">

                    <a href="#" class="js-partner__remove_user my-partners__del is-or-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                        <i class="fa fa-trash-o i-left-15"></i>
                        <span>Убрать</span>
                    </a>

                    <a href="#" class="js-partner__undo_remove_user my-partners__del is-blue-link is-hidden" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                        <i class="fa fa-plus i-left-15"></i>
                        <span>Вернуть</span>
                    </a>

                </div>


            </div>
        </div>

        <div class="clear"></div>

    </div>

</div>
