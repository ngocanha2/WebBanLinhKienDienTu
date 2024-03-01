//item-shop-order-setup-info-address.data("address-id")
var address_list = null;
var total = 0;
var transportCost = 0;
var discount = 0;
const address_for_all_info = $(".box-address-shared")
const checkAuth = $(".address-info-auth-none");
const modalChooseAddress = $("#modal-choose-address");
const modelBoxUpdateAddress = $('#box-update-address');
// const btnAddAddress = $("#btn-add-address");
//address_id: trường hợp khi cần thay đổi nội dung địa chỉ load lại dữ liệu
var ShowAddressOption = (idbinding=null,buildEvent = true,idUpdate = null)=>{
    GetAddressAll(function(res){        
        address_list = res.data;
        let box_address_list = $("#box-address-list");  
        box_address_list.html("") 
        if(res.data.length == 0)
        {            
            modelBoxUpdateAddress.attr('data-bs-backdrop', 'static');
            modelBoxUpdateAddress.modal('show');
            modelBoxUpdateAddress.find(".modal-title").html("Vui lòng tạo 1 địa chỉ giao hàng để tiến hành đặt hàng!!!");
            modelBoxUpdateAddress.find(".btn-close").remove();
            modelBoxUpdateAddress.find("#btn-cancel").remove();
            modelBoxUpdateAddress.find("#btn-confirm-address").text("Thêm")
            createEventFormUpdateAddress(null,null,()=>{
                setTimeout(()=>{
                    location.reload();
                },500)
            });
            
        }
        else if(buildEvent)
        {
            createEventFormUpdateAddress(
                function(updateId){
                    console.log(updateId)            
                    ShowAddressOption(address_for_all_info.data("address-id"),false,updateId)
                    modalChooseAddress.modal("show")
                    modelBoxUpdateAddress.modal("hide")
                },
                function(item_update){
                $(".item-address-default-title").remove();
                item_update.append($(`<div class="item-address-default-title">Mặc định</div>`))    
                },()=>{
                    setTimeout(()=>{
                        location.reload();
                    },500)
            });
            
        }
        res.data.forEach(item=>{            
            let div_address = $(`<div class="item item-address w-100 row" id="id${item.MaDiaChi}">
                                    <div class="col-11">
                                    <span class="item-address-receiver item-address-recipient-name">${item.TenNguoiNhan}</span> | <span class="item-address-phone item-address-phone-number">${item.SDT}</span> | 
                                    <a class="btn-address-update" data-bs-toggle="modal" data-bs-target="#box-update-address" href="">Cập nhật</a>
                                    <div class="item-address-type">
                                        Nhà riêng
                                    </div>                                            
                                    <span class="item-address-info">${item.DiaChi}</span><br />
                                    <span class="item-address-material item-address-detail">${item.DiaChiCuThe}</span>
                                    - <span class="item-address-mesage item-address-note">${item.GhiChu ?? "---"}</span>
                                </div>
                                <div class="col-1">                                            
                                </div>                                             
                                <input class="form-check-input item-address-radio" type="radio" name="dia_chi">
                                </div>`);   
            div_address.data("address-id",item.MaDiaChi);
            let item_address_radio = div_address.find(".item-address-radio") 
            item_address_radio.data("address-id",item.MaDiaChi)          
            div_address.find(".btn-address-update").click(function(){
                loadDataAddressUpdate(item);
            })
            if((item.MacDinh && buildEvent == true) || (buildEvent == false && idUpdate != null && address_for_all_info.data("address-id") == idUpdate && item.MaDiaChi == idUpdate))
            {                        
                const addressDefault = buildAddressDefault(item)                    
                address_for_all_info.html(addressDefault);
                address_for_all_info.data("address-id",item.MaDiaChi)
            } 
            if(item.MacDinh)                        
            {
                div_address.append(`<div class="item-address-default-title">Mặc định</div>`);
                box_address_list.prepend(div_address);                
            }
            else
                box_address_list.append(div_address);              
            if(idbinding && idbinding == item.MaDiaChi)
                item_address_radio.prop("checked",true)  
            div_address.on("click",function(){
                item_address_radio.prop("checked",true)
            })                     
        })       

        let item_address = $(".item-address")
        address_for_all_info.find(".change-address-link").on("click",()=>{            
            let current_address_id = address_for_all_info.data("address-id");
            for (let item of item_address) {
                let id = $(item).data("address-id");            
                if(current_address_id == id)
                {
                    $(item).find(".item-address-radio").click();             
                    return;
                }
            }       
        }); 
    },"Bạn chưa tạo địa chỉ giao hàng nào, vui lòng tạo địa chỉ để tiếp tục thao tác!!!","Đã xảy ra lỗi");    
}
const buildAddressDefault = (item)=>{
    return $(`<div class="row" id="address-for-all-info" >
                <p style="margin-bottom:5px; font-size:17px;"><b class="receiver" id="receiver-all">${item.TenNguoiNhan}</b> | <span class="phone-number" id="phone-number-all">${item.SDT}</span></span></p>
                <div class="item-address-type">
                    <b class="address-type" id="address-type-all">Nhà riêng</b>
                </div>
                <div>
                    (<span id="address-material-all" class="item-address-material address-material">${item.DiaChiCuThe}</span>)<br>
                    <span class="address-detail-all address">${item.DiaChi}</span><br>
                    <span class="item-address-mesage address-message" id="address-mesage-all">${item.GhiChu ? "("+item.GhiChu+")":""}</span>
                </div>
                <div class="col-6">
                    <button data-bs-toggle="modal" class="change-address-link" data-bs-target="#modal-choose-address">Thay đổi</button>
                </div>
            </div>`)
}



CallApiOrderCheckout((res)=>{
    console.log(res);
    BuildAllItemPackage(res.data);
    if(checkAuth.length == 0)
        ShowAddressOption();
    // $("#total").text(total.toLocaleString('de-DE')+"đ");
},(res)=>{
    console.log(res);
    $("#body-order").html(`<center>${res.message}</center>`)
})


