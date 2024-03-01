$(()=>{
    const form = $("#form-send-mass-mail")
    const massMailApi = new CallApi(PREFIX_MANAGER+PREFIX_MAIL+PREFIX_MASS_MAIL);
    const boxMailAddress = $("#box-mail-address")
    const inputTitle = $(`input[name="TieuDeMail"]`);
    const inputContent = $(`textarea[name="NoiDungMail"`);
    const checkboxMassMail= $("#checkbox-mass-mail");
    const inputMailAddress = $(`input[name="DiaChiMail"`);    
    form.on('submit',(ev)=>{
        ev.preventDefault(); 
        let checkValidate = true;
        if(inputTitle.val() == undefined || inputTitle.val().trim() == "")
        {
            $(".error-validate-update.TieuDe").text("Tiêu đề không được để trống");
            checkValidate = false;            
        }
        else
            $(".error-validate-update.TieuDe").text("");
            console.log(inputContent)
        if(inputContent.val() == undefined || inputContent.val().trim() == "")
        {
            $(".error-validate-update.NoiDung").text("Nội dung mail không được để trống");
            checkValidate = false;
        }
        else
            $(".error-validate-update.NoiDung").text("");
        if(!checkboxMassMail.is(":checked"))
        {
            if(inputMailAddress.val() == undefined || inputMailAddress.val().trim() == "")
            {
                $(".error-validate-update.DiaChi").text("Địa chỉ mail cụ thê không được để trống");
                checkValidate = false;
            }
            else
            {
                var emails = inputMailAddress.val().trim().split(" ");
                for (const email of emails) {
                    if(!isEmail(email))
                    {
                        $(".error-validate-update.DiaChi").text(`Địa chỉ ${email} không đúng định dạng!`);
                        return
                    }
                }
                $(".error-validate-update.DiaChi").text("");
            }
        }  
        if(checkValidate == true)
        {            
            showMessage("Thông báo","Xác nhận gửi mail này?",()=>{
                let data = {
                    TieuDe:inputTitle.val(),
                    NoiDung:inputContent.val(),
                    GuiHangLoat:checkboxMassMail.is(":checked"),
                    DiaChiCuThe:inputMailAddress.val().trim()       
                }                
                massMailApi.create(data,(res)=>{
                    console.log(res)
                    handleCreateToast("success","Thao tác thành công",null,true);
                    inputTitle.val("")
                    inputContent.val("")
                    // inputMailAddress.val("")
                },(res)=>{
                    handleCreateToast("error","Thao tác thất bại",null,true);
                })
            });
        }                             
    })
    checkboxMassMail.change(()=>{
        if(checkboxMassMail.is(":checked"))
            boxMailAddress.slideUp();
        else
            boxMailAddress.slideDown();
    })
    inputMailAddress.on("keydown",function(ev){         
        let value = inputMailAddress.val()        
        if(ev.key == " " && value != undefined && value[value.length-1].toString() == " ")
            ev.preventDefault();
    });
})