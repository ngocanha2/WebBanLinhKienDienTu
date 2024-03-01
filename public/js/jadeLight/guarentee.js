
var elementgroupStatus = document.querySelector('.status-group-js');
var ListElementItemStatus = elementgroupStatus.querySelectorAll('.title-status');
var elementActive = elementgroupStatus.querySelector('.active');

var contentList = document.querySelector('.contentStatus');
 //var flag =0;
var flag = localStorage.getItem('vtWork') || 0;
localStorage.setItem('vtWork', flag);
console.log("flagg 000", flag);



function setUI(item){
    elementActive.classList.remove('active');
        elementActive = item;
        item.classList.add('active');
}


ListElementItemStatus.forEach( (item, index )=>{
    item.addEventListener('click',function(){
        flag = index;
        localStorage.setItem('vtWork', flag);
        console.log("flagg", flag);
        setUIAfterUpdate(item);
    })
})

setUIAfterUpdate(ListElementItemStatus[flag]);

function UpdateStatus(id, tt){
    
    showMessage("Thông báo","Xác nhận cập nhật trạng thái mới", 
        function(){
            capNhatTrangThai(id, tt+1)
        },
        function(){
            
        })
}

function cancelStatus(id){
    
    showMessage("Thông báo","Xác nhận hủy yêu cầu bảo hành", 
        function(){
            capNhatTrangThai(id, 3)
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
            //console.log(response.message);
           // alert("Cập nhật trạng thái thành công");
            handleCreateToast("success","Cập nhật thành công")
           setTimeout(function(){
            location.reload(true)
            flag = localStorage.getItem('vtWork') || 0
           },2000)
           
            //load lại data   
        },
        error: function(error) {
            console.error('Lỗi khi gửi yêu cầu cập nhật trạng thái:', error);
           handleCreateToast("erorr","cập nhật thấy bại")
         //  alert("thất bại")
        }
    });
}

function redirectCreateOrderHandel(id){
    this.location.href=`/orderhandelguarantee/${id}`
}

function setUIAfterUpdate(item){
    setUI(item);
    // flag = index;
    if(flag==0){
        contentList.innerHTML="";
        YCBH.forEach(item => {
            let html = ` 
            <td> ${item.MaHang}</td>
            <td> ${item.TenHang}</td>
            <td><img style="width: 100px" src="../images/${item.HinhAnh}"> </td>
            <td>${item.SoLuong}</td>
            <td>${item.ThoiGianBaoHanh} Tháng </td>
            <td>${item.MaDonhang}</td>
            <td>${item.HoVaTen}</td>`
            if(item.SDT != null){
                html+= `<td>${item.SDT}</td>`
            }else 
            {
                html+=`<td>${item.SDTKH}</td>`
            }

            html+= `<td>${item.NgayMua}</td>
                    <td>${item.NgayYeuCau}</td>
                    `

            if(item.DaXuLy == 0)
                html+= `<td><div>
                <button class="btn btn-warning btnUpdate" onclick="UpdateStatus(${item.id},${item.DaXuLy})">Tiếp nhận </button>
                <p></p>
                <button class="btn btn-danger btnUpdate" onclick="cancelStatus(${item.id})">Hủy  </button>
            </div></td>`
            else if(item.DaXuLy==1)
                html+= `<td> <button class="btn btn-primary btnUpdate" onclick="redirectCreateOrderHandel(${item.id})">Xác nhận </button> 
                <p></p>
                <button class="btn btn-secondary btnUpdate" onclick="cancelStatus(${item.id},${item.DaXuLy})">Từ chối</button>
                </td>`
            else if(item.DaXuLy==2)
            html+= `<td>Đã xử lý <br> <a href='/admin/detailorderhandelguarantee/${item.id}'> Chi tiết bảo hành-sửa chữa</a></td>`
                else html+= "<td>Đã Hủy</td>"
            let currentUrl = window.location.href;
            let newUrl = currentUrl.replace("/admin/guarantee", `/admin/detailguarantee/${item.id}`);
            
            html += `<td> <a href=${newUrl}>Chi tiết </a></td></tr>`;
            contentList.innerHTML += html;
        });
        
    } else{
        contentList.innerHTML="";
        YCBH.forEach((item) => {
           if(item.DaXuLy == flag-1){
                let html = `<tr> 
                <td> ${item.MaHang}</td>
                <td> ${item.TenHang}</td>
                <td><img style="width: 100px" src="../images/${item.HinhAnh}"> </td>
                <td>${item.SoLuong}</td>
                <td>${item.ThoiGianBaoHanh} Tháng </td>
                <td>${item.MaDonhang}</td>
                <td>${item.HoVaTen}</td>`
                if(item.SDT != null){
                    html+= `<td>${item.SDT}</td>`
                }else 
                {
                    html+=`<td>${item.SDTKH}</td>`
                }

                html+= `<td>${item.NgayMua}</td>
                        <td>${item.NgayYeuCau}</td>`
                        if(item.DaXuLy ==0)
                html+= `<td><div>
                <button class="btn btn-warning btnUpdate" onclick="UpdateStatus(${item.id}, ${item.DaXuLy})">Tiếp nhận </button>
                <p></p>
                <button class="btn btn-danger btnUpdate" onclick="cancelStatus(${item.id})">Hủy  </button>
                </div></td>`
                else if(item.DaXuLy==1)
                    html+= `<td> <button class="btn btn-primary btnUpdate" onclick="redirectCreateOrderHandel(${item.id})"> Xác nhận </button> 
                    <p></p>
                    <button class="btn btn-secondary btnUpdate" onclick="cancelStatus(${item.id},${item.DaXuLy})">Từ chối</button>
                    </td>`
                else if(item.DaXuLy==2)
                    html+= `<td>Đã xử lý <br> <a href='/admin/detailorderhandelguarantee/${item.id}'> Chi tiết bảo hành-sửa chữa </a></td>`
                else
                    html+= "<td>Đã Hủy</td>"

              
                let currentUrl = window.location.href;
                let newUrl = currentUrl.replace("/admin/guarantee", `/admin/detailguarantee/${item.id}`);
                
                html += `<td> <a href=${newUrl}>Chi tiết </a></td></tr>`;

                contentList.innerHTML += html;
           }

        });
    }
}



