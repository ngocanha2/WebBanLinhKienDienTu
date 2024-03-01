$(document).ready(function(){

    const information_inputs = $(".information-input.readonly");
    const btn_update = $(".btn-update");
    const update_data_information = $("#update-data-information")    
    const error_informations = $(".error-information")



    
    const input_username = $("#input-username")
    const input_full_name = $("#input-full-name")
    const input_phone_number = $("#input-phone-number")
    const input_email = $("#input-email")
    const input_date_of_birth = $("#input-date-of-birth")
    const radioGenderMale = $("#radio-gender-male")
    const radioGenderFemale = $("#radio-gender-female")


    const error_input_username = $("#error-input-username")
    const error_input_full_name = $("#error-input-full-name")
    const error_input_phone_number = $("#error-input-phone-number")
    const error_input_email = $("#error-input-email")
    const error_input_date_of_birth = $("#error-input-date-of-birth")


    const error_input_username_message = "Tên đăng nhập không được để trống";
    const error_input_full_name_message  = "Họ và tên không được để trống";
    const error_input_phone_number_message  = "Số điện thoại không đươc để trống";
    const error_input_email_message  = "Email không được để trống";
    const error_input_email_message_format = "Email không đúng định dạng";



    update_data_information.change(function(){
        console.log($(this).is(":checked"))
        if($(this).is(":checked"))
        {
            setInputReadonly(false)
            btn_update.text("Lưu")
            btn_update.removeClass("btn-outline-dark")
            btn_update.addClass("btn-warning")
        }
        else
        {
            update_data_information.prop("checked",true)
            for(var element of error_informations)
                if($(element).css("display")!=="none")
                {
                    handleCreateToast("error","Kiểm tra thông tin","check-information");
                    return; 
                }          
            showMessage("Thông báo","Xác nhận cập nhật thông tin cá nhân?",function(){                            
                var data = {
                    "TenDangNhap":input_username.val(),
                    "HoVaTen":input_full_name.val(),
                    "SDT":input_phone_number.val(),
                    "Email":input_email.val(),
                    "NgaySinh":input_date_of_birth.val(),                    
                }   
                if(radioGenderMale.is(":checked"))
                    data["GioiTinh"] = "Nam"; 
                else if(radioGenderFemale.is(":checked"))
                    data["GioiTinh"] = "Nữ";                 
                PutDataInfomation(data,function(res){
                    setInputReadonly(true)
                    btn_update.text("Change")
                    btn_update.addClass("btn-outline-dark")
                    btn_update.removeClass("btn-warning")
                    update_data_information.prop("checked",false)
                    handleCreateToast("success",res.message);                    
                },(res,status)=>{
                    handleCreateToast("error",res.message);                      
                    console.log(res) 
                    if(status == 422)
                    {                        
                        switch (res.status) {
                            case 0:
                                error_input_username.text(res.message);      
                                error_input_username.slideDown();                               
                                break;
                            case -1:
                                error_input_email.text(res.message);      
                                error_input_email.slideDown();  
                                break;
                            case -2:
                                error_input_phone_number.text(res.message);      
                                error_input_phone_number.slideDown();  
                                break;
                            case -3:
                                error_input_full_name.text(res.message)
                                error_input_full_name.slideDown();  
                                break;
                            default:
                                return;
                        }                                                                               
                    }
                })
            })
        }
    })
    var setInputReadonly = (boolValue)=>{
        information_inputs.each(function(){
            $(this).attr("readonly",boolValue);                    
            return boolValue ?  $(this).removeClass("information-input-hover"): $(this).addClass("information-input-hover");
            
        })
        $("input[type='radio']").each(function(){
            $(this).attr("disabled",boolValue)
        })
    }

    setInputReadonly(true);





    var GetInfoUser = ()=>{
        GetDataInfomation(function(data){   
            input_username.val(data.TenDangNhap)
            input_full_name.val(data.HoVaTen)
            input_phone_number.val(data.SDT ?? "")
            input_email.val(data.Email ?? "")               
            input_date_of_birth.val(convertDateToString(data.NgaySinh))
            if(data.GioiTinh == "Nam")
                radioGenderMale.prop("checked",true)
            else if(data.GioiTinh == "Nữ")
                radioGenderFemale.prop("checked",true)
            $("#input-joining-date").text(convertDateToString(data.created_at))
            $("#input-password").text('**********')
        });
    }

    GetInfoUser();

    createInputNumber(input_phone_number);

    createEventInputNotImptyCustom(input_username,error_input_username,error_input_username_message)
    createEventInputNotSpecialCharacter(input_username)
    createEventInputNotImptyCustom(input_full_name,error_input_full_name,error_input_full_name_message)
    // createEventBlurCheckLength(input_phone_number,10,error_input_phone_number,error_input_phone_number_message)
    //createEventInputNotImptyCustom(input_phone_number,error_input_phone_number,error_input_phone_number_message)
    //createEventInputNotImptyCustom(input_email,error_input_email,error_input_email_message)
    input_email.blur(function(){
        if($(this).val()=="")    
            return errorShow($(this),error_input_email,error_input_email_message)            
        else if(!isEmail($(this).val()))            
            return errorShow($(this),error_input_email,error_input_email_message_format)    
            errorHide($(this),error_input_email)
    })
    // input_date_of_birth.change(function(){
    //     if(new Date($(this).val())>TODAY)
    //         messageSizeShow(error_input_date_of_birth,error_input_date_of_birth_message,$(this))
    //     else
    //         messageSizeHide(error_input_date_of_birth,$(this))
    // })


    const input_old_password = $("#input-old-password")
    const input_new_password = $("#input-new-password")
    const input_new_password_confirmation = $("#input-new-password-confirmation")

    const error_input_old_password = $("#error-input-old-password")
    const error_input_new_password = $("#error-input-new-password")
    const error_input_new_password_confirmation = $("#error-input-new-password-confirmation")


    const error_input_old_password_mess = "Mật khẩu cũ không được để trống"
    const error_input_new_password_mess = "Mật khẩu mới không được để trống"
    const error_input_new_password_confirmation_mess = "Mật khẩu nhập lại không được để trống"
    const error_input_new_password_confirmation_mess_not_match = "Mật khẩu nhập lại không trùng khớp";
    createEventInputNotImptyCustom(input_old_password,error_input_old_password,error_input_old_password_mess)
    createEventInputNotImptyCustom(input_new_password,error_input_new_password,error_input_new_password_mess)
    createEventInputNotImptyCustom(input_new_password_confirmation,error_input_new_password_confirmation,error_input_new_password_confirmation_mess)
    input_old_password.on("input",function(){
        $(this).val($(this).val().trim());
    })
    input_new_password.on("input",function(){
        $(this).val($(this).val().trim());
    })
    input_new_password_confirmation.on("input",function(){
        $(this).val($(this).val().trim());
    })
    $("#form-change-password").on("submit",function(ev){          
        ev.preventDefault();       
        let chkValidate = [            
            checkInputNotImptyCusTom(input_old_password,error_input_old_password,error_input_old_password_mess),
            checkInputNotImptyCusTom(input_new_password,error_input_new_password,error_input_new_password_mess),
            checkInputNotImptyCusTom(input_new_password_confirmation,error_input_new_password_confirmation,error_input_new_password_confirmation_mess)
        ]  
        if(chkValidate.indexOf(false)==-1)
        {
            if(input_new_password.val()!=input_new_password_confirmation.val())  
            {                
                return errorShow(input_new_password_confirmation,error_input_new_password_confirmation,error_input_new_password_confirmation_mess_not_match)                        
            }          
            var formData = $("#form-change-password").serialize();             
            ChangePassword(formData,(res)=>{
                input_old_password.val("")
                input_new_password.val("")
                input_new_password_confirmation.val("")
                handleCreateToast("success",res.message)   
                $("#btn-modal-change-password-close").trigger("click");         
            },(res)=>{                
                error_input_old_password.text(res.message)
                error_input_old_password.slideDown()
            })
        }                          
    })
    $("#show-password").click(function(){
        let type = $(this).is(":checked") ? "text":"password";
        $(".information-input.password").each(function(){
            $(this).attr("type",type);
        })
    })
})