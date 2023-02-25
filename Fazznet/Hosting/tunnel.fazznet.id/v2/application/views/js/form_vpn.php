<script>
    function change_status() {
        if($("#status").prop("checked") == true){
            $("#status").val("Aktif");
            $(".custom-control-label").html("Aktif");
        }else{
            $("#status").val("Non Aktif");
            $(".custom-control-label").html("Non Aktif");
        }
    }
    change_status();

    $("#detail_server").hide();
    $("#id_server").change(function() {
        console.log($(this).val());
        if($(this).val() == ""){
            $("#detail_server").hide();
            $("#lokasi").val("");
        }else{
            $("#detail_server").show();
            $("#lokasi").val($(this).find(":selected").attr("data-country"));
        }
        $("#tnama_server").html(": "+$(this).find(":selected").attr("data-nama_server"));
        $("#tip_address").html(": "+$(this).find(":selected").attr("data-ip_address"));
        $("#tport").html(": "+$(this).find(":selected").attr("data-port"));
    })
</script>