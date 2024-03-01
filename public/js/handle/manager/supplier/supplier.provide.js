$(()=>{
    // SOURCE_GOODS

    const supplier = $("#supplier-id");   
    const selectProduct = $("#product-id"); 
    const boxBody = $("#box-body")
    const elementPrice = $("#GiaNhap")
    createInputNumber(elementPrice,1,9999999999);
    const btnAdd = $("#btn-add")
    const apiSoureGoods = new CallApi(PREFIX_MANAGER+SOURCE_GOODS)
    new CallApi(PREFIX_MANAGER + PREFIX_SUPPLIER)
    .get((res)=>{
        console.log(res)
        var s = `<option value="-1">-- Tất cả --</option>`
        res.data.forEach(item => {
            s+=`<option value="${item.MaNCC}">${item.MaNCC} - ${item.TenNCC}</option>`
        });
        supplier.html(s);
    },(res)=>{

    },{
        status:0
    });     
    supplier.change(()=>{
        loadData(supplier.val(),1)
    })  
    btnAdd.click(()=>{
        if(selectProduct.val() == null)
            return handleCreateToast("error","Vui lòng chọn 1 nhà cung cấp cụ thể","error-product",true)
        if(elementPrice.val() == null || elementPrice.val().trim() == "")
        {
            elementPrice.focus();
            return handleCreateToast("error","Vui lòng nhập số lượng","error-quantity",true)
        }
        showMessage("Thông báo","Xác nhận tạo nguồn hàng này?",()=>{
            apiSoureGoods.create({
                MaHang:selectProduct.val(),
                GiaNhap:elementPrice.val()
            },(res)=>{
                handleCreateToast("success","Thêm nguồn hàng thành công",null,true);
                elementPrice.val("")                
                loadData(supplier.val(),getPage());
            },(res)=>[
                console.log(res)
            ],supplier.val())
        })
    })
    const loadData = (MaNCC,page=1)=>{
        selectProduct.html("")
        elementPrice.val("")
        if(MaNCC == -1)
        {            
            selectProduct.prop("disabled",true)
            elementPrice.prop("disabled",true)
            btnAdd.prop("disabled",true)            
        }
        apiSoureGoods.all((res)=>{
            console.log(res)
            selectProduct.prop("disabled",false)            
            if(res.data.hangHoas!=null)
            {         
                if(res.data.hangHoas.length!=0)
                {
                    btnAdd.prop("disabled",false)
                    elementPrice.prop("disabled",false)
                    var s = "";
                    res.data.hangHoas.forEach(item=>{                                
                        s+=`<option value="${item.MaHang}">${item.MaHang} - ${item.TenHang}</option>`                                
                    });
                    selectProduct.html(s);
                }
                else
                {
                    elementPrice.prop("disabled",true)                       
                    btnAdd.prop("disabled",true)            
                }
            } 
            else             
            {
                elementPrice.prop("disabled",true)
                btnAdd.prop("disabled",true)
            }
            if(res.data.nguonHangs.data.length == 0)
            {
                boxBody.html(`<center><h3>Không tìm thấy dữ liệu</h3></center>`) 
                return;
            }
            boxBody.html(`<table class="table table-hover table-striped table-bordered" border="1">
                            <tr>
                                <th>Mã nhà cung cấp</th>
                                <th>Hàng hóa</th>                    
                                <th>Giá nhập</th>                            
                                <th></th>
                            </tr>
                            <tbody id="tbody-supplier-provide"></tbody>
                            </table>
                            `)
            const tableSupplierProvide = $("#tbody-supplier-provide");
            res.data.nguonHangs.data.forEach(item=>{
                const row = $(`<tr>
                                <td>${item.MaNCC}</td>
                                <td>${item.MaHang} - ${item.TenHang}</td>                    
                                <td>
                                    <center class="td-input-price">
                                    </center>
                                    <center class="btn-update-price">
                                        
                                    </center>
                                </td>                            
                                <td class="td-operation"></td>
                            </tr>`)
                const btnDelete = $(`<button class="btn btn-danger btn-delete">Xóa</button>`)
                let legnth = res.data.nguonHangs.data.length
                btnDelete.click(()=>{
                    showMessage("Thông báo","Xác nhận xóa nguồn hàng này?",()=>{
                        apiSoureGoods.delete( item.MaNCC + "/" + item.MaHang,(res)=>{
                            handleCreateToast("success","Xóa nguồn hàng thành công",null,true);                            
                            loadData(supplier.val(),legnth == 1 ? page-1 : page);
                        },(res)=>{                            
                        })
                    })
                })
                row.find(".td-operation").append(btnDelete)
                const inputUpdatePrice = $(`<input type="number" class="input-update-price" value="${item.GiaNhap}" placeholder="Giá nhập">`)
                const btnUpdatePrice = $(`<button class="btn btn-outline-warning" style="display:none">Sửa</button>`)
                inputUpdatePrice.data("price",item.GiaNhap);
                inputUpdatePrice.on("input",()=>{
                    let price = inputUpdatePrice.data("price")
                    if(price != inputUpdatePrice.val())
                    {
                        btnUpdatePrice.slideDown()
                    }
                    else
                        btnUpdatePrice.slideUp()
                })
                btnUpdatePrice.click(()=>{
                    apiSoureGoods.update(item.MaNCC + "/" + item.MaHang,{
                        GiaNhap:inputUpdatePrice.val()
                    },(res)=>{
                        handleCreateToast("success","Cập nhật thành công",null,true);
                        inputUpdatePrice.data("price",inputUpdatePrice.val());
                        btnUpdatePrice.slideUp()
                    },(res)=>{

                    })
                })
                createInputNumber(inputUpdatePrice,1,9999999999);
                row.find(".btn-update-price").append(btnUpdatePrice)
                row.find(".td-input-price").append(inputUpdatePrice)
                tableSupplierProvide.append(row)
            }) 
            loadPaginationButtons(res.data.nguonHangs.current_page,res.data.nguonHangs.last_page,function(page,numpages){
                loadData(MaNCC,page)
            })           
        },(res)=>{
            console.log(res)
        },{
            page:page
        },MaNCC)
    }
    loadData(-1,getPage())
})