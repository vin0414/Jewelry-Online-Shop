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
        $customerModel = new \App\Models\customerModel();
        //data
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
