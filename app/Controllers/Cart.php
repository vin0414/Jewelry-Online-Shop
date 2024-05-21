<?php

namespace App\Controllers;

class Cart extends BaseController
{
    private $db;
    public function __construct()
    {
        $this->db = db_connect();
    }

    public function productDetails($id)
    {
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->WHERE('a.productID',$id);
        $products = $builder->get()->getResult();
        $data = ['product'=>$products];
        return view('cart/product-details',$data);
    }

    public function remove($id)
    {
        $index = $this->exists($id);
        $cart = array_values(session('cart'));
        unset($cart[$index]);
        $session = session();
        $session->set('cart',$cart);
        return $this->response->redirect(site_url('/'));
    }

    public function buy($id)
    {
        $qty = $this->request->getPost('qty');
        $productModel = new \App\Models\productModel();
        $product = $productModel->WHERE('productID',$id)->first();
        $item = array(
            'id'=>$id,
            'name'=>$product['productName'],
            'photo'=>$product['Image'],
            'price'=>$product['UnitPrice']-($product['UnitPrice']*$product['Discount']),
            'quantity'=>$qty
        );
        $session = session();
        if($session->has('cart'))
        {
            $index = $this->exists($id);
            $cart = array_values(session('cart'));
            if($index == -1)
            {
                array_push($cart, $item);
            }
            else
            {
                session()->setFlashdata('fail','Invalid! Item(s) already added in your cart');
                return redirect()->to('/')->withInput();
            }
            $session->set('cart',$cart);
        }
        else
        {
            $cart = array($item);
            $session->set('cart',$cart);
        }
        return $this->response->redirect(site_url('/'));
    }

    private function exists($id)
    {
        $items = array_values(session('cart'));
        for($i = 0; $i < count($items); $i++)
        {
            if($items[$i]['id']==$id)
            {
                return $i;
            }
        }
        return -1;
    }

    public function checkOut()
    {
        $items = is_array(session('cart'))?array_values(session('cart')):array();
        $total = $this->total();
        $data = ['items'=>$items,'total'=>$total];
        return view('cart/check-out',$data);
    }

    private function total()
    {
        $s = 0;
        $items = is_array(session('cart'))?array_values(session('cart')):array();
        foreach($items as $item)
        {
            $s += $item['price']*$item['quantity'];
        }
        return $s;
    }

    public function orders()
    {
        return view('customer/orders');
    }

    public function account()
    {
        return view('customer/profile');
    }
}