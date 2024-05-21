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
    public function index()
    {
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
        $products = $builder->get()->getResult();
        //new products
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->WHERE('DATE_FORMAT(DateCreated,"%m")',date('m'));
        $builder->WHERE('DATE_FORMAT(DateCreated,"%Y")',date('Y'));
        $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
        $newProduct = $builder->get()->getResult();
        //featured
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->WHERE('a.feature','Yes');
        $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
        $feature = $builder->get()->getResult();
        //on sales
        $builder = $this->db->table('tblproduct a');
        $builder->select('a.*,b.CategoryName');
        $builder->join('tblcategory b','b.categoryID=a.categoryID','LEFT');
        $builder->WHERE('a.onSales','Yes');
        $builder->groupBy('a.productID')->orderBy('a.productID','DESC');
        $discounted = $builder->get()->getResult();

        $data = ['products'=>$products,'arrival'=>$newProduct,'feature'=>$feature,'discount'=>$discounted];
        return view('welcome_message',$data);
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
