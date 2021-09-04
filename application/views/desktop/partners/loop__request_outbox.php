<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 18.02.2017
 * Time: 13:38
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
            <a href="/partners/<?php echo $id;?>" class="my-partners__name is-blue-link"><span><b><?php echo $name;?> <?php echo $last_name;?></b></span></a>
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
            <div class="my-partners__status">
                <?php echo $status;?>
            </div>
            <?php if ($message):?>
                <div class="my-partners__inbox-msg outbox-msg__text">
                    <div class="my-partners__inbox-msg--before">Вы написали: </div>
                    <p><?php echo $message;?></p>
                    <?php /*
                    <div class="outbox-msg__full">
                        <p>Капитальное строительство, реконструкция, фасадные работы, производство строительных материалов и фасадного покрытия стали основными направлениями нашей деятельности.</p>
                        <p>Капитальное строительство, реконструкция, фасадные работы, производство строительных материалов и фасадного покрытия стали основными направлениями нашей деятельности.</p>
                        <ul>
                            <li>Пункт списка 1</li>
                            <li>Полезная информация 2</li>
                            <li>Очень важный текст в списке под номером 3</li>
                        </ul>
                    </div>
                    <a href="" class="outbox-msg__open is-blue-link"><span>Подробнее</span></a>
                    */
                    ?>
                </div>
            <?php endif;?>
        </div>
    </div>

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
</div>
