$(document).ready(function(){        
    const total_quantity = $("#total_quantity");
    const total_price = $("#total_price");
    const refreshTotal = ()=>{
        let totalPrice = 0;
        let totalQuantity = 0;
        const item_products = $(".item-product")
        for (let item_product of item_products) {
            item_product = $(item_product);
            const checkbox_choose = item_product.find(".checkbox_choose");
            if(checkbox_choose.is(":checked"))
            {                
                const show_quantity = item_product.find(".cart-show-quantity");                                
                let quantity = parseInt(show_quantity.val() ?? 0);
                totalPrice += quantity*parseInt(show_quantity.data("current-price"))
                totalQuantity += quantity;
            }
        }        
        total_quantity.text(totalQuantity);
        total_price.text(totalPrice.toLocaleString('de-DE'));
    }
    const ValidateQuantityCart = (items_product,checkboxCartProduct,data)=>{        
        let show_quantity = items_product.find(".cart-show-quantity");
        let btnUpdateCartQuantity = items_product.find(".btn-update-cart-quantity");   
        let infoUpdateCartQuantity = items_product.find(".item-message-update-quantity");
        let itemPresentQuantity = items_product.find(".item-present-quantity");        
        let price = parseInt(data.GiaBan);    
        show_quantity.data("present-value",data.SoLuong) 
        show_quantity.data("previous-value",data.SoLuong) 
        show_quantity.data("current-price",price)    
        show_quantity.val(data.SoLuong);    
        btnUpdateCartQuantity.slideUp();
        items_product.find(".cart-add").on("click", () => {
            let max_quantity = parseInt(itemPresentQuantity.text());
            let value = parseInt(show_quantity.val());
            value = isNaN(value) ? 0: value;
            if (value + 1 > max_quantity) {
                handleCreateToast("warning", "Đã đạt số lượng tồn tối đa", "info-"+data.MaHang,true);
                return;
            }        
            show_quantity.val(value + 1);
            if(checkboxCartProduct.is(':checked'))
                refreshTotal()
            if(parseInt(show_quantity.data("present-value")) != value+1)
                btnUpdateCartQuantity.slideDown();
            else
            {
                infoUpdateCartQuantity.slideUp();
                btnUpdateCartQuantity.slideUp();                
            }
        });
        items_product.find(".cart-minus").on("click", () => {
            let value = parseInt(show_quantity.val());
            value = isNaN(value) ? 2: value;
            if (value - 1 > 0) {            
                show_quantity.val(value - 1);
                if(checkboxCartProduct.is(':checked'))
                    refreshTotal()
                if(parseInt(show_quantity.data("present-value")) != value-1)
                    btnUpdateCartQuantity.slideDown();
                else
                {
                    infoUpdateCartQuantity.slideUp();
                    btnUpdateCartQuantity.slideUp();                
                }
            }
        });
        show_quantity.on("input", () => {
            let previousValue = parseInt(show_quantity.data("previous-value"));        
            if (show_quantity.val() !== "") {
                let max_quantity = parseInt(itemPresentQuantity.text());
                let value = show_quantity.val();                                                
                //show_quantity.val(isNaN(value) ? x : value == 0 ? 1 : show_quantity.val() > max_quantity ? max_quantity : value);
                if(!isNaN(value))
                {
                    let quantityNew = value == 0 ? 1 : value > max_quantity ? max_quantity : value
                    show_quantity.val(quantityNew);
                    show_quantity.data("previous-value",quantityNew);                
                    if(checkboxCartProduct.is(':checked'))
                        refreshTotal()
                }
                else
                    show_quantity.val(previousValue == 0 ? 1 : previousValue);      
                if(parseInt(show_quantity.data("present-value")) != show_quantity.val())
                    btnUpdateCartQuantity.slideDown();
                else
                {
                    infoUpdateCartQuantity.slideUp();
                    btnUpdateCartQuantity.slideUp();                      
                }
            }
            else
            {      
                infoUpdateCartQuantity.slideUp();      
                btnUpdateCartQuantity.slideUp();
                show_quantity.data("previous-value",0);
                if(checkboxCartProduct.is(':checked'))
                    refreshTotal()
            }
        });
        btnUpdateCartQuantity.on("click",() => {
            let so_luong_moi = parseInt(show_quantity.val()); 
            if( parseInt(show_quantity.data("present-value")) == so_luong_moi)
                return;    
            data['so_luong_moi'] = so_luong_moi;         
            CallApiCartUpdate(data.MaHang,so_luong_moi,(res)=>{                
                handleCreateToast("success","Cập nhật số lượng thành công",null,true);                         
                btnUpdateCartQuantity.slideUp();
                infoUpdateCartQuantity.slideUp();
                show_quantity.data("present-value",data.so_luong_moi);         
            },(res)=>{
                handleCreateToast("error",res.message,'error-update-quantity',true); 
            })        
        })
    }
    
    const box_show_carts = $("#box_show_carts")
    CallApiGetCarts((res)=>{
        console.log(res)
        if(res.data.length == 0 )
            return box_show_carts.html(`<center><h1>Giỏ hàng trống</h1></center>`);
        box_show_carts.html("");
        const btnClearCart = $(`<button class="btn btn-outline-danger" class="btn-delete-all-cart">Xóa tất cả</button>`)
        btnClearCart.click(()=>{
            showMessage("Thông báo","Bạn muốn xóa tất cả sản phẩm trong giỏ hàng?",()=>{
                new CallApi(PREFIX_CART)
                .patch(CLEAR,null,(res)=>{
                    handleCreateToast("success","Thao tác thành công",null,true)
                    btnClearCart.remove();
                    box_show_carts.html(`<center><h1>Giỏ hàng trống</h1></center>`);
                },(res)=>{
                    handleCreateToast("error",res.error,null,true)
                })
            })
        })
        $(".box-btn-delete-all-cart").append(btnClearCart)
        res.data.forEach(item => {
            const element = $(`<div class="row item-product" >
                                    <div class="item-product-remove">                                
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                        </svg>                                
                                    </div>
                                    <div class="row item-product-details">
                                        <a href="#" class="col-12 col-lg-6 row" style="margin-bottom:20px;">
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <input value="${item.MaHang}" name="MaHang" class="form-check-input checkbox_choose " type="checkbox" />
                                                    </div>
                                                    <div class="col-9">
                                                        <img src="/images/${item.HinhAnh}" style="width:100%; min-height:100px ; border:1px solid black">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                ${item.TenHang}                                                
                                            </div>
                                        </a>
                                        <div class="col-12 col-lg-6">
                                            <div class="row">
                                                <div class="col-md-6 gia">
                                                    <center><h4 class="giasp" title="123" style="color:crimson">${item.GiaKhuyenMai.toLocaleString('de-DE')}đ</h4></center>
                                                    ${item.TyLeGiamGia ? `<center><span class="product-price-sale" title="123">${item.GiaBan.toLocaleString('de-DE')}đ</span></center>`:""}
                                                </div>
                                                <div class="col-md-6 " style="text-align:center; justify-content:center; align-items:center;">
                                                    <div class="cart-box-edit-quantity" >
                                                        <a class="btn btn-outline-warning cart-add">+</a>
                                                        <input type="text" name="so_luong_mua" class="cart-show-quantity" />
                                                        <a class="btn btn-outline-warning cart-minus">-</a> 
                                                        <span class="item-present-quantity hidden" >${item.SoLuongTon}</span><br>
                                                        <center class="box-update-quantity">  
                                                            <span class="item-message-update-quantity" style="display: none" ><img src="${URL_HOST}FE/img/core-img/icon-warning.svg"> </span>
                                                            <button class="btn btn-outline-warning btn-update-cart-quantity">Lưu</button>                                                                                                              
                                                        </center>
                                                    </div>
                                                   
                                                </div>                                   
                                            </div>
                                            <div style="position:relative;">
                                                <span style="" class="loi_sl">Vui lòng nhập đủ số lượng nếu bạn muốn mua sản phẩm này!</span>
                                            </div>
                                        </div>  </div>                          
                                </div>`)
            const cart_box_edit_quantity = element.find(".cart-box-edit-quantity");
            const checkbox_choose = element.find(".checkbox_choose");  
            const item_product_remove = element.find(".item-product-remove");
            ValidateQuantityCart(cart_box_edit_quantity,checkbox_choose,{
                MaHang:item.MaHang,
                SoLuong:item.SoLuongTrongGio,
                GiaBan:item.GiaKhuyenMai
            })
            item_product_remove.click(function(){
                showMessage("Thông báo","Xác nhận xóa sản phẩm này khỏi giỏ hàng?",()=>{
                    CallApiCartDetele(item.MaHang,(res)=>{
                        loadCartQuantity()
                        handleCreateToast("success","Đã xóa sản phẩm khỏi giỏ hàng",null,true);
                        element.remove();  
                        refreshTotal();
                        if($(".item-product").length == 0)                        
                            box_show_carts.html(`<center><h1>Giỏ hàng trống</h1></center>`)                                             
                    },(res)=>{

                    })
                })
            })
            checkbox_choose.click(()=>{refreshTotal()})
            box_show_carts.append(element);
        });
    },(res)=>{
        console.log(res)
    })
    const btn_build_order = $("#btn_build_order");
    btn_build_order.click(()=>{
        const ma_hangs = $(".checkbox_choose:checked").map(function(){
            return $(this).val();
        }).get();
        if(ma_hangs.length == 0)
        {
            handleCreateToast("warning","Bạn chưa chọn sản phẩm nảo","warning-choose-product")
            return;
        }
        CallApiBuildOrder(ma_hangs,(res)=>{
            location.replace("/order/checkout")
        },(res)=>{
            handleCreateToast("error",res.message);
        })
    })
})

{/* <div>
<a class="sl btn btn-outline-info cong">+</a>
<input type="text" class="hienthi_sl btn input_quantity" value="${item.SoLuongTrongGio}" />
<a class="sl btn btn-outline-info tru">-</a>
</div> */}