// var CreateEvent = (address_for_all,data)=>{    
//     address_for_all.prop("checked", true);
//     let item_shop_order_setup_info_address = $(".item-shop-order-setup-info-address");
//     address_for_all.on("change",()=>{
//         if(address_for_all.is(":not(:checked)"))
//         {
//             // let dia_chi_id = $("#address-for-all-info").data("address-id");
//             // for (let i = 0; i < data.length; i++) {   
//             //     id_str = JsonParseStr(data[i].id);             
//             //     if(id_str == dia_chi_id)      
//             //     {
//                     item_shop_order_setup_info_address.each(function(){                                             
//                         $(this).slideDown();
//                         //DataDumpAddress($(this),data[i]);                                                                                                                                                                                                
//                     }) 
//                     $("#address-for-all-info").slideUp();
                   
//             //     }
//             // }                        
//         }
//         else
//         {
//             item_shop_order_setup_info_address.each(function(){                                                         
//                 $(this).slideUp();                                                                
//             })    
//             $("#address-for-all-info").slideDown();
//         }  
//     })
// }

var DataDumpAddress = (doc,data)=>{
    doc.find(".receiver").text(data.TenNguoiNhan);
    doc.find(".phone-number").text(data.SDT);
    doc.find(".address").text(data.DiaChi);
    doc.find(".address-material").text(data.DiaChiCuThe);
    doc.find(".address-message").text(data.GhiChu ? `(${data.GhiChu})`: "");
    if((addressType=doc.find(".address-type"))!=null)
        addressType.text(data.LoaiDiaChi);        
    doc.data("address-id",data.MaDiaChi);
}

var BuildAllItemPackage = (data)=>{        
    let s =""                
    let item_shop_order_products = $("#item-shop-order-products")
    let tatolQuantity = 0; 
    let tatolPackage = 0; 
    // item_order.data("shop-id",cua_hang_id);    
    // item_order.data("object-ids",cua_hang_id)  
    data.forEach(item=>{                
        tatolQuantity+= item.SoLuongTrongGio;
        tatolPackage+=item.GiaKhuyenMai*item.SoLuongTrongGio;               
        s=`<div class="row w-100 item-order" style="min-height:170px;">
                <div class="col-xl-3 col-lg-4 col-sm-3 col-12">
                    <div class="item-shop-order-avatar" style="background: url(${URL_HOST}images/${item.HinhAnh}); background-size:cover;">                                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 col-sm-9 col-12 row">
                    <strong href="" class="item-shop-order-product-title w-100">${item.TenHang}</strong>                                
                    <div class="col-sm-7 col-12">  
                    <span class="item-shop-order-product-classify">${item.GiaKhuyenMai.toLocaleString("DE-de")}đ</span>
                    <span class="price-sale">${item.GiaBan != item.GiaKhuyenMai ? item.GiaBan.toLocaleString("DE-de") : ""}</span>                                            
                        <br>
                        <span>SL: x <span>${item.SoLuongTrongGio}</span></span>
                    </div>                                
                    <div class="col-sm-5 col-12">
                        <span class="item-shop-order-product-price">${(item.GiaKhuyenMai*item.SoLuongTrongGio).toLocaleString("DE-de")}đ</span>
                    </div>  
                </div>                
            </div>
            <div class="line-bottom"></div>`
        var order_product = $(s);
        // item_order.data("object-ids",item_order.data("object-ids")+"-"+JsonParseStr(item.san_pham.danh_muc_id))            
        item_shop_order_products.append(order_product);  
    })   
    $("#total-quantity").text(tatolQuantity)
    $("#total-pay-info-result-money").text(tatolPackage.toLocaleString("DE-de") + "đ")
    $("#btn-confirm-address").on("click",()=>{
        let address_id_select = $(".item-address-radio:checked").data("address-id")

        console.log(address_id_select)
        for (let address of address_list) {                      
            if(address.MaDiaChi == address_id_select)
            {                
                // var item_shop_orders = $(".item-shop-order")
                // for (var item_order of item_shop_orders)
                // {  
                //     item_order.find(".item-shop-order-setup-info-address").data("address-id",address_id_select)
                // }
                return DataDumpAddress(address_for_all_info,address);                
            }
        }  
    })  
    // LoadShippingMethod() 
    // // createEventChooseshopbeeVoucher()
    // loadEventShopbeeVoucher(data)
    createEventBtnSubmit()  
}

