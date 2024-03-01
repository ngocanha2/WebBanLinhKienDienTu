var convertDateToString = (date)=>{
    if(date == null || date == "")
        return;
    return new Date(date).toISOString().split('T')[0];
}
var convertDateTimeToString = (date)=>{
    if(date == null || date == "")
        return;
    if(date.indexOf("T")==-1)
        return date
    let valueTime = new Date(date).toISOString();        
    let vls = valueTime.split("T");
    valueTime = vls[0] +" "
    vls = vls[1].split(":");
    valueTime+=vls[0]+":"+vls[1];
    return valueTime;
}

var GetContentRatingLevel = (rating)=>{
    return rating == 5 ? "Cực kì hài lòng" : rating == 4 ? "Hài lòng" : rating == 3 ? "Bình thường" : rating == 2 ? "Không hài lòng" : "Quá tệ";
}

var Subtring = (value, end = 41)=>{
    return value.length <= end-1 ? value : value.substring(0, end)+"...";
}

function containsSpecialCharacter(str) {
    const pattern = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?\s]+/;
    return pattern.test(str);
}
function checkForUnsignedString(str) {
    const pattern = /[^\x00-\x7F]+/;
    return pattern.test(str);
}

function isDigit(str) {    
    const pattern = /[0-9]+/;
    return pattern.test(str);
}
function isEmail(str) {    
    const pattern = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    return pattern.test(str);
}

const createInputNumber = (element,min = null,max = 99999999999,numeric = true)=>{    
    if(typeof element ==="string")
        element = $(element);
    element.data("minimum",min)
    element.data("maximum",max)        
    element.on("keydown",function(ev){                
        if(!isDigit(ev.key) && ev.key!=="Backspace" && ev.key!=="Delete" && ev.key!=="ArrowLeft" && ev.key!=="ArrowRight" && ev.key!=="Shift" && ev.key!=="Home" && ev.key!=="End")    
            ev.preventDefault();
    });
    if(numeric == true)    
        element.on("input",function(ev){             
            if($(this).val()!="")      
            {          
                const minimum = $(this).data("minimum");                
                const maximum = $(this).data("maximum");
                var value = parseInt($(this).val());
                $(this).val(value == (minimum-1) ? minimum : value > maximum ? maximum : value);                    
            }
        });
}


var createEventSelect = (dom)=>{
    if(typeof dom === "string")
        dom = $(dom);
    dom.click(function(){
        $(this).select();
    })
}



var createEventBlurCheckLength = (element,length,element_msg,msg)=>{
    element.blur(function(){
        checkLength($(this),length,element_msg,msg)
    })
}

var checkLength = (element,length,element_msg,msg)=>{
    if(element.val().length != length)
    {
        errorShow(element,element_msg,msg);
        return false;
    }
    else
    {
        errorHide(element,element_msg);
        return true;
    }            
}

var split = (str,separator)=>{
    ss = str.split(separator);
    let sss = ""
    for(s of ss)
        sss+=s;
    return s;
}

var createEventInputNotSpecialCharacter = (element)=>{
    element.on("keydown",function(ev){
        if(containsSpecialCharacter(ev.key) || checkForUnsignedString(ev.key))    
            ev.preventDefault();
    })
}

var createEventInputNotImptyEmail = (element,element_msg = null,msg = null,msgEmail=null)=>{
    element.blur(function(){
        checkInputNotImptyEmail($(this),element_msg,msg,msgEmail);     
    })
}


var createEventInputNotImptyCustom = (element,element_msg = null,msg = null)=>{
    element.blur(function(){
        checkInputNotImptyCusTom($(this),element_msg,msg);     
    })
}

var errorShow = (input_size,dom_mess = null,msg = null)=>{
    input_size.addClass("border-error") 
    if(dom_mess==null)
        return;
    dom_mess.text(msg);
    dom_mess.slideDown()           
}

var errorHide = (input_size,dom_mess = null)=>{    
    input_size.removeClass("border-error")    
    if(dom_mess==null)
        return;
    dom_mess.text("");
    dom_mess.slideUp();
}
const checkInputNotImptyCusTom = (element,element_msg,msg)=>{    
    element.val(element.val().trim());
    if(element.val()=="")
    {
        errorShow(element,element_msg,msg);
        return false;
    }
    else
    {
        errorHide(element,element_msg);
        return true;

    }             
}
const checkInputNotImptyEmail = (element,element_msg,msg,msgEmail)=>{    
    element.val(element.val().trim());
    if(element.val()=="")
    {
        errorShow(element,element_msg,msg);
        return false;
    }
    else if(!isEmail(element.val()))
    {
        errorShow(element,element_msg,msgEmail);
        return false;
    }
    else 
    {
        errorHide(element,element_msg);
        return true;

    }             
}
const createEventTada = (element)=>{
    element.on("mouseenter",function(){
        $(this).find("i").addClass("bx-tada");                        
     })
     element.on("mouseleave",function(){
        $(this).find("i").removeClass("bx-tada");
     })                        
}

const ValidateQuantity = (box)=>{      
    let show_quantity = box.querySelector(".show-quantity");    
    box.querySelector(".add").addEventListener("click",()=>{
        let max_quantity = parseInt(box.querySelector(".item-present-quantity").innerText);        
        let value = parseInt(show_quantity.value)
        show_quantity.value = value + 1 > max_quantity ? max_quantity : value + 1;
        if(value + 1 > max_quantity)
        {
            return handleCreateToast("info","Đã đạt số lượng tồn tối đa","info");
        }
        show_quantity.value = value + 1;
    })
    box.querySelector(".minus").addEventListener("click",()=>{        
        let value = parseInt(show_quantity.value)
        show_quantity.value = value - 1 > 0 ? value - 1 : 1;
    })
    show_quantity.addEventListener("input",()=>{             
        if (show_quantity.value != "") {
            let max_quantity = parseInt(box.querySelector(".item-present-quantity").innerText);
            var value = show_quantity.value;
            var x = value.substr(0, value.length - 1);
            show_quantity.value = isNaN(value) ? x : value == 0 ? 1 : show_quantity.value > max_quantity ? max_quantity : value;
        }
    })
    
}

const getParamPrefix = (index = 0)=>{
	var currentURL = window.location.toString();    
    var t = currentURL.split("/")
    return t[t.length-1-index];
}