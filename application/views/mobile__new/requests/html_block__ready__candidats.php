<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.05.17
 * Time: 15:03
 */
?>

<!--  Заголовок 2 -->
<div class="requests-step__line" style="padding: 5px 10px">
    <div class="requests-step__title">
        Получатели заявки и статус обработки
    </div>
</div>
<!--  Получатели -->
<div class="requests-step__addressee  is-box-shadow is-mtop-20 req-addressee__list clear">
    <ul>
        <?php
        foreach ( $page_content["request_partners"] as $request_partner ):
            ?>
            <li class="req-addressee__item
            <?php switch ($request_partner->status):
                case 'send':
                    echo 'req-addressee__item--processing';
                    break;
                case 'read':
                    echo 'req-addressee__item--processing';
                    break;
                case 'answered':
                    echo 'req-addressee__item--answered';
                    break;
                case 'canceled':
                    echo 'req-addressee__item--rejected';
                    break;
            endswitch;
            ?>">
                <a href="/partners/<?php echo $request_partner->user_id;?>" class="req-addressee__link is-fade">
                    <div class="req-addressee__photo is-rounded">
                        <?php if( $request_partner->avatar ):?>
                            <img src="/uploads/users/<?php echo $request_partner->user_id;?>/avatar/80x80_<?php echo $request_partner->avatar;?>" class="img-responsive" alt="">
                        <?php else:?>
                            <img src="/assets__old/img/news-advpost-head__photo--empty.jpg" class="img-responsive">
                        <?php endif;?>
                    </div>
                    <div class="req-addressee__descr">
                        <?php
                            if( $request_partner->name ) :
                                $name   = $request_partner->name;
                            else :
                                $name   = $request_partner->phone;
                            endif;?>
                        <div class="req-addressee__name is-blue-text is-fade"><b><?php echo $name;?></b></div>
                        <?php switch ($request_partner->status):
                            case 'send':
                                echo '<div class="req-addressee__answer">отправлено</div>';
                                break;
                            case 'read':
                                echo '<div class="req-addressee__answer">обрабатывает</div>';
                                break;
                            case 'answered':
                                echo '<div class="req-addressee__answer">есть ответ</div>';
                                break;
                            case 'canceled':
                                echo '<div class="req-addressee__answer">заявка отклонена</div>';
                                break;
                        endswitch;
                        ?>
                    </div>
                </a>
            </li>
            <?php
        endforeach;
        ?>
    </ul>
</div>
<!--  Ссылка "Сравнить"
<div class="requests-step__line compare-link is-mtop-20">
    <a href="/requests/<?php echo $page_content["request_data"]->id;?>/compare" class="is-or-link"><span>Сравнить предложения</span></a>
</div>
 -->
