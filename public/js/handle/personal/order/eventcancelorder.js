const createBoxCancelOrder = (id,checkEmail = false)=>{
    var box_cancel_order = $(`<div class="box-btn-cancel-order">
                                <button class="btn btn-danger" id="btn-cancel-order" data-bs-toggle="modal" data-bs-target="#modal-cancel-order">Hủy bỏ đơn hàng</button>               
                            </div>
                            <div style="clear: both"></div>
                            <div class="modal fade" id="modal-cancel-order" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" >
                                    <div class="modal-content" >
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tại sao bạn muốn hủy bỏ đơn hàng này?</h1>
                                            <button type="button" class="btn-close" id="btn-close-form-cancel-order" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="box-cancel-order">
                                                <form action="" id="form-cancel-order" method="POST">
                                                    <div class="item-option-cancel-order">                                    
                                                        <input type="radio" name="ly_do" id="ly_do1" value="Tôi muốn thay đổi địa chỉ giao hàng" checked>                                    
                                                        <label for="ly_do1">Tôi muốn thay đổi địa chỉ giao hàng</label>
                                                    </div>
                                                    <div class="item-option-cancel-order">                                    
                                                        <input type="radio" name="ly_do" id="ly_do2" value="Tôi muốn nhập/thay đổi mã Voucher">                                    
                                                        <label for="ly_do2">Tôi muốn nhập/thay đổi mã Voucher</label>
                                                    </div>
                                                    <div class="item-option-cancel-order">                                    
                                                        <input type="radio" name="ly_do" id="ly_do3" value="Tôi muốn thay đổi sản phẩm trong đơn hàng">                                    
                                                        <label for="ly_do3">Tôi muốn thay đổi sản phẩm trong đơn hàng</label>
                                                    </div>
                                                    <div class="item-option-cancel-order">                                    
                                                        <input type="radio" name="ly_do" id="ly_do4" value="Thủ tục thanh toán quá rắc rối">                                    
                                                        <label for="ly_do4">Thủ tục thanh toán quá rắc rối</label>
                                                    </div>
                                                    <div class="item-option-cancel-order">                                    
                                                        <input type="radio" name="ly_do" id="ly_do5" value="Tìm thấy giá rẻ hơn ở chỗ khác">                                    
                                                        <label for="ly_do5">Tìm thấy giá rẻ hơn ở chỗ khác</label>
                                                    </div>
                                                    <div class="item-option-cancel-order">                                    
                                                        <input type="radio" name="ly_do" id="ly_do6" value="Đổi ý, không muốn mua nữa">                                    
                                                        <label for="ly_do6">Đổi ý, không muốn mua nữa</label>
                                                    </div>
                                            </form>
                                            </div>                           
                                        </div>
                                        <div class="modal-footer">                    
                                            <a class="btn btn-secondary" id="btn-cancel" data-bs-dismiss="modal">Hủy bỏ</a>
                                            <a class="btn btn-warning" id="btn-confirm">Xác nhận</a>
                                        </div>
                                    </div>
                                </div>
                            </div>`);
    box_cancel_order.find("#btn-confirm").click(function(){
        $("#form-cancel-order").prop("hidden",true)
        $("#btn-close-form-cancel-order").prop("hidden",true)        
        createMessageBoxCancelOrder(box_cancel_order,id,checkEmail)
    })
    return box_cancel_order;
}
const createMessageBoxCancelOrder = (box_cancel_order,id,checkEmail)=>{    
    showMessage("Thông báo","Xác nhận bạn muốn hủy đơn hàng này?",function(value){                
        let formData = $('#form-cancel-order').serialize();
        formData += "&email="+value            
        CancelOrder(id,formData,()=>{
            handleCreateToast("success","Bạn đã hủy đơn hàng thành công");
            $(".item-order-details-status").text("Đã hủy")
            $(".btn-close").click();
            box_cancel_order.remove();
        },(res)=>{
            console.log(res)
            handleCreateToast("error",res.error,null,true);
            createMessageBoxCancelOrder(box_cancel_order,id,checkEmail)
        });
    },()=>{
        $("#form-cancel-order").prop("hidden",false)
        $("#btn-close-form-cancel-order").prop("hidden",false)
    },checkEmail ? "text":undefined,checkEmail ? "Vui lòng nhập đúng địa chỉ email đã đặt hàng để hủy đơn hàng này":undefined)
}
const CancelOrder = (id,formData,func_success,func_fail)=>{
    new CallApi(PREFIX_PERSONAL+PREFIX_ORDER)
    .patch(id,formData,(res)=>{
        if(typeof func_success ==="function")
            func_success(res)
    },(res)=>{
        if(typeof func_fail ==="function")
            func_fail(res)        
    },CANCEL)
}