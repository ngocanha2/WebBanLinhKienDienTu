
<script src="{{asset("js/callapi/personal/address.js")}}"></script>
<div class="modal fade" id="box-update-address" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" >Cập nhật địa chỉ</h1>
                <button type="button" class="btn-close" id="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="form-update-address" method="POST">
                @include("personal.address.body_address")
                <div class="modal-footer">                                                                                
                    <a class="btn btn-secondary" id="btn-cancel" data-bs-dismiss="modal">Đóng</a>
                    <button class="btn btn-warning" type="submit" id="btn-confirm-address">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script  rel="stylesheet" src="{{asset('js/handle/personal/address_update.js')}}"></script>