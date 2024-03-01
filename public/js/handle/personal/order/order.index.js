$(()=>{
    const build = new BuildFontendRestFullApi(
        BASE_URL_API+PREFIX_PERSONAL+PREFIX_ORDER,["tab","tab-pane"],null,null,null,(item,Api)=>{                        
            let s =`<div class="box-order">
            <div class="item-order-header">
                <div class="item-order-header-left">
                    <strong class="item-order-shop-name">
                        <img  src="${URL_HOST}img/core-img/icon-box.svg" alt="">                        
                    </strong> 
                    <strong>Đơn hàng: ${item.MaDonhang}</strong>                                       
                </div>   
                <div class="item-order-header-right">
                    <strong class="item-order-shop-status">${item.TrangThai}</strong> | 
                    <a href="#">Đánh giá</a>                                    
                </div>  
            <div style="clear: both"></div>                           
            </div>
            <div class="item-order-content">
                    </div>
                        <div class="item-order-footer">
                            <hr>
                            <div class="item-order-footer-left">
                                <span class="item-product-total">Thành tiền<span> [x<span class="total-quantity"></span>]: ${item.ThanhTien.toLocaleString("de-DE")}đ</span></span><br>
                                <span class="item-order-footer-left-review">Không nhận được đánh giá</span>
                            </div>
                            <div class="item-order-footer-right">`
                            if(item.TrangThai == "Đã giao" || item.TrangThai == "Đã hủy")                            
                                s+=`<button class="btn-order-repurchase">Mua lại</button>`                                                                        
                                s+=`<a class="btn-order-detail" href="/personal/order/${item.MaDonhang}">Xem chi tiết</a>
                            </div>
                            <div style="clear: both"></div>
                        </div>
                    </div>`;
                const element = $(s);
                const itemOrderContent = element.find(".item-order-content");                
                    Api.show(item.MaDonhang,(res)=>{                                                                   
                        let totalQuantity = 0;                                                
                        let chiTietDonHangs = res.data.chitietdonhangs
                        chiTietDonHangs.forEach(chiTietDonHang=>{                            
                            totalQuantity+=chiTietDonHang.SoLuong;                                                        
                            s=`<div class="item-order-product">
                                    <div class="row">
                                        <div class="col-lg-2 col-xxl-1 col-md-3 col-sm-4 col-5">
                                            <div class="image-product" style="background: url(${URL_HOST}images/${chiTietDonHang.HinhAnh}); background-size: cover; ">                                                
                                            </div>
                                        </div>
                                        <div class="col-lg-10 col-xxl-11 col-md-9 col-sm-8 col-7">
                                            <strong class="item-product-name">${chiTietDonHang.TenHang}</strong><br>
                                            <span class="item-product-classify">${(chiTietDonHang.DonGia).toLocaleString("de-DE")}đ</span><br>
                                            <span class="item-product-quantity">x ${chiTietDonHang.SoLuong}</span>
                                            <strong class="item-product-price">${(chiTietDonHang.SoLuong*chiTietDonHang.DonGia).toLocaleString("de-DE")}đ</strong>
                                        </div>
                                    </div>
                                </div>`
                            itemOrderContent.append(s);
                        });   
                        element.find(".total-quantity").text(totalQuantity);
                    },(res)=>{                
                        console.log(res)
                    });
            return element;
    })
    build.handle();   
})