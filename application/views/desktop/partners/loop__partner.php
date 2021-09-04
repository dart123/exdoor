<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 18.02.2017
 * Time: 13:37
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
            </div>
        </div>

        <div class="my-partners__rcell">
            <div>
                <a class="js-partner__open_chat is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                    <i class="fas fa-envelope i-left-15"></i>
                    <span>Написать сообщение</span>
                </a>
            </div>
            <?php /*
            <div>
                <a href="index-16.html" target="_blank" class="is-blue-link">
                    <i class="fa fa-search i-left-15"></i>
                    <span>Найти его коллег</span>
                </a>
            </div> */;?>

            <a class="js-partner__remove_user my-partners__del is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                <i class="fas fa-trash-alt i-left-15"></i>
                <span>Убрать из партнеров</span>
            </a>

            <a class="js-partner__undo_remove_user my-partners__del is-blue-link is-hidden" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                <i class="fas fa-plus i-left-15"></i>
                <span>Вернуть в партнеры</span>
            </a>

        </div>
    </div>