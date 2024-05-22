
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?=base_url('assets/Diamond Ring.ico')?>" type="image/x-icon">
    <title>Products</title>
</head>
<body>
<div><a href="<?=site_url('products')?>">Products</a></div>
<div><a href="<?=site_url('customer-orders')?>">Orders</a></div>
<div><a href="<?=site_url('sales-report')?>">Sales Report</a></div>
<table border="1" width="100%">
    <thead>
        <th>Image</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Type</th>
        <th>Unit</th>
        <th>Qty</th>
        <th>Unit Cost</th>
        <th>Total Cost</th>
        <th>On Sales</th>
        <th>More</th>
    </thead>
    <tbody>
    <?php foreach($products as $row): ?>
        <tr>
            <td><img src="<?=base_url('assets/images/product')?>/<?php echo $row->Image ?>" alt="<?php echo $row->productName ?>" style="width:50px;display: block;margin-left: auto;margin-right: auto;"/></td>
            <td><?php echo $row->productName ?></td>
            <td><?php echo $row->CategoryName ?></td>
            <td><?php echo $row->Product_Type ?></td>
            <td><?php echo $row->ItemUnit?></td>
            <td><?php echo $row->Qty ?></td>
            <td><?php echo number_format($row->UnitPrice,2) ?></td>
            <td><?php echo number_format($row->UnitPrice*$row->Qty,2) ?></td>
            <td>
                <?php if($row->onSales=="Yes"){ ?>
                    <?php echo $row->Discount*100 ?>%
                <?php }else{?>
                    -
                <?php } ?>
            </td>
            <td></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>