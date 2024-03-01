const loadCartQuantity = () =>{
    CallApiCartGetQuantity((res)=>{          
        const itemShowCartQuantity = $("#item-show-cart-quantity");                                                
        if(res.data>0)
        {            
            itemShowCartQuantity.html(`<span class="gh position-absolute translate-middle badge rounded-pill text-bg-warning">
                                            ${res.data}
                                            <span class="visually-hidden">unread messages</span>
                                        </span>`)
        }
        else
            itemShowCartQuantity.html("");
    })
}