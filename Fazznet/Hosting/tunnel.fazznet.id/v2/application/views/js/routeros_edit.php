<script>
    function change_status() {
        if($("#is_active").prop("checked") == true){
            $("#is_active").val("Aktif");
            $(".custom-control-label").html("Aktif");
        }else{
            $("#is_active").val("Non Aktif");
            $(".custom-control-label").html("Non Aktif");
        }
    }
    change_status();
</script>