$(()=>{
    const btnUpdate = $("#btn-update");    
    const btnCancel = $("#btn-cancel");
    const btnSubmit = $("#btn-submit");
    const inputQuantity = $("#quantity");
    const selectProduct = $("#select-product")    
    const tableDelivery = $("#delivery-note-details")
    const id = getParamPrefix(1);    
    const api = new CallApi(PREFIX_SUPPLIER+id);    
    const initialization = ()=>{
        reset()
        createInputNumber(inputQuantity,1,selectProduct.find(`option[value="${selectProduct.val()}"]`).attr("max-value"))
    }    
    const reset = ()=>{
        btnUpdate.text("Thêm")
        btnCancel.text("Làm mới")  
        btnUpdate.data("update-id",null);         
        selectProduct.prop("disabled",false) 
        inputQuantity.val("");   
        $(".tr-change").removeClass("tr-change") 
    }
    btnCancel.click(()=>{
        reset();
    })
    selectProduct.change(function(){
        const option = $(this).find(`option[value="${$(this).val()}"]`)
        inputQuantity.val(""); 
        inputQuantity.data("maximum",option.attr("max-value"))        
    })
    btnUpdate.click(()=>{
        if(inputQuantity.val()=="")    
            return handleCreateToast("error","Số lượng không được để trống",`error-quantity-${selectProduct.val()}`,true);        
        const id  = btnUpdate.data("update-id");
        if(id == null)
        {
            const option = selectProduct.find(`option[value="${selectProduct.val()}"]`)
            const row = $(`#product-${selectProduct.val()}`);
            if(row.length)
            {
                const td = row.find(".td-quantity");
                let quantityNew = parseInt(td.text()) + parseInt(inputQuantity.val())                
                if(parseInt(option.attr("max-value"))<quantityNew)
                    return handleCreateToast("error",`Tổng số lượng giao cập nhật cho mặt hàng"${option.attr("product-name")}" vượt quá số lượng chưa giao(${option.attr("max-value")})`,`error-update-quantity-${selectProduct.val()}`,true);
                td.text(quantityNew)
            }
            else
            {                
                let s =`<tr id="product-${selectProduct.val()}">
                            <td>${selectProduct.val()}</td>
                            <td>${option.attr("product-name")}</td>
                            <td class="td-quantity">${inputQuantity.val()}</td>
                            <td><button class="btn btn-outline-danger btn-delete">Xóa</button></td>
                        </tr>`
                const rowNew = $(s);
                rowNew.click(function(){
                    btnUpdate.data("update-id",selectProduct.val())
                    btnUpdate.text("Cập nhật")
                    btnCancel.text("Hủy")                    
                    selectProduct.prop("disabled",true)
                    option.prop("selected",true);
                    $(".tr-change").removeClass("tr-change") 
                    rowNew.addClass("tr-change");                       
                    inputQuantity.val($(this).find(".td-quantity").text())
                })
                rowNew.find(".btn-delete").click(()=>{
                    rowNew.remove();
                })
                rowNew.data("product-id",selectProduct.val())
                tableDelivery.append(rowNew)
            }            
        }
        else
        {
            const row = $(`#product-${id}`);
            const td = row.find(".td-quantity");
            td.text(inputQuantity.val());
            reset();            
        }
    })
    btnSubmit.click(()=>{
        const rows = tableDelivery.find("tr");
        if(!rows.length)
            return handleCreateToast("error","Phải có ít nhất 1 chi tiết giao hàng","error-submit",true);
        showMessage("Thông báo","Xác nhận tạo phiếu giao hàng?",()=>{
            let data = []
            for (var row of rows) {
                row = $(row)
                data.push({
                    MaHang:row.data("product-id"),
                    SoLuong:parseInt(row.find(".td-quantity").text())
                })
            };
            console.log(data)
            api.create({
                data:data
            },(res)=>{
                showMessage("Thành công","Tạo phiếu giao hàng thành công",()=>{
                    location.reload("/supplier/order")
                },false)
            },(res)=>{
                console.log(res)
            },PREFIX_HANDLE)
        })        
    })
    initialization();
})