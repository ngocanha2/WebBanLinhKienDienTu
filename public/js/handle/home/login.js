

const checkBoxLoginAdmin = $("#login-admin")
const inputFieldvalue = $("#fieldvalue")
checkBoxLoginAdmin.change(()=>{
    if(checkBoxLoginAdmin.is(":checked"))
        inputFieldvalue.attr("placeholder","Tên đăng nhập")
    else
        inputFieldvalue.attr("placeholder","Email, số điện thoại hoặc tên đăng nhập")
})
$('#form-login').on('submit',(ev)=>{
    ev.preventDefault();        
    let formData = $('#form-login').serialize();  
    $("#error-validate").text("");
    $("#btn-login").prop("disabled", true); 
    login(formData,(res)=>{
        console.log(res)
        //localStorage.setItem(TOKEN_AUTH,res.data.access_token)
        // var d = new Date();
        // d.setTime(d.getTime() + (res.data.expires_in*60*2000)); 
        // var expires = "expires=" + d.toUTCString();
        // document.cookie = `${"token"}=${res.data.access_token}; expires=${expires}; path=/; samesite=strict; secure`;   
        location.replace(res.data.url ?? "/");
    },(res)=>{
        console.log(res)
        $("#error-validate").text("Thông tin đăng nhập không chính xác");
        $("#btn-login").prop("disabled", false)
    })                 
})

  

  
  
  
  
  
  