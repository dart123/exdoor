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
        </div>
    </div>

    <?php
    if( $id != $this->session->user ):
        $rel    = $this->Partner_model->check_relationship( $this->session->user, $id );
            if ( $rel == false ):?>
            <div class="my-partners__rcell">
                <div class="choosen-partner add-partner">
                    <a class="js-partner__send_request is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                        <i class="fas fa-plus i-left-15"></i>
                        <span>Добавить в партнеры</span>
                    </a>
                </div>
                <div class="choosen-partner del-partner is-hidden">
                    <div>
                        <span class="is-grey-text">
                            <i class="far fa-clock i-left-15"></i>
                            <span>Заявка еще не принята</span>
                        </span>
                    </div>

                    <a class="js-partner__cancel_request is-or-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                        <i class="fas fa-times i-left-15"></i>
                        <span>Отменить заявку</span>
                    </a>
                </div>
            </div>
        <?php elseif ( $rel == 'partner' ):?>
            <div class="my-partners__rcell">
                <div>
                    <a class="js-partner__open_chat is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                        <i class="fas fa-envelope i-left-15"></i>
                        <span>Написать сообщение</span>
                    </a>
                </div>

                <a class="js-partner__remove_user my-partners__del is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                    <i class="fas fa-trash-alt i-left-15"></i>
                    <span>Убрать из партнеров</span>
                </a>

                <a class="js-partner__undo_remove_user my-partners__del is-blue-link is-hidden" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                    <i class="fas fa-plus i-left-15"></i>
                    <span>Вернуть в партнеры</span>
                </a>

            </div>
        <?php elseif ( $rel == 'send_request' ):?>
            <div class="my-partners__rcell">
                <div class="choosen-partner add-partner is-hidden">
                    <a class="js-partner__send_request is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                        <i class="fas fa-plus i-left-15"></i>
                        <span>Добавить в партнеры</span>
                    </a>
                </div>
                <div class="choosen-partner del-partner">
                    <div>
                        <span class="is-grey-text">
                            <i class="far fa-clock i-left-15"></i>
                            <span>Заявка еще не принята</span>
                        </span>
                    </div>

                    <a class="js-partner__cancel_request is-or-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                        <i class="fas fa-times i-left-15"></i>
                        <span>Отменить заявку</span>
                    </a>
                </div>
            </div>

        <?php elseif ( $rel == 'get_request' ):?>
            <div class="my-partners__rcell">
                <a class="js-partner__add_user my-partners__accept is-blue-link" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                    <i class="fas fa-check i-left-15"></i>
                    <span>Принять заявку</span>
                </a>

                <a class="js-partner__cancel_request_inbox my-partners__cancel is-or-link" title="Отменить" data-user-id="<?php echo $this->session->user;?>" data-partner-id="<?php echo $id;?>">
                    <i class="fas fa-times i-left-15"></i>
                </a>
            </div>
        <?php endif;?>
    <?php endif;?>
</div>
