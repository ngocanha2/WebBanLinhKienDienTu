$(function(){
    const btnAddToCart = $("#btn-add-to-cart");
    const formAddProductToCart = $("#form-add-product-to-cart");
    const productId = getParamPrefix();    
    const Api = new CallApi(BASE_URL_API+PREFIX_CART)
    formAddProductToCart.on("submit",function(ev){
        ev.preventDefault();        
        let formData = $(this).serialize(); 
        formData+="&ma_hang="+productId;
        Api.create(formData,(res)=>{
            handleCreateToast("success","Thêm sản phẩm vào giỏ hàng thàng công",null,true);            
            loadCartQuantity();
        },(res)=>{
            console.log(res)
            handleCreateToast("error",res.error,"err",true);     
        })       
    })
})