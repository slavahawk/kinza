<?php


namespace frontend\controllers;


use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderItems;
use frontend\models\Product;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

class CartController extends Controller
{

    public function actionIndex()
    {
        $session = Yii::$app->session;

        if (Yii::$app->request->post('clear')) {
            return  $this->actionClear();
        }

        return $this->render('index', [
            'session' => $session,
        ]);
    }

    public function actionAdd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);

        if (empty($product)) return false;

        $cart = new Cart();
        $cart->addToCart($product);

        return Json::encode([
            'qty' => $_SESSION['cart.qty'],
            'num' => $_SESSION['cart'][$id]['qty']
        ]);
    }

    public function actionAddInCart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);

        if (empty($product)) return false;

        $cart = new Cart();
        $cart->addToCart($product);

        return Json::encode([
            'qty' => $_SESSION['cart.qty'],
            'sum' => $_SESSION['cart.sum'],
            'num' => $_SESSION['cart'][$id]['qty'],
        ]);
    }

    public function actionMinusInCart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);

        if (empty($product) || $_SESSION['cart'][$id]['qty'] == 1) return false;

        $cart = new Cart();
        $cart->minusToCart($product);

        return Json::encode([
            'qty' => $_SESSION['cart.qty'],
            'sum' => $_SESSION['cart.sum'],
            'num' => $_SESSION['cart'][$id]['qty'],
        ]);
    }

    protected function actionClear()
    {
        $session = Yii::$app->session;
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');

        return $this->redirect(['cart/index']);
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);

        if (empty($product)) return false;

        $cart = new Cart();
        $cart->recalc($id);

        return Json::encode([
            'qty' => $_SESSION['cart.qty'],
            'sum' => $_SESSION['cart.sum'],
        ]);
    }

    public function actionOrder()
    {
        $session = Yii::$app->session;

        if (empty($session['cart'])) return $this->redirect(['cart/index']);

        $order = new Order();

        if (Yii::$app->request->post('order_delivery')){
            if ($order->load(Yii::$app->request->post())) {
                $order->qty = $session['cart.qty'];
                $order->sum = $session['cart.sum'];
                $order->type = 'delivery';
                if (Yii::$app->request->post() && $order->save()) {
                    $this->saveOrderItems($session['cart'], $order->id);
                    $session->remove('cart');
                    $session->remove('cart.qty');
                    $session->remove('cart.sum');
                    return $this->actionSuccess();
                }
            }
        } elseif (Yii::$app->request->post('order_pickup')) {
            if ($order->load(Yii::$app->request->post())) {
                $order->qty = $session['cart.qty'];
                $order->sum = $session['cart.sum'];
                $order->address = 'pickup';
                $order->type = 'pickup';
                if (Yii::$app->request->post() && $order->save()) {
                    $this->saveOrderItems($session['cart'], $order->id);
                    $session->remove('cart');
                    $session->remove('cart.qty');
                    $session->remove('cart.sum');
                    return $this->actionSuccess();
                }
            }
        }

        return $this->render('order', [
            'session' => $session,
            'order' => $order,
        ]);
    }

    protected function saveOrderItems($items, $order_id)
    {
        foreach ($items as $id => $item) {
            $order_items = new OrderItems();
            $order_items->order_id = $order_id;
            $order_items->product_id = $id;
            $order_items->name = $item['name'];
            $order_items->price = $item['price'];
            $order_items->qty_item = $item['qty'];
            $order_items->sum_item = $item['qty'] * $item['price'];
            $order_items->save();
        }
    }

    protected function actionSuccess()
    {
        return $this->render('success', []);
    }

}