<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 2019-01-30
 * Time: 18:40
 */
?>



<div class="my-partners__row">
    <div class="my-partners__lcell">
        <?php if( $data->logo ):?>
            <a href="/company/id<?php echo $data->id;?>" class="my-partners__image is-rounded">
                <img src="/uploads/companies/<?php echo $data->id;?>/logo/80x80_<?php echo $data->logo;?>" alt="">
            </a>
        <?php else:?>
            <a href="/company/id<?php echo $data->id;?>" class="my-partners__image is-rounded">

            </a>
        <?php endif;?>
        <div class="my-partners__content">
            <a href="/company/id<?php echo $data->id;?>" class="my-partners__name is-blue-text"><b><?php echo $value;?></b> <?php echo $city;?></a>
            <div>
                <span class="is-grey-text">
                    <span>сотрудников в компании: <?php echo $company_employers_count;?></span>
                </span>
            </div>

            <?php if( $data->rating ):?>
            <div class="company-profile__rating-level rate__lvl rate__lvl--<?php echo intval($data->rating);?>"></div>
            <?php endif;?>

            <div class="partner-status partner-status__list">
                <div class="partner-status__lbar">

                    <a href="/company/id<?php echo $data->id;?>" class="is-blue-link">
                        <i class="fa fa-home i-left-15"></i>
                        <span>Профиль</span>
                    </a>

                </div>
                <div class="partner-status__rbar">

                    <a class="partners-add-all is-blue-link pointer js--company--add-all-partners" data-company-id="<?php echo $data->id;?>">
                        <i class="fa fa-plus i-left-15"></i>
                        <span>Всех в партнеры</span>
                    </a>

                </div>


            </div>
        </div>
    </div>
