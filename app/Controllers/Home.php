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
        $product = $productModel->WHERE('productID',$id)->first();
        $newStocks = $number + $product['Qty'];
        $values = ['Qty'=>$newStocks];
        $productModel->update($id,$values);
        echo "success";
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
                <td><?php echo $row->Total ?></td>
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
                <td></td>
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
                <td><?php echo $row->Total ?></td>
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
                <td></td>
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

    public function editAccount($id)
    {
        return view('admin/edit-account');
    }

    public function salesReport()
    {
        return view('admin/sales-report');
    }

    public function settings()
    {
        return view('admin/settings');
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

        $items = is_array(session('cart'))?array_values(session('cart')):array();
        $total = $this->total();
        $totalItem = count(is_array(session('cart'))?array_values(session('cart')):array());
        $data = ['items'=>$items,'total'=>$total,'volume'=>$totalItem,'products'=>$products];
        return view('shop',$data);
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
                $imgURL = "assets/images/logo/LOGO2-Photoroom.jpg";
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
}
