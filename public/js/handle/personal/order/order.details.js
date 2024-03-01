$(()=>{
    const Api = new CallApi(BASE_URL_API+PREFIX_PERSONAL+PREFIX_ORDER);    
    const id = getParamPrefix();    
    const ApiGuarantee = new CallApi(PREFIX_PERSONAL+GUARANTEE)
    const modalGuarantee = $("#modal-guarantee")
    const soLuongBaoHanh = $("#SoLuongBaoHanh")
    const lyDoBaoHanh = $("#LyDoBaoHanh");
    const titleGuarantee = $("#title-guarantee")
    const formGuarantee = $("#form-guarantee")
    const btnConfirmGuarantee = $("#btn-confirm-guarantee")
    const boxGuaranteeHistory= $("#box-guarantee-history")
    const modalGuaranteeHistory= $("#modal-guarantee-history")
    const boxCancelGuarantee = $("#box-cancel-guarantee")
    const btnCancelGuarantee = $("#btn-cancel-guarantee")
    createInputNumber(soLuongBaoHanh,1,999999999999);
    Api.show(id,(res)=>{   
        console.log(res)     
        let chiTietDonHangs = res.data.chitietdonhangs
        let donHang = res.data.donhang
        let TrangThai = donHang.TrangThai
    $(".item-order-details-code").text(donHang.MaDonhang)
    $(".item-order-details-status").text(TrangThai)
    $(".info-address-phone-number").text(donHang.SDT)
    $(".info-address-name").text(donHang.TenNguoiNhan)
    $(".info-address-info").text(donHang.DiaChiGiaoHang)
    $(".info-address-detail").text(donHang.DiaChiCuThe ?? "---")
    $(".info-address-note").text(donHang.GhiChu ?? "---")    
    $(".order-date").text(convertDateTimeToString(donHang.NgayMua))
    $(".info-order-details-shipping-method").text(donHang.PhuongThucVanChuyen)
    // $(".item-order-shop-name").text(donHang.ten_cua_hang)
    // $(".btn-order-shop-access").attr("href",`${URL_HOST}cua-hang/${JsonParseStr(donHang.cua_hang_id)}`)
    const box_order_details_products = $(".box-order-details-products");
    let s = "";
    let total_amount = 0;
    box_order_details_products.html("")
    let feedbacks = [];
    const ngayTao = new Date(donHang.NgayMua)  
    const toDay = new Date();
    chiTietDonHangs.forEach(chiTiet => {
        let san_pham_id = chiTiet.MaHang
        let total_price = chiTiet.SoLuong * chiTiet.DonGia;
        total_amount+=total_price
        s=`<div class="item-order-product">
                <div class="row">
                    <div class="col-lg-2 col-xxl-1 col-md-3 col-sm-4 col-5">
                        <div class="image-product w-100 h-100" style="background: url(${URL_HOST}images/${chiTiet.HinhAnh}); background-size: cover; ">                                                
                        </div>
                    </div>
                    <div class="col-lg-10 col-xxl-11 col-md-9 col-sm-8 col-7">
                        <strong class="item-product-name text-dark">${chiTiet.TenHang}</strong><br>
                        <div class="box-btn-create-feedback">                            
                        </div>                       
                        <span class="item-product-classify">${chiTiet.DonGia.toLocaleString("de-DE")}đ</span><br>
                        <span class="item-product-quantity">x ${chiTiet.SoLuong}</span><br>
                        <strong class="item-product-price">${(total_price).toLocaleString("de-DE")}đ</strong><br>                                               
                    </div>                                                                                       
                    <div class="guarantee">
                        <span class="box-guarantee-history">
                        </span> 
                        <span class="box-guarantee" id="box-guarantee-${chiTiet.MaHang}">
                        </span>                                                                                                                          
                    </div>                
                </div>
            </div>`
        var item_order_product = $(s);
        if(chiTiet.MucDoHaiLong != null && feedbacks.indexOf(`feedback-${san_pham_id}`)==-1)        
            feedbacks.push(`feedback-${san_pham_id}`)
        if( TrangThai == "Đã giao")
        {        
            if(!chiTiet.MucDoHaiLong  && feedbacks.indexOf(`feedback-${san_pham_id}`)==-1)
            {
                createModalFeedback();
                let btn_feedback = $(`<a class="btn-create-feedback feedback-${san_pham_id}" data-bs-toggle="modal" data-bs-target="#modal-feedback">Đánh giá</a>`);
                var btn_confirm_feedback = $("#btn-confirm-feedback"); 
                btn_feedback.click(function(){                
                    if(btn_confirm_feedback.data("feedback-id-product") != undefined && btn_confirm_feedback.data("feedback-id-product")!=san_pham_id)                
                        resetLevelFeedback();                                    
                    else
                    {
                        // console.log(chiTiet.san_pham.ten_kich_co)
                        $(".feedback-image-product").css('background',`url(${URL_HOST}images/${chiTiet.HinhAnh})`)
                        $(".feedback-image-product").css("background-size",'cover');                
                        $("#feedback-produce-name").text(chiTiet.TenHang)
                        btn_confirm_feedback.data("feedback-id-product",san_pham_id);
                        // btn_confirm_feedback.data("classify-value",chiTiet.san_pham.ten_phan_loai);
                        // btn_confirm_feedback.data("size-value",chiTiet.san_pham.ten_kich_co);                                  
                    }
                    
                })
                item_order_product.find(".box-btn-create-feedback").append(btn_feedback);
            }           
            const btnGuaranteeHistory = $(`<button class="btn-guarantee" id="btn-guarantee-history-${chiTiet.MaHang}">Lịch sử bảo hành</button>`)     
            btnGuaranteeHistory.click(()=>{
                ApiGuarantee.all((res)=>{
                    console.log(res)
                    modalGuaranteeHistory.modal("show");
                    if(res.data.length==0)
                    {
                        boxGuaranteeHistory.html("<center><h3>Không tìm thấy lịch sử bảo hành</h3></center>")
                    }
                    else
                    {
                        boxGuaranteeHistory.html(`<table class="table table-hover table-striped table-bordered" border="1">
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Ngày yêu cầu</th>
                                                        <th>Mã đơn hàng</th>
                                                        <th>Hàng hóa</th>                            
                                                        <th>Số lượng</th>                            
                                                        <th>Nguyên nhân bảo hành</th>                            
                                                        <th>Trạng thái</th>
                                                        <th>Ngày xử lý</th>
                                                        <th>Số lượng sửa chửa</th>
                                                        <th>Số lượng thay mới</th>
                                                        <th>Thành tiền</th>
                                                        <th>Ghi chú</th>
                                                    </tr>
                                                    <tbody id="tbody-guarantee-history"></tbody>
                                                </table>`)
                        const tbodyGuaranteeHistory = boxGuaranteeHistory.find("#tbody-guarantee-history")
                        console.log(res.data)
                        res.data.forEach(item=>{
                            let row = $(` <tr>
                                            <td>${item.id}</td>
                                            <td>${item.NgayYeuCau}</td>
                                            <td>${item.MaDonHang}</td>
                                            <td>${item.MaHang} - ${item.TenHang}</td>                            
                                            <td>${item.SoLuong}</td>                            
                                            <td>${item.NguyenNhanBaoHanh}</td>                            
                                            <td>${item.DaXuLy == 0 ? "Chờ tiếp nhận" : (item.DaXuLy == 1 ? "Đang xử lý" : (item.DaXuLy == 2 ? "Đã xử lý" : "Đã hủy"))}</td>
                                            <td>${item.NgayTao ?? ""}</td>
                                            <td>${item.SoLuongSuaChua ?? ""}</td>
                                            <td>${item.SoLuongThayMoi ?? ""}</td>
                                            <td>${item.ThanhTien ?? ""}</td>
                                            <td>${item.MoTa ?? ""}</td>
                                        </tr>`)
                            tbodyGuaranteeHistory.append(row)                            
                        })
                    }
                },(res)=>{
                    console.log(res)
                },null,chiTiet.MaDonhang+"/"+chiTiet.MaHang)
            })       
            item_order_product.find(".box-guarantee-history").append(btnGuaranteeHistory);                       
            if(chiTiet.DaXuLyBaoHanh == null)
            {
                let newMonth= ngayTao.getMonth() + chiTiet.SoThangBaoHanh;
                let newYear = parseInt(newMonth/12) + ngayTao.getFullYear();
                newMonth = newMonth%12;            
                let expirateDate = new Date(donHang.NgayMua)
                expirateDate.setMonth(newMonth)
                expirateDate.setFullYear(newYear) 
                if(expirateDate > toDay)
                {
                    const btnGuarantee = $(`<button class="btn-guarantee" id="btn-guarantee-${chiTiet.MaHang}">Yêu cầu bảo hành</button>`)
                    btnGuarantee.click(()=>{
                        btnConfirmGuarantee.text("Xác nhận")
                        boxCancelGuarantee.hide()
                        modalGuarantee.modal("show")
                        soLuongBaoHanh.data("maximum",chiTiet.SoLuong)
                        lyDoBaoHanh.val("")
                        soLuongBaoHanh.val("")
                        titleGuarantee.text(" '"+chiTiet.TenHang+"'")
                        formGuarantee.data("product-id",chiTiet.MaHang);
                        formGuarantee.data("product-name",chiTiet.TenHang);
                        formGuarantee.data("update",null)
                    })
                    item_order_product.find(".box-guarantee").append(btnGuarantee);
                }
            }
            else
            {                
                item_order_product.find(".box-guarantee").append(createBoxGuaranteeDetails(chiTiet));
            }
        }                                 
        box_order_details_products.append(item_order_product);
    });  
    if(feedbacks.length>0) 
    {
        feedbacks.forEach(feedback=>{
            $("."+feedback).each(function(){
                $(this).remove();
            }) 
        }) 
        if(!$(".btn-create-feedback").length)
            $("#modal-feedback").remove()
    }     
    $(".total_amount").text(total_amount.toLocaleString("de-DE"));
    $(".into-money").text(donHang.ThanhTien.toLocaleString("de-DE"));
    $(".payment-method").text(donHang.PhuongThucThanhToan)
    if(TrangThai == "Chờ xác nhận" || TrangThai == "Đang xử lý" && donHang.PhuongThucThanhToan != "Thanh toán online")
    {
        $(".box-order-details").append(createBoxCancelOrder(id));
    }
    },(res)=>{
        console.log(res)
    })
    btnCancelGuarantee.click(()=>{
        let updateId = formGuarantee.data("update")
        showMessage("Bạn đang muốn hủy yêu cầu bảo hành?","Xác nhận hủy bỏ yêu bảo hành này?",()=>{
            ApiGuarantee.delete(updateId,(res)=>{
                showMessage("Thành công","Hủy bỏ yêu cầu bảo hành thành công",()=>{
                    location.reload()
                },false);
            },(res)=>{
                showMessage("error",res.error,null,true);
            })
        })
    })
    formGuarantee.on("submit",function(ev){
        ev.preventDefault();        
        $(".error-validate-update.LyDoBaoHanh").text("")
        $(".error-validate-update.SoLuongBaoHanh").text("")
        
        if(lyDoBaoHanh.val().trim() == null || lyDoBaoHanh.val().trim() == "")
        {
            $(".error-validate-update.LyDoBaoHanh").text("Nguyên nhân bảo hành không được để trống")
            lyDoBaoHanh.focus();
            return handleCreateToast("error","Nguyên nhân bảo hành không được để trống","error-baohang1",true)
        }
        if(soLuongBaoHanh.val().trim() == null || soLuongBaoHanh.val().trim() == "")
        {
            soLuongBaoHanh.focus();
            $(".error-validate-update.SoLuongBaoHanh").text("Số lượng bảo hành không được để trống")
            return handleCreateToast("error","Số lượng bảo hành không được để trống","error-baohang2",true)
        }
        if(parseInt(soLuongBaoHanh.val().trim())<1)
        {
            $(".error-validate-update.SoLuongBaoHanh").text("Số lượng bảo hành phải là số nguyên dương")
            return handleCreateToast("error","Số lượng bảo hành phải là số nguyên dương","error-baohang3",true)
        }
        clearToast();        
        let formData = formGuarantee.serialize(); 
        let productId = formGuarantee.data("product-id")
        let updateId = formGuarantee.data("update")
        if(updateId!=null)
        {            
            ApiGuarantee.update(updateId,formData,(res)=>{            
                modalGuarantee.modal("hide")                
                console.log(res)
                showMessage("Thành công","Cập nhật yêu cầu bảo hành thành công",()=>{
                    location.reload()
                },false)
            },(res)=>{
                console.log(res)
                handleCreateToast("error",res.error,null,true);
            })
        }
        else
        {
            ApiGuarantee.create(formData,(res)=>{            
                modalGuarantee.modal("hide")
                // handleCreateToast("success","Yêu cầu bảo thành thành công",null,true);
                // $(`#btn-guarantee-${productId}`).remove();
                // $(`box-guarantee-${productId}`).append(createBoxGuaranteeDetails(res,soLuongBaoHanh.data("maximum"),formGuarantee.data("product-name")))
                showMessage("Thành công","Yêu cầu bảo hành thành công",()=>{
                    location.reload()
                },false)
            },(res)=>{
                console.log(res)
                handleCreateToast("error",res.error,null,true);
            },id+"/"+productId)
        }        
    })
const createBoxGuaranteeDetails = (data,quantity = null,productName = null)=>{
    const btnGuaranteeDetails = $(`<button class="btn-guarantee-details">Cập nhật yêu cầu bảo hành chưa xử lý</button>`);
    btnGuaranteeDetails.click(()=>{
        btnConfirmGuarantee.text("Cập nhật")
        boxCancelGuarantee.show()
        modalGuarantee.modal("show")
        soLuongBaoHanh.val(data.SoLuongBaoHanh ?? data.SoLuong)
        soLuongBaoHanh.data("maximum",quantity ?? data.SoLuong)
        lyDoBaoHanh.val(data.NguyenNhanBaoHanh)
        soLuongBaoHanh.val()
        titleGuarantee.text(" '"+(productName ?? data.TenHang)+"'")
        formGuarantee.data("product-id",data.MaHang);
        formGuarantee.data("update",data.idYeuCauBaoHanh)
    })
    return btnGuaranteeDetails;
}
var createEventFeedback = ()=>{
    const btn_confirm_feedback = $("#btn-confirm-feedback");    
    var star_feedbacks = document.querySelectorAll(".star-feedback")
    btn_confirm_feedback.data("evaluate-value",0);    
    star_feedbacks.forEach(function(element,index){                
        $(element).on("mouseover",function(){
            let evaluate = $("#btn-confirm-feedback").data("evaluate")                      
                for(let i = 0 ;i< index+1;i++)
                {
                    $(star_feedbacks[i]).css("color","gold")
                }              
                for(let i = evaluate-1 ;i> index;i++)
                {
                    $(star_feedbacks[i]).css("color","black")
                }      
        })
        $(element).on("click",function(){
            let evaluate = btn_confirm_feedback.data("evaluate-value")
            for(let i = evaluate ;i< index+1;i++)            
                $(star_feedbacks[i]).css("color","gold")                   
            for(let i = evaluate-1 ; i > index;i--)            
                $(star_feedbacks[i]).css("color","black")
            $("#feedback-value").text(GetContentRatingLevel(index+1));
            $("#error-feedback").slideUp();
            btn_confirm_feedback.data("evaluate-value",(index+1));                

        })
        $(element).on("mouseout",function(){
            let evaluate = btn_confirm_feedback.data("evaluate-value")
            for(let i = 4 ; i > evaluate-1;i--)            
                $(star_feedbacks[i]).css("color","black")                       
        })
    });
    btn_confirm_feedback.click(function(){
        let evaluate = btn_confirm_feedback.data("evaluate-value")
        if(evaluate==0)
        {
            return handleCreateToast("error","Vui lòng đánh giá mức độ hài lòng","error-feedback-level",true)
        }
        let noi_dung = "";
        var content_feedback_samples = $(".content-feedback-sample");        
        content_feedback_samples.each(function(){
            if($(this).is(":checked"))
                noi_dung+=$(this).val() + ", "
        })
        let content_feedback_value = $("#content-feedback").val().trim();
        if(content_feedback_value == "")
            noi_dung = noi_dung.substring(0,noi_dung.length-2);
        else
            noi_dung+=content_feedback_value
        if(noi_dung=="")
            return handleCreateToast("error","Vui lòng nhập nội dung đánh giá","error-feedback-level2",true)
        let danh_gia = {
            "MucDoHaiLong":evaluate,
            "NoiDungDanhGia":noi_dung,            
        }
        if($("#feedback-incognito").is(":checked"))
            danh_gia["AnDanh"] = true;        
        else
            danh_gia["AnDanh"] = false;    
        console.log(danh_gia)    
        // danh_gia["MucDoHaiLong"] = MucDoHaiLong;
        // let ten_phan_loai = btn_confirm_feedback.data("classify-value") 
        // if(ten_phan_loai != undefined)
        // {
        //     formData["ten_phan_loai"] = ten_phan_loai;
        //     let ten_kich_co = btn_confirm_feedback.data("size-value") 
        //     if(ten_kich_co!=undefined)
        //         formData["ten_kich_co"] = ten_kich_co;
        // }        
        let san_pham_id = btn_confirm_feedback.data("feedback-id-product");
        Api.create(danh_gia,(res)=>{
            console.log(res)
            handleCreateToast("success","Đánh giá sản phẩm thành công","success"+san_pham_id);
            $(`.feedback-${san_pham_id}`).each(function(){
                $(this).remove();
                $(".btn-close").click();
                if(!$(".btn-create-feedback").length)
                {
                    $("#modal-feedback").remove()
                }
            })
        },(res)=>{
            console.log(res)
        },id+"/"+san_pham_id+"/"+PREFIX_FEEDBACK)
    })
}

var createModalFeedback = ()=>{
    if(!$("#modal-feedback").length)
    {
        let s = `<div class="modal fade" id="modal-feedback" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" >
                        <div class="modal-content" >
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Đánh giá sản phẩm</h1>
                                <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="height:700px; padding: 20px">
                                <div >
                                    <div style=" margin-top: 20px;">
                                        <center>
                                            <div class="feedback-image-product" style="height:120px; width:100px; border:1px solid #000">                                                
                                            </div>
                                        </center>
                                        <center><b id="feedback-produce-name">Tên sản phẩm</b></center>
                                    </div>
                                    <center>`
            for(var i = 0 ;i<5 ;i++)
                s+=`<strong class="star-feedback">
                        <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                    </strong> `
            s+=`<br />
                    <span style="color:rgb(255, 153, 0); font-size:17px;" id="feedback-value">-</span>
                    <br />
                        <span style="color:crimson; font-size:14px; display: none" id="error-feedback">Vui lòng chọn số sao đánh giá</span>        
                        </center>                                                                      
                        <div class="row" style="margin-top:10px;">
                            <center><textarea maxlength="200" id="content-feedback" name="noi_dung" placeholder="Bạn cảm thấy sản phẩm như thế nào"></textarea></center>
                        </div>
                    <center class="box-feedback-sample">
                        <input type="checkbox" class="btn-check content-feedback-sample" id="chatluong"  name="noi_dung1" value="Chất lượng sản phẩm tuyệt vời" autocomplete="off">
                        <label class="btn  btn-outline-warning content-feedback-sample-label"  for="chatluong">Chất lượng sản phẩm tuyệt vời</label>
                        <input type="checkbox" class="btn-check content-feedback-sample" id="phucvutot"  name="noi_dung2" value="Shop phục vụ rất tốt"  autocomplete="off">
                        <label class="btn btn-outline-warning content-feedback-sample-label"  for="phucvutot">Shop phục vụ rất tốt</label><br>
                        <input type="checkbox" class="btn-check content-feedback-sample" id="kyluong"  name="noi_dung3" value="Đóng gói sản phẩm rất đẹp kỷ lưỡng" autocomplete="off">
                        <label class="btn btn-outline-warning content-feedback-sample-label"  for="kyluong">Đóng gói sản phẩm rất đẹp kỷ lưỡng</label>
                    </center>
                        <div style="margin-left:70px; margin-top:20px; font-size:19px;" class="form-check form-switch">
                            <input style="height:20px; width:40px" class="form-check-input btn-outline-warning btn" name="AnDanh" value="true" type="checkbox" id="feedback-incognito">
                            <label class=" form-check-label"  for="feedback-incognito" style="float:left; margin-left:5px; margin-top:-2px;">Đánh giá ẩn danh</label>
                        </div>                                                
                    </div>
                </div>
                <div class="modal-footer">                    
                    <a class="btn btn-secondary" id="btn-cancel-feedback" data-bs-dismiss="modal">Hủy bỏ</a>
                    <a class="btn btn-warning" id="btn-confirm-feedback">Đánh giá</a>
                </div>
            </div>
        </div>
        </div>`
        $("body").append($(s));
        createEventFeedback()
    }
}




var resetLevelFeedback = () =>{
    const btn_confirm_feedback = $("#btn-confirm-feedback"); 
    var star_feedbacks = document.querySelectorAll(".star-feedback")
    btn_confirm_feedback.data("evaluate-value",0);
    $("#feedback-value").text("-");
    $("#content-feedback").val("")
    for(let i = 0 ;i< 5;i++)
    {
        $(star_feedbacks[i]).css("color","black")
    } 
}
})

