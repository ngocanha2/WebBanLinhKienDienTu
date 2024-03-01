$(()=>{

    const supplier = $("#supplier-id");
    const modalShowDetails = $("#modal-details");
    const tableOrderSupplier = $("#tbody-order-supplier");
    const tableDelivery = $("#tbody-delivery");
    new CallApi(PREFIX_MANAGER + PREFIX_SUPPLIER)
    .get((res)=>{
        var s = `<option value="-1">-- Tất cả --</option>`
        res.data.forEach(item => {
            s+=`<option value="${item.MaNCC}">${item.MaNCC} - ${item.TenNCC}</option>`
        });
        supplier.html(s)        
        new BuildFontendRestFullApi(PREFIX_DELIVERY,["tab","tab-pane",`
                        <table class="table table-hover table-striped table-bordered" border="1">
                            <tr>
                                <th>Số phiếu giao</th>
                                <th>Số phiếu đặt</th>
                                <th>Ngày giao</th>
                                <th>Nhà cung cấp</th>                            
                                <th>Tổng số lượng</th>
                                <th>Thành tiền</th>
                                <th>Trạng thái</th>
                                <th>Ghi chú</th>                            
                                <th></th>
                            </tr>
                            <tbody class="show-data">

                            </tbody>
                        </table> `],null,null,"SoPhieuGiaoHang",(item,api)=>{                            
                            let s = `<tr>
                                        <td>${item.SoPhieuGiaoHang}</td>
                                        <td>${item.SoPhieuDatHang}</td>
                                        <td>${item.NgayGiao}</td>
                                        <td>${item.MaNCC} - ${item.TenNCC}</td>                            
                                        <td>${item.TongSoLuong}</td>
                                        <td>${item.ThanhTien}</td>
                                        <td class="td-status">${item.TrangThai}</td>
                                        <td>${item.GhiChu ?? ""}</td>
                                        <td class="td-operation">                                            
                                            <button class="btn btn-outline-info btn-details">Chi tiết</button>                                            
                                        </td>
                                    </tr>`
                            const row = $(s);
                            row.find(".btn-details").click(()=>{
                                modalShowDetails.modal("show")
                                api.show(item.SoPhieuGiaoHang,(res)=>{
                                    console.log(res)
                                    tableOrderSupplier.html("")
                                    tableDelivery.html("")                                    
                                    res.data.chitietdathang.forEach(element=>{
                                        tableOrderSupplier.append(`<tr>
                                                    <td>${element.SoPhieuDatHang}</td>
                                                    <td>${element.MaHang} - ${element.TenHang}</td>
                                                    <td>${element.SoLuong}</td>
                                                    <td>${element.SoLuong-element.SoLuongDaGiao}</td>
                                                </tr>`)
                                    })
                                    res.data.chitietgiaohang.forEach(element=>{
                                        tableDelivery.append(`<tr>
                                                    <td>${element.SoPhieuGiaoHang}</td>
                                                    <td>${element.MaHang} - ${element.TenHang}</td>
                                                    <td>${element.SoLuong}</td>                                                    
                                                </tr>`)
                                    })
                                },(res)=>{
                                    console.log(res)
                                })
                            })
                            if(item.TrangThai=="Chờ xác nhận")
                            {
                                const btnUpdateStatus = $(`<button class=" btn btn-info" style="margin:4 0;">Xác nhận</button>`)
                                const brnCancel = $(`<button class="btn btn-outline-danger btn-cancel">Từ chối</button>`)
                                btnUpdateStatus.click(()=>{
                                    showMessage("Thông báo","Số lượng sản phẩm các chi tiết giao hàng của phiêu giao hàng này sẽ được cập nhật vào kho, xác nhận?",()=>{
                                        api.patch(item.SoPhieuGiaoHang,null,(res)=>{
                                            handleCreateToast("success",res.message,null,true);
                                            btnUpdateStatus.remove();
                                            brnCancel.remove();
                                            row.find(".td-status").text("Đã xác nhận")
                                        },(res)=>{
                                            console.log(res)
                                        })
                                    });   
                                })
                                row.find(".td-operation").prepend(brnCancel);
                                row.find(".td-operation").prepend("<br>");    
                                row.find(".td-operation").prepend(btnUpdateStatus);                                                            
                                brnCancel.click(()=>{
                                    showMessage("Bạn muốn từ chối phiếu giao hàng này?","Phiếu giao hàng này sẽ bị hủy, nếu bị từ chối",(value)=>{
                                        api.destroy(item.SoPhieuGiaoHang,{
                                            LyDo:value
                                        },(res)=>{
                                            handleCreateToast("success",res.message,null,true);
                                            btnUpdateStatus.remove();
                                            brnCancel.remove();
                                            row.find(".td-status").text("Từ chối")
                                        },(res)=>{
                                            console.log(res)
                                        })
                                    },null,"text","Vui lòng nhập lý do từ chối");   
                                })                                
                            }
                            return row
                        },null,null,()=>{
                            return {
                                dataFilter:{
                                    MaNCC:supplier.val()
                                },
                                btnFilter:supplier
                            }
                        }).handle();
    },(res)=>{
        console.log(res)
    },{
        status:0
    })
})