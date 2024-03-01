

//---------------------------------------------------------- MỚI CODE------------------------

let elementNcc = document.getElementById('nhaCungCap');
let elementSupply = document.getElementById('nguonHangAll')
let listElementNguonHang = document.getElementById('nguonHangAll').querySelectorAll('.product');
let elmentTongTien = document.getElementById('sumCost');
let sumCosst =0;

elementNcc.addEventListener('change', function(){
    //kt table trỗng hay không
    if(document.getElementsByTagName('tbody')[0].getElementsByTagName('tr').length >0)
    {
       
        showMessage("Thông báo","Xóa dữ liệu trong bảng", 
        function(){
            //console.log("đã vô delete");
            document.getElementsByTagName('tbody')[0].innerHTML='';
            document.getElementById('quantity').value=0; 
            let maNCC = elementNcc.value + '-'
            sumCosst=0;
            elmentTongTien.innerText = '0';
            listElementNguonHang.forEach(item => {
            if(item.value.startsWith(maNCC)){
               item.style.display = 'block'
               elementSupply.value= item.value
            }else{
                item.style.display = 'none'
            }
            return;
           })
        },
        function(){
            console.log("đã vô cancel");
            let elementTableOriginal = document.getElementById('tableOrderProduct').getElementsByTagName('tbody')[0].getElementsByTagName('tr')[0].getElementsByTagName('td')[6].textContent
           

            elementNcc.value = hangHoas[parseInt(elementTableOriginal)].MaNCC;
            document.getElementById('quantity').value=0; 
            let maNCC = elementNcc.value + '-'
        }  
    )
         
        
    }
    document.getElementById('quantity').value=0; 
    let maNCC = elementNcc.value + '-'
    listElementNguonHang.forEach(item => {
    if(item.value.startsWith(maNCC)){
       item.style.display = 'block'
       elementSupply.value= item.value
    }else{
        item.style.display = 'none'
    }
   })  
})

let elementQuantity = document.getElementById('quantity');
elementQuantity.addEventListener('change',function(){
    if(elementQuantity.value < 0){
        elementQuantity.value = 0;
    }
})

//-------------------handel button add data---------------------
document.getElementById('addProductOrder').addEventListener("click", function() {
    //nhập thiếu dl
    if(elementNcc.value=="-1" || elementSupply.value=="-1"  ){
        alert('Vui lòng nhập đầy đủ thông tin');
        return;
    }
    if( elementQuantity.value==0){
        alert('Vui lòn nhập số lượng lớn hơn 0');
        return;
    }
        
    //thêm dữ liệu
    let table = document.getElementById('tableOrderProduct')
    let tBody= table.getElementsByTagName('tbody')[0];
    
    let productInfor = elementSupply.value.split('-')
    let vt = productInfor[2]
    
    //dl trùng, cập nhật số lượng
    let isExist = false;
    tBody.querySelectorAll('tr').forEach((item)=>{
        let mahang = item.getElementsByTagName('td')[0].textContent;
        if(mahang == productInfor[1])
        {
            isExist = true;
            //tính tiền mới
            let tienNew = parseInt(elementQuantity.value) * parseInt(item.getElementsByTagName('td')[2].textContent)
            //cập nhật số lượng
            item.getElementsByTagName('td')[3].textContent = parseInt( item.getElementsByTagName('td')[3].textContent) + parseInt(elementQuantity.value);
            //tính thành tiền
            item.getElementsByTagName('td')[4].textContent = parseInt( item.getElementsByTagName('td')[4].textContent) + tienNew
            //cập nhật tổng tiền
            sumCosst+=   tienNew
            elmentTongTien.textContent = sumCosst;
            return;  
        }   
    })
    
    //dl mới
    if(!isExist){
         //create a new row
        var newRow = document.createElement('tr');
        newRow.classList.add("chiTietRow");
        newRow.innerHTML=`<td scope="row" name="mahang">${hangHoas[vt].MaHang}</td>
                       <td scope="row" name="tenhang">${hangHoas[vt].TenHang}</td>
                       <td scope="row" name="giaban">${hangHoas[vt].GiaBan}</td>
                       <td scope="row" name="soluong">${elementQuantity.value}</td>
                       <td scope="row" name="thanhtien">${elementQuantity.value * hangHoas[vt].GiaBan}</td>
                       <td scope="row" onclick=deleteRow(this)><i class="bi bi-x-square"></i>  </td>
                       <td style="display: none;">${vt} </td>
                       `;
                       sumCosst += elementQuantity.value * hangHoas[vt].GiaBan;
                       
                       
       //bindings
       newRow.addEventListener('click', function(){
           let cells= this.getElementsByTagName('td');
           elementQuantity.value = cells[3].textContent;
           elementNcc.value =hangHoas[parseInt(cells[6].textContent)].MaNCC;
           elementSupply.value=elementNcc.value+"-"+ hangHoas[parseInt(cells[6].textContent)].MaHang + "-"+ parseInt(cells[6].textContent);
       })
       elmentTongTien.textContent = sumCosst;
    
       tBody.appendChild(newRow);
       
    }else{
        //alert("đã tồn tại");
    } 
})

//delete a row
function deleteRow(icon){
    let row = icon.parentNode;
    sumCosst-=   parseInt(row.getElementsByTagName('td')[4].textContent)
    elmentTongTien.textContent = sumCosst;
    row.parentNode.removeChild(row);
    
}


document.getElementById('insertDataSupply').addEventListener('click', function () {
   var TongSL=0;
    var hoadonData = {
        MaNV: 1,
            MaNCC: document.getElementById('nhaCungCap').value,
            TongSL: 0,
            ThanhTien: parseInt(document.getElementById('sumCost').innerText)
    }; 
   var chiTietData = [];

   document.querySelectorAll('.chiTietRow').forEach(function (row) {
    // Lấy giá trị từ các input trong dòng 
        var maHang = row.querySelector('[name="mahang"]').innerText;
        var soLuong = row.querySelector('[name="soluong"]').innerText;
        var donGia = row.querySelector('[name="giaban"]').innerText;

        // Thêm vào mảng chiTietData
        chiTietData.push({MaHang: maHang, SoLuong: soLuong, DonGia: donGia });
        TongSL+= parseInt(soLuong);

        hoadonData.TongSL = TongSL;
    });
   var csrfToken = $('meta[name="csrf-token"]').attr('content');

   // Gửi AJAX để thêm hóa đơn và lấy mã hóa đơn tự động tăng từ cơ sở dữ liệu
    $.ajax({
        type: 'POST',
        url: '/api/insert-supply-order',
        data:{_token: csrfToken,
            hoadonData:hoadonData,
            chiTietData:chiTietData
            },
        success: function (response) {
            console.log(response);
            handleCreateToast("success","Thêm đơn đặt hàng thành công")
            var SoPhieuDatHang = response.SoPhieuDatHang;

            //điều hướng sang trang xem chi tiết 
            setTimeout(()=>{
                var currentUrl = window.location.href;
                var newUrl = currentUrl.replace("/admin/supply", `/admin/detailsSupplyOrder/${response.SoPhieuDatHang}`);
                window.location.href = newUrl;
            },2000)

        },
        error: function (error) {
            alert("có lỗi")
            console.log("lỗi",error);
           
        }
    });
});
