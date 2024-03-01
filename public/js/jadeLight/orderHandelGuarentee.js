// console.log(YCBH)

let thanhtien =0;
let slDoiMoi =0;
let slSuaChua=0;
let thanhTien =0;
let sl = parseInt(document.getElementById("SLBH").innerText);



let ElementSlThayMoi= document.getElementById("slThayMoi")

let ElementSlSuaChua= document.getElementById("slSuaChua")
let ElementMoTa= document.getElementById("moTa")

let ElementThanhTien= document.getElementById("thanhTien")
ElementSlThayMoi.value =sl;
ElementSlSuaChua.value = 0;
thanhTien = parseInt(ElementThanhTien.value);

ElementSlThayMoi.addEventListener("input", function(){

    if(ElementSlThayMoi.value ===""){
        ElementSlThayMoi.value =0
    }
    slDoiMoi = ElementSlThayMoi.value
    if(slDoiMoi < 0){
        ElementSlThayMoi.value =0
    }else if(slDoiMoi > sl){
        ElementSlThayMoi.value = sl
        slDoiMoi = sl
    }
    ElementSlSuaChua.value = sl - slDoiMoi
    slSuaChua = sl-slDoiMoi
})

ElementSlSuaChua.addEventListener("input", function(){

    if(ElementSlSuaChua.value ===""){
        ElementSlSuaChua.value =0
    }
    slSuaChua = ElementSlSuaChua.value

    if(slSuaChua < 0){
        ElementSlSuaChua.value =0

    }else if(slSuaChua > sl){
        ElementSlSuaChua.value = sl
        slSuaChua = sl
    }
    ElementSlThayMoi.value = sl - slSuaChua
    slDoiMoi = sl - slSuaChua
})

ElementThanhTien.oninput = function(){
    
        if (ElementThanhTien.value === "" || isNaN(ElementThanhTien.value)) {
            // Gán giá trị bằng 0
            ElementThanhTien.value = "";
            thanhTien =0;
        }
        thanhTien = parseInt(ElementThanhTien.value);
}

function updatefinalstatus(id, tt){
console.log("id",id)
    $.ajax({
        type: 'PUT',
        url: `/updateNextStatusGuarantee/${id}/${tt}`,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
           
            handleCreateToast("success","Cập nhật thành công")
        },
        error: function(error) {
            handleCreateToast("erorr","cập nhật thấy bại")
        }
    });
}
let csrfToken = $('meta[name="csrf-token"]').attr('content');

document.getElementById("btnThemhDBH").addEventListener("click", function(){   

    //thêm hóa đơn
    showMessage("Thông báo","Hoàn thành xử lý yêu cầu bảo hành - sửa chữa", 
    function(){
        var hoadondata = {
            'YeuCauBaoHanhId':YCBH.id,
            'SoLuongThayMoi':parseInt(ElementSlThayMoi.value),
            'SoLuongSuaChua':parseInt(ElementSlSuaChua.value),        
            'ThanhTien':thanhTien,
            'MoTa':ElementMoTa.value
        };
    
    
        $.ajax({
            type: 'POST',
            url: '/insertorderhandelguarantee',
            data: {_token: csrfToken,
                hoadondata: hoadondata},
    
            success: function(response) {
                console.log(response);
                updatefinalstatus(YCBH.id, YCBH.DaXuLy+1)
    
                handleCreateToast("success","Thêm hóa đơn bảo hành - sửa chữa thành công")
    
                setTimeout(function(){
                    this.location.href=`/admin/detailorderhandelguarantee/${YCBH.id}`
                },1500)
            },
            error: function(error) {
                console.log(error);
                handleCreateToast('Đã xảy ra lỗi khi thêm hóa đơn');
            }
        });
    },
    function(){
        
    })
})