// var loadVoucherShop = (cua_hang_id,tatolPackage,item_order)=>{    
//     var btn_show_box_voucher_shop = item_order.find(".btn-show-box-voucher-shop");
//     var box_shop_order_option_voucher = item_order.find(".box-show-shop-order-option-voucher");
//     btn_show_box_voucher_shop.click(function(){    
//         $(this).text($(this).text() == "Ẩn" ? "Chọn" : "Ẩn")    
//         if(box_shop_order_option_voucher.data("load")!=true)
//         {            
//             discount[cua_hang_id] = 0;
//             let box_shop_order_option_voucher_content = item_order.find(".box-shop-order-option-voucher-content");
//             getAllVoucher(cua_hang_id,function(data){
//                 box_shop_order_option_voucher_content.html("")
//                 let countVoucher = 0;
//                 data.forEach(item=>{
//                     let ngay_bat_dau = ConvertDate(item.ngay_bat_dau);
//                     let ngay_ket_thuc = ConvertDate(item.ngay_ket_thuc);
//                     if(ngay_ket_thuc > TODAY)
//                     {
//                         countVoucher++;
//                         ngay_ket_thuc = ConvertDateTimeToString(item.ngay_ket_thuc);
//                         let box = `<div class="col-12 col-sm-6 col-md-12 box-voucher-shop-option">                                                         
//                                         <div class="box-voucher-shop ">     
//                                             <input class="item-voucher-radio-select" name="voucher_${cua_hang_id}" type="radio" value="${item.ma_khuyen_mai}">                                                                                              
//                                             <div class="item-voucher-avatar">
//                                                 <div class="item-voucher-avatar-image" style="background: url({{ asset('system/hhgt-1.png') }}); background-size:cover;"></div>
//                                             </div>
//                                             <div class="item-voucher-content">
//                                                 <strong>Giảm ${item.ty_le_giam_gia*100}%</strong>
//                                                 <br>
//                                                 <span class="item-voucher-content-title">Đơn tối thiểu ${parseInt(item.don_hang_toi_thieu/1000)}k</span>
//                                                 <br>
//                                                 <span class="item-voucher-content-title">Giảm tối đa ${parseInt(item.muc_giam_toi_da/1000)}k</span>
//                                                 <br>
//                                                 <span class="item-voucher-content-duration">Hạn: ${ngay_ket_thuc}</span>
//                                             </div>                                                
//                                             <div class="clear-both"></div>                                                
//                                         </div>                                        
//                                     </div>`
//                         let element = $(box);
//                         element.data("voucher-code",item.ma_khuyen_mai)
//                         let item_voucher_radio_select = element.find(".item-voucher-radio-select");
//                         let box_voucher_shop = element.find(".box-voucher-shop");
//                         if(ngay_bat_dau > TODAY || item.don_hang_toi_thieu > tatolPackage)
//                         {                                              
//                             item_voucher_radio_select.attr("name","")
//                             item_voucher_radio_select.attr("value","-")
//                             item_voucher_radio_select.attr("disabled",true)
//                             item_voucher_radio_select.attr("readonly",true);
//                             box_voucher_shop.addClass("box-voucher-shop-disabled")
//                             if(item.don_hang_toi_thieu > tatolPackage)
//                             {
//                                 element.append($(`<div class="item-voucher-review-need-more">
//                                                     Cần mua thêm ${parseInt((item.don_hang_toi_thieu-tatolPackage)/1000)}k nữa
//                                                 </div>`))
//                             }
//                             else
//                             {
//                                 element.append($(`<div class="item-voucher-review-need-more">
//                                                     Ngày bắt đầu: ${ConvertDateTimeToString(item.ngay_bat_dau)}
//                                                 </div>`))
//                             }
//                         }
//                         else
//                         {
//                             let sale = (tatolPackage*item.ty_le_giam_gia)  
//                             sale = sale > item.muc_giam_toi_da ? item.muc_giam_toi_da : sale;                        
//                             box_voucher_shop.addClass("box-voucher-shop-hover");                            
//                             element.click(function(){
//                                 item_voucher_radio_select[0].checked = true;
//                                 item_order.data("sale",sale)
//                             })         
//                             item_voucher_radio_select.change(function(){
//                                 item_order.data("sale",sale)
//                             })                   
//                         }                            
//                         box_shop_order_option_voucher_content.append(element)
//                     }                     
//                 })
//                 if(countVoucher > 0)
//                 {
//                     let btn_apply_voucher  = item_order.find(".btn-apply-voucher");
//                     btn_apply_voucher.click(function(){
//                         radio_voucher_change = $(`input[name="voucher_${cua_hang_id}"]:checked`);
//                         if(radio_voucher_change.length)
//                         {
//                             item_order.find(".item-shop-order-setup-info-id-voucher-shop").text(radio_voucher_change.val())
//                             discount[cua_hang_id] = item_order.data("sale")
//                             item_order.find(".item-shop-order-setup-info-data-discount-value").text("-"+discount[cua_hang_id].toLocaleString("de-DE")+"đ")
//                             item_order.find(".item-shop-order-setup-info-data-total").text((tatolPackage-discount[cua_hang_id]).toLocaleString("de-DE")+"đ")  
//                             item_order.data("shop-voucher-code",radio_voucher_change.val())                                                        
//                             reloadDiscount()
//                             reloadTotalMoneyAll();                                  
//                         }          
//                         else
//                         {
//                             handleCreateToast("info","Bạn chưa chọn voucher nào",`mess-voucher-${cua_hang_id}`)
//                         }              
//                         box_shop_order_option_voucher.slideUp()
//                         btn_show_box_voucher_shop.text("Chọn")   
//                     })
//                     var box_shop_order_option_voucher_search_input = item_order.find(".box-shop-order-option-voucher-search-input");
//                     box_shop_order_option_voucher_content.append(`<center class="title-is-impty-voucher" style="display:none">Không tìm thấy voucher</center>`)                    
//                     var title_is_impty_voucher = item_order.find(".title-is-impty-voucher");
//                     var box_voucher_shop_options = item_order.find(".box-voucher-shop-option");
//                     box_shop_order_option_voucher_search_input.on("input",function(){ 
//                         let show_voucher = false; 
//                         $(this).val($(this).val().trim())                      
//                         box_voucher_shop_options.each(function(){
//                             if($(this).data("voucher-code").match(box_shop_order_option_voucher_search_input.val()))
//                             {
//                                 $(this).slideDown()
//                                 show_voucher = true;                                
//                             }
//                             else
//                                 $(this).slideUp()   
//                         })
//                         if(!show_voucher)
//                             title_is_impty_voucher.slideDown();
//                         else
//                             title_is_impty_voucher.slideUp();
//                     })
//                     box_shop_order_option_voucher.data("load",true)
//                 }
//                 else                
//                     box_shop_order_option_voucher_content.html("<center>Không có voucher</center>")                
                
//             })                        
//         }        
//         box_shop_order_option_voucher.slideToggle();
//     })
// }
// var CurrentStoreDestination = (doc)=>{        
   
// }





