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

    public function removeItem($id)
    {
        $index = $this->exists($id);
        $cart = array_values(session('cart'));
        unset($cart[$index]);
        $session = session();
        $session->set('cart',$cart);
        return $this->response->redirect(site_url('/check-out'));
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

    public function orderConfirmation()
    {
        $orderModel = new \App\Models\orderModel();
        $paymentModel = new \App\Models\paymentModel();
        $user = session()->get('sess_id');
        $address = $this->request->getPost('address');
        $contactNo = $this->request->getPost('contactNo');
        $amount = $this->request->getPost('amount');
        $payment = $this->request->getPost('payment');
        $status = 0;
        $trxnCode = "";
        $builder = $this->db->table('tblpayment');
        $builder->select('COUNT(paymentID)+1 as total');
        $count = $builder->get();
        if($row = $count->getRow())
        {
            $trxnCode = str_pad($row->total, 11, '0', STR_PAD_LEFT);
        }
        //save the cart
        $items = array_values(session('cart'));
        foreach($items as $item)
        {
            $values = [
                'customerID'=>$user,'productName'=>$item['name'], 'Qty'=>$item['quantity'],
                'price'=>$item['price'],'Status'=>0,'TransactionNo'=>$trxnCode
            ];
            $orderModel->save($values);
        }
        $session = session();
        $session->remove('cart');
        //save the other info
        $values = ['customerID'=>$user,'TransactionNo'=>$trxnCode,'Total'=>$amount,
                    'Status'=>$status,'DateCreated'=>date('Y-m-d'),'DateReceived'=>'0000-00-00',
                    'DeliveryAddress'=>$address,'ContactNo'=>$contactNo,'paymentDetails'=>$payment];
        $paymentModel->save($values);
        //redirect to my orders page
        return $this->response->redirect(site_url('/orders'));
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

    public function orderHistory()
    {
        return view('customer/order-history');
    }

    public function primaryAddress()
    {
        $user = session()->get('sess_id');
        $builder = $this->db->table('tbl_customerinfo');
        $builder->select('*');
        $builder->LIKE('customerID',$user)->WHERE('primary','Yes');
        $data = $builder->get();
        if($row = $data->getRow())
        {
            $info = array("Address"=>$row->Street.",".$row->Barangay.",".$row->City.",".$row->Province." ".$row->ZipCode,"contactNo"=>$row->ContactNo);
            echo json_encode($info);
        }
    }
}