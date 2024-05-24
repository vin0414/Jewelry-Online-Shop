<?php

namespace App\Controllers;
use App\Libraries\Hash;
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
        $dateReceived = date('Y-m-d', strtotime(date('Y-m-d'). ' + 3 days'));
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
                    'Status'=>$status,'DateCreated'=>date('Y-m-d'),'DateReceived'=>$dateReceived,
                    'DeliveryAddress'=>$address,'ContactNo'=>$contactNo,'paymentDetails'=>$payment,'Remarks'=>'PENDING'];
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
        $user = session()->get('sess_id');
        $paymentModel = new \App\Models\paymentModel();
        $payment = $paymentModel->WHERE('Status',0)->WHERE('customerID',$user)->findAll();
        $data = ['orders'=>$payment];
        return view('customer/orders',$data);
    }

    public function account()
    {
        $customerModel = new \App\Models\customerModel();
        $customerInfoModel = new \App\Models\customerinfoModel();
        $user = session()->get('sess_id');
        $customer = $customerModel->WHERE('customerID',$user)->first();
        $info = $customerInfoModel->WHERE('customerID',$user)->first();
        $data = ['customer'=>$customer,'info'=>$info];
        return view('customer/profile',$data);
    }

    public function orderHistory()
    {
        $user = session()->get('sess_id');
        $paymentModel = new \App\Models\paymentModel();
        $payment = $paymentModel->WHERE('Status<>',0)->WHERE('customerID',$user)->findAll();
        $data = ['orders'=>$payment];
        return view('customer/order-history',$data);
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

    public function cancelOrder()
    {
        $paymentModel = new \App\Models\paymentModel();
        $val = $this->request->getPost("value");
        $values = ['Status'=>2,'Remarks'=>'CANCELLED'];
        $paymentModel->update($val,$values);
        echo "success";
    }

    public function searchOrders()
    {
        $text = "%".$this->request->getGet('keyword')."%";
        $user = session()->get('sess_id');
        $builder = $this->db->table('tblpayment');
        $builder->select('*');
        $builder->LIKE('TransactionNo',$text)->WHERE('Status<>',0)->WHERE('customerID',$user);
        $data = $builder->get();
        foreach($data->getResult() as $row)
        {
            ?>
            <div class="order__details__box">
                <div class="order__text__boxx">
                  <p class="order__text__heading">Delivery Address</p>
                  <p class="order__text__description margin_top_2">
                  <span><?php echo $row->DeliveryAddress ?></span>
                  </p>
                  <p class="order__text__date">
                    <span class="badge bg-default"><?php echo $row->Remarks ?></span>
                  </p>
                </div>
                <div class="order__text__boxx">
                  <p class="order__text__heading">Order Details</p>
                  <p class="order__text__description margin_top_2">
                    Reference No : <span><?php echo $row->TransactionNo ?></span>
                  </p>
                  <p class="order__text__date">Payment Status: 
                    <?php if($row->Status==1){ ?>
                      <span class="badge bg-success">Paid</span>
                    <?php }else if($row->Status==2){?>
                      <span class="badge bg-danger">UnPaid</span>
                    <?php } ?>
                  </p>
                </div>
                <div class="order__text__boxx">
                  <p class="order__text__heading">Total Amount</p>
                  <p class="order__text__description margin_top_2">PhP <?php echo number_format($row->Total,2)?></p>
                </div>
                <div class="order__text__box">
                  <p class="order__text__heading">&nbsp;</p>
                  <br/>
                  <?php if($row->Remarks=="CANCELLED"){ ?>
                    <button type="button" class="btn">View</button>
                  <?php }else{?>
                    <button type="button" class="btn">Print</button>
                    <button type="button" class="btn">View</button>
                  <?php } ?>
                </div>
              </div>
            <?php
        }
    }

    public function updateAccount()
    {
        $customerModel = new \App\Models\customerModel();
        $customerInfoModel = new \App\Models\customerinfoModel();
        $user = session()->get('sess_id');
        //update the tblcustomer
        $fullname = $this->request->getPost('fullname');
        $email = $this->request->getPost('email');
        //information
        $birthdate = $this->request->getPost('birthdate');
        $phone = $this->request->getPost('phone');
        $gender = $this->request->getPost('gender');
        $street = $this->request->getPost('street');
        $brgy = $this->request->getPost('barangay');
        $city = $this->request->getPost('city');
        $province = $this->request->getPost('province');
        $zipcode = $this->request->getPost('zipcode');
        //update
        $values = ['Email'=>$email,'Fullname'=>$fullname];
        $customerModel->update($user,$values);
        //check if data is empty
        $builder = $this->db->table('tbl_customerinfo');
        $builder->select('infoID');
        $builder->WHERE('customerID',$user);
        $data = $builder->get();
        if($row = $data->getRow())
        {
            //update
            $values = ['customerID'=>$user, 'Street'=>$street,'Barangay'=>$brgy,'City'=>$city,
                    'Province'=>$province,'ZipCode'=>$zipcode,'BirthDate'=>$birthdate,
                    'Gender'=>$gender,'ContactNo'=>$phone];
            $customerInfoModel->update($row->infoID,$values);
        }
        else
        {
            $validation = $this->validate([
                'birthdate'=>'required',
                'phone'=>'required',
                'gender'=>'required',
                'street'=>'required',
                'barangay'=>'required',
                'city'=>'required',
                'province'=>'required',
                'zipcode'=>'required',
            ]);
            if(!$validation)
            {
                //do nothing
            }
            else
            {
                //save 
                ['customerID'=>$user, 'Street'=>$street,'Barangay'=>$brgy,'City'=>$city,
                        'Province'=>$province,'ZipCode'=>$zipcode,'BirthDate'=>$birthdate,
                        'Gender'=>$gender,'ContactNo'=>$phone,'primary'=>'Yes'];
                $customerInfoModel->save($values);
            }
        }
        echo "success";
    }

    public function updatePassword()
    {
        $customerModel = new \App\Models\customerModel();
        $user = session()->get('sess_id');
        $currentP = $this->request->getPost('current_password');
        $newP = $this->request->getPost('new_password');
        $confirmP = $this->request->getPost('confirm_password');
        //verify
        $builder = $this->db->table('tblcustomer');
        $builder->select('*');
        $builder->WHERE('customerID',$user);
        $data = $builder->get();
        if($row = $data->getRow())
        {
            $check_password = Hash::check($currentP, $row->Password);
            if(empty($check_password) || !$check_password)
            {
                echo "Invalid Password! Please try again";
            }
            else
            {
                if($newP!=$confirmP)
                {
                    echo "Invalid! Password mismatch. Please try again";
                }
                else
                {
                    $values = ['Password'=>Hash::make($newP)];
                    $customerModel->update($user,$values);
                    echo "success";
                }
            }
        }
    }
}