//xử lý vận chuyển
var LoadShippingMethod = ()=>{        
    GetAllShippingMethod(function(data){ 
        var box_show_shipping_method =$("#box-show-shipping-method");
        box_show_shipping_method.html("")
        data.forEach(item=>{
            let phuong_thuc_van_chuyen_id = JsonParseStr(item._id);
            s=`<div class="item-shipping-method" >                
                    <div class="item-shipping-method-left">
                        <span class="shipping-method-name">${item.ten_phuong_thuc_van_chuyen}</span> | +<span class="shipping-method-fee">${item.chi_phi.toLocaleString("de-DE")}đ</span>
                        <br>
                        <span class="shipping-method-estimate-time-title">Nhận hàng vào khoảng <span class="shipping-method-estimate-time">${item.thoi_gian_uoc_tinh}</span> ngày nữa</span>
                        <br>
                        <span class="shipping-method-co-check">${item.dong_kiem ? "Cho phép đồng kiểm":"-"}</span>
                    </div>
                    <div class="item-shipping-method-right"> 
                        <input type="radio" name="phuong_thuc_van_chuyen_id">                  
                    </div>
                    <div style="clear: both"></div>
                </div> `;
            var item_shipping_method = $(s);
            let radio_shipping_method = item_shipping_method.find(`input[name="phuong_thuc_van_chuyen_id"]`);  
            radio_shipping_method.val(phuong_thuc_van_chuyen_id);
            if(item.mac_dinh)
            {                
                radio_shipping_method[0].checked = true;
                item_shipping_method.addClass("active")                
                $(".item-shop-order").each(function(){                                        
                    transportCost +=item.chi_phi;
                    $(this).data("object-ids", $(this).data("object-ids")+$(this).data("shop-id")+":["+phuong_thuc_van_chuyen_id+"]")                    
                    setTextDataShippingMethod($(this),item)                    
                })
                reloadTotalMoneyAll()
                reloadTransportCost()
            }                      
            item_shipping_method.click(function(){                         
                radio_shipping_method[0].checked = true;                              
                radio_shipping_method[0].click();                            
            })
            radio_shipping_method.click(function(){
                if($(this).is(":checked"))
                {
                    $(".item-shipping-method.active").removeClass("active")
                    item_shipping_method.addClass("active")
                }
            })
            box_show_shipping_method.append(item_shipping_method)
        })
        var btn_confirm_shipping_method = $("#btn-confirm-shipping-method")        
        btn_confirm_shipping_method.click(function(){
            let cua_hang_id = btn_confirm_shipping_method.data("object-shop-exist");
            var item_order = $(`#order-shop-${cua_hang_id}`);
            let radio_shipping_method_checked = $(`input[name="phuong_thuc_van_chuyen_id"]:checked`);  
            if(radio_shipping_method_checked)
            {
                resetShopbeeVoucher()
                $("#btn-close-box-shipping-method").click()
                for (let i = 0; i < data.length; i++) {
                    const item = data[i];
                    phuong_thuc_van_chuyen_id = JsonParseStr(item._id)
                    if(phuong_thuc_van_chuyen_id==radio_shipping_method_checked.val())                                                                        
                    {         
                        let transportCostOld = item_order.data("chi_phi_phuong_thuc_van_chuyen")                         
                        reloadTransportCost(transportCost - transportCostOld + item.chi_phi)
                        reloadTotalMoneyAll()
                        let objectIds = item_order.data("object-ids");
                        let indexShip = objectIds.indexOf("|");
                        let payId = objectIds.substring(objectIds.indexOf("="),objectIds.length+1)
                        objectIds = objectIds.substring(0,indexShip) + ":["+phuong_thuc_van_chuyen_id+"]"+payId;
                        item_order.data("object-ids",objectIds)                        
                        return setTextDataShippingMethod(item_order,item)                                                                  
                    }
                    
                }                                
            }            
        })
        LoadPaymentMethod()
    })
}

var reloadTotalMoneyAll = ()=>{
    $("#total-pay-info-result-money").text((total+discount).toLocaleString('de-DE')+"đ");
}
var reloadDiscount = ()=>{    
    $("#discount").text("-"+(discount).toLocaleString('de-DE')+"đ");
    // $("#discount_phuong_thuc_van_chuyen").text("-"+(discount["phuong_thuc_van_chuyen"] ?? 0).toLocaleString('de-DE')+"đ")
    // $("#discount_don_hang").text("-"+(getDiscountOrder()).toLocaleString('de-DE')+"đ")
}
// var getDiscountOrder = () =>{
//     let totalDiscountOrder = 0;
//     for (const key in discount) {
//         if (Object.hasOwnProperty.call(discount, key) && key!="phuong_thuc_van_chuyen") {            
//             totalDiscountOrder += discount[key];
//         }
//     }
//     return parseInt(totalDiscountOrder);
// }
// var getTotalDiscount = ()=>{
//     let totalDiscount = 0;
//     for (const key in discount) {
//         if (Object.hasOwnProperty.call(discount, key)) {            
//             totalDiscount += discount[key];
//         }
//     }
//     return parseInt(totalDiscount);
// }


//xử lý phương thức thanh toán
// var LoadPaymentMethod = ()=>{
//     const box_payment_methods = $("#box-payment-methods");
//     GetAllPaymentMethod(function(data){
//         box_payment_methods.html("")
//         data.forEach(item=>{
//             let phuong_thuc_thanh_toan_id = JsonParseStr(item._id)
//             let s = `<div class="col-lg-12 col-sm-6 padding-0">
//                         <div class=" row total-pay-info-payment-methods-item padding-0">
//                             <div class="col-11 total-pay-info-payment-methods-label"  >
//                                 <label for="payment-method-${phuong_thuc_thanh_toan_id}"> 
//                                     <img src="${URL_HOST}pay/momo.png" alt="" style="background-size: cover"> 
//                                     ${item.ten_phuong_thuc_thanh_toan}
//                                 </label>                                         
//                             </div>
//                             <div class="col-1 padding-0 total-pay-info-payment-methods-input">
//                                 <input  type="radio" name="phuong_thuc_thanh_toan_id" id="payment-method-${phuong_thuc_thanh_toan_id}" value="${phuong_thuc_thanh_toan_id}">
//                             </div>
//                             <br>                                    
//                         </div>     
//                     </div>`
//             var element = $(s);  
//             if(item.mac_dinh)
//             {
//                 element.find(`#payment-method-${phuong_thuc_thanh_toan_id}`).prop("checked",true);
//                 buildIdPaymentMethod(phuong_thuc_thanh_toan_id)
//             }                        
//             element.click(function(){
//                 var check_pay_method = $(this).find(`input[type="radio"]`)
//                 check_pay_method[0].checked = true;
//                 buildIdPaymentMethod(check_pay_method.val()) 
//                 resetShopbeeVoucher();              
//             })
//             box_payment_methods.append(element);
//         })
//     });
// }




