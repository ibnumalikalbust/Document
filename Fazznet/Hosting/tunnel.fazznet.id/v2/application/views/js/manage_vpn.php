<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.5/sweetalert2.min.js"></script>
<script>
    function copyDivToClipboard() {
        var range = document.createRange();
        range.selectNode(document.getElementById("code_pelanggan"));
        window.getSelection().removeAllRanges(); // clear current selection
        window.getSelection().addRange(range); // to select text
        document.execCommand("copy");
        window.getSelection().removeAllRanges();// to deselect
        swal.fire("Sukses","Code Berhasil Di Salin","success");
    }

    $("#EditVPN").submit(function() {
        Swal.fire({
            title:"Loading...",
            html: "Sedang update Remote VPN anda",
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
            },
            allowOutsideClick: false
        })
    })
</script>