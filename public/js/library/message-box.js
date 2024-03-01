function showMessage(title,mes,function_submit,function_cancel = null,type = null,label = null)
{
    let s = `<form class="modall" id="message-box">
                <div>
                    <div class="modal__innerr">
                        <div class="modal__headerr">
                            <p>${title}</p>
                            <i class="fas fa-times" id="btn-message-box-close" ></i>
                        </div>
                        <div class="modal__bodyy">
                            <span>${mes}</span><br>`
                            if(type!=null)
                                if(type=="checkbox")                            
                                    s+=`<div class="form-check form-switch">              
                                            <input class="form-check-input" type="checkbox" role="switch" id="value-message-box" value="true">
                                            <label class="form-check-label" for="value-message-box" class="theme-toggle">${label ?? ""}</label>                                                      
                                        </div>`                                                        
                                else 
                                    s+=`<input class="message-input" id="value-message-box" required type="${type}">
                                    <lable for="value-message-box">${label ?? ""}</lable>`
                        s+=`</div>
                        <div class="modal__footerr">
                            <button id="btn-message-box-cancel" class=" close btn btn-warning">Hủy bỏ</button>
                            <button id="btn-message-submit" type="submit" class="btn btn-danger">Xác nhận</button>
                        </div>
                    </div>
                </div>
            </form>`;            
    $("body").append(s);
    $("#value-message-box").focus()
    $('#btn-message-box-cancel').on("click",()=>$('.modall').remove());
    $('#btn-message-box-close').on("click",()=>$('.modall').remove());
    $('#message-box').on("submit",function(ev){
        ev.preventDefault();
        if (typeof function_submit === 'function') {            
            let value = type=="checkbox" ? $("#value-message-box").is(":checked") : $("#value-message-box").val() 
            function_submit(value);
            $("#message-box").remove();
        }                       
    })
    if (typeof function_cancel === 'function') {            
        $("#btn-message-box-cancel").click(()=>{
            function_cancel();        
        })                
    }
    else if(function_cancel == false)
    {
        $("#btn-message-box-close").remove()
        $("#btn-message-box-cancel").remove()
    }


}