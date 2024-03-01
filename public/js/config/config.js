const TOKEN_AUTH = "token-auth";

//prefix auth
const PREFIX_AUTH = "auth/";
const PREFIX_LOGIN = "login";
const PREFIX_REGISTER = "register";
const PREFIX_VERIFY = "verify/";
const PREFIX_RESEND_VERIFY_EMAIL = "resend-verify-email"
const GUARANTEE = "guarantee/";
const CANCEL = "cancel/";
const REFUSE ="refuse/"
const CLEAR = "clear/"
const SOURCE_GOODS ="source-goods/"
const PREFIX_CATEGORY = "category/"
const PREFIX_SUPPLY_ORDER ="supply-order/"

const PREFIX_MAIL = "mail/";
const PREFIX_MASS_MAIL = "mass-mail/";

//cart
const PREFIX_CART = "cart/";
const PREFIX_QUANTITY = "quantity/";
const PREFIX_DELETE_ALL = "delete-all";

const PREFIX_MANAGER = "manager/"
const PREFIX_PERMISSION = "permission/";

const PREFIX_UPDATE_STATUS = "update-status"

const PREFIX_USER = "users"
const PREFIX_PRESONAL = "personal/"
const PREFIX_INFOMATION = "infomation"
const PREFIX_CHANGE_PASSWORD = "change-password"

const PREFIX_PARSE = "parse"
const PREFIX_QRCODE = "qrcode"

const PREFIX_CREATE_OR_DELETE = "create-delete"







//prefix sản phẩm
const PREFIX_PRODUCT = "product/";
// const PREFIX_PRODUCT_ALL = "tat-ca-san-pham";
// const PREFIX_PRODUCT_SALE = "san-pham-khuyen-mai";
// const PREFIX_PRODUCT_CREATE = "build";


//prefix danh mục
const PREFIX_PERSONAL = 'personal/'


//prefix voucher
const PREFIX_VOUCHER = "voucher/";
const PREFIX_PROMOTION = "promotion/";
// const PREFIX_VOUCHER_CREATE = "tao-khuyen-mai";



// //prefix phương thức vận chuyển
// const PREFIX_SHIPPING_METHOD = "phuong-thuc-van-chuyen/";


// //prefix phương thức thanh toán
// const PREFIX_PAYMENT_METHOD = "phuong-thuc-thanh-toan/";

//prefix đánh giá

const PREFIX_FEEDBACK = "feedback/";


//prefix giỏ hàng
const PREFIX_CART_UPDATE_QUANTITY = "update-quantity-product";



//prefix dat-dang
const PREFIX_ORDER = "order/";
const PREFIX_CHECKOUT = "checkout";
const PREFIX_SUCCESS = "success";

const PREFIX_BUILD = "build";
// const PREFIX_ORDER_CREATE = "tao-don-dat-hang";
// const PREFIX_ORDER_SUCCESS = "dat-hang-thanh-cong";
// const PREFIX_ORDER_ALL = "tat-ca-don-hang";



//prefix auth
const PREFIX_LOGOUT = "logout";


//prefix sổ địa đỉa
const PREFIX_ADDRESS = "address/";
const PREFIX_SET_DEFAULT = "set-default";


const PREFIX_PERSONAL_INFO = "infomation"

//prefix nhà cung cấp 
const PREFIX_SUPPLIER = "supplier/"
const PREFIX_HANDLE = "handle/"
const PREFIX_DELIVERY = "delivery/"
const PREFIX_WAITING_CONFIRM = "waiting-confirm/"






function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
var Cookies = ()=> {
    var cookies = document.cookie;
    var cookieArray = cookies.split(';');
    var cookieList = {};
  
    for (var i = 0; i < cookieArray.length; i++) {
      var cookie = cookieArray[i].trim().split('=');
      var cookieName = cookie[0];
      var cookieValue = cookie[1];
      cookieList[cookieName] = cookieValue;
    }
  
    return cookieList;
  }
// $.ajaxSetup({
//     headers: {
//         'Authorization': `Bearer ${getCookie(TOKEN_AUTH)}`
//     }
// });


const BuildCallApi = (data,func_success,func_fail,method = "GET",url,prefix = "")=>{
  $.ajax({
      url: url + prefix,
      type: method, 
      data:data,     
      success: function (res) {
          if(typeof func_success === "function")
              func_success(res)               
      },
      error: function (xhr, status, error) {        
          if(typeof func_fail === "function")
              func_fail(xhr.responseJSON)               
      }
  });   													 
}
