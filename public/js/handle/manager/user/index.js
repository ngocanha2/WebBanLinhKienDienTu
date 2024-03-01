
var CallApiDeleteUsers = (listId)=>{
    CallApiUsers(METHOD_DELETE,{
        list_id:listId
    },function(res){ 
        if(res.success)
        {
            handleCreateToast("success","delete users successfully!");
            listId.forEach(id=>{
                $(`#user-id-${id}`).remove()
            })
        }   
    })    
}

const api = new CallApi(PREFIX_MANAGER+PREFIX_USER);
const loadDataUsers = (page)=>{     
    api.all((res)=>{
        console.log(res)
        let s = ""
        res.data.data.forEach(item => {
            s+=`<tr id="user-id-${item.id}">
                    <td><input type="checkbox" value="${item.id}" class="user-ids"></td>
                    <td>${item.MaKH}</td>
                    <td>${item.TenDangNhap}</td>
                    <td>${item.HoVaTen}</td>                    
                    <td>${item.Email}</td>
                    <td>${item.SDT ?? "-"}</td>                    
                    <td>${item.NgaySinh ?? ""}</td>
                    <td>${item.GioiTinh ?? ""}</td>
                    <td>${convertDateTimeToString(item.created_at)}</td> 
                    <td>${item.DaXacMinh ? "Đã xác minh" : "Chưa xác minh"}</td>                                                                                            
                </tr>`
        });
        $("#table-users-body").html(s);
        loadPaginationButtons(res.data.current_page,res.data.last_page,function(page,numpages){
            loadDataUsers(page)
        })
    },(res)=>{
        console.log(res)
    },{
        page:page
    })  
}
loadDataUsers(getPage()) 

$("#btn-sort").click(function(){
    var currentURL = window.location.href;
    var url = new URL(currentURL);
	page = url.searchParams.get("page")
    CallApiGetUser(page)
})

$("#delete").click(function(){

    var listId = $(`input[class="user-ids"]:checked`).map(function() {
        return $(this).val();
    }).get();
    if(listId.length)
    {
        CallApiDeleteUsers(listId);
    }  
    else
    {
        handleCreateToast("warning","You have not selected any object yet!!!","warning-delete");
    }  
})
