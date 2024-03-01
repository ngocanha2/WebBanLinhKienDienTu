$(document).ready(function(){
    const Api = new CallApi(BASE_URL_API+PREFIX_MANAGER+PREFIX_PROMOTION);
    const formEditPromotion = $("#form-edit-promotion");
    const btnAddPromotion = $("#btn-add-promotion");
    const btnSavePromotion = $("#btn-save-promotion");
    const modalEditPromotiom = $("#modal-edit-promotion");
    var statusPresent = null;
    var tabPresent = null;

    btnAddPromotion.click(()=>{
        formEditPromotion.data("update-id",undefined);
        btnSavePromotion.text("Thêm")
        bindingData()
    })
    const getPromotion = (status,tab)=>{   
        statusPresent = status;     
        tabPresent = tab;     
        Api.all((res)=>{                  
            if(res.data.length == 0)
            {
                tab.html(`<center><h2>Không tìm thấy dữ liệu</h2></center>`)
                return;
            }            
            tab.html(`<table class="table table-hover table-striped table-bordered" border="1">
                            <tr>
                                <th>Mã khuyến mãi</th>
                                <th>Tên khuyến mãi</th>
                                <th>Tỷ lệ giảm giá</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th></th>
                            </tr>
                            <tbody class="tbody-promotion"></tbody>
                        </table>`);
            const tbody = tab.find(".tbody-promotion");            
            res.data.forEach(item => {
                const row = $(`<tr class="tr-promotion" id="promotion-row-${item.MaKM}">
                                <td class="td-MaKM">${item.MaKM}</td>
                                <td class="td-TenKhuyenMai">${item.TenKhuyenMai ?? ""}</td>
                                <td class="td-TyLeGiamGia">${item.TyLeGiamGia}</td>
                                <td class="td-NgayBatDau">${convertDateToString(item.NgayBatDau)}</td>
                                <td class="td-NgayKetThuc">${convertDateToString(item.NgayKetThuc)}</td>
                                <td class="td-center">
                                    
                                    <button class="btn btn-outline-info btn-update" data-bs-toggle="modal" data-bs-target="#modal-edit-promotion">Sửa</button>
                                    <button class="btn btn-outline-danger btn-delete">Xóa</button>
                                </td>
                            </tr>`)                            
                row.find(".btn-update").click(()=>{
                    formEditPromotion.data("update-id",item.MaKM);
                    btnSavePromotion.text("Cập nhật")
                    bindingData(item)
                })
                row.find(".btn-delete").click(()=>{
                    showMessage("Thông báo","Xác nhận xóa khuyến mãi này?",()=>{
                        Api.delete(item.MaKM,(res)=>{                            
                            handleCreateToast("success","Xóa khuyến mãi thành công",null,true);
                            row.remove();
                            console.log(res)
                            if(tbody.find(".tr-promotion").length == 0)                            
                                tab.html(`<center><h2>Không tìm thấy dữ liệu</h2></center>`)                                                            
                        },(res)=>{
                            handleCreateToast("error",res.error,"err-promotion-"+item.MaKM,true);     
                            console.log(res)                      
                        })
                    })
                })
                tbody.append(row);
            });            
        },(res)=>{
            console.log(res)
        },{
            status:status
        })
    }
    const tabs = $(".tab");
    const tabPanes = $(".tab-pane")
    tabs.each(function(index,element){        
        $(this).click(()=>{                          
            getPromotion(index,$(tabPanes[index]))
        })   
    })     
    getPromotion(0,$(tabPanes[0]))


    const inputPromotionName = $("#TenKhuyenMai");
    const inputPromotionDiscountRate = $("#TyLeGiamGia");
    const inputPromotionStartDay = $("#NgayBatDau");
    const inputPromotionEndDay = $("#NgayKetThuc");
    createInputNumber(inputPromotionDiscountRate,0,100)
    const bindingData = (khuyenMai = null)=>{
        resetErrors();
        if(khuyenMai == null)
            khuyenMai = {};
        inputPromotionName.val(khuyenMai.TenKhuyenMai ?? "")
        inputPromotionDiscountRate.val(khuyenMai.TyLeGiamGia ?? "")
        inputPromotionStartDay.val(convertDateToString(khuyenMai.NgayBatDau ?? ""))
        inputPromotionEndDay.val(convertDateToString(khuyenMai.NgayKetThuc ?? ""))
    }

    formEditPromotion.on("submit",function(ev){
        ev.preventDefault();        
        let formData = $(this).serialize(); 
        const id = formEditPromotion.data("update-id");
        if(id != null)
        {
            showMessage("Thông báo","Xác nhận cập nhật khuyến mãi '"+id+"'?",()=>{
                Api.update(id,formData,(res)=>{                    
                    handleCreateToast("success","Cập nhật khuyến mãi thành công",null,true);                     
                    refreshTab()
                },(res)=>{                    
                    resetErrors();
                    showErrors(res.errors)        
                })
            })
        }
        else
        {
            showMessage("Thông báo","Xác nhận tạo khuyễn mãi?",()=>{
                Api.create(formData,(res)=>{                                    
                    handleCreateToast("success","Tạo khuyễn mãi thành công",null,true);                     
                    refreshTab()
                },(res)=>{                                      
                    resetErrors();
                    showErrors(res.errors)        
                })
            })
        }
    })

    const showErrors = (errors)=>{
        for (const key in errors) {
            if (Object.hasOwnProperty.call(errors, key)) {
                const error = errors[key];
                $(`.error-validate-update.${key}`).text(error[0])
            }
        }   
    }
    const refreshTab = ()=>{
        getPromotion(statusPresent,tabPresent); 
        modalEditPromotiom.modal("hide") 
    }

    const resetErrors = ()=>{
        $(`.error-validate-update`).each(function(){
            $(this).text("")
        })
    }
})