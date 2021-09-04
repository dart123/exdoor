<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27.10.2017
 * Time: 20:30
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
        </div>
    </div>

    <div class="my-partners__rcell">
        <div>
            <a href="/company/id<?php echo $data->id;?>" class="is-blue-link">
                <i class="fa fa-home i-left-15"></i>
                <span>Страница компании</span>
            </a>
        </div>

        <div>
            <a class="partners-add-all is-blue-link pointer js--company--add-all-partners" data-company-id="<?php echo $data->id;?>">
                <i class="fas fa-plus i-left-15"></i>
                <span>Всех в партнеры</span>
            </a>
        </div>

    </div>
</div>

<?php if( $company_employers ):?>
<div class="my-partners__wrapper">

    <div class="wrapper-top"></div>
    <div class="wrapper-btm"></div>
    <!--
    <a href="" class="my-partners__slide-list-down">
        <div class="is-blue-link">
            <i class="fa fa-long-arrow-down"></i>
            <span>Развернуть список</span>
        </div>
    </a>
    <a href="" class="my-partners__slide-list-up slide-hidden">
        <div class="is-blue-link">
            <i class="fa fa-long-arrow-up"></i>
            <span>Свернуть список</span>
        </div>
    </a>
    -->

    <div class="my-partners__slide-content scrollbar-inner">
        <?php foreach( $company_employers as $employer ):
            $this->load->view('desktop/partners/loop__partner__potencial', $employer);
        endforeach;?>
    </div>
</div>
<?php endif;?>
