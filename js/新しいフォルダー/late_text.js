$( '#home' ).live( 'pageinit',function(event){
    $(".radio_button").click(function(){
        var num = $(".radio_button").index(this);
        if(num == 2){
            $("#note").show();
        } else {
            $("#note").hide();
        }
    });
});