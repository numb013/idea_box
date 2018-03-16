s$( '#home' ).live( 'pageinit',function(event){
    $(".radio_button").click(function(){
        var num = $(".radio_button").index(this);
        if(num == 0){
            $("#early").show();
        } else if(num == 1) {
            $("#early").hide();
        } else if(num == 2) {
            $("#early").hide();
        }
    });
});