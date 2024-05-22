
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?=base_url('assets/Diamond Ring.ico')?>" type="image/x-icon">
    <title>Dashboard</title>
</head>
<body>
<div><a href="<?=site_url('dashboard')?>">Dashboard</a></div>
<div><a href="<?=site_url('products')?>">Products</a></div>
<div><a href="<?=site_url('customer-orders')?>">Orders</a></div>
<div><a href="<?=site_url('customers')?>">Customers</a></div>
<div><a href="<?=site_url('sales-report')?>">Sales Report</a></div>
<div>
    <h5>New Orders</h5>
    <h1><?=number_format($order,0)?></h1>
</div>
<div>
    <h5>Monthly Income</h5>
    <h1><?=number_format($income,2)?></h1>
</div>
<div>
    <h5>Daily Income</h5>
    <h1><?=number_format($daily,2)?></h1>
</div>
<div>
    <h5>Customers</h5>
    <h1><?=number_format($customer,0)?></h1>
</div>
<ul>
    <?php foreach($products as $row):?>
        <li>
            <?php echo $row->productName ?><br/>
            <?php if($row->onSales=="Yes"){ ?>
                <small><?php echo number_format($row->UnitPrice-($row->UnitPrice*$row->Discount),2) ?><sup><?php echo $row->Discount*100 ?>% OFF</sup></small>
            <?php }else{?>
                <small><?php echo number_format($row->UnitPrice,2) ?></small>
            <?php } ?>
        </li>
    <?php endforeach;?>
</ul>
</body>
</html>
