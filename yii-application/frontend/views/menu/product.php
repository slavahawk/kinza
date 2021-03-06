<?php

/* @var $this yii\web\View */

use frontend\widgets\categoryList\CategoryList;
use yii\helpers\Url;
use yii\web\JqueryAsset;

$this->title = "$product->product_name — Кинза";
$this->registerMetaTag([
    'name' => $product->product_name,
    'content' => $product->description
]);

?>

<main>

    <?= CategoryList::widget(); ?>

    <section class="product">
        <div class="product__content">
            <div class="product__content-item">
                <div class="product__content-item-image">

                    <?php if ($product->product_image): ?>
                    <img src="<?= Yii::getAlias('@imgFrontEnd'); ?>/product/<?= $product->product_image; ?>.jpg"
                        alt="<?= $product->product_name; ?>" />
                    <?php else: ?>
                    <img src="<?= Yii::getAlias('@imgFrontEnd'); ?>/dish.png"
                         alt="<?= $product->product_name; ?>" />
                    <?php endif; ?>

                </div>
                <div class="product__content-item-info">
                    <h2><?= $product->product_name; ?></h2>
                    <a class="backMenu__link"
                        href="<?= Url::to(['menu/category', 'categoryId' => $product->category_id]); ?>">Вернуться в
                        каталог</a>
                    <p class="price"><?= $product->price; ?><span>₽</span></p>
                    <p class="amount">В корзине: <span
                            id="cart-count-num"><?= $_SESSION['cart'][$product->product_id]['qty'] ?? 0 ?></span> шт.
                    </p>
                    <div class="product__content-item-info-btn">
                        <a class="pay__link add-to-cart" data-id="<?= $product->product_id; ?>">В корзину</a>
                    </div>

                    <h3>Описание</h3>
                    <p>
                        <?= $product->description; ?>
                    </p>
                    <br />
                    <p>Вес: <?= $product->weight; ?> г</p>
                    <br />
                    <p>
                        Белки: <?= $product->proteins; ?> <br />
                        Жиры: <?= $product->fats; ?> <br />
                        Углеводы: <?= $product->carbohydrates; ?> <br />
                        Калорийность: <?= $product->calories; ?> ккал/100г
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php $this->registerJsFile('/yii-application/frontend/web/js/backend/addToCart.js', [
    'depends' => JqueryAsset::className()
]);