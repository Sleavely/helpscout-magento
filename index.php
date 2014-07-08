<?php

require 'vendor/autoload.php';

use HelpScoutApp\DynamicApp;
use Illuminate\Database\Eloquent\Model as Model;

$app = new DynamicApp('HELPSCOUT-SECRET-KEY');
if ($app->isSignatureValid())
{
  $customer = $app->getCustomer();
  $user     = $app->getUser();
  $convo    = $app->getConversation();
  
  $html = array();
  $html[] = '<h4>Orders</h4>';
  $html[] = '<ul>';
  $settings = array(
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'magento',
    'username'  => 'root',
    'password'  => 'topsecret',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
  );
  // This is far more readable on newer versions of Illuminate (with PHP 5.4 and above)
  $connFactory = new \Illuminate\Database\Connectors\ConnectionFactory(new Illuminate\Container\Container);
  $conn = $connFactory->make($settings);
  $resolver = new \Illuminate\Database\ConnectionResolver();
  $resolver->addConnection('default', $conn);
  $resolver->setDefaultConnection('default');
  \Illuminate\Database\Eloquent\Model::setConnectionResolver($resolver);
  
  class Order extends Model {
    public $table = 'sales_flat_order'; 
    public $timestamps = false;
  }
  $orders = Order::whereIn('customer_email', $customer->getEmails())->orderBy('entity_id', 'desc')->take(5)->get();
  foreach($orders as $order)
  {
    $html[] = '<li><a href="http://animail.se/index.php/admin/sales_order/view/order_id/'.$order->entity_id.'/" target="_blank">#'.$order->increment_id.'</a>, '.number_format($order->base_grand_total, 2).' '.$order->base_currency_code .'</li>';
  }
  $html[] = '</ul>';
  echo $app->getResponse($html);
}
else
{
  echo 'Invalid Request';
}
