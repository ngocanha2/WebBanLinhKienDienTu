const inputPhoneNumber =$("#SDT");
const btnAdd = $("#btn-add-supplier");

createInputNumber(inputPhoneNumber,0,9999999999,false)

const modal = $("#modal-edit-supplier");
const elementShow = $("#tbody-supplier");

const buildSupplierFontend = new BuildFontendRestFullApi(
    BASE_URL_API+PREFIX_MANAGER+PREFIX_SUPPLIER,elementShow,modal,btnAdd,"MaNCC",(item)=>{
        return $(`<tr>
                        <td>${item.MaNCC}</td>
                        <td>${item.TenNCC}</td>
                        <td>${item.DiaChi}</td>
                        <td>${item.SDT}</td>                            
                        <td class="td-center">
                           
                            <button class="btn btn-outline-primary btn-update" data-bs-toggle="modal" data-bs-target="#modal-edit-supplier">Sửa</button>
                            <button class="btn btn-outline-danger btn-delete">Xóa</button>
                            
                        </td>
                    </tr>`)
    }).handle()