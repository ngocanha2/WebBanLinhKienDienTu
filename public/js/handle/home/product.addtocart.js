

const addProductToCart = (productId)=>{
    const Api = new CallApi(BASE_URL_API+PREFIX_CART)
    Api.create({
        so_luong:1,
        ma_hang:productId
    },(res)=>{
        handleCreateToast("success","Thêm sản phẩm vào giỏ hàng thàng công",null,true);            
        loadCartQuantity();
    },(res)=>{
        console.log(res)
        handleCreateToast("error",res.error,"err",true);     
    })      
}