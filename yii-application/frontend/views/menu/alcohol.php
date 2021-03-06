<?php

/* @var $this yii\web\View */

use frontend\widgets\categoryList\CategoryList;
use yii\helpers\Url;
use yii\web\JqueryAsset;

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Description of the page'
]);

?>

<section class="alcohol">
    <div class="alcohol__content">

        <div class="alcohol__content-title">
            <div class="alcohol__content-title-btn">
                <a data-index="1" class="main__btn__alco <?= (Yii::$app->request->get('bar')) ? 'active' : false ?>">Барная карта</a>
                <a data-index="2" class="main__btn__alco <?= (Yii::$app->request->get('wine')) ? 'active' : false ?>">Винная карта</a>
            </div>
            <a class="back__menu" href="<?= Url::to(['menu/index']) ?>">Вернуться в меню</a>
        </div>

        <div data-index="1" class="alcohol__content__item <?= (Yii::$app->request->get('bar')) ? 'active' : false ?>">
            <aside>

                <?php foreach ($parentBarCategories as $category): ?>
                <a data-index="<?= $category->sort_order ?>" class="tab__alco__btn"><?= $category->name ?></a>
                <?php endforeach; ?>

            </aside>

            <?php foreach ($parentBarCategories as $category): ?>
            <div data-index="<?= $category->sort_order ?>" class="alcohol__content__item-main">

                <?php foreach ($childBarCategories as $child): ?>
                <?php if($category->category_alcohol_id == $child->parent_category): ?>
                <div class="table__aclo">
                    <h2><?= $child->name ?></h2>

                    <?php foreach ($child->alcohol as $alcohol): ?>
                        <div class="table__aclo__item">
                            <p><?= $alcohol->name ?></p>
                            <p><?= $alcohol->weight ?> мл.</p>
                            <p><?= $alcohol->price ?> руб.</p>
                        </div>
                    <?php endforeach; ?>

                </div>
                <?php endif; ?>
                <?php endforeach; ?>

            </div>
            <?php endforeach; ?>

        </div>
        <div data-index="2" class="alcohol__content__item wine__item <?= (Yii::$app->request->get('wine')) ? 'active' : false ?>">


            <?php foreach ($WineCategories as $category): ?>
            <div data-index="<?= $category->sort_order ?>" class="alcohol__content__item-main active">
                <div class="table__aclo">
                    <h2><?= $category->name ?></h2>

                    <?php foreach ($category->alcohol as $alcohol): ?>
                        <div class="table__aclo__item">
                            <p><?= $alcohol->name ?></p>
                            <p><?= $alcohol->weight ?> мл.</p>
                            <p><?= $alcohol->price ?> руб.</p>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>