const inputPhoneNumber =$("#SDT");
const btnAdd = $("#btn-add-category");


const modal = $("#modal-edit-category");
const elementShow = $("#tbody-category");

const buildcategoryFontend = new BuildFontendRestFullApi(
    BASE_URL_API+PREFIX_MANAGER+PREFIX_CATEGORY,elementShow,modal,btnAdd,"MaDanhMuc",(item)=>{
        return $(`<tr>
                        <td>${item.MaDanhMuc}</td>
                        <td>${item.TenDanhMuc}</td>
                        <td class="td-center">
                            <button class="btn btn-outline-primary btn-update" data-bs-toggle="modal" data-bs-target="#modal-edit-category">Sửa</button>
                            <button class="btn btn-outline-danger btn-destroy">Xóa</button>
                        </td>
                    </tr>`)
    }).handle()