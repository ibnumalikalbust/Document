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
</script>