// var buildIdPaymentMethod = (id)=>{
//     var item_shop_orders = $(".item-shop-order")    
//     item_shop_orders.each(function(){
//         let objectIds = $(this).data("object-ids");
//         indexPay = objectIds.indexOf("=")
//         if(indexPay == -1)
//             $(this).data("object-ids",objectIds+"="+id);
//         else 
//             $(this).data("object-ids",objectIds.substring(0,indexPay)+"="+id);                    
//     })    
// }



// var createEventChooseshopbeeVoucher = ()=>{
//     const box_show_shopbee_voucher = $("#box-show-shopbee-voucher");
//     getAllVouchershopbee(function(data){
//         box_show_shopbee_voucher.html("")
//         let countVoucher = 0;
//         data.forEach(item=>{
//             if(ConvertDate(item.ngay_ket_thuc)>TODAY)
//             {
//                 let ngay_bat_dau = ConvertDateTimeToString(item.ngay_bat_dau)
//                 let ngay_ket_thuc = ConvertDateTimeToString(item.ngay_ket_thuc)
//                 let s = `<div class="voucher">
//                             <div class="item pad w-100">
//                                 <div class="row">
//                                     <div class="col-6" style="border-right:1px dashed #999999; padding: 0px 5px;">
//                                         <span class="shopbee-voucher-name">${item.ten_voucher}</span><br />
//                                         <a>
//                                             Giảm 
//                                             <span class="shopbee-voucher-discount-rate">
//                                                 ${item.ty_le_giam_gia * 100}%,
//                                             </span> tối đa 
//                                             <span class="shopbee-voucher-maximum-reduction">
//                                                 ${parseInt(item.muc_giam_toi_da/1000)}k
//                                             </span> cho đơn hàng từ ${parseInt(item.don_hang_toi_thieu/1000)}k
//                                         </a><br />
//                                         <div class="shopbee-voucher-box-quantity">
//                                             <span class="shopbee-voucher-quantity-title">Còn: <span class="shopbee-voucher-quantity">${item.so_luong}</span></span>
//                                         </div>
//                                     </div>
//                                     <div class="col-6 p-0">
//                                         <div class="shopbee-voucher-box-timeout">
//                                             <span class="shopbee-voucher-timeout">HSD: ${ngay_ket_thuc}</span>
//                                         </div>
//                                         <div class="shopbee-voucher-box-code">
//                                             <strong class="shopbee-voucher-code">daylâmvoucher</strong>
//                                         </div>
//                                         <input class="form-check-input shopbee-voucher-radio" type="radio" name="ma_voucher" value="${item.ma_voucher}">
//                                     </div>
//                                 </div>
//                             </div>                                                                                                            
//                         </div>`;
//                 var element = $(s);
//                 if(item.don_hang_toi_thieu > total || ConvertDate(item.ngay_bat_dau)>TODAY)
//                 {                    
//                     element.find(".item").addClass("voucher-disabled")
//                     element.append(`<div class="shopbee-voucher-unqualified">
//                                         ${ item.don_hang_toi_thieu > total ? `Mua thêm ${parseInt((item.don_hang_toi_thieu - total)/1000)}k nữa để có thể sử dụng được Voucher này!!`:`Chương trình bắt đầu lúc ${ngay_bat_dau}`}
//                                     </div>`)
//                     let radio_shopbee_voucher =  element.find(`input[name="ma_voucher"]`);
//                     radio_shopbee_voucher.attr("type","text")
//                     radio_shopbee_voucher.prop("disabled",true)
//                     radio_shopbee_voucher.val("");

//                 } 
//                 else
//                     countVoucher++;                               
//                 element.click(function(){
//                     element.find("input[type='radio']")[0].checked = true;
//                 })                
//                 box_show_shopbee_voucher.append(element);                              
//             }            
//         })
//         var btn_apply_shopbee_vouche = $("#btn-apply-shopbee-voucher");
//         if(countVoucher > 0)
//         {
//             btn_apply_shopbee_vouche.click(function(){
//                 let radio_shopbee_voucher =  $(`input[name="ma_voucher"]:checked`);
//                 if(radio_shopbee_voucher.length)                
//                     for (const item of data) {
//                         if(item.ma_voucher == radio_shopbee_voucher.val())
//                         {
//                             let discountShopbee = total * item.ty_le_giam_gia;
//                             discountShopbee = discountShopbee <= item.muc_giam_toi_da ? discountShopbee : item.muc_giam_toi_da;
//                             let discount_old = $("#shopbee-voucher-code").data("discount");
//                             discount_old = discount_old ?? 0;                            
//                             $("#shopbee-voucher-code").data("discount",discountShopbee);
//                             $("#shopbee-voucher-code").val(item.ma_voucher)
//                             reloadDiscount(discount - discount_old + discountShopbee)
//                             reloadTotalMoneyAll();
//                             return;                            
//                         }
//                     }
//             })
//         }
//         else
//             btn_apply_shopbee_vouche.remove()
        
//     })
// }


// var resetShopbeeVoucher = ()=>{
//     if($("#shopbee-voucher-code").find("input").length>0)
//     {
//         $("#shopbee-voucher-code").html("Chọn/Nhập mã");
//         var item_shop_orders = $(".item-shop-order")
//         for (var item_order of item_shop_orders)
//         {                       
//             item_order = $(item_order)        
//             item_order.data("shopbee-voucher-code-don_hang","");              
//             item_order.data("shopbee-voucher-code-phuong_thuc_van_chuyen","");  
//             console.log(item_order.data("shopbee-voucher-code-phuong_thuc_van_chuyen"))               
//             for (const key in discount) {
//                 if(key.indexOf("_")!=-1)
//                 {                    
//                     let discount_old = item_order.data("discount-"+key) ?? 0; 
//                     discount[key] -= discount_old                    
//                     item_order.data("discount-"+key,0);    
//                     item_order.find(`.line-through-`+key).removeClass("line-through")               
//                     item_order.find(`.discounted-`+key).text("")
//                 }                
//             }                                                                                                                               
//         }   
//         reloadDiscount()
//         reloadTotalMoneyAll(); 
//     }                                 
// }




