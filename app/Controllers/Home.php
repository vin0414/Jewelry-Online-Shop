<?php

namespace App\Controllers;
use App\Libraries\Hash;
use Config\App;

class Home extends BaseController
{
    private $db;
    public function __construct()
    {
        helper('text');
        $this->db = db_connect();
    } 

    public function auth()
    {
        return view('auth');
    }

    public function Faq()
    {
        return view('faq');
    }

    public function validateUser()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $validation = $this->validate([
            'email'=>'required|valid_email',
            'password'=>'required'
        ]);

        if(!$validation)
        {
            session()->setFlashdata('fail','Invalid email or password');
            return redirect()->to('/login')->withInput();
        }
        else
        {
            $builder = $this->db->table('tblaccount');
            $builder->select('*');
            $builder->WHERE('Email',$email)->WHERE('Status',1);
            $data = $builder->get();
            if($row = $data->getRow())
            {
                $check_password = Hash::check($password, $row->Password);
                if(empty($check_password) || !$check_password)
                {
                    session()->setFlashdata('fail','Invalid email or password');
                    return redirect()->to('/auth')->withInput();
                }
                else
                {
                    session()->set('loggedUser', $row->accountID);
                    session()->set('sess_fullname', $row->Fullname);
                    session()->set('sess_email',$row->Email);
                    session()->set('sess_role',$row->Role);
                    return $this->response->redirect(site_url('dashboard'));
                }
            }
            else
            {
                session()->setFlashdata('fail','Account is disabled. Please contact the Administrator');
                return redirect()->to('/auth')->withInput();
            }
        }
    }

    public function logOut()
    {
        if(session()->has('loggedUser'))
        {
            session()->remove('loggedUser');
            session()->remove('sess_fullname');
            session()->destroy();
            return redirect()->to('/auth?access=out')->with('fail', 'You are logged out!');
        }
    }

    public function dashboard()
    {
        //orders
        $customer = 0;
        $builder = $this->db->table('tblcustomer');
        $builder->select('COUNT(customerID)total');
        $builder->WHERE('Status',1);
        $orderList = $builder->get();
        if($row = $orderList->getRow())
        {
            $customer = $row->total;
        }
        //orders
        $order = 0;
        $builder = $this->db->table('tblpayment');
        $builder->select('COUNT(paymentID)total');
        $builder->WHERE('Status',0);
        $orderList = $builder->get();
        if($row = $orderList->getRow())
        {
            $order = $row->total;
        }
        //revenue for the month
        $income = 0;$month = date('m');$year = date('Y');
        $status = [0,2];
        $builder = $this->db->table('tblpayment');
        $builder->select('IFNULL(SUM(Total),0)total');
        $builder->WHERENOTIN('Status',$status)
        ->WHERE('DATE_FORMAT(DateCreated,"%m")',$month)
        ->WHERE('DATE_FORMAT(DateCreated,"%Y")',$year);
        $orderList = $builder->get();
        if($row = $orderList->getRow())
        {
            $income = $row->total;
        }
        //revenue for the current date
        $dailyIncome = 0;$date=date('Y-m-d');
        $status = [0,2];
        $builder = $this->db->table('tblpayment');
        $builder->select('IFNULL(SUM(Total),0)total');
        $builder->WHERENOTIN('Status',$status)
        ->WHERE('DateCreated',$date);
        $orderList = $builder->get();
        if($row = $orderList->getRow())
        {
            $dailyIncome = $row->total;
        }
        //recent products
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->groupBy('a.productID')->orderBy('a.productID','DESC')->limit(5);
        $products = $builder->get()->getResult();
        //create chart
        $builder = $this->db->table('tblpayment');
        $builder->select('DateCreated,COUNT(paymentID)total');
        $builder->groupBy('DateCreated');
        $query = $builder->get()->getResult();
        //revenue
        $status = [0,2];
        $builder = $this->db->table('tblpayment');
        $builder->select('DateCreated,SUM(Total)total');
        $builder->WHERENOTIN('Status',$status);
        $builder->groupBy('DateCreated');
        $revenue = $builder->get()->getResult();
        //collect 
        $data = ['order'=>$order,'income'=>$income,'daily'=>$dailyIncome,
        'customer'=>$customer,'products'=>$products,'query'=>$query,'revenue'=>$revenue];
        return view('admin/index',$data);
    }

    public function products()
    {
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
        $products = $builder->get()->getResult();
        //category
        $categoryModel = new \App\Models\categoryModel();
        $category = $categoryModel->findAll();
        $data = ['products'=>$products,'category'=>$category];
        return view('admin/products',$data);
    }

    public function newProduct()
    {
        $categoryModel = new \App\Models\categoryModel();
        $category = $categoryModel->findAll();
        $data = ['category'=>$category];
        return view('admin/new-product',$data);
    }

    public function editProduct($id)
    {
        $categoryModel = new \App\Models\categoryModel();
        $category = $categoryModel->findAll();
        //product
        $productModel = new \App\Models\productModel();
        $product = $productModel->find($id);
        //other photo
        $otherphotoModel = new \App\Models\otherphotoModel();
        $other = $otherphotoModel->WHERE('productID',$product['productID'])->findAll();
        $data = ['category'=>$category,'product'=>$product,'photos'=>$other];
        return view('admin/edit-product',$data);
    }

    public function uploadImage()
    {
        $otherphotoModel = new \App\Models\otherphotoModel();
        //data
        $id = $this->request->getPost('productID');
        if($this->request->getFileMultiple('images')) 
        {
            foreach($this->request->getFileMultiple('images') as $file)
            {
                $originalName = $file->getClientName();
                $file->move('assets/images/product/',$originalName);
                //save the images
                $values = [
                    'productID'=>$id,
                    'Image'=>$file->getClientName(),
                ];
                $otherphotoModel->save($values);
            }
        }
        session()->setFlashdata('success',"Great! Successfully added");
        return redirect()->to('/edit/'.$id)->withInput();
    }

    public function addStocks()
    {
        $productModel = new \App\Models\productModel();
        $id = $this->request->getPost('value');
        $number = $this->request->getPost('number');
        $newStocks = 0;
        if($number<=0)
        {
            echo "Invalid! Please try again";
        }
        else
        {
            $product = $productModel->WHERE('productID',$id)->first();
            $newStocks = $number + $product['Qty'];
            $values = ['Qty'=>$newStocks];
            $productModel->update($id,$values);
            echo "success";
        }
    }

    public function saveProduct()
    {
        $productModel = new \App\Models\productModel();
        $pName = $this->request->getPost('productName');
        $desc = $this->request->getPost('description');
        $itemUnit = $this->request->getPost('itemUnit');
        $unitPrice = $this->request->getPost('unitPrice');
        $qty = $this->request->getPost('qty');
        $type = $this->request->getPost('type');
        $category = $this->request->getPost('category');
        $onsales = $this->request->getPost('onsales');
        $discount = $this->request->getPost('discount');
        $featured = $this->request->getPost('featured');
        $file = $this->request->getFile('file');
        $originalName = $file->getClientName();
        //save the records
        $validation = $this->validate([
            'productName'=>'is_unique[tblproduct.productName]'
        ]);

        if(!$validation)
        {
            session()->setFlashdata('fail',"Invalid !".$pName." already exist.");
            return redirect()->to('/new')->withInput();
        }
        else
        {
            if($featured=="Yes")
            {
                $values = ['productName'=>$pName,'Description'=>$desc,'Image'=>$originalName,
                                'ItemUnit'=>$itemUnit,'Qty'=>$qty,'UnitPrice'=>$unitPrice,'DateCreated'=>date('Y-m-d'),
                                'Product_Type'=>$type,'categoryID'=>$category,
                                'feature'=>'Yes','onSales'=>$onsales,'Discount'=>($discount/100)];
                $productModel->save($values);
            }
            else
            {
                $values = ['productName'=>$pName,'Description'=>$desc,'Image'=>$originalName,
                    'ItemUnit'=>$itemUnit,'Qty'=>$qty,'UnitPrice'=>$unitPrice,'DateCreated'=>date('Y-m-d'),
                    'Product_Type'=>$type,'categoryID'=>$category,
                    'feature'=>'No','onSales'=>$onsales,'Discount'=>($discount/100)];
                $productModel->save($values);
            }
            $file->move('assets/images/product/',$originalName);
            session()->setFlashdata('success',"Great! Successfully added");
            return redirect()->to('/new')->withInput();
        }
    }

    public function updateProduct()
    {
        $productModel = new \App\Models\productModel();
        //data
        $id = $this->request->getPost('productID');
        $pName = $this->request->getPost('productName');
        $desc = $this->request->getPost('description');
        $itemUnit = $this->request->getPost('itemUnit');
        $unitPrice = $this->request->getPost('unitPrice');
        $type = $this->request->getPost('type');
        $category = $this->request->getPost('category');
        $onsales = $this->request->getPost('onsales');
        $discount = $this->request->getPost('discount');
        $featured = $this->request->getPost('featured');
        //validate if featured or not
        if($featured=="Yes")
        {
            $values = ['productName'=>$pName,'Description'=>$desc,
                        'ItemUnit'=>$itemUnit,'UnitPrice'=>$unitPrice,
                        'Product_Type'=>$type,'categoryID'=>$category,
                        'feature'=>$featured,'onSales'=>$onsales,'Discount'=>($discount/100)];
            $productModel->update($id,$values);
        }
        else
        {
            $values = ['productName'=>$pName,'Description'=>$desc,
                        'ItemUnit'=>$itemUnit,'UnitPrice'=>$unitPrice,
                        'Product_Type'=>$type,'categoryID'=>$category,
                        'feature'=>'No','onSales'=>$onsales,'Discount'=>($discount/100)];
            $productModel->update($id,$values);
        }
        echo "success";
    }

    public function fetchByCategory()
    {
        $val = $this->request->getGet('value');
        if(!empty($val))
        {
            $builder = $this->db->table('tblproduct a');
            $builder->select('a.*,b.CategoryName');
            $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
            $builder->WHERE('a.categoryID',$val);
            $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
            $data = $builder->get();
            foreach($data->getResult() as $row)
            {
                ?>
                <div class="cards">
                <div class="card">
                <img src="<?=base_url('assets/images/product')?>/<?php echo $row->Image ?>" 
                alt="<?php echo $row->productName ?>" style="width:50%;display: block;margin-left: auto;margin-right: auto;"/>
                    <p class="card__textdescription"><?php echo $row->CategoryName ?></p>
                    <h4 class="card__heading"><center><?php echo $row->productName ?></center></h4>
                    <span class="card__textdescription">Price : PhP <?php echo number_format($row->UnitPrice,2) ?> | Qty :<?php echo $row->Qty ?></span>
                    <center>
                    <a href="<?=site_url('edit/') ?><?php echo $row->productID ?>" class="btn bg-default">Edit Item</a>
                    <button type="button" class="btn bg-default">Add Stocks</button>
                    </cente>
                </div>
                </div>
                <?php
            }
        }
        else
        {
            $builder = $this->db->table('tblproduct a');
            $builder->select('a.*,b.CategoryName');
            $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
            $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
            $data = $builder->get();
            foreach($data->getResult() as $row)
            {
                ?>
                <div class="cards">
                <div class="card">
                <img src="<?=base_url('assets/images/product')?>/<?php echo $row->Image ?>" 
                alt="<?php echo $row->productName ?>" style="width:50%;display: block;margin-left: auto;margin-right: auto;"/>
                    <p class="card__textdescription"><?php echo $row->CategoryName ?></p>
                    <h4 class="card__heading"><center><?php echo $row->productName ?></center></h4>
                    <span class="card__textdescription">Price : PhP <?php echo number_format($row->UnitPrice,2) ?> | Qty :<?php echo $row->Qty ?></span>
                    <center>
                    <a href="<?=site_url('edit/') ?><?php echo $row->productID ?>" class="btn bg-default">Edit Item</a>
                    <button type="button" class="btn bg-default">Add Stocks</button>
                    </cente>
                </div>
                </div>
                <?php
            }
        }
    }

    public function fetchByType()
    {
        $val = $this->request->getGet('value');
        if(!empty($val))
        {
            $builder = $this->db->table('tblproduct a');
            $builder->select('a.*,b.CategoryName');
            $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
            $builder->WHERE('a.Product_Type',$val);
            $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
            $data = $builder->get();
            foreach($data->getResult() as $row)
            {
                ?>
                <div class="cards">
                <div class="card">
                <img src="<?=base_url('assets/images/product')?>/<?php echo $row->Image ?>" 
                alt="<?php echo $row->productName ?>" style="width:50%;display: block;margin-left: auto;margin-right: auto;"/>
                    <p class="card__textdescription"><?php echo $row->CategoryName ?></p>
                    <h4 class="card__heading"><center><?php echo $row->productName ?></center></h4>
                    <span class="card__textdescription">Price : PhP <?php echo number_format($row->UnitPrice,2) ?> | Qty :<?php echo $row->Qty ?></span>
                    <center>
                    <a href="<?=site_url('edit/') ?><?php echo $row->productID ?>" class="btn bg-default">Edit Item</a>
                    <button type="button" class="btn bg-default">Add Stocks</button>
                    </cente>
                </div>
                </div>
                <?php
            }
        }
        else
        {
            $builder = $this->db->table('tblproduct a');
            $builder->select('a.*,b.CategoryName');
            $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
            $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
            $data = $builder->get();
            foreach($data->getResult() as $row)
            {
                ?>
                <div class="cards">
                <div class="card">
                <img src="<?=base_url('assets/images/product')?>/<?php echo $row->Image ?>" 
                alt="<?php echo $row->productName ?>" style="width:50%;display: block;margin-left: auto;margin-right: auto;"/>
                    <p class="card__textdescription"><?php echo $row->CategoryName ?></p>
                    <h4 class="card__heading"><center><?php echo $row->productName ?></center></h4>
                    <span class="card__textdescription">Price : PhP <?php echo number_format($row->UnitPrice,2) ?> | Qty :<?php echo $row->Qty ?></span>
                    <center>
                    <a href="<?=site_url('edit/') ?><?php echo $row->productID ?>" class="btn bg-default">Edit Item</a>
                    <button type="button" class="btn bg-default">Add Stocks</button>
                    </cente>
                </div>
                </div>
                <?php
            }
        }
    }

    public function findProducts()
    {
        $text = "%".$this->request->getGet('keyword')."%";
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->LIKE('a.productName',$text);
        $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
        $data = $builder->get();
        foreach($data->getResult() as $row)
        {
            ?>
            <div class="cards">
              <div class="card">
              <img src="<?=base_url('assets/images/product')?>/<?php echo $row->Image ?>" 
              alt="<?php echo $row->productName ?>" style="width:50%;display: block;margin-left: auto;margin-right: auto;"/>
                <p class="card__textdescription"><?php echo $row->CategoryName ?></p>
                <h4 class="card__heading"><center><?php echo $row->productName ?></center></h4>
                <span class="card__textdescription">Price : PhP <?php echo number_format($row->UnitPrice,2) ?> | Qty :<?php echo $row->Qty ?></span>
                <center>
                  <a href="<?=site_url('edit/') ?><?php echo $row->productID ?>" class="btn bg-default">Edit Item</a>
                  <button type="button" class="btn bg-default">Add Stocks</button>
                </cente>
              </div>
            </div>
            <?php
        }
    }

    public function orders()
    {
        //orders
        $order = 0;
        $builder = $this->db->table('tblpayment');
        $builder->select('COUNT(paymentID)total');
        $builder->WHERE('Status',0);
        $orderList = $builder->get();
        if($row = $orderList->getRow())
        {
            $order = $row->total;
        }
        //confirmed
        $confirm = 0;
        $builder = $this->db->table('tblpayment');
        $builder->select('COUNT(paymentID)total');
        $builder->WHERE('Status',1);
        $orderList = $builder->get();
        if($row = $orderList->getRow())
        {
            $confirm = $row->total;
        }
        //for delivery
        $delivery = 0;
        $builder = $this->db->table('tblpayment');
        $builder->select('COUNT(paymentID)total');
        $builder->WHERE('Remarks','FOR DELIVERY');
        $orderList = $builder->get();
        if($row = $orderList->getRow())
        {
            $delivery = $row->total;
        }
        //paid
        $paid = 0;
        $builder = $this->db->table('tblpayment');
        $builder->select('COUNT(paymentID)total');
        $builder->WHERE('Status',3);
        $orderList = $builder->get();
        if($row = $orderList->getRow())
        {
            $paid = $row->total;
        }
        $builder = $this->db->table('tblpayment a');
        $builder->select('a.*,b.Fullname');
        $builder->join('tblcustomer b','b.customerID=a.customerID','LEFT');
        $builder->orderBy('a.Status','ASC');
        $orderList = $builder->get()->getResult();
        $data = ['orders'=>$orderList,'new'=>$order,'confirm'=>$confirm,'deliver'=>$delivery,'paid'=>$paid];
        return view('admin/orders',$data);
    }

    public function viewOrder($id)
    {
        $builder = $this->db->table('tblpayment a');
        $builder->select('a.*,b.Fullname');
        $builder->join('tblcustomer b','b.customerID=a.customerID','LEFT');
        $builder->WHERE('a.TransactionNo',$id);
        $payment = $builder->get()->getResult();
        //items
        $orderModel = new \App\Models\orderModel();
        $order = $orderModel->WHERE('TransactionNo',$id)->findAll();
        //collect
        $data = ['id'=>$id,'payment'=>$payment,'order'=>$order];
        return view('admin/view-orders',$data);
    }

    public function updatePayment()
    {
        $paymentModel = new \App\Models\paymentModel();
        $customerModel = new \App\Models\customerModel();
        $productModel = new \App\Models\productModel();
        //data
        $id = $this->request->getPost('paymentID');
        $status = $this->request->getPost('status');
        $remarks = $this->request->getPost('remarks');
        $customerID = $this->request->getPost('customerID');
        $payment = $paymentModel->WHERE('paymentID',$id)->first();
        $customer = $customerModel->WHERE('customerID',$customerID)->first();
        if($status==2)
        {
            $values = ['Status'=>$status,'Remarks'=>$remarks];
            $paymentModel->update($id,$values);

            if($remarks=="Out of Stocks")
            {
                $email = \Config\Services::email();
                $email->setTo($customer['Email']);
                $email->setFrom("vinmogate@gmail.com","Nasser Goldsmith and Jewelry");
                $template = "Dear ".$customer['Fullname'].",<br/><br/>
                We hope this email finds you well. We regret to inform you that your order # ".$payment['TransactionNo']." has been cancelled.<br/> 
                Unfortunately, this item is currently out of stock and we are unable to fulfill your order at this time.<br/>
                We apologize for any inconvenience caused. As a token of our appreciation for your understanding.<br/>
                Please feel free to reach out to us if you have any further questions or require assistance with finding an alternative product.<br/>
                 We value your support and look forward to serving you in the future.<br/><br/>
                Best regards,<br/><br/>
                Nasser Goldsmith and Jewelry";
                $subject = "Cancellation Due to Out-of-Stock Item";
                $email->setSubject($subject);
                $email->setMessage($template);
                $email->send();
            }
            else
            {
                $email = \Config\Services::email();
                $email->setTo($customer['Email']);
                $email->setFrom("vinmogate@gmail.com","Nasser Goldsmith and Jewelry");
                $template = "Dear ".$customer['Fullname'].",<br/><br/>
                We hope this email finds you well. We regret to inform you that we have been unable to process and ship your order #".$payment['TransactionNo']." due to unforeseen shipping constraints.<br/>
                We understand the frustration this may cause and would like to offer you two options. Firstly, we can issue a full refund for your order amount. <br/>
                Alternatively, if you would like to wait, we anticipate being able to fulfill your order within the next 2-3 business days and will expedite the shipping at no additional cost to you.<br/>
                Please let us know your preference, and we will ensure your request is promptly handled. Our sincerest apologies once again, and thank you for your understanding and patience.<br/>
                Warm regards,<br/><br/>
                Nasser Goldsmith and Jewelry";
                $subject = "Cancellation Due to Shipping Issues";
                $email->setSubject($subject);
                $email->setMessage($template);
                $email->send();
            }
            echo "success";
        }
        else if($status==1)
        {
            $validation = $this->validate([
                'Remarks'=>'is_unique[tblpayment.Remarks]'
            ]);
            if(!$validation)
            {
                echo "Invalid! Already tagged as ".$remarks;
            }
            else
            {
                $values = ['Status'=>$status,'Remarks'=>$remarks];
                $paymentModel->update($id,$values);
                if($remarks=="For Delivery")
                {
                    $builder = $this->db->table('tblorders');
                    $builder->select('productName,Qty');
                    $builder->WHERE('TransactionNo',$payment['TransactionNo']);
                    $data = $builder->get();
                    foreach($data->getResult() as $row)
                    {
                        $product = $productModel->WHERE('productName',$row->productName)->first();
                        $newQty = $product['Qty']-$row->Qty;
                        $values = ['Qty'=>$newQty];
                        $productModel->update($product['productID'],$values);
                    }
                }
                //send email
                $email = \Config\Services::email();
                $email->setTo($customer['Email']);
                $email->setFrom("vinmogate@gmail.com","Nasser Goldsmith and Jewelry");
                $template = "Dear ".$customer['Fullname'].",<br/><br/>
                Thank you for placing your order with us!<br/>
                    
                We will now process your order and get it ready for shipment.<br/> 
                You can expect to receive the items along with the estimated delivery date within the next few days.<br/>
                If you have any questions or need further assistance, please don't hesitate to reach out to our customer support team.<br/>
                    
                Thank you once again for choosing us. We greatly appreciate your business!<br/>
                Warm regards,<br/><br/>
                Nasser Goldsmith and Jewelry";
                $subject = "Order Confirmation";
                $email->setSubject($subject);
                $email->setMessage($template);
                $email->send();
                echo "success";
            }
        }
        else
        {
            $values = ['Status'=>$status,'Remarks'=>$remarks];
            $paymentModel->update($id,$values);
            echo "success";
        }
    }

    public function searchOrders()
    {
        $text = "%".$this->request->getGet('keyword')."%";
        $builder = $this->db->table('tblpayment a');
        $builder->select('a.*,b.Fullname');
        $builder->join('tblcustomer b','b.customerID=a.customerID','LEFT');
        $builder->LIKE('TransactionNo',$text)->orLike('b.Fullname',$text);
        $builder->orderBy('a.Status','ASC');
        $orderList = $builder->get();
        foreach($orderList->getResult() as $row)
        {
            ?>
            <tr>
                <td><?php echo $row->DateCreated ?></td>
                <td><?php echo $row->TransactionNo ?></td>
                <td><?php echo $row->Fullname ?></td>
                <td><?php echo $row->DeliveryAddress ?></td>
                <td><?php echo $row->ContactNo ?></td>
                <td><?php echo number_format($row->Total,2) ?></td>
                <td><?php echo $row->paymentDetails ?></td>
                <td>
                    <?php if($row->Status==0){ ?>
                    <span class="btn btn-sm bg-outline-default">Waiting</span>
                    <?php }else if($row->Status==1){?>
                    <span class="btn btn-sm bg-default">Confirmed</span>
                    <?php }else if($row->Status== 2){?>
                    <span class="btn btn-sm bg-danger">Cancelled</span>
                    <?php }else{?>
                    <span class="btn btn-sm bg-success">Success</span>
                    <?php } ?>
                </td>
                <td><?php echo $row->Remarks ?></td>
                <td>
                    <div class="dropdown">
                        <button class="dropbtn btn-sm"><ion-icon name="reorder-three-outline"></ion-icon>&nbsp;Action</button>
                        <div class="dropdown-content">
                        <a href="<?=site_url('view/')?><?php echo $row->TransactionNo ?>">View Orders</a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php
        }
    }

    public function searchOrdersDate()
    {
        $date = $this->request->getGet('value');
        $builder = $this->db->table('tblpayment a');
        $builder->select('a.*,b.Fullname');
        $builder->join('tblcustomer b','b.customerID=a.customerID','LEFT');
        $builder->WHERE('a.DateCreated',$date);
        $builder->orderBy('a.Status','ASC');
        $orderList = $builder->get();
        foreach($orderList->getResult() as $row)
        {
            ?>
            <tr>
                <td><?php echo $row->DateCreated ?></td>
                <td><?php echo $row->TransactionNo ?></td>
                <td><?php echo $row->Fullname ?></td>
                <td><?php echo $row->DeliveryAddress ?></td>
                <td><?php echo $row->ContactNo ?></td>
                <td><?php echo number_format($row->Total,2) ?></td>
                <td><?php echo $row->paymentDetails ?></td>
                <td>
                    <?php if($row->Status==0){ ?>
                    <span class="btn btn-sm bg-outline-default">Waiting</span>
                    <?php }else if($row->Status==1){?>
                    <span class="btn btn-sm bg-default">Confirmed</span>
                    <?php }else if($row->Status== 2){?>
                    <span class="btn btn-sm bg-danger">Cancelled</span>
                    <?php }else{?>
                    <span class="btn btn-sm bg-success">Success</span>
                    <?php } ?>
                </td>
                <td><?php echo $row->Remarks ?></td>
                <td>
                    <div class="dropdown">
                        <button class="dropbtn btn-sm"><ion-icon name="reorder-three-outline"></ion-icon>&nbsp;Action</button>
                        <div class="dropdown-content">
                        <a href="<?=site_url('view/')?><?php echo $row->TransactionNo ?>">View Orders</a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php
        }
    }

    public function members()
    {
        $accountModel = new \App\Models\accountModel();
        $accounts = $accountModel->findAll();
        $data = ['accounts'=>$accounts];
        return view('admin/members',$data);
    }

    public function resetAccount()
    {
        $accountModel = new \App\Models\accountModel();
        $id = $this->request->getPost('value');
        $password = "Qwerty1234";
        $hash_password = Hash::make($password);
        $values = ['Password'=>$hash_password];
        $accountModel->update($id,$values);
        echo "Great! Successfully reset";
    }

    public function searchAccounts()
    {
        $text = "%".$this->request->getGet('keyword')."%";
        $builder = $this->db->table('tblaccount');
        $builder->select('*');
        $builder->LIKE('Fullname',$text);
        $data = $builder->get();
        foreach($data->getResult()as $row)
        {
            ?>
            <div class="cards">
              <div class="card">
              <img src="<?=base_url('assets/images/logo/user-photo.png')?>" alt="" style="width:50%;display: block;margin-left: auto;margin-right: auto;"/>
                <p class="card__textdescription"><?php echo $row->Email ?></p>
                <h4 class="card__heading"><center><?php echo $row->Fullname ?></center></h4>
                <span class="card__textdescription"><?php echo $row->Role ?></span>
                <center>
                  <a href="<?=site_url('edit-account/')?><?php echo $row->accountID ?>" class="btn bg-default">Edit Account</a>
                  <button type="button" class="btn bg-default reset" value="<?php echo $row->accountID ?>">Reset</button>
                </cente>
              </div>
            </div>
            <?php
        }
    }

    public function addAccount()
    {
        $accountModel = new \App\Models\accountModel();
        $fullname = $this->request->getPost('fullname');
        $email = $this->request->getPost('email');
        $role = $this->request->getPost('role');
        $password = "Qwerty1234";
        $hash_password = Hash::make($password);
        $validation = $this->validate([
            'fullname'=>'required',
            'email'=>'required|is_unique[tblaccount.Email]',
            'role'=> 'required',
        ]);
        if(!$validation)
        {
            echo "Invalid! Please fill in the form";
        }
        else
        {
            $values = ['Email'=>$email, 'Password'=>$hash_password,'Fullname'=>$fullname,'Role'=>$role,'Status'=>1];
            $accountModel->save($values);
            echo "success";
        }
    }

    public function editAccount($id)
    {
        $accountModel = new \App\Models\accountModel();
        $account = $accountModel->WHERE('accountID',$id)->first();
        $data = ['account'=>$account];
        return view('admin/edit-account',$data);
    }

    public function updateAccount()
    {
        $accountModel = new \App\Models\accountModel();
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('fullname');
        $email = $this->request->getPost('email');
        $role = $this->request->getPost('role');
        $values = ['Email'=>$email, 'Fullname'=>$name,'Role'=>$role];
        $accountModel->update($id,$values);
        echo "success";
    }

    public function salesReport()
    {
        return view('admin/sales-report');
    }

    public function generateReport()
    {
        $output="";
        $status = [0,2];
        $fromdate = $this->request->getGet('fromdate');
        $todate = $this->request->getGet('todate');
        $builder = $this->db->table('tblpayment a');
        $builder->select('a.*,b.Fullname');
        $builder->join('tblcustomer b','b.customerID=a.customerID','LEFT');
        $builder->WHERE('a.DateCreated>=',$fromdate)->WHERE('a.DateCreated<=',$todate);
        $builder->WHERENOTIN('a.Status',$status);
        $data = $builder->get();
        foreach($data->getResult() as $row)
        {
            $output.="<tr>
                        <td>".$row->DateCreated."</td>
                        <td>".$row->TransactionNo."</td>
                        <td>".$row->Fullname."</td>
                        <td>".$row->paymentDetails."</td>
                        <td style='text-align:right;'>".number_format($row->Total,2)."</td>
                    </tr>";
        }
        $builder = $this->db->table('tblpayment a');
        $builder->select('SUM(a.Total)Total');
        $builder->WHERE('a.DateCreated>=',$fromdate)->WHERE('a.DateCreated<=',$todate);
        $builder->WHERENOTIN('a.Status',$status);
        $data = $builder->get();
        if($row = $data->getRow())
        {
            $output.="<tr style='font-weight:bold;'><td colspan='4'>Total</td><td style='text-align:right;'>".number_format($row->Total,2)."</td></tr>";
        }
        echo $output;
    }

    public function settings()
    {
        return view('admin/settings');
    }

    public function saveCategory()
    {
        $categoryModel = new \App\Models\categoryModel();
        $c_name = $this->request->getPost('category_name');
        $validation = $this->validate([
            'category_name'=>'is_unique[tblcategory.CategoryName]'
        ]);
        if(!$validation)
        {
            echo "Invalid! ".$c_name." Already exist";
        }
        else
        {
            if(empty($c_name))
            {
                echo "Invalid! Please enter category name";
            }
            else
            {
                $values = ['CategoryName'=>$c_name];
                $categoryModel->save($values);
                echo "success";
            }
        }
    }

    public function account()
    {
        return view('admin/account');
    }

    //customer

    public function index()
    {
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->groupBy('a.productID')->orderBy('a.productID','DESC')->limit(4);
        $products = $builder->get()->getResult();
        //new products
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->WHERE('DATE_FORMAT(DateCreated,"%m")',date('m'));
        $builder->WHERE('DATE_FORMAT(DateCreated,"%Y")',date('Y'));
        $builder->groupBy('a.productID')->orderBy('a.productID','DESC')->limit(4);
        $newProduct = $builder->get()->getResult();
        //featured
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->WHERE('a.feature','Yes');
        $builder->groupBy('a.productID')->orderBy('a.productID','DESC')->limit(4);
        $feature = $builder->get()->getResult();
        //on sales
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->WHERE('a.onSales','Yes');
        $builder->groupBy('a.productID')->orderBy('a.productID','DESC')->limit(4);
        $discounted = $builder->get()->getResult();
        //cart
        $items = is_array(session('cart'))?array_values(session('cart')):array();
        $total = $this->total();
        $totalItem = count(is_array(session('cart'))?array_values(session('cart')):array());

        $data = ['products'=>$products,'arrival'=>$newProduct,'feature'=>$feature,
        'discount'=>$discounted,'items'=>$items,'total'=>$total,'volume'=>$totalItem];
        return view('welcome_message',$data);
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

    public function store()
    {
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
        $products = $builder->get()->getResult();

        $categoryModel = new \App\Models\categoryModel();
        $category = $categoryModel->findAll();

        $items = is_array(session('cart'))?array_values(session('cart')):array();
        $total = $this->total();
        $totalItem = count(is_array(session('cart'))?array_values(session('cart')):array());
        $data = ['items'=>$items,'total'=>$total,'volume'=>$totalItem,'products'=>$products,'category'=>$category];
        return view('shop',$data);
    }

    public function searchByType()
    {
        $val = $this->request->getGet('value');
        if(empty($val))
        {
            $builder = $this->db->table('tblproduct a');
            $builder->select('a.*,b.CategoryName');
            $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
            $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
            $data = $builder->get();
            foreach($data->getResult() as $row)
            {
                ?>
                <div class="col-lg-3 form-group">
                    <div class="card" style="background-color:#000;color:#fff;border:1px solid #fff;">
                        <div class="card-body">
                            <img src="assets/images/product/<?php echo $row->Image ?>"/>
                            <center><?php echo $row->CategoryName ?></center>
                            <center><h4><?php echo $row->productName ?></h4></center>
                            <?php if($row->onSales=="Yes"){ ?>
                            <div class="modal_price mb-10 text-center">
                                <span class="new_price">PhP <?php echo number_format($row->UnitPrice-($row->UnitPrice*$row->Discount),2) ?></span>
                                <span class="old_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                            </div>
                            <?php }else {?>
                            <div class="modal_price mb-10 text-center">
                                <span class="new_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                            </div>
                            <?php } ?>
                            <div class="product_desc">
                                <p class="text-center"><?php echo $row->Description ?></p>
                            </div>
                            <div class="action_links">
                                <center>
                                <ul>
                                    <li><a href="#" data-placement="top" title="Add to Wishlist"
                                            data-toggle="tooltip"><span
                                                class="ion-heart"></span></a></li>
                                    <li class="add_to_cart">
                                        <a href="<?=site_url('cart/details/')?><?php echo $row->productID ?>" title="Add to Cart">Add to Cart</a>
                                    </li>
                                    <li><a href="#" title="Compare"><i
                                                class="ion-ios-settings-strong"></i></a>
                                    </li>
                                </ul>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        else
        {
            $builder = $this->db->table('tblproduct a');
            $builder->select('a.*,b.CategoryName');
            $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
            $builder->WHERE('a.Product_Type',$val);
            $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
            $data = $builder->get();
            foreach($data->getResult() as $row)
            {
                ?>
                <div class="col-lg-3 form-group">
                    <div class="card" style="background-color:#000;color:#fff;border:1px solid #fff;">
                        <div class="card-body">
                            <img src="assets/images/product/<?php echo $row->Image ?>"/>
                            <center><?php echo $row->CategoryName ?></center>
                            <center><h4><?php echo $row->productName ?></h4></center>
                            <?php if($row->onSales=="Yes"){ ?>
                            <div class="modal_price mb-10 text-center">
                                <span class="new_price">PhP <?php echo number_format($row->UnitPrice-($row->UnitPrice*$row->Discount),2) ?></span>
                                <span class="old_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                            </div>
                            <?php }else {?>
                            <div class="modal_price mb-10 text-center">
                                <span class="new_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                            </div>
                            <?php } ?>
                            <div class="product_desc">
                                <p class="text-center"><?php echo $row->Description ?></p>
                            </div>
                            <div class="action_links">
                                <center>
                                <ul>
                                    <li><a href="#" data-placement="top" title="Add to Wishlist"
                                            data-toggle="tooltip"><span
                                                class="ion-heart"></span></a></li>
                                    <li class="add_to_cart">
                                        <a href="<?=site_url('cart/details/')?><?php echo $row->productID ?>" title="Add to Cart">Add to Cart</a>
                                    </li>
                                    <li><a href="#" title="Compare"><i
                                                class="ion-ios-settings-strong"></i></a>
                                    </li>
                                </ul>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }

    public function searchByCategory()
    {
        $val = $this->request->getGet('value');
        if(empty($val))
        {
            $builder = $this->db->table('tblproduct a');
            $builder->select('a.*,b.CategoryName');
            $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
            $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
            $data = $builder->get();
            foreach($data->getResult() as $row)
            {
                ?>
                <div class="col-lg-3 form-group">
                    <div class="card" style="background-color:#000;color:#fff;border:1px solid #fff;">
                        <div class="card-body">
                            <img src="assets/images/product/<?php echo $row->Image ?>"/>
                            <center><?php echo $row->CategoryName ?></center>
                            <center><h4><?php echo $row->productName ?></h4></center>
                            <?php if($row->onSales=="Yes"){ ?>
                            <div class="modal_price mb-10 text-center">
                                <span class="new_price">PhP <?php echo number_format($row->UnitPrice-($row->UnitPrice*$row->Discount),2) ?></span>
                                <span class="old_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                            </div>
                            <?php }else {?>
                            <div class="modal_price mb-10 text-center">
                                <span class="new_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                            </div>
                            <?php } ?>
                            <div class="product_desc">
                                <p class="text-center"><?php echo $row->Description ?></p>
                            </div>
                            <div class="action_links">
                                <center>
                                <ul>
                                    <li><a href="#" data-placement="top" title="Add to Wishlist"
                                            data-toggle="tooltip"><span
                                                class="ion-heart"></span></a></li>
                                    <li class="add_to_cart">
                                        <a href="<?=site_url('cart/details/')?><?php echo $row->productID ?>" title="Add to Cart">Add to Cart</a>
                                    </li>
                                    <li><a href="#" title="Compare"><i
                                                class="ion-ios-settings-strong"></i></a>
                                    </li>
                                </ul>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        else
        {
            $builder = $this->db->table('tblproduct a');
            $builder->select('a.*,b.CategoryName');
            $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
            $builder->WHERE('a.categoryID',$val);
            $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
            $data = $builder->get();
            foreach($data->getResult() as $row)
            {
                ?>
                <div class="col-lg-3 form-group">
                    <div class="card" style="background-color:#000;color:#fff;border:1px solid #fff;">
                        <div class="card-body">
                            <img src="assets/images/product/<?php echo $row->Image ?>"/>
                            <center><?php echo $row->CategoryName ?></center>
                            <center><h4><?php echo $row->productName ?></h4></center>
                            <?php if($row->onSales=="Yes"){ ?>
                            <div class="modal_price mb-10 text-center">
                                <span class="new_price">PhP <?php echo number_format($row->UnitPrice-($row->UnitPrice*$row->Discount),2) ?></span>
                                <span class="old_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                            </div>
                            <?php }else {?>
                            <div class="modal_price mb-10 text-center">
                                <span class="new_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                            </div>
                            <?php } ?>
                            <div class="product_desc">
                                <p class="text-center"><?php echo $row->Description ?></p>
                            </div>
                            <div class="action_links">
                                <center>
                                <ul>
                                    <li><a href="#" data-placement="top" title="Add to Wishlist"
                                            data-toggle="tooltip"><span
                                                class="ion-heart"></span></a></li>
                                    <li class="add_to_cart">
                                        <a href="<?=site_url('cart/details/')?><?php echo $row->productID ?>" title="Add to Cart">Add to Cart</a>
                                    </li>
                                    <li><a href="#" title="Compare"><i
                                                class="ion-ios-settings-strong"></i></a>
                                    </li>
                                </ul>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }

    public function searchProducts()
    {
        $text = "%".$this->request->getGet('keyword')."%";
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->LIKE('a.productName',$text);
        $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
        $data = $builder->get();
        foreach($data->getResult() as $row)
        {
            ?>
            <div class="col-lg-3 form-group">
                <div class="card" style="background-color:#000;color:#fff;border:1px solid #fff;">
                    <div class="card-body">
                        <img src="assets/images/product/<?php echo $row->Image ?>"/>
                        <center><?php echo $row->CategoryName ?></center>
                        <center><h4><?php echo $row->productName ?></h4></center>
                        <?php if($row->onSales=="Yes"){ ?>
                        <div class="modal_price mb-10 text-center">
                            <span class="new_price">PhP <?php echo number_format($row->UnitPrice-($row->UnitPrice*$row->Discount),2) ?></span>
                            <span class="old_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                        </div>
                        <?php }else {?>
                        <div class="modal_price mb-10 text-center">
                            <span class="new_price">PhP <?php echo number_format($row->UnitPrice,2) ?></span>
                        </div>
                        <?php } ?>
                        <div class="product_desc">
                            <p class="text-center"><?php echo $row->Description ?></p>
                        </div>
                        <div class="action_links">
                            <center>
                            <ul>
                                <li><a href="#" data-placement="top" title="Add to Wishlist"
                                        data-toggle="tooltip"><span
                                            class="ion-heart"></span></a></li>
                                <li class="add_to_cart">
                                    <a href="<?=site_url('cart/details/')?><?php echo $row->productID ?>" title="Add to Cart">Add to Cart</a>
                                </li>
                                <li><a href="#" title="Compare"><i
                                            class="ion-ios-settings-strong"></i></a>
                                </li>
                            </ul>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    public function about()
    {
        return view('about');
    }

    public function signIn()
    {
        return view('sign-in');
    }

    public function register()
    {
        return view('register');
    }

    public function forgotPassword()
    {
        return view('forgot-password');
    }

    public function requestNewPassword()
    {
        return view('request-new-password');
    }

    public function createAccount()
    {
        $customerModel = new \App\Models\customerModel();
        //data
        $emailadd = $this->request->getPost('email');
        $fullname = $this->request->getPost('fullname');
        $password = $this->request->getPost('password');
        $retype = $this->request->getPost('retype_password');

        $validation = $this->validate([
            'email'=>'required|valid_email|is_unique[tblcustomer.Email]',
            'fullname'=>'required',
            'password'=>'required',
            'retype_password'=>'required',
        ]);

        if(!$validation)
        {
            session()->setFlashdata('fail','Invalid! Email already exists');
            return redirect()->to('/register')->withInput();
        }
        else
        {
            if($password!=$retype)
            {
                session()->setFlashdata('fail','Invalid! Password mismatched');
                return redirect()->to('/register')->withInput();
            }
            else
            {
                $token_code = random_string('alnum',20);
                $hash_password = Hash::make($password);
                $values = [
                    'Email'=>$emailadd, 'Password'=>$hash_password ,'Fullname'=>$fullname,'Status'=>0,'Token'=>$token_code,'DateCreated'=>date('Y-m-d')
                ];
                $customerModel->save($values);
                $email = \Config\Services::email();
                $email->setTo($emailadd);
                $email->setFrom("vinmogate@gmail.com","Nasser Goldsmith and Jewelry");
                $imgURL = "assets/images/logo/LOGO2.jpg";
                $email->attach($imgURL);
                $cid = $email->setAttachmentCID($imgURL);
                $template = "<center>
                <img src='cid:". $cid ."' width='100'/>
                <table style='padding:20px;background-color:#ffffff;' border='0'><tbody>
                <tr><td><center><h1>Account Activation</h1></center></td></tr>
                <tr><td><center>Hi, ".$fullname."</center></td></tr>
                <tr><td><p><center>Please click the link below to activate your account.</center></p></td><tr>
                <tr><td><center><b>".anchor('activate/'.$token_code,'Activate Account')."</b></center></td></tr>
                <tr><td><p><center>If you did not sign-up in Nasser Goldsmith and Jewelry website,<br/> please ignore this message or contact us @ nasser.jewelry@gmail.com</center></p></td></tr>
                <tr><td>Nasser Goldsmith and Jewelry Support Team</td></tr></tbody></table></center>";
                $subject = "Account Activation | Nasser Goldsmith and Jewelry";
                $email->setSubject($subject);
                $email->setMessage($template);
                $email->send();
                session()->setFlashdata('success','Great! Activation link was sent to your email provided. Thank you');
                return redirect()->to('/register')->withInput();
            }
        }
    }

    public function activate($id)
    {
        $customerModel = new \App\Models\customerModel();
        $customer = $customerModel->WHERE('Token',$id)->first();
        $values = ['Status'=>1];
        $customerModel->update($customer['customerID'],$values);
        session()->set('sess_id', $customer['customerID']);
        session()->set('sess_fullname', $customer['Fullname']);
        session()->set('customer_email',$customer['Email']);
        return $this->response->redirect(site_url('/'));
    }

    public function Login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $validation = $this->validate([
            'email'=>'required|valid_email',
            'password'=>'required'
        ]);

        if(!$validation)
        {
            session()->setFlashdata('fail','Invalid email or password');
            return redirect()->to('/login')->withInput();
        }
        else
        {
            $builder = $this->db->table('tblcustomer');
            $builder->select('*');
            $builder->WHERE('Email',$email)->WHERE('Status',1);
            $data = $builder->get();
            if($row = $data->getRow())
            {
                $check_password = Hash::check($password, $row->Password);
                if(empty($check_password) || !$check_password)
                {
                    session()->setFlashdata('fail','Invalid email or password');
                    return redirect()->to('/sign-in')->withInput();
                }
                else
                {
                    session()->set('sess_id', $row->customerID);
                    session()->set('sess_fullname', $row->Fullname);
                    session()->set('customer_email',$row->Email);
                    return $this->response->redirect(site_url('/'));
                }
            }
            else
            {
                session()->setFlashdata('fail','Account is disabled. Please contact the Administrator');
                return redirect()->to('/sign-in')->withInput();
            }
        }
    }

    public function signOut()
    {
        if(session()->has('customer_email'))
        {
            session()->remove('customer_email');
            session()->remove('sess_id');
            session()->destroy();
            return redirect()->to('/sign-in?access=out')->with('fail', 'You are logged out!');
        }
    }

    public function requestPassword()
    {
        $emailAddress = $this->request->getPost('email');
        $table = $this->db->table('tblaccount');
        $table->select('accountID, Fullname');
        $table->WHERE('Email', $emailAddress);
        $rows = $table->get();
        $data = $rows->getResult();
        
        if(empty($emailAddress)){
            session()->setFlashdata('fail','Invalid! Please enter your email address');
            return redirect()->to('/request-new-password')->withInput();
        }
        else{
            if(count($data) != 0)
            {
                //generate password
                // String of all alphanumeric character
                $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
             
                // Shuffle the $str_result and returns substring
                // of specified length
                $password = substr(str_shuffle($str_result),0,8);
                
                //send email
                if($row = $rows->getRow())
                {                   
                    $accountModel = new \App\Models\accountModel();
                    $values = ['Password'=>Hash::make($password),];
                    $accountModel->update($row->accountID,$values);
                
                    $email = \Config\Services::email();
                    $email->setTo($emailAddress);
                    $email->setFrom("vinmogate@gmail.com","NASSER GOLDSMITH & JEWELRY STORE");
                    $template = "
                    <p>Dear " . $row->Fullname . ",</p>
                    <p>We hope this email finds you well. This message is to inform you that your password has been successfully reset. Your new password is: " . $password  . ".</p>
                    <p>For security purposes, we strongly advise you to change this password once you log in to our website. To do so, please follow these steps:</p>
                    <ol>
                    <li>Visit our website at <a href='https://nassergoldsmithandjewelryshop.online/'>NASSER GOLDSMITH & JEWELRY STORE</a>.</li>
                    <li>Log in to your account.</li>
                    <li>Navigate to the \"My Account\" section.</li>
                    <li>Enter your new password and confirm it.</li>
                    <li>Save the changes.</li>
                    </ol>
                    <p>If you did not request this password reset, or if you encounter any issues, please contact our team at nassergoldsmithjewelry@gmail.com immediately.</p>
                    <p>Thank you for choosing our services. If you have any questions or need further assistance, feel free to reach out to us.</p>
                    <p>Best regards,</p>
                    <p>NASSER GOLDSMITH & JEWELRY STORE Team</p>
                    ";
                    $subject = "Password Successfully Reset";
                    $email->setSubject($subject);
                    $email->setMessage($template);
                    $email->send();
                    session()->setFlashdata('success','Password Successfully reset. Please login');
                    return redirect()->to('/request-new-password')->withInput();
                }
            }
            else
            {
                session()->setFlashdata('fail','No Record(s) found');
                return redirect()->to('/request-new-password')->withInput();
            }
        
        }
    }
}
