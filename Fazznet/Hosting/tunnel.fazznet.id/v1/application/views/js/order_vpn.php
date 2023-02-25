<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.5/sweetalert2.min.js"></script>
<script>
    function total_bayar() {
        const harga = $("#id_server").find(":selected").attr("data-harga");
        const berlangganan = $("#berlangganan").find(":selected").val();
        const total_bayar = formatharga(parseInt(harga)*parseInt(berlangganan),'');
        console.log(total_bayar);
        $("#total_bayar").html(total_bayar);
    }

    $("#id_server, #berlangganan").change(function() {
        total_bayar();
    });

    $("#VPNRemote").submit(function() {
        Swal.fire({
            title:"Loading...",
            html: "Sedang membuat Remote VPN anda",
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
            },
            allowOutsideClick: false
        })
    })
</script>