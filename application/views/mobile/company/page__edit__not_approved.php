<?php
/**
 * Created by PhpStorm.
 * User: obvio
 * Date: 22/10/2018
 * Time: 11:54
 */
?>



<body>

<?php $this->load->view('mobile/misc/preloader');?>
    <aside class="sidebar">
        <?php
        $this->load->view('mobile/user/page__header', $page_content['menu']);
        $this->load->view('mobile/user/menu_user', $page_content['menu']);
        ?>
    </aside>
    <div class="sidebar-cover"></div>


    <header class="header">
        <div class="container">
            <!-- блоки, видимые на мобильном -->
            <div class="header__menu-bar js-menu t-hide"><i class="fa fa-bars"></i></div>
            <div class="header__page-title t-hide">
                <?php if( $page_header["search_or_link"]['type'] == 'link' ):?>
                    <a href="<?php echo $page_header["search_or_link"]['url'];?>" class="js--header__go-back   header__go-back is-white-link">
                        <i class="fa fa-caret-left"></i> <span>Назад</span>
                    </a>
                <?php else:?>
                    Моя компания
                <?php endif;?>
            </div>

            <?php $this->load->view('mobile/user/page__topbar', $page_content['menu']); ?>

        </div>
    </header>

    <style>
        .content img {
            width: 100%;
            height: auto;
        }
    </style>


    <div class="content">








        <div class="page-content-form__left">
            <div class="my-pers-profile__block is-rounded is-box-shadow">
                <b class="my-pers-profile__form--title">Информация о компании <?php echo $page_content["company"]->short_name;?></b>
                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <span class="my-company-edit-profile__title">Статус</span>
                    <span class="is-red-text"><b>На модерации<?php if( $page_content["company"]->removed == 1 ):?> (временно деактивирована)<?php endif;?></b></span>
                </label>
                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <span class="my-company-edit-profile__title">Полное наименование</span>
                    <span><?php echo $page_content["company"]->full_name; ?></span>
                </label>
                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <span class="my-company-edit-profile__title">Тип компании</span>
                    <span>
                            <?php switch ($page_content["company"]->type){
                                case 'sell':
                                    echo 'Продающая';
                                    break;
                                case 'buy':
                                    echo 'Покупающая';
                                    break;
                                case 'all':
                                    echo 'Комбинированная';
                                    break;
                                default:
                                    echo 'Не указано';
                            };?>
                        </span>
                </label>
                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <span class="my-company-edit-profile__title">Город</span>
                    <span><?php echo ( $page_content["company"]->city ) ? $page_content["company"]->city_name : '---';?></span>
                </label>

                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <span class="my-company-edit-profile__title">Бренды</span>
                    <span><?php foreach ($page_content["company"]->brands as $company_brand): echo $company_brand.'; '; endforeach;?></span>
                </label>

                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <span class="my-company-edit-profile__title">Описание</span>
                    <span><?php echo $page_content["company"]->description; ?></span>
                </label>
                <br><br>
                <b class="my-pers-profile__form--title">Контактная информация</b>
                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <span class="my-company-edit-profile__title">Телефон</span>
                    <span><?php echo $page_content["company"]->phone; ?></span>
                </label>
                <?php if( $page_content["company"]->email ):?>
                    <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                        <span class="my-company-edit-profile__title">E-mail</span>
                        <span><?php echo $page_content["company"]->email; ?></span>
                    </label>
                <?php endif;?>
                <?php if( $page_content["company"]->site ):?>
                    <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                        <span class="my-company-edit-profile__title">Сайт</span>
                        <span><?php echo $page_content["company"]->site; ?></span>
                    </label>
                <?php endif;?>
                <br><br>
                <b class="my-pers-profile__form--title">Реквизиты</b>
                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <span class="my-company-edit-profile__title">ИНН</span>
                    <span><?php echo $page_content["company"]->inn; ?></span>
                </label>
                <?php if( $page_content["company"]->kpp ):?>
                    <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                        <span class="my-company-edit-profile__title">КПП</span>
                        <span><?php echo $page_content["company"]->kpp; ?></span>
                    </label>
                <?php endif;?>
                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <span class="my-company-edit-profile__title">ОГРН</span>
                    <span><?php echo $page_content["company"]->ogrn; ?></span>
                </label>
                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <span class="my-company-edit-profile__title">БИК банка</span>
                    <span><?php echo $page_content["company"]->bank_bik; ?></span>
                </label>
                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <span class="my-company-edit-profile__title">Наименование</span>
                    <span><?php echo $page_content["company"]->bank_name; ?></span>
                </label>
                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <span class="my-company-edit-profile__title">Расчетный счет</span>
                    <span><?php echo $page_content["company"]->r_account; ?></span>
                </label>
                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <span class="my-company-edit-profile__title">Корр. счет</span>
                    <span><?php echo $page_content["company"]->k_account; ?></span>
                </label>
                <br><br>
                <b class="my-pers-profile__form--title">Сотрудники</b>
                <label class="my-company-edit-profile__line my-company-profile__line-label no-padding">
                    <?php if ($page_content["employers"]):?>
                        <?php foreach( $page_content["employers"] as $employer ):?>
                            <span class="my-company-edit-profile__title"></span>
                            <span>
                                    <a href="/partners/<?php echo $employer->id;?>" class="my-partners__name is-blue-link">
                                        <span>
                                            <b>
                                                <?php echo $employer->last_name;?> <?php echo $employer->name;?> <?php echo $employer->second_name;?>
                                            </b>
                                        </span>

                                    </a>
                                    (<?php echo $employer->company_profession;?><?php if($employer->company_role && $employer->company_role__val) : echo ', '.$employer->company_role__val; endif;?>)
                                </span>
                            <br>
                        <?php endforeach;?>
                    <?php endif;?>
                    <?php if ($page_content["candidats"]):?>
                        <?php foreach( $page_content["candidats"] as $candidat ):?>
                            <span class="my-company-edit-profile__title"></span>
                            <span>
                                    <a href="/partners/<?php echo $candidat->id;?>" class="my-partners__name is-blue-link">
                                        <span>
                                            <b>
                                                <?php echo $candidat->last_name;?> <?php echo $candidat->name;?> <?php echo $candidat->second_name;?> (Ожидает подтверждения)
                                            </b>
                                        </span>
                                    </a>
                                </span>
                            <br>
                        <?php endforeach;?>
                    <?php endif;?>
                </label>
            </div>
        </div>




    </div>

