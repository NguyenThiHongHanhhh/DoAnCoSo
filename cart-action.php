<?php 
    include('./config/constants.php'); 

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    $action = (isset($_GET['action'])) ? $_GET['action'] : 'add'; 

    $quantity = (isset($_GET['quantity'])) ? (int)$_GET['quantity'] : 1; // Ép kiểu số nguyên
    $sql = "SELECT * FROM tbl_products WHERE id = $id"; 

    $res = mysqli_query($conn, $sql); 
    
    if($res == TRUE){
        $row = mysqli_fetch_assoc($res);
    }

    $item = [
        'id' => $row['id'], 
        'title' => $row['title'], 
        'image_name' => $row['image_name'], 
        'price' => $row['price'], 
        'qty' => $quantity
    ];
    
    if($action == 'add'){
        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]['qty'] = (int)$_SESSION['cart'][$id]['qty'] + $quantity; // Ép kiểu số nguyên
        }else{
            $_SESSION['cart'][$id] = $item; 
        }
    }elseif($action == 'update'){
        $_SESSION['cart'][$id]['qty'] = $quantity;
    }elseif($action == 'delete'){
        unset($_SESSION['cart'][$id]);
    }

    echo("<script>location.href = '".SITEURL."cart.php';</script>");
    echo "<pre>"; 
    print_r($_SESSION['cart']);

?>


