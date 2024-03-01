const CallApiCarts = (data,func_success,func_fail,method = "GET",prefix = "")=>{
    $.ajax({
        url: BASE_URL_API+PREFIX_CART+prefix,
        type: method,
        data:data,
        success: function (res) {  
            if(typeof func_success === "function")
                func_success(res);           
        },
        error: function (xhr, status, error) {
            if(typeof func_fail === "function")
                func_fail(xhr.responseJSON);     
        }
    });
}


const CallApiGetCarts = (func_success,func_fail)=>{
    return  CallApiCarts(null,func_success,func_fail);
}
const CallApiCartInsert = (ma_hang,so_luong,func_success,func_fail)=>{
    return  CallApiCarts({
        ma_hang:ma_hang,
        so_luong:so_luong
    },func_success,func_fail,METHOD_POST);
}
const CallApiCartUpdate = (ma_hang,so_luong,func_success,func_fail)=>{
    return  CallApiCarts({
        ma_hang:ma_hang,
        so_luong:so_luong
    },func_success,func_fail,METHOD_PUT);
}

const CallApiCartDetele = (ma_hang,func_success,func_fail)=>{
    return  CallApiCarts({
        ma_hang:ma_hang,        
    },func_success,func_fail,METHOD_DELETE);
}
const CallApiCartDeteleAll = (func_success,func_fail)=>{
    return  CallApiCarts(null,func_success,func_fail,METHOD_DELETE,PREFIX_DELETE_ALL);
}

const CallApiCartGetQuantity = (func_success,func_fail)=>{
    return  CallApiCarts(null,func_success,func_fail,METHOD_GET,PREFIX_QUANTITY);
}