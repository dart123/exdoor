<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.09.16
 * Time: 21:15
 */
?>

<?php if($partners):

    ?>
    <div class="main-partners">
        <h2 class="section-title">
            <?php if( $view_mode == 'owner'):?>
            Мои партнеры
            <?php else:?>
            Партнеры
            <?php endif;?>
            <span class="section-title__sub">(<?php echo $count_user_partners;?>)</span>
        </h2>
        <div class="main-partners__block is-rounded">
            <ul class="main-partners__list partners-list">
                <?php foreach ($partners as $partner):?>

                    <li class="partners-list__item partner-info">
                        <a href="/partners/<?php echo $partner->id;?>" class="partner-info__link">
                            <div class="partner-info__photo  is-rounded">
                                <?php if($partner->avatar):?>
                                    <img src="/uploads/users/<?php echo $partner->id;?>/avatar/80x80_<?php echo $partner->avatar;?>" alt="">
                                <?php else:?>
                                    <div class="my-partners__image is-rounded my-partners__image__75"></div>
                                <?php endif;?>
                            </div>

                            <div class="partner-info__name is-fade" style="white-space: nowrap;" title="">
                                <?php if($partner->name):
                                    echo $partner->name;
                                elseif($partner->last_name) :
                                    echo $partner->last_name;
                                else:?>
                                    Без имени
                                <?php endif;?>
                            </div>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
<?php else:?>
    <div class="main-partners">
        <h2 class="section-title">Мои партнеры<span class="section-title__sub">(0)</span></h2>
        <div class="main-partners__block is-rounded">
            <a href="/partners/find" class="main-partners__find is-blue-link">
                <i class="fa fa-users"></i>
                <span>Найти партнёров</span>
            </a>
        </div>
    </div>
<?php endif;?>
