<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/fh-3.2.4/r-2.3.0/datatables.min.js"></script>
<script>
    $("#datatable").DataTable();
    $("#info-pembayaran").hide();
    $("#jenis_pembayaran").change(function(){
        $("#info-pembayaran").show();
        $("#data-nomor-tujuan").html($(this).find(":selected").attr("data-nomor-tujuan"));
        $("#nomor_tujuan").val($(this).find(":selected").attr("data-nomor-tujuan"));
        $("#data-an").html($(this).find(":selected").attr("data-an"));
        $("#penerima").val($(this).find(":selected").attr("data-an"));
    })
</script>