var createEventBtnSubmit = (dataOrder,dataShopbeeVoucher)=>{      
  
    const button_submit_total_pay = $(".button-submit-total-pay");
    button_submit_total_pay.click(()=>{                
        if(checkAuth.length && CheckValidate().indexOf(false) !=-1)
        {
            handleCreateToast("error","Vui lòng kiểm tra lại thông tin giao hàng","check-address-info");          
            return;           
        } 
        showMessage("Đặt hàng","Xác nhận đặt đơn hàng này",function(){   
            let data = checkAuth.length ? $('#form-address').serialize() : ("MaDiaChi="+address_for_all_info.data("address-id")) 
            data+="&VanChuyen="+$(`input[name="van_chuyen"]:checked`).val()
            data+="&ThanhToan="+$(`input[name="thanh_toan"]:checked`).val()
            // let dataOrderDeepCoppy = _.cloneDeep(dataOrder)
            // var item_shop_orders = $(".item-shop-order")
            // var phuong_thuc_thanh_toan_id = $(`input[name="phuong_thuc_thanh_toan_id"]:checked`).val()
            // for (let orderShop of dataOrderDeepCoppy) {               
            //     var cua_hang_id = JsonParseStr(orderShop._id)
            //     const item_order = $(`#order-shop-${cua_hang_id}`);
            //     if(item_shop_orders.length == 1 || $("#one-address-for-all").is(":checked"))
            //         orderShop["dia_chi_giao_hang_id"] = $("#address-for-all-info").data("address-id")
            //     else                                    
            //         orderShop["dia_chi_giao_hang_id"] = item_order.find(".item-shop-order-setup-info-address").data("address-id")                                             
            //     if(item_order.data("shop-voucher-code")!=undefined)
            //         orderShop["ma_voucher_cua_hang"] = item_order.data("shop-voucher-code")                
            //     let shopbeeVouchers = new Array();
            //     for (const item of dataShopbeeVoucher) {                    
            //         shopbeeVoucherCode = item_order.data("shopbee-voucher-code-"+item.loai_chi_phi_ap_dung);
            //         if(shopbeeVoucherCode)
            //             shopbeeVouchers.push(shopbeeVoucherCode)
            //     }        
            //     if(shopbeeVouchers.length>0)                                            
            //             orderShop["vouchers"] = shopbeeVouchers 
            //     let input_note = $(`input[name="loi_nhan_${cua_hang_id}"]`)
            //     if(input_note.val().trim()!="")
            //         orderShop["loi_nhan"] = input_note.val().trim() 
            //     orderShop["phuong_thuc_van_chuyen_id"] = item_order.data("shipping-method-id");
            //     orderShop["phuong_thuc_thanh_toan_id"] = phuong_thuc_thanh_toan_id
            // }                    
            return CreateOrder(data)                     
        })
    })
}

var CreateOrder = (dataAddress)=>{   
    console.log(dataAddress) 
    CallApiOrderPostCheckout(dataAddress,(res)=>{
        console.log(res) 
        location.replace(res.data.url)
        // location.replace(URL_HOST+PREFIX_ORDER+PREFIX_SUCCESS)
    },(res)=>{
        console.log(res)
        handleCreateToast("error",res.error ?? res.errors);
    })
}


// var loadEventShopbeeVoucher = (dataOrder)=>{    
//     getShopbeeVouchers(function(data){        
//         creeateEventShowShopbeeVoucher(data);
//         var btn_apply_shopbee_vouche = $("#btn-apply-shopbee-voucher");
//         if(data.length > 0)
//         {
//             var shopbee_voucher_code = $("#shopbee-voucher-code");
//             var item_shop_orders = $(".item-shop-order")
//             btn_apply_shopbee_vouche.click(function(){    
//                 resetShopbeeVoucher();                                                                      
//                 for (const item of data) {                    
//                     let radio_shopbee_voucher =  $(`input[name="ma_voucher_${item.loai_chi_phi_ap_dung}"]:checked`);
//                     console.log(radio_shopbee_voucher.val());                     
//                     if(radio_shopbee_voucher.length)              
//                     {                       
//                         for (const voucher of item.vouchers) {
//                             if(voucher.ma_voucher == radio_shopbee_voucher.val())
//                             {
//                                 let dataBoxVoucher=$(`<input type="text" class="btn voucher-code-apply" style="display:none" name="ma_voucher_apply_${item.loai_chi_phi_ap_dung}" value="${radio_shopbee_voucher.val()}" readonly>`)
//                                 if(shopbee_voucher_code.find("input").length==0)
//                                     shopbee_voucher_code.html("")
//                                 shopbee_voucher_code.append(dataBoxVoucher)
//                                 dataBoxVoucher.slideDown()
//                                 for (var item_order of item_shop_orders)
//                                 {
//                                     item_order = $(item_order)                                     
//                                     if(item_order.data("pass-check-object-voucher-"+radio_shopbee_voucher.val()) == true)
//                                     {                                                
//                                         item_order.data("shopbee-voucher-code-"+item.loai_chi_phi_ap_dung,radio_shopbee_voucher.val())                                
//                                         let chi_phi = item_order.data("chi_phi_"+item.loai_chi_phi_ap_dung);      
//                                         let discountShopbee = chi_phi * voucher.ty_le_giam_gia;                                                                                                                     
//                                         discountShopbee = discountShopbee <= voucher.muc_giam_toi_da ? discountShopbee : voucher.muc_giam_toi_da;                                         
//                                         let discount_old = item_order.data("discount-"+item.loai_chi_phi_ap_dung) ?? 0;  
//                                         item_order.find(`.line-through-`+item.loai_chi_phi_ap_dung).addClass("line-through")
//                                         item_order.find(`.discounted-`+item.loai_chi_phi_ap_dung).text(" "+(parseInt(chi_phi-discountShopbee)).toLocaleString("de-DE"))
//                                         discount[item.loai_chi_phi_ap_dung] = (discount[item.loai_chi_phi_ap_dung] ?? 0) - discount_old + discountShopbee;                                       
//                                         item_order.data("discount-"+item.loai_chi_phi_ap_dung,discountShopbee);                                                                 
//                                     }
//                                 }
//                             }  
//                         }
//                     }
//                 }
//                 reloadDiscount()
//                 reloadTotalMoneyAll();                                                                                                                                                     
//             })
//             const input_search_shopbee_voucher = $("#input-search-shopbee-voucher")
//             input_search_shopbee_voucher.on("input",function(){
//                 input_search_shopbee_voucher.val(input_search_shopbee_voucher.val().trim())
//                 var box_show_shopbee_voucher_types = $(".box-show-shopbee-voucher-type")
//                 for (var box_show_shopbee_voucher_type of box_show_shopbee_voucher_types) {
//                     box_show_shopbee_voucher_type = $(box_show_shopbee_voucher_type)
//                     var title_is_impty_voucher = box_show_shopbee_voucher_type.find(".title-shopbee-voucher-is-empty")
//                     let show_voucher = false;
//                     let vouchers = box_show_shopbee_voucher_type.find(".voucher");
//                     vouchers.each(function(){
//                         if($(this).find(".shopbee-voucher-radio").val().match(input_search_shopbee_voucher.val()))
//                         {
//                             $(this).slideDown()
//                             show_voucher = true;                                
//                         }
//                         else
//                             $(this).slideUp()   
//                     })
//                     if(!show_voucher)
//                         title_is_impty_voucher.slideDown();
//                     else
//                         title_is_impty_voucher.slideUp();                    
//                 }                                
//             })
//         }
//         else
//         {
//             btn_apply_shopbee_vouche.remove()
//             $("#box-show-shopbee-voucher").html("<center>Không có voucher nào phù hợp</center>")
//         }
//         createEventBtnSubmit(dataOrder,data)
//     })
// }

// var creeateEventShowShopbeeVoucher = (data)=>{
//     const box_show_shopbee_voucher = $("#box-show-shopbee-voucher");    
//     $("#shopbee-voucher-code").click(function(){  
//         $("#input-search-shopbee-voucher").val("")               
//         box_show_shopbee_voucher.html("")          
//         data.forEach(item=>{
//             let element_voucher_type = $(`<div class="box-show-shopbee-voucher-type">
//                                                 <div class="item-title-shopbee-voucher-type">
//                                                     <span class="shopbee-voucher-type">${item.loai_voucher}</span>
//                                                 </div>
//                                                 <div class="box-show-shopbee-voucher">                                                    

//                                                 </div>                                    
//                                             </div>`)            
//             const box_show_shopbee_voucher_child = element_voucher_type.find(".box-show-shopbee-voucher");
//             item.vouchers.forEach(voucher=>{                                               
//                     let ngay_bat_dau = ConvertDateTimeToString(voucher.ngay_bat_dau)
//                     let ngay_ket_thuc = ConvertDateTimeToString(voucher.ngay_ket_thuc)
//                     let doi_tuong_su_dung = "Dành cho tất cả mọi đơn hàng"                      
//                     var pass = true;                                           
//                     let mes_unuse = undefined;                                           
//                     var item_shop_orders = $(".item-shop-order")        
//                     if(voucher.doi_tuong_tham_chieu && voucher.doi_tuong_tham_chieu.length > 0)
//                     {             
//                         doi_tuong_su_dung = "Dành cho các đơn hàng thuộc"                                   
//                         let chk_danh_muc = {};    
//                         item_shop_orders.each(function(){
//                             $(this).data("count-check-object",0);
//                             chk_danh_muc[$(this).data("shop-id")] = false;
//                         })
//                         pass = false;
//                         for (const doi_tuong of voucher.doi_tuong_tham_chieu) {
//                             //doi_tuong_su_dung+= " "+getObjectName(doi_tuong)+": "
//                             if(doi_tuong == "danh_muc")
//                             {
//                                 doi_tuong_su_dung+=" Danh mục: "                                  
//                             }  
//                             else if(doi_tuong == "phuong_thuc_van_chuyen")     
//                             {
//                                 doi_tuong_su_dung+=" Phương thức vận chuyển: "  
//                             }  
//                             else if(doi_tuong == "phuong_thuc_thanh_toan")
//                                 doi_tuong_su_dung+=" Phương thức thanh toán: "
//                             else
//                                 doi_tuong_su_dung+=" một số cửa hàng đăng ký sử dụng; "                                                                         
//                             for (var i = 0;i< voucher[doi_tuong+"s"].length;i++) {
//                                 let ten_doi_tuong = voucher[doi_tuong+"s"][i]["ten_"+doi_tuong]     
//                                 // if(doi_tuong=="cua_hang")
//                                 // {                                    
//                                 //     for (var item_order of item_shop_orders)                                    
//                                 //         $(item_order).data("count-check-object",parseInt($(item_order).data("count-check-object"))+1);                                                                              
//                                 // } 
//                                 // else
//                                 // {
//                                     let doi_tuong_id = JsonParseStr(voucher[doi_tuong+"s"][i]["_id"] ?? voucher[doi_tuong+"s"][i])
//                                     for (var item_order of item_shop_orders)
//                                     {            
//                                         item_order = $(item_order)                               
//                                         objectIds = item_order.data("object-ids");
//                                         if(doi_tuong=="danh_muc")
//                                         {      
//                                             if(chk_danh_muc[item_order.data("shop-id")]==false)
//                                             {
//                                                 if(objectIds.indexOf(doi_tuong_id) != -1)
//                                                 {
//                                                     item_order.data("count-check-object",parseInt(item_order.data("count-check-object"))+1);
//                                                     chk_danh_muc[item_order.data("shop-id")] = true;
//                                                 }   
//                                                 else
//                                                 {                                                                                                
//                                                    var danh_muc_cons = voucher["danh_muc_cons"][i];
//                                                    for (var danh_muc_con of danh_muc_cons) {
//                                                         if(objectIds.indexOf(JsonParseStr(danh_muc_con._id))!=-1)   
//                                                         {
//                                                             item_order.data("count-check-object",parseInt(item_order.data("count-check-object"))+1);
//                                                             chk_danh_muc[item_order.data("shop-id")] = true;
//                                                             break;
//                                                         }                                             
//                                                    }
//                                                 }      
//                                             }                                                                                   
//                                         }
//                                         else                                        
//                                             if(objectIds.indexOf(doi_tuong_id)!=-1)
//                                             {
//                                                 item_order.data("count-check-object",parseInt(item_order.data("count-check-object"))+1);                                                                                           
//                                             }                                        
//                                     }                                                                                                                    
//                                 // }                                                                                             
//                                 doi_tuong_su_dung+=ten_doi_tuong ? (ten_doi_tuong +"; "):""
//                             }                            
//                         };
//                     }
//                     let buyMoreMoney = [];
//                     for (var item_order of item_shop_orders)
//                     {
//                         item_order = $(item_order) 
//                         if(voucher.doi_tuong_tham_chieu == null || parseInt(item_order.data("count-check-object")) == voucher.doi_tuong_tham_chieu.length)
//                         {                               
//                             pass = true;
//                             item_order.data("pass-check-object-voucher-"+voucher.ma_voucher,true);                                                                 
//                         }
//                         else
//                             item_order.data("pass-check-object-voucher-"+voucher.ma_voucher,false); 
//                         let tatolPackage = parseInt(item_order.data("chi_phi_don_hang"))                                                      
//                         if(voucher.don_hang_toi_thieu > tatolPackage)
//                         {                                                                                                                              
//                             if(mes_unuse !== null)
//                             {                                                           
//                                 buyMoreMoney.push(voucher.don_hang_toi_thieu - tatolPackage)                             
//                                 if(Math.min(...buyMoreMoney) == (voucher.don_hang_toi_thieu - tatolPackage))
//                                     mes_unuse = `Mua thêm ${parseInt((voucher.don_hang_toi_thieu - tatolPackage)/1000)}k nữa để có thể sử dụng được Voucher này!!`
//                             }
//                             item_order.data("pass-check-object-voucher-"+voucher.ma_voucher,false);
//                         }
//                         else                            
//                             mes_unuse = null;                                                            
                        
                        
//                     }                            
//                         // if(!pass)
//                         // {
//                         //     box_unuse=`<div class="shopbee-voucher-unqualified">
//                         //                    Chưa đủ điều kiện, xem thông tin để biết thêm chi tiết
//                         //                 </div>`;
//                         // }
                                        
//                     let s = `<div class="voucher" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-title="${voucher.ten_voucher ?? "Ưu đãi"}" data-bs-content="${doi_tuong_su_dung}">
//                                 <div class="item pad w-100">
//                                     <div class="row">
//                                         <div class="col-6" style="border-right:1px dashed #999999; padding: 0px 5px;">
//                                             <span class="shopbee-voucher-name" title="${voucher.ten_voucher ?? "Ưu đãi"}">${ voucher.ten_voucher ? (voucher.ten_voucher.length >30 ? voucher.ten_voucher.substring(0,30)+"..." : voucher.ten_voucher) : "Ưu đãi"}</span><br />
//                                             <a>
//                                                 Giảm 
//                                                 <span class="shopbee-voucher-discount-rate">
//                                                     ${voucher.ty_le_giam_gia * 100}%,
//                                                 </span> tối đa 
//                                                 <span class="shopbee-voucher-maximum-reduction">
//                                                     ${parseInt(voucher.muc_giam_toi_da/1000)}k
//                                                 </span> cho đơn hàng từ ${parseInt(voucher.don_hang_toi_thieu/1000)}k
//                                             </a><br />
//                                             <div class="shopbee-voucher-box-quantity">
//                                                 <span class="shopbee-voucher-quantity-title">Còn: <span class="shopbee-voucher-quantity">${voucher.so_luong}</span></span>
//                                             </div>
//                                         </div>
//                                         <div class="col-6 p-0">
//                                             <div class="shopbee-voucher-box-timeout">
//                                                 <span class="shopbee-voucher-timeout">HSD: ${ngay_ket_thuc}</span>
//                                             </div>
//                                             <div class="shopbee-voucher-box-code">
//                                                 <strong class="shopbee-voucher-code">${voucher.ma_voucher}</strong>
//                                             </div>
//                                             <input class="form-check-input shopbee-voucher-radio" type="radio" name="ma_voucher_${item.loai_chi_phi_ap_dung}" value="${voucher.ma_voucher}">
//                                         </div>
//                                     </div>
//                                 </div>                                                                                                            
//                             </div>`;
//                     var element = $(s);
//                     new bootstrap.Popover(element)
//                     var ngay_bat_dau_date = ConvertDate(voucher.ngay_bat_dau)                    
//                     if((mes_unuse != null) || ngay_bat_dau_date > TODAY || !pass)
//                     {                    
//                         element.find(".item").addClass("voucher-disabled")
//                         element.append(`<div class="shopbee-voucher-unqualified">
//                                             ${ mes_unuse ?? (ngay_bat_dau_date > TODAY? `Chương trình bắt đầu lúc ${ngay_bat_dau}`
//                                             : "Chưa đủ điều kiện, xem thông tin để biết thêm chi tiết")}
//                                         </div>`)
//                         let radio_shopbee_voucher =  element.find(`input[name="ma_voucher_${item.loai_chi_phi_ap_dung}"]`);
//                         radio_shopbee_voucher.attr("type","text")
//                         radio_shopbee_voucher.prop("disabled",true)
//                         radio_shopbee_voucher.val("");
//                         box_show_shopbee_voucher_child.append(element)                        
//                     }
//                     else                                                    
//                     {
//                         element.click(function(){
//                             element.find("input[type='radio']")[0].checked = true;
//                         })
//                         box_show_shopbee_voucher_child.prepend(element)  
//                     }                                                                                                                 
//             })  
//             box_show_shopbee_voucher_child.append(`<center class="title-shopbee-voucher-is-empty" >Không tìm thấy</center>`)
//             box_show_shopbee_voucher.append(element_voucher_type);                       
//         })    
//     })
//     const btn_choose_shopbee_voucher = $(".btn-choose-shopbee-voucher");
//     btn_choose_shopbee_voucher.click(function(){        
//         $("#shopbee-voucher-code").click()
//     })
// }
