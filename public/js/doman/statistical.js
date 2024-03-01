let elementNgayBD = document.getElementById('NgayBatDau');
let elementNgayKT = document.getElementById('NgayKetThuc');

const formUpdateProduct = $("#form-statistical");//update
formUpdateProduct.on("submit",(ev)=>{
    if(elementNgayBD.value.trim()=="")
    {
        handleCreateToast("error",'Vui lòng chọn ngày bắt đầu',"err",true);
        ev.preventDefault();
        return;
    }
    if(elementNgayKT.value.trim()=="")
    {
        handleCreateToast("error",'Vui lòng chọn ngày kết thúc',"err1",true);
        ev.preventDefault();
        return;
    }
})
