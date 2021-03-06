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

<main>

    <?= CategoryList::widget(); ?>

    <section class="catalog">
        <div class="catalog__content">

            <?php foreach ($productList as $product): ?>
            <div class="catalog__content-item">
                <a href="<?= Url::to(['menu/product', 'productId' => $product->product_id]); ?>">

                    <?php if ($product->product_image): ?>
                    <img class="lozad" data-src="<?= $product->product_image; ?>" alt="<?= $product->product_name; ?>"
                        src="<?php echo Yii::getAlias('@imgFrontEnd'); ?>/dish.png" />
                    <?php else: ?>
                    <img src="<?= Yii::getAlias('@imgFrontEnd'); ?>/dish.png" alt="<?= $product->product_name; ?>" />
                    <?php endif; ?>

                </a>
                <a class="title__product" href="<?= Url::to(['menu/product', 'productId' => $product->product_id]); ?>">
                    <?= $product->product_name; ?>
                </a>
                <p><?= $product->price; ?><span>₽</span></p>
                <a class="add-to-cart btn__pay" data-id="<?= $product->product_id; ?>"
                    href="<?= Url::to(['cart/add', 'id' => $product->product_id]); ?>">В корзину</a>
            </div>
            <?php endforeach; ?>

        </div>
    </section>
</main>

<?php $this->registerJsFile('/yii-application/frontend/web/js/backend/addToCart.js', [
    'depends' => JqueryAsset::className()
]);