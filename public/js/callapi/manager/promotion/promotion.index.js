

const CallApiPromotion = (data,func_success,func_fail,method = "GET",prefix = "")=>{
    return BuildCallApi(
        data,
        func_success,
        func_fail,
        method,
        BASE_URL_API+PREFIX_MANAGER+PREFIX_PROMOTION,
        prefix)
}

const CallApiPromotionAll = (func_success,func_fail)=>{
    return CallApiPromotion(null,func_success,func_fail)
}

const CallApiPromotionShow = (maKM,func_success,func_fail)=>{
    return CallApiPromotion(null,func_success,func_fail,METHOD_GET,maKM)
}
const CallApiPromotionCreate = (data,func_success,func_fail)=>{
    return CallApiPromotion(data,func_success,func_fail,METHOD_POST)
}
    
const CallApiPromotionUpdate = (maKM,data,func_success,func_fail)=>{
    return CallApiPromotion(data,func_success,func_fail,METHOD_PUT,maKM)
}
const CallApiPromotionDelete = (maKM,func_success,func_fail)=>{
    return CallApiPromotion(null,func_success,func_fail,METHOD_DELETE,maKM)
}

