<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="description" content="A simple demo form, that registers a new product in my shopify store"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width,minimum-scale=1.0,initial-scale=1.0,maximum-scale=1.0,user-scalable=no' name='viewport' />
    <link rel="shortcut icon" href="assets/shopify.png"/>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="css/main.css">
    <title>Shopify Demo</title>
</head>
<body>
    <!-- full page dropzone -->
    <div id="dropzone">
        <span>You may drop the file now</span>
        <input type="file" accept="image/*">
    </div>
    
    <!-- feedback and filters -->
    <div id="loading"></div>
    
    <!-- upper title -->
    <h1><span>Shopify Demo<br><span>By Stelios Michalakis</span></span></h1> 
    
    <!-- main page frame -->
    <div id="mainframe">
        
        <!-- product info -->
        <h3>Product information</h3>
        <label>Title</label>        <input type="text" id="title" maxlength="100" placeholder="Title" autofocus>
        <label>Description</label>  <input type="text" id="description" maxlength="100" placeholder="Description">
        <label>Price</label>        <input type="text" id="price" maxlength="6" placeholder="Price" title="Must be between 0 and 999999">
        <label>Vendor</label>       <input type="text" id="vendor" maxlength="50" placeholder="Vendor">
        <label>Product type</label> <input type="text" id="type" maxlength="100" placeholder="Product type">
        <label>SKU</label>          <input type="text" id="sku" maxlength="10" placeholder="SKU" title="Only letters,digits,underscore is allowed">
            
        <!-- product image -->
        <h3 class="other">Product image</h3> 
        <!-- image by url -->
        <label>Image url<input type="radio" id="useUrl" name="file" title="Use this url as product image"></label>
        <input type="text" id="imgurl" maxlength="300" placeholder="Image url">
        <!-- image by file -->
        <label>Image file<input type="radio" id="useFile" name="file" title="Use locally selected file as product image"></label>
        <div id="filechooser">
            <input type="file" id="imgfile" accept="image/*">
            <span>Click here to select a local file<br>OR drag and drop anywhere</span>
        </div>
        
        <!-- save button -->
        <button id="save" title="Save the new product" disabled>Save product</button>
    </div>
    
    <!-- javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="js/main.js"></script>
</body>
