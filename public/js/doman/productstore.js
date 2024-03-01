let elementTenSP = document.getElementById('tenSP');
let elementGiaBan = document.getElementById('giaBan');
let elementSLTon = document.getElementById('slTon');
let elementTGBaoHanh = document.getElementById('tgBaoHanh');
let elementMoTa = document.getElementById('moTa');
let elementHinh = document.getElementById('hinh');
const btn_Them = $('#btn_XacNhan');
const btn_Sua = $('#Sua');


const formUpdateProduct = $("#form-update-product");//update, insert
formUpdateProduct.on("submit",(ev)=>{
    if(elementTenSP.value.trim()=="")
    {
        handleCreateToast("error",'Không để trống tên sản phẩm',"err10",true);
        ev.preventDefault();
        return;
    }

    if(elementGiaBan.value.trim() == "")
    {
        handleCreateToast("error",'Vui lòng nhập giá bán',"err",true);
        ev.preventDefault();
        return;
    }
    if(elementGiaBan.value == 0)
    {
        handleCreateToast("error",'Nhập giá bán lớn hơn 0',"err1",true);
        ev.preventDefault();
        return;
    }
    if(!/^\d+$/.test(elementGiaBan.value.trim()))
    {
        handleCreateToast("error",'Giá bán chỉ nhập số',"err2",true);
        ev.preventDefault();
        return;
    }
    if(elementSLTon.value == 0)
    {
        handleCreateToast("error",'Nhập số lượng tồn lớn hơn 0',"err3",true);
        ev.preventDefault();
        return;
    }
    if(!/^\d+$/.test(elementSLTon.value.trim()))
    {
        handleCreateToast("error",'Số lượng tồn chỉ nhập số',"err4",true);
        ev.preventDefault();
        return;
    }
    if(!/^\d+$/.test(elementTGBaoHanh.value.trim()))
    {
        handleCreateToast("error",'Thời gian bảo hành chỉ nhập số',"err5",true);
        ev.preventDefault();
        return;
    }
    if(elementTGBaoHanh.value == 0)
    {
        handleCreateToast("error",'Nhập thời gian bảo hành lớn hơn 0',"err6",true);
        ev.preventDefault();
        return;
    }
    if(elementMoTa.value.trim()=="")
    {
        handleCreateToast("error",'Không để trống mô tả',"err7",true);
        ev.preventDefault();
        return;
    }
    if(elementMoTa.value.trim().length < 20)
    {
        handleCreateToast("error",'Mô tả ít nhất 20 kí tự',"err8",true);
        ev.preventDefault();
        return;
    }
    if(box_show_avatar.attr("update-product") == undefined && box_show_avatar.data("checkimg") == undefined)
    {
        handleCreateToast("error",'Vui lòng chọn hình ảnh cho sản phẩm',"err9",true);
        ev.preventDefault();
        return;
    }
    else
    {
        handleCreateToast("success",'Lưu sản phẩm thành công',"err9",false);
    }

    //
})


const chose_Image = $('#btn_ChonAnh');
const box_show_avatar = $('#list_hinh');
chose_Image.on("change",function(ev){
    showFileImage(this.files[0]);
})
function showFileImage(file) {            
    const fileType = file.type;
    const validExtensions = ['image/jpeg', 'image/jpg', 'image/png'];
    if (validExtensions.includes(fileType)) {
        const fileReader = new FileReader();
        fileReader.onload = function () {                          
            const fileUrl = fileReader.result;                                
            let img = $(`<div class="avatar-preview w-100 h-100" style="background: url(${fileUrl}); background-size:cover ">                                                          
                        </div>`);                                                                                                                         
            box_show_avatar.html(img);
            box_show_avatar.data("checkimg",true);
            box_show_avatar.fadeIn();
        }                
        fileReader.readAsDataURL(file);          
    } else {
        handleCreateToast("error","Không đúng định dạng hình ảnh!!!","info-images")        
    }
    title_choose_avatar.text("Chọn hoặc kéo thả ảnh vào đây")
}