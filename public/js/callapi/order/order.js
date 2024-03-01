
const CallApiOrder = (data,func_success,func_fail,method = "GET",prefix = "")=>{
    $.ajax({
        url: BASE_URL_API+PREFIX_ORDER+prefix,
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

const CallApiBuildOrder = (ma_hangs,func_success,func_fail)=>{
    return  CallApiOrder({
        ma_hangs:ma_hangs
    },func_success,func_fail,METHOD_POST,PREFIX_BUILD);
}

const CallApiOrderCheckout = (func_success,func_fail)=>{
    return  CallApiOrder(null,func_success,func_fail,METHOD_GET,PREFIX_CHECKOUT);
}

const CallApiOrderPostCheckout = (dia_chi_nhan_hang,func_success,func_fail)=>{
    return  CallApiOrder(dia_chi_nhan_hang,func_success,func_fail,METHOD_POST,PREFIX_CHECKOUT);
}
