//closure for own namespace
$(function(){

//scope reference
var $scope = this;

//validness of fields is saved here
$scope.allValid = false;
$scope.invalid = {
    fields:[],
    imgUrl:true,
    imgFile:true
};

//minimum length for field input (except price,sku)
$scope.minFieldLength = 3;

//run validators once
runValidators();
    
//set page events
setEvents();


//setup page events
function setEvents() {
    //field checks
    $('input[type=text]').not('#imgurl')
        .keyup(function(){validateField(this);})
        .bind('paste', function(){validateField(this);})
        .bind('cut', function(){validateField(this);});
    //image url checks
    $('#imgurl').keyup(validateImageUrl)
        .bind('paste', validateImageUrl)
        .bind('cut', validateImageUrl);
    //local image
    $('#imgfile').change(imageSelect);
    $('#save').click(saveProduct);
    //image usage radio option
    $('input[type=radio]').change(function(){
        $scope.imageOption = this.id;
        validateAll();
    })
    //dropzone
    $(document).on('dragover', function() {$('#dropzone').show();});
    $('#dropzone').on('drop', function(e) { $('#dropzone').hide();});
    $('#dropzone').on('dragleave', function() {$('#dropzone').hide();});
    $('#dropzone').change(imageSelect);
}

//check if a field is valid
function validateField(el) {
    var valid = false;
    //do and save validation (special for price and sku)
    if      (el.id == "price") valid = isPrice(el.value);
    else if (el.id == "sku")   valid = isSKU(el.value);
    else                       valid = ($(el).val().trim().length >= $scope.minFieldLength);
    $scope.invalid.fields[el.id] = !valid;
    //show visual feedback
    if (!valid) $(el).addClass('invalid');
    else        $(el).removeClass('invalid');
    validateAll();
    //returns whether string is a valid price
    function isPrice(str) {
        var price = parseFloat(str.trim());
        if (isNaN(price)) return false;
        return (price >= 0 && price <= 999999);
    }
    //returns whether string is a valid SKU
    function isSKU(str) {return /^\w+$/i.test(str)||str=="";}
}



//checks if url for image is valid
function validateImageUrl() {
    var $el = $('#imgurl');
    if ($scope.imgTimer) clearTimeout($scope.imgTimer);
    $('#useUrl').prop('checked',true).trigger('change');
    //delay to avoid multiple remote remote image checks when typing
    $scope.imgTimer = setTimeout(function(){
        //create element for load testing
        var img = new Image();
        img.src = $el.val().trim();
        //invalidate if error loading img
        img.onerror = function(){
            $scope.invalid.imgUrl = true;
            $el.addClass('invalid');
            validateAll();
        }
        //validate if succesfull load
        img.onload = function(){
            $scope.invalid.imgUrl = false;
            $el.removeClass('invalid');
            validateAll();
        }
    },800);
    //invalidated until load check
    $scope.invalid.imgUrl = true;
    $el.addClass('invalid');
    validateAll();
}

//checks if image file has been selected
function validateImageFile() {
    //check if img selected
    var valid = $scope.selectedImg!=undefined; 
    $scope.invalid.imgFile = !valid;
    //show the visual feedback
    if (!valid) $('#filechooser').addClass('invalid');
    else        $('#filechooser').removeClass('invalid');
    validateAll();
}

//handles local image selection
function imageSelect(evt) {
    var file = evt.target.files[0];
    //if no file, or not an image
    if (!file || !file.type.match('image.*')) return;
    $('#useFile').prop('checked',true).trigger('change');
    //read image file data
    if (window.FileReader) {
        var reader = new FileReader();
        reader.onload = function (e) {
            previewAndSave(reader.result);
        }.bind(this);
        reader.readAsDataURL(file);
    } else {
        alert('FileReader is not supported on this browser');
    }
}

//previews image and saves data for upload
function previewAndSave(imgdata) {
    var $fch = $('#filechooser');
    $fch.css('background-image','url('+imgdata+')');
    if (imgdata) $fch.addClass('hasimg');
    else         $fch.removeClass('hasimg');
    $scope.selectedImg = imgdata;
    validateImageFile();
}

//checks if everything is valid to enable saving
function validateAll() {
    var allValid = true;
    //fields validness
    for (var i in $scope.invalid.fields) 
        if ($scope.invalid.fields[i] === true) {allValid = false;break;}
    //valid image
    if (!$scope.imageOption) allValid = false;
    if ($scope.imageOption == "useFile" && $scope.invalid.imgFile) allValid = false;
    if ($scope.imageOption == "useUrl"  && $scope.invalid.imgUrl)  allValid = false;
    //leave if overall validness remained
    if ($scope.allValid == allValid) return;
    //save new validness and enable/disable button
    $scope.allValid = allValid;
    $('#save').prop('disabled',!allValid);
    console.log('all valid');
}

//tries to save the product
function saveProduct() {
    var data = {}
    //get field values
    $('input[type=text]').not('#imgurl').each(function(i,el){
        data[el.id] = el.value.trim();
    });
    //get image data
    data.imgOption = $scope.imageOption;
    data.imageUrl  = (data.imgOption=="useUrl")?$('#imgurl').val().trim():"";
    data.imageFile = (data.imgOption=="useFile")?$scope.selectedImg:"";
    //loading feedback text based on option
    var loading = (data.imgOption == "useFile") ? 
                "Uploading image<br>and creating product":"Creating product";
    $('#loading').html(loading).show();
    //save to the store
    $.ajax({
        url:'product.php?action=save',
        type:'POST', data:data
    }).done(function(resp) {
        console.log(resp);
        if (resp == "fail1") alert('Invalid product data!');
        else {
            var status = "";
            try {status = resp.split("\n")[0].split(" ")[2].trim()} catch(e){}
            if (status == "Continue" || status == "Created") success();
            else error();
        }
    }).error(error);
    //product creation success
    function success() {$('#loading').hide();alert('Product succesfully created!');resetData();}
    //product creation error
    function error() {$('#loading').hide();alert('Product creation failed, please try again');}
}

//reset all page data and fields
function resetData() {
    $('input[type=text]').val('');
    $('#filechooser').css('background-image','');
    $scope.selectedImg = undefined;
    $scope.allValid    = false;
    $scope.invalid     = {fields:[],imgUrl:true,imgFile:true};
    runValidators();
}

//runs all field validators once
function runValidators() {
    $('input[type=text]').not('#imgurl').each(function(){validateField(this);});
    validateImageUrl();
    validateImageFile();
}
    
});


