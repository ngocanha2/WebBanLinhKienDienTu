let idDH= CTYCBH[0].MaDonhang;
let idHH=CTYCBH[0].MaHang;
let tt=CTYCBH[0].DaXuLy;
let idyc = CTYCBH[0].id;

function UpdateNextStatus(){
    console.log(idyc)
    showMessage("Thông báo","Xác nhận cập nhật trạng thái mới", 
        function(){
            capNhatTrangThai(idyc, tt+1)
        },
        function(){
            
        })
}

function UpdateCancelStatus(){
    
    showMessage("Thông báo","Xác nhận hủy yêu cầu bảo hành", 
        function(){
            capNhatTrangThai(idyc,3)
        },
        function(){
            
        })
}

function capNhatTrangThai(id, tt) { 
    $.ajax({
        type: 'PUT',
        url: `/updateStatusGuarantee/${id}/${tt}`,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response.message);
            handleCreateToast("success","Cập nhật thành công")
           setTimeout(function(){
            location.reload(true)
           },2000)
        },
        error: function(error) {
            console.error('Lỗi khi gửi yêu cầu cập nhật trạng thái:', error);
           handleCreateToast("erorr","cập nhật thấy bại")

        }
    });
}

function redirectCreateOrderHandel(){
    this.location.href=`/orderhandelguarantee/${idyc}`
}