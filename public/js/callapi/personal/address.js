const CallApiAddress = (data,func_success,func_fail,method = "GET",prefix = "")=>{
    $.ajax({
        url: BASE_URL_API+PREFIX_PERSONAL+PREFIX_ADDRESS+prefix,
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

var GetAddressAll = ( func_success,func_fail)=>{
    CallApiAddress(null,func_success,func_fail)
}

var SetAddressDefault = (id,func_success,func_fail)=>{
    CallApiAddress(null,func_success,func_fail, METHOD_PUT, id +"/" + PREFIX_SET_DEFAULT) 
}

var DeleteAddress = (id,func_success,func_fail)=>{
    CallApiAddress(null,func_success,func_fail, METHOD_DELETE, id)   
}

var UpdateAddress = (id,formData,func_success,func_fail)=>{
    CallApiAddress(formData,func_success,func_fail, METHOD_PUT, id)   
}

var InsertAddress = (formData,func_success,func_fail)=>{        
    CallApiAddress(formData,func_success,func_fail, METHOD_POST)
}
