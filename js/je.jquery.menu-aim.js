var $menu = $(".dropdown-menu");
var $active = true;

$menu.menuAim({
    activate: activateSubmenu,
    deactivate: deactivateSubmenu,
	exitMenu: function(){return true;}
});
function activateSubmenu(row) {
    if($(window).width() < 1000) return;
    var $row = $(row),
        submenuId = $row.data("submenuId"),
        $submenu = $("#" + submenuId),
        height = $menu.outerHeight(),
        width = $menu.outerWidth();


    // if($active){
    $row.find("a.dropdown-toggle").addClass("maintainHover");
    $($(".maintainHover").parent().find('.popOverImage')[0]).show();
        $submenu.css({
            display: "block",
            top: -1,
            left: width-2,  // main should overlay submenu
            height: height + 400,  // padding for main dropdown's arrow
            width: width + 400
        });
}

function deactivateSubmenu(row) {
    if($(window).width() < 768) return;
    var $row = $(row),
        submenuId = $row.data("submenuId"),
        $submenu = $("#" + submenuId);
        $submenu.css("display", "none");
        $row.find("a").removeClass("maintainHover");
}

$("#shopByCategory .dropdown-menu > li > a").click(function(e) {
    e.stopPropagation();
    e.preventDefault();
    if($(window).width() < 992) {
        var currentDisplay = $($(this).parent().find('> div')[0]).css('display');
        if (currentDisplay == 'none'){
            $(this).parent().parent().css('height','auto');
			$($(this).parent().find('> div')[0]).attr('style', 'width:'+$(window).width()+'px !important;display:block;');
        }
        else{
            $($(this).parent().find('> div')[0]).css('display','none');
            $(this).parent().parent().css('height','auto');
        }
    }
});

$("li.shopCategory-list > a").click(function(e) {
    window.location.href = $(this).attr('href');
});

$(document).click(function() {
    $("#shopByCategory .popover").css("display", "none");
    $("#shopByCategory a.maintainHover").removeClass("maintainHover");
});
