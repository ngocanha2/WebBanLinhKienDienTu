let elemetTenNV = document.getElementById('tenNV');
let elemetTenDN = document.getElementById('tenDN');
let elemetMatKhau = document.getElementById('matKhau');
let elemetDiaChi = document.getElementById('diaChi');
let elemetNgaySinh = document.getElementById('ngaySinh');
let elemetSDT = document.getElementById('sdt');
let elemetGioiTinh = document.getElementById('gioiTinh');
let elementMKHienTai = document.getElementById('matKhauHienTai');
let elementMKMoi = document.getElementById('matKhauMoi');
let elementMKMoi1 = document.getElementById('matKhauMoi1');


const formEmployee = $("#form-employee");//update, insert
formEmployee.on("submit",(ev)=>{
    
    if(elemetTenNV.value.trim() == "" || elemetTenDN.value.trim() == "" || 
    elemetMatKhau.value.trim() == "" || elemetDiaChi.value.trim() == "" ||
    elemetSDT.value.trim() == "" || elemetNgaySinh.value.trim() == "" ||
    elemetGioiTinh.value.trim() == "")
    {
        handleCreateToast("error",'Vui lòng nhập đầy đủ thông tin',"err",true);
        ev.preventDefault();
        return;
    }
    if(!/^\d+$/.test(elemetSDT.value.trim()))
    {
        handleCreateToast("error",'Số điện thoại không được nhập chữ',"err1",true);
        ev.preventDefault();
        return;
    }
    else
    {
        handleCreateToast("success",'Lưu nhân viên thành công',"err2",false);
    }
});

const formInformation = $("#form-information");//update, insert
formInformation.on("submit",(ev)=>{
    
    if(elemetTenNV.value.trim() == "" || elemetTenDN.value.trim() == ""
     || elemetDiaChi.value.trim() == "" || elemetGioiTinh.value.trim() == "" ||
    elemetSDT.value.trim() == "" || elemetNgaySinh.value.trim() == "" )
    {
        handleCreateToast("error",'Vui lòng nhập đầy đủ thông tin',"err3",true);
        ev.preventDefault();
        return;
    }
    if(!/^\d+$/.test(elemetSDT.value.trim()))
    {
        handleCreateToast("error",'Số điện thoại không được nhập chữ',"err4",true);
        ev.preventDefault();
        return;
    }
    else
    {
        handleCreateToast("success",'Cập nhật thông tin thành công',"err5",false);
    }
});
//Chang pass
const formPass = $("#form-password");//update, insert
formPass.on("submit",(ev)=>{
    
    if(elementMKHienTai.value.trim() == "" )
    {
        handleCreateToast("error",'Vui lòng nhập đầy đủ mật khẩu',"err6",true);
        ev.preventDefault();
        return;
    }
    if(elementMKMoi.value.trim() != elementMKMoi1.value.trim())
    {
        handleCreateToast("error",'Mật khẩu mới và xác thực không trùng khớp',"err7",true);
        ev.preventDefault();
        return;
    }
   
    // if(elementMatKhau != elementMKHienTai.value.trim())
    // {
    //     handleCreateToast("error",'Mật khẩu hiện tại chưa đúng',"err",true);
    //     ev.preventDefault();
    //     return;
    // }
    else
    {
        handleCreateToast("success",'Cập nhật thông tin thành công',"err8",false);
    }
    
});
