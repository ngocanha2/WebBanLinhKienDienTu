const createBoxRefuseOrder = (id)=>{
    var box_refuse_order = $(`<div class="modal fade" id="modal-cancel-order" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" >
                                    <div class="modal-content" >
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tại sao bạn muốn từ chối đơn hàng này?</h1>
                                            <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="box-cancel-order">
                                                <form action="" id="form-cancel-order" method="POST">
                                                    <div class="item-option-cancel-order">                                    
                                                        <input type="radio" name="ly_do" id="ly_do1" value="Tôi không xác nhận được đơn hàng" checked>                                    
                                                        <label for="ly_do1">Tôi không xác nhận được đơn hàng</label>
                                                    </div>
                                                    <div class="item-option-cancel-order">                                    
                                                        <input type="radio" name="ly_do" id="ly_do2" value="Tôi không liên lạc được với người mua hàng">                                    
                                                        <label for="ly_do2">Tôi không liên lạc được với người mua hàng</label>
                                                    </div>
                                                    <div class="item-option-cancel-order">                                    
                                                        <input type="radio" name="ly_do" id="ly_do3" value="Tôi nghĩ đây là 1 đơn hàng ảo">                                    
                                                        <label for="ly_do3">Tôi nghĩ đây là 1 đơn hàng ảo</label>
                                                    </div>
                                                    <div class="item-option-cancel-order">                                    
                                                        <input type="radio" name="ly_do" id="ly_do4" value="Tôi thường hay bị người này boom hàng">                                    
                                                        <label for="ly_do4">Tôi thường hay bị người này boom hàng</label>
                                                    </div>
                                                    <div class="item-option-cancel-order">                                    
                                                        <input type="radio" name="ly_do" id="ly_do5" value="Tôi không muốn bán cho người này">                                    
                                                        <label for="ly_do5">Tôi không muốn bán cho người này</label>
                                                    </div>
                                                    <div class="item-option-cancel-order">                                    
                                                        <input type="radio" name="ly_do" id="ly_do6" value="Tôi cảm thấy người này có ý đồ lừa đảo">                                    
                                                        <label for="ly_do6">Tôi cảm thấy người này có ý đồ lừa đảo</label>
                                                    </div>
                                                    <div class="item-option-cancel-order">                                    
                                                        <input type="radio" name="ly_do" id="ly_do7" value="Đã quá lâu nhưng vẫn chưa thấy xác thực đơn hàng">
                                                        <label for="ly_do7">Đã quá lâu nhưng vẫn chưa thấy xác thực đơn hàng</label>
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
    box_refuse_order.find("#btn-confirm").click(function(){
        showMessage("Thông báo","Xác nhận từ chối đơn hàng này?",function(){                
            let formData = $('#form-cancel-order').serialize();
            console.log(formData)
            RefuseOrder(id,formData,()=>{
                showMessage("Thành công","Bạn đã từ chối đơn hàng thành công",()=>{
                    location.reload();
                },false)
                handleCreateToast("success","Bạn đã từ chối đơn hàng thành công",null,true);                
            },(res)=>{
                handleCreateToast("error",res.error,null,true);
            });
        })
    })
    $("body").append(box_refuse_order);
}
const RefuseOrder = (id,formData,func_success,func_fail)=>{
    new CallApi(PREFIX_MANAGER+PREFIX_ORDER)
    .patch(id,formData,(res)=>{
        if(typeof func_success === "function")
            func_success(res)
    },(res)=>{
        if(typeof func_success === "function")
            func_fail(res)
    },REFUSE)
}