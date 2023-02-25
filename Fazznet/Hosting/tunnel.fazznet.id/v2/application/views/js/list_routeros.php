<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.5/sweetalert2.min.js"></script>
<script>
    function loading() {
        Swal.fire({
            title:"Check Koneksi...",
            html: "Mohon tunggu sistem sedang check koneksi server",
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
            },
            allowOutsideClick: false
        })
    }

    function test(id) {
        $.ajax({
            url:"<?=base_url("test_routeros/")?>"+id,
            beforeSend:function(){
                loading();
            },
            success:function(r){
                if(r == 200){
                    swal.fire("Sukses","Testing Koneksi Sukses","success");
                }else{
                    swal.fire("Error","Testing Koneksi Gagal, Mohon Periksa kembali IP Address, Port, Username, atau Password Server.","error");
                }
                console.log(r);
            },
            error:function(a,b,c){
                swal.fire(c,a.responseText,b);
            }
        })
    }
</script>