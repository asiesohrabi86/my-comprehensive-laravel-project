$(document).ready(function () {
    
    function removeAllSidebarToggleClasses() {
        $('#sidebar-toggle-hide').removeClass('d-md-inline');
        $('#sidebar-toggle-hide').removeClass('d-none');
        $('#sidebar-toggle-show').removeClass('d-inline');
        $('#sidebar-toggle-show').removeClass('d-md-none');
    }

    // عدم نمایش سایدبار:
    $('#sidebar-toggle-hide').click(function () {
        $('#sidebar').fadeOut(300);
        $('#main-body').animate({width: "100%"},300);

        setTimeout(function() {
            removeAllSidebarToggleClasses();
            $('#sidebar-toggle-hide').addClass('d-none');
            $('#sidebar-toggle-show').removeClass('d-none');
        }, 300)
    });


    // نمایش سایدبار:
    $('#sidebar-toggle-show').click(function () {
        $('#sidebar').fadeIn(300);

        setTimeout(function() {
            removeAllSidebarToggleClasses();
            $('#sidebar-toggle-hide').removeClass('d-none');
            $('#sidebar-toggle-show').addClass('d-none');
        }, 300)
    });

    // با کلیک بر آیکون سه نقطه در سایزهای کوچک هدر سفید نمایش داده شود:
    $('#menu-toggle').click(function(){
        $('#body-header').toggle(300);
    });

    // نمایش و عدم نمایش بخش سرچ:
    $('#search-toggle').click(function(){
        $('#search-toggle').removeClass('d-md-inline');
        $('#search-input').animate({width : "12rem"}, 300);
        $('#search-area').addClass('d-md-inline');
        
    });

    $('#search-area-hide').click(function(){
        $('#search-input').animate({width : "0"}, 300);

        setTimeout(function(){
            $('#search-area').removeClass('d-md-inline');
            $('#search-toggle').addClass('d-md-inline');
        }, 300);
    });


    // نمایش و عدم نمایش بخش هدر-نوتیفیکیشن:
    $('#header-notification-toggle').click(function(){
        $('#header-notification').fadeToggle();
    });


    // نمایش و عدم نمایش بخش هدر-کامنت:
    $('#header-comment-toggle').click(function(){
        $('#header-comment').fadeToggle(300);
    });


    // نمایش و عدم نمایش هدر-پروفایل:
    $('#header-profile-toggle').click(function(){
        $('#header-profile').fadeToggle(300);
    });


    // بخش سایدبار:
    $('.sidebar-group-link').click(function(){

        // همه لینک های مربوطه که اکتیو هستند را غیراکتیو میکند:
        $('.sidebar-group-link').removeClass('sidebar-group-link-active');
        $('.sidebar-group-link').children('.sidebar-dropdown-toggle').children('.angle').removeClass('fa-angle-down');
        $('.sidebar-group-link').children('.sidebar-dropdown-toggle').children('.angle').addClass('fa-angle-left');

        // لینک کلیک شده را اکتیو میکند:
        $(this).addClass('sidebar-group-link-active');
        $(this).children('.sidebar-dropdown-toggle').children('.angle').removeClass('fa-angle-left');
        $(this).children('.sidebar-dropdown-toggle').children('.angle').addClass('fa-angle-down');
    });

    $('.sidebar-group-link-active').click(function(){
        
        // $(this).removeClass('sidebar-group-link-active');
        // $(this).children('.sidebar-dropdown-toggle').children('.angle').removeClass('fa-angle-down');
        // $(this).children('.sidebar-dropdown-toggle').children('.angle').addClass('fa-angle-left');
    });


});


    // حالت فول اسکرین:
    $('#full-screen').click(function(){
        fullScreenToggle();
    });


    function fullScreenToggle(){
        if((document.fullScreenElement && fullScreenElement != null) || (! document.mozFullSceen && ! document.webkitIsFullScreen)){
            if(document.documentElement.requestFullScreen){
                document.documentElement.requestFullScreen();
            }

            else if(document.documentElement.mozFullSceen){
                document.documentElement.mozRequestFullScreen();
            }

            else if(document.documentElement.webkitRequestFullScreen){
                document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
            }

            $('#screen-compress').removeClass('d-none');
            $('#screen-expand').addClass('d-none');
        }

        else{

            if (document.cancelFullScreen) {
                
                document.cancelFullScreen();
            }

            else if (document.moazCancelFullScreen) {
                
                document.moazCancelFullScreen();
            }

            else if (document.webkitCancelFullScreen) {
                
                document.webkitCancelFullScreen();
            }

            $('#screen-compress').addClass('d-none');
            $('#screen-expand').removeClass('d-none');

        }
        

    }


