var loadinghtml = '';
var displaynum = 1;

function loadproducts(gid,pid) {
    $("#productslist").html(loadinghtml);
    $.post("order/index.php", { a: "getproducts", gid: gid },
    function(data){
        $("#productconfig1").hide();
        $("#productconfig2").hide();
        $("#productslist").html(data);
        $("#productslist").slideDown();
        if (pid) {
            $("#pid"+pid).attr('checked', true);
            loadproductconfig(pid);
        }
    });
}

function loadproductconfig(pid) {
    if (pid) var displaynum = 1; else var displaynum = 2;
    $("#productconfig"+displaynum).html(loadinghtml);
    $.post("order/index.php", 'a=getproduct&displaynum='+displaynum+'&billingcycle='+$("#billingcycle").val()+'&'+$("#orderfrm").serialize(),
    function(data){
        $("#productconfig2").hide();
        $("#productconfig"+displaynum).html(data);
        $("#productconfig"+displaynum).slideDown();
    });
    recalctotals();
}

function validatedomain() {
    $("#domainresults").html(loadinghtml);
    $("#productconfig2").slideUp();
    $.post("order/index.php", { a: "getdomainoptions", domain: $("#domain").val() },
    function(data){
        $("#domainresults").html(data);
        $("#domainresults").slideDown();
    });
}

function cyclechange() {
    $.post("order/index.php", 'a=getproduct&'+$("#orderfrm").serialize(),
    function(data){
        $("#productconfig2").html(data);
    });
    recalctotals();
}

function recalctotals() {
    $("#loader").show();
    $.post("order/index.php", 'a=cartsummary&'+$("#orderfrm").serialize(),
    function(data){
        $("#cartsummary").html(data);
        $("#loader").hide();
    });
}

function signupnew() {
    $("#newsignup").slideDown();
    $("#existinglogin").slideUp();
    $("#loginemail").rules("remove");
    $("#loginpw").rules("remove");
    $("#firstname").rules("add","required");
    $("#lastname").rules("add","required");
    $("#email").rules("add","required");
    $("#email").rules("add","email");
    $("#address1").rules("add","required");
    $("#city").rules("add","required");
    $("#state").rules("add","required");
    $("#postcode").rules("add","required");
    $("#phonenumber").rules("add","required");
    $("#phonenumber").rules("add","phonenumber");
    $("#password1").rules("add","required");
    $("#password2").rules("add",{
     required: true,
     equalTo: "#password1"
    });
}

function signupexisting() {
    $("#existinglogin").slideDown();
    $("#newsignup").slideUp();
    $("#firstname").rules("remove");
    $("#lastname").rules("remove");
    $("#email").rules("remove");
    $("#address1").rules("remove");
    $("#city").rules("remove");
    $("#state").rules("remove");
    $("#postcode").rules("remove");
    $("#phonenumber").rules("remove");
    $("#password1").rules("remove");
    $("#password2").rules("remove");
    $("#loginemail").rules("add",{
     required: true,
     email: true
    });
    $("#loginemail").rules("add","email");
    $("#loginpw").rules("add","required");
}

function currencychange() {
    $("#loader").show();
    $.post("order/index.php", 'a=cartsummary&currency='+$("#currency").val()+'&'+$("#orderfrm").serialize(),
    function(data){
        $("#cartsummary").html(data);
        $("#loader").hide();
    });
}

function applypromo() {
    $.post("order/index.php", { a: "applypromo", promocode: $("#promocode").val() },
    function(data){
        if (data) alert(data);
        else recalctotals();
    });
}

function removepromo() {
    $.post("order/index.php", { a: "removepromo", promocode: $("#promocode").val() },
    function(data){
        recalctotals();
    });
}

function selectbox(id) {
    $("#"+id).attr('checked', true);
}

function toggleaccepttos() {
    if ($("#accepttos").is(":checked")) $("#checkoutbtn").removeAttr("disabled");
    else $("#checkoutbtn").attr("disabled","disabled");
}

function checkoutvalidate() {
    $("#checkoutbtn").hide();
    $("#checkoutloading").show();
    $.post("order/index.php", 'a=validatecheckout&'+$("#orderfrm").serialize(),
    function(data){
        if (data) {
            $("#checkouterrormsg").html(data);
            $("#checkouterrormsg").slideDown();
            $('html, body').animate({scrollTop: $("#checkouterrormsg").offset().top-10}, 1000);
        } else {
            document.orderfrm.submit();
        }
    });
    $("#checkoutbtn").show();
    $("#checkoutloading").hide();
}