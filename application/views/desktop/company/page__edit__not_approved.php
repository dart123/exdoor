<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 15.10.16
 * Time: 15:28
 */

?>

<main>
    <div class="container">
        <div class="main-features">
            <?php
                $this->load->view('desktop/user/menu_user', $menu);
            ?>
        </div>
        <section class="additional-features">
            <?php $this->load->view('desktop/user/template__right-sidebar-ads');?>
        </section>
        <section class="page-content-form left-200">
            <div class="page-content-form__left">
                <div class="my-pers-profile__block is-rounded is-box-shadow">
                    <b class="my-pers-profile__form--title">Информация о компании <?php echo $company->short_name;?></b>
                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <span class="my-company-edit-profile__title">Статус</span>
                        <span class="is-red-text"><b>На модерации<?php if( $company->removed == 1 ):?> (временно деактивирована)<?php endif;?></b></span>
                    </label>
                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <span class="my-company-edit-profile__title">Полное наименование</span>
                        <span><?php echo $company->full_name; ?></span>
                    </label>
                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <span class="my-company-edit-profile__title">Тип компании</span>
                        <span>
                            <?php switch ($company->type){
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
                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <span class="my-company-edit-profile__title">Город</span>
                        <span><?php echo ( $company->city ) ? $company->city_name : '---';?></span>
                    </label>

                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <span class="my-company-edit-profile__title">Бренды</span>
                        <span><?php foreach ($company->brands as $company_brand): echo $company_brand.'; '; endforeach;?></span>
                    </label>

                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <span class="my-company-edit-profile__title">Описание</span>
                        <span><?php echo $company->description; ?></span>
                    </label>
                    <br><br>
                    <b class="my-pers-profile__form--title">Контактная информация</b>
                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <span class="my-company-edit-profile__title">Телефон</span>
                        <span><?php echo $company->phone; ?></span>
                    </label>
                    <?php if( $company->email ):?>
                        <label class="my-company-edit-profile__line my-company-profile__line-label">
                            <span class="my-company-edit-profile__title">E-mail</span>
                            <span><?php echo $company->email; ?></span>
                        </label>
                    <?php endif;?>
                    <?php if( $company->site ):?>
                        <label class="my-company-edit-profile__line my-company-profile__line-label">
                            <span class="my-company-edit-profile__title">Сайт</span>
                            <span><?php echo $company->site; ?></span>
                        </label>
                    <?php endif;?>
                    <br><br>
                    <b class="my-pers-profile__form--title">Реквизиты</b>
                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <span class="my-company-edit-profile__title">ИНН</span>
                        <span><?php echo $company->inn; ?></span>
                    </label>
                    <?php if( $company->kpp ):?>
                        <label class="my-company-edit-profile__line my-company-profile__line-label">
                            <span class="my-company-edit-profile__title">КПП</span>
                            <span><?php echo $company->kpp; ?></span>
                        </label>
                    <?php endif;?>
                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <span class="my-company-edit-profile__title">ОГРН</span>
                        <span><?php echo $company->ogrn; ?></span>
                    </label>
                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <span class="my-company-edit-profile__title">БИК банка</span>
                        <span><?php echo $company->bank_bik; ?></span>
                    </label>
                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <span class="my-company-edit-profile__title">Наименование банка</span>
                        <span><?php echo $company->bank_name; ?></span>
                    </label>
                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <span class="my-company-edit-profile__title">Расчетный счет</span>
                        <span><?php echo $company->r_account; ?></span>
                    </label>
                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <span class="my-company-edit-profile__title">Корр. счет</span>
                        <span><?php echo $company->k_account; ?></span>
                    </label>
                    <br><br>
                    <b class="my-pers-profile__form--title">Сотрудники</b>
                    <label class="my-company-edit-profile__line my-company-profile__line-label">
                        <?php if ($employers):?>
                            <?php foreach( $employers as $employer ):?>
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
                        <?php if ($candidats):?>
                            <?php foreach( $candidats as $candidat ):?>
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
        </section>
    </div>
</main>