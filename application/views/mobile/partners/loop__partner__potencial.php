<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 18.02.2017
 * Time: 18:51
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
                <?php if (isset( $company ) && is_object( $company ) ):?>
                    <a href="/company/id<?php echo $company->id;?>" class="my-partners__company-name is-grey-link">
                        <span><?php echo $company->short_name;?></span>
                    </a>
                <?php elseif( isset( $company ) && $company == false ):?>
                    <a class="my-partners__company-name">
                        <span>Физическое лицо</span>
                    </a>
                <?php endif;?>
            </div>
            <div class="my-partners__status"><?php echo $status;?></div>
            <?php if ($rating):?>
                <div class="company-profile__rating-level rate__lvl rate__lvl--<?php echo intval( $rating );?>"></div>
            <?php endif;?>


            <?php if( $id != $this->session->user ):?>
                <div class="partner-status partner-status__list">
                    <div class="partner-status__lbar">

                        <div class="choosen-partner add-partner">
                            <a href="#" class="js-partner__send_request is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                                <i class="fa fa-plus i-left-15"></i>
                                <span>Добавить</span>
                            </a>
                        </div>

                    </div>
                    <div class="partner-status__rbar">

                        <div class="choosen-partner del-partner is-hidden">
                            <a href="#" class="js-partner__cancel_request is-or-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                                <i class="fa fa-times i-left-15"></i>
                                <span>Отменить</span>
                            </a>
                        </div>

                    </div>


                </div>

            <?php endif;?>


        </div>
    </div>


</div>
