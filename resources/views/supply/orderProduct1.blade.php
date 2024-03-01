@extends('layouts.app')
@section('content')
<div class="row" style="margin-top:40px">
    <div class="col-md-12"> 
        <!-- <div class="row"> -->
            <select class="form-select " aria-label="Default select example" id="nhaCungCap">
                <option value="-1" selected>--Chọn nhà cung cấp--</option>
                @foreach($NCCs as $ncc)
                    <option value="{{$ncc->MaNCC}}">{{$ncc->TenNCC}} </option>
                @endforeach
            </select>

            <select class="form-select" aria-label="Default select example" id="nguonHangAll">
                <option value="-1" selected>--Chọn nguồn hàng--</option>
            @foreach($supplys as $index => $s)
                    <option class="product" value="{{$s->MaNCC}}-{{$s->MaHang}}-{{$loop->index}}">{{$s->GiaNhap}} - {{$s->TenHang}}  </option>
                @endforeach
                
            </select>
        <!-- </div> -->
        

        <div class="mb-3">
            <label for="quantity" class="form-label">Số lượng</label>
            <input type="number" class="form-control" id="quantity" placeholder="Nhập số lượng">
        </div>
        <button class="btn btn-primary" id="addProductOrder">Thêm</button>
    </div>    
</div>

<div class="row">
    <div class="col-md-10">
        <table class="table table-hover" id="tableOrderProduct">
            <thead>
                <tr>
                <th scope="col">Mã hàng</th>
                    <th scope="col">Tên hàng</th>
                    <th scope="col">Đơn giá</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Thành tiền</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            
        </table>
    </div>    
</div>

<script>
    let hangHoas = @json($supplys);
    let elementNcc = document.getElementById('nhaCungCap');
    let elementSupply = document.getElementById('nguonHangAll')
    let listElementNguonHang = document.getElementById('nguonHangAll').querySelectorAll('.product');

    elementNcc.addEventListener('change', function(){
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

    document.getElementById('addProductOrder').addEventListener("click", function() {
        if(elementNcc.value=="-1" || elementSupply.value=="-1"  ){
            alert('Vui lòng nhập đầy đủ thông tin');
            if( elementQuantity.value==0)
                alert('Vui lòn nhập số lượng lớn hơn 0');
            return;
        }
       
        let table = document.getElementById('tableOrderProduct')
        let tBody= table.getElementsByTagName('tbody')[0];
        
        let productInfor = elementSupply.value.split('-')
        let vt = productInfor[2]
        
        //create a new row
        var newRow = document.createElement('tr');
         newRow.innerHTML=`<td scope="row">${hangHoas[vt].MaHang}</td>
                        <td scope="row">${hangHoas[vt].TenHang}</td>
                        <td scope="row">${hangHoas[vt].GiaBan}</td>
                        <td scope="row">${elementQuantity.value}</td>
                        <td scope="row">${elementQuantity.value * hangHoas[vt].GiaBan}</td>
                        <td scope="row" onclick=deleteRow(this)><i class="bi bi-x-square"></i>  </td>
                        <td style="display: none;">${vt} </td>
                        `;
        //bindings
        newRow.addEventListener('click', function(){
            let cells= this.getElementsByTagName('td');
            elementQuantity.value = cells[3].textContent;
            elementNcc.value =hangHoas[parseInt(cells[6].textContent)].MaNCC;
            elementSupply.value=elementNcc.value+"-"+ hangHoas[parseInt(cells[6].textContent)].MaHang + "-"+ parseInt(cells[6].textContent)
        })
        tBody.appendChild(newRow);
    })

    //delete a row
    function deleteRow(icon){
        let row = icon.parentNode;
        row.parentNode.removeChild(row);
    }
</script>

@endsection

