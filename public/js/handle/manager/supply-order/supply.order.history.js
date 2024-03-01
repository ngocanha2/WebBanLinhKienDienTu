$(()=>{
    const tableOrderSupplier = $("#tbody-order-supplier")
    const api = new CallApi(PREFIX_MANAGER + PREFIX_SUPPLY_ORDER)
    const modal = $("#modal-details")
    $(".btn-show-details").each(function(){        
        $(this).click(()=>{
            modal.modal("show")
            api.show($(this).attr("sophieudathang"),(res)=>{
                console.log(res)  
                tableOrderSupplier.html("")
                res.data.forEach(element=>{
                    tableOrderSupplier.append(`<tr>
                                <td>${element.SoPhieuDatHang}</td>
                                <td>${element.MaHang} - ${element.TenHang}</td>
                                <td>${element.SoLuong}</td>
                                <td>${element.SoLuong-element.SoLuongDaGiao}</td>
                            </tr>`)
                })              
            },(res)=>{
    
            })
        })        
    })
})