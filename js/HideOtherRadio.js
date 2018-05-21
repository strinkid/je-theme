  $(document).ready(function(){
    $("ul.woof_list > li").click(function(){
        var atLeastOneChecked = false;

        //Looping Direct Li
        $("ul.woof_list").find("> li").each(function(index){

            // Find Checked Li
            var a = $(this).find('input[checked="checked"]', ".woof_list");
            
            //Length > 0 , at least one checked
            if(a.length > 0){
                atLeastOneChecked = true;
            }
        });

            if(atLeastOneChecked == true){
                $("ul.woof_list").find("> li").each(function(index){
                    //DO HIDE OTHERS
                    var a = $(this).find('input[checked="checked"]', ".woof_list");

                    if(a.length == 0){
                        $(this).hide();
                    }   
                });
            }
    });
            
});