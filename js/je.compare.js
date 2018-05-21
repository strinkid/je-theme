$(window).load(function(){
    setClassSameHeight(".compareProductName");
    setClassSameHeight(".compareBox");
});
function setClassSameHeight(className){
    var maxHeight = 0;
    $(className).each(function(){
        if ($(this).height() > maxHeight){
            maxHeight = $(this).height();
        }
        console.log("height = "+$(this).height());
        console.log("maxHeight = "+maxHeight);
    });

    $(className).each(function(){
        $(this).height(maxHeight);
    });
}