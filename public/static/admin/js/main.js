$(function() {
    //BEGIN MENU SIDEBAR
    $('#sidebar').css('min-height', '100%');
    $('#side-menu').metisMenu();
    $(window).on("load resize", function() {
        if ($(this).width() < 768) {
            $('body').removeClass();
            $('div.sidebar-collapse').addClass('collapse');
        } else {
            $('body').addClass($.cookie('menu_style') + ' ' + $.cookie('header'));
            $('div.sidebar-collapse').removeClass('collapse');
            $('div.sidebar-collapse').css('height', 'auto');
        }

        if ($('#sidebar').height() > $('#page-wrapper').height()) {
            $('#wrapper').css('height', $('#sidebar').height());
        }
    });

    $('#news-ticker-close').click(function(e) {
        $('.news-ticker').remove();
        $('.quick-sidebar').css('top', '50px');
    });
    //END NEWS TICKER TOPBAR

    //BEGIN TOPBAR DROPDOWN
    $('.dropdown-slimscroll').slimScroll({
        "height": '250px',
        "wheelStep": 30
    });
    //END TOPBAR DROPDOWN

    //BEGIN CHECKBOX & RADIO
    // if($('#demo-checkbox-radio').length <= 0){
    //     $('input[type="checkbox"]:not(".switch")').iCheck({
    //         checkboxClass: 'icheckbox_minimal-grey',
    //         increaseArea: '20%' // optional
    //     });
    //     $('input[type="radio"]:not(".switch")').iCheck({
    //         radioClass: 'iradio_minimal-grey',
    //         increaseArea: '20%' // optional
    //     });
    // }
    //END CHECKBOX & RADIO

    //BEGIN TOOTLIP
    $("[data-toggle='tooltip'], [data-hover='tooltip']").tooltip();
    //END TOOLTIP

    //BEGIN POPOVER
    $("[data-toggle='popover'], [data-hover='popover']").popover();
    //END POPOVER

    //BEGIN THEME SETTING
    $('#theme-setting > a.btn-theme-setting').click(function() {
        if ($('#theme-setting').css('right') < '0') {
            $('#theme-setting').css('right', '0');
        } else {
            $('#theme-setting').css('right', '-250px');
        }
    });

    // Begin Change Theme Color
    var list_menu = $('.dropdown-theme-setting > li > select#list-menu');
    var list_style = $('.dropdown-theme-setting > li > select#list-style');
    var list_header = $('.dropdown-theme-setting > li > select#list-header');
    var list_color = $('.dropdown-theme-setting > li > ul#list-color > li');

    // FUNCTION CHANGE URL STYLE ON HEAD TAG
    var setTheme = function(menu_style, style, header, color) {
            $.cookie('menu_style', menu_style);
            $.cookie('style', style);
            $.cookie('header', header);
            $.cookie('color', color);

            $('body').removeClass();
            $('body').addClass(menu_style + ' ' + header);
            // Set slimscroll when sidebar fixed
            if ($.cookie('header') == 'header-fixed') {
                if ($('body').hasClass('sidebar-collapsed')) {
                    $('#side-menu').attr('style', '').parent('.slimScrollDiv').replaceWith($('#side-menu'));
                } else {
                    setTimeout(function() {
                        $('#side-menu').slimScroll({
                            "height": $(window).height() - 100,
                            'width': '250px',
                            'wheelStep': 30
                        });
                        $('#side-menu').focus();
                    }, 500)
                }
            } else {
                $('#side-menu').attr('style', '').parent('.slimScrollDiv').replaceWith($('#side-menu'));
            }

            $('#theme-change').attr('href', 'css/themes/' + style + '/' + color + '.css');
        }
        // INITIALIZE THEME FROM COOKIE
        // --NOTES: HAVE TO SET VALUE FOR STYLE & COLOR BEFORE AND AFTER ACTIVE THEME
        // Check cookie when window reload and set value for each option(menu,style,color)
    if ($.cookie('style')) {
        // FIX SIDEBAR IN HORIZONTAL AND RIGHT
        if ($('body').hasClass('clear-cookie')) {
            $.removeCookie('menu_style');
        } else {
            list_menu.find('option').each(function() {
                if ($(this).attr('value') == $.cookie('menu_style')) {
                    $(this).attr('selected', 'selected');
                }
            });

            list_style.find('option').each(function() {
                if ($(this).attr('value') == $.cookie('style')) {
                    $(this).attr('selected', 'selected');
                }
            });

            list_header.find('option').each(function() {
                if ($(this).attr('value') == $.cookie('header')) {
                    $(this).attr('selected', 'selected');
                }
            });

            list_color.removeClass("active");
            list_color.each(function() {
                if ($(this).attr('data-color') == $.cookie('color')) {
                    $(this).addClass('active');
                }
            });
            setTheme($.cookie('menu_style'), $.cookie('style'), $.cookie('header'), $.cookie('color'));
        }
    };

    // SELECT MENU STYLE EVENT
    list_menu.on('change', function() {
        list_color.each(function() {
            if ($(this).hasClass('active')) {
                color_active = $(this).attr('data-color');
            }
        });
        // No Menu style 3 fixed
        if (($.cookie('header') == 'header-fixed') && ($(this).val() == 'sidebar-icons')) {
            setTheme($(this).val(), list_style.val(), 'header-static', color_active);
            return;
        }
        setTheme($(this).val(), list_style.val(), list_header.val(), color_active);
    });
    // SELECT STYLE EVENT
    list_style.on('change', function() {
        list_color.each(function() {
            if ($(this).hasClass('active')) {
                color_active = $(this).attr('data-color');
            }
        });
        setTheme(list_menu.val(), $(this).val(), list_header.val(), color_active);
    });

    // SELECT HEADER EVENT
    list_header.on('change', function() {
        list_color.each(function() {
            if ($(this).hasClass('active')) {
                color_active = $(this).attr('data-color');
            }
        });
        // No Menu style 3 fixed
        if (($.cookie('menu_style') == 'sidebar-icons') && ($(this).val() == 'header-fixed')) {
            return;
        }
        setTheme(list_menu.val(), list_style.val(), $(this).val(), color_active);
    });
    // LI CLICK EVENT
    list_color.on('click', function() {
        list_color.removeClass('active');
        $(this).addClass('active');
        setTheme(list_menu.val(), list_style.val(), list_header.val(), $(this).attr('data-color'));
    });
    // End Change Theme Color
    //END THEME SETTING

    //BEGIN FULL SCREEN
    $('.btn-fullscreen').click(function() {

        if (!document.fullscreenElement && // alternative standard method
            !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) { // current working methods
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) {
                document.documentElement.msRequestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        }
    });
    //END FULL SCREEN

    // BEGIN FORM CHAT
    $('.btn-chat').click(function() {
        if ($('#chat-box').is(':visible')) {
            $('#chat-form').toggle('slide', {
                direction: 'right'
            }, 500);
            $('#chat-form').slimScroll();
            $('#chat-box').hide();
        } else {
            $('#chat-form').toggle('slide', {
                direction: 'right'
            }, 500);
            $('#chat-form > .chat-inner').slimScroll({
                "height": $(window).height(),
                'width': '280px',
                "wheelStep": 30
            });
        }
    });
    $('.chat-box-close').click(function() {
        $('#chat-box').hide();
        $('#chat-form .chat-group a').removeClass('active');
    });
    $('.chat-form-close').click(function() {
        $('#chat-form').toggle('slide', {
            direction: 'right'
        }, 500);
        $('#chat-box').hide();
    });

    $('#chat-form .chat-group a').unbind('*').click(function() {
        $('#chat-box').hide();
        $('#chat-form .chat-group a').removeClass('active');
        $(this).addClass('active');
        var strUserName = $('> small', this).text();
        $('.display-name', '#chat-box').html(strUserName);
        var userStatus = $(this).find('span.user-status').attr('class');
        $('#chat-box > .chat-box-header > span.user-status').removeClass().addClass(userStatus);
        var chatBoxStatus = $('span.user-status', '#chat-box');
        var chatBoxStatusShow = $('#chat-box > .chat-box-header > small');
        if (chatBoxStatus.hasClass('is-online')) {
            chatBoxStatusShow.html('Online');
        } else if (chatBoxStatus.hasClass('is-offline')) {
            chatBoxStatusShow.html('Offline');
        } else if (chatBoxStatus.hasClass('is-busy')) {
            chatBoxStatusShow.html('Busy');
        } else if (chatBoxStatus.hasClass('is-idle')) {
            chatBoxStatusShow.html('Idle');
        }

        var offset = $(this).offset();
        var h_main = $('#chat-form').height();
        var h_title = $("#chat-box > .chat-box-header").height();
        var top = ($('#chat-box').is(':visible') ? (offset.top - h_title - 40) : (offset.top + h_title - 20));

        if ((top + $('#chat-box').height()) > h_main) {
            top = h_main - $('#chat-box').height();
        }

        $('#chat-box').css({ 'top': top });

        if (!$('#chat-box').is(':visible')) {
            $('#chat-box').toggle('slide', {
                direction: 'right'
            }, 500);
        }
        // FOCUS INPUT TEXT WHEN CLICK
        $("#chat-box .chat-textarea input").focus();
        $('.chat-content > .chat-box-body').slimScroll({
            "height": "250px",
            'width': '340px',
            "wheelStep": 30,
            "scrollTo": $(this).height()
        });
    });
    // Add content to form
    $('.chat-textarea input').on("keypress", function(e) {
        var $obj = $(this);
        var $me = $obj.parent().parent().find('ul.chat-box-body');
        var $my_avt = 'https://s3.amazonaws.com/uifaces/faces/twitter/kolage/128.jpg';
        var $your_avt = 'https://s3.amazonaws.com/uifaces/faces/twitter/alagoon/48.jpg';
        if (e.which == 13) {
            var $content = $obj.val();

            if ($content !== "") {
                var d = new Date();
                var h = d.getHours();
                var m = d.getMinutes();
                if (m < 10) m = "0" + m;
                $obj.val(""); // CLEAR TEXT ON TEXTAREA

                var $element = "";
                $element += "<li>";
                $element += "<p>";
                $element += "<img class='avt' src='" + $my_avt + "'>";
                $element += "<span class='user'>John Doe</span>";
                $element += "<span class='time'>" + h + ":" + m + "</span>";
                $element += "</p>";
                $element = $element + "<p>" + $content + "</p>";
                $element += "</li>";

                $me.append($element);
                var height = 0;
                $me.find('li').each(function(i, value) {
                    height += parseInt($(this).height());
                });

                height += '';
                $me.scrollTop(height);

                // RANDOM RESPOND CHAT
                var $res = "";
                $res += "<li class='odd'>";
                $res += "<p>";
                $res += "<img class='avt' src='" + $your_avt + "'>";
                $res += "<span class='user'>Swlabs</span>";
                $res += "<span class='time'>" + h + ":" + m + "</span>";
                $res += "</p>";
                $res = $res + "<p>" + "Yep! It's so funny :)" + "</p>";
                $res += "</li>";
                setTimeout(function() {
                    $me.append($res);
                    $me.scrollTop(height + 100);
                }, 1000);
            }
        }
    });
    //END FORM CHAT

    //BEGIN PORTLET
    $(".portlet").each(function(index, element) {
        var me = $(this);
        $(">.portlet-header>.tools>i", me).click(function(e) {
            if ($(this).hasClass('fa-chevron-up')) {
                $(">.portlet-body", me).slideUp('fast');
                $(this).removeClass('fa-chevron-up').addClass('fa-chevron-down');
            } else if ($(this).hasClass('fa-chevron-down')) {
                $(">.portlet-body", me).slideDown('fast');
                $(this).removeClass('fa-chevron-down').addClass('fa-chevron-up');
            } else if ($(this).hasClass('fa-cog')) {
                //Show modal
            } else if ($(this).hasClass('fa-refresh')) {
                //$(">.portlet-body", me).hide();
                $(">.portlet-body", me).addClass('wait');

                setTimeout(function() {
                    //$(">.portlet-body>div", me).show();
                    $(">.portlet-body", me).removeClass('wait');
                }, 1000);
            } else if ($(this).hasClass('fa-times')) {
                me.remove();
            }
        });
    });
    //END PORTLET

    //BEGIN BACK TO TOP
    $(window).scroll(function() {
        if ($(this).scrollTop() < 200) {
            $('#totop').fadeOut();
        } else {
            $('#totop').fadeIn();
        }
    });
    $('#totop').on('click', function() {
        $('html, body').animate({ scrollTop: 0 }, 'fast');
        return false;
    });
    //END BACK TO TOP

    $('.cnl_email_send').on('click', function(e) {
        if ($('.fltlft:checked').length < 1) {
            e.preventDefault();
            $('#cnl_users_grp_er').show();
        } else {
            $('#cnl_users_grp_er').hide();
        }
    });

    //BEGIN CHECKBOX TABLE
    $('.checkall').on('ifChecked ifUnchecked', function(event) {
        if (event.type == 'ifChecked') {
            $(this).closest('table').find('input[type=checkbox]').iCheck('check');
        } else {
            $(this).closest('table').find('input[type=checkbox]').iCheck('uncheck');
        }
    });
    //ONLY FOR USER_PROFILE PAGE
    $('.checkall-email').on('ifChecked ifUnchecked', function(event) {
        if (event.type == 'ifChecked') {
            $(this).closest('.tab-pane').find('input[type=checkbox]').iCheck('check');
        } else {
            $(this).closest('.tab-pane').find('input[type=checkbox]').iCheck('uncheck');
        }
    });
    //END CHECKBOX TABLE

    $('.option-demo').hover(function() {
        $(this).append("<div class='demo-layout animated fadeInUp'><i class='fa fa-magic mrs'></i>Demo</div>");
    }, function() {
        $('.demo-layout').remove();
    });
    $('#header-topbar-page .demo-layout').live('click', function() {
        var HtmlOption = $(this).parent().detach();
        $('#header-topbar-option-demo').html(HtmlOption).addClass('animated flash').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $(this).removeClass('animated flash');
        });
        $('#header-topbar-option-demo').find('.demo-layout').remove();
        return false;
    });
    $('#title-breadcrumb-page .demo-layout').live('click', function() {
        var HtmlOption = $(this).parent().html();
        $('#title-breadcrumb-option-demo').html(HtmlOption).addClass('animated flash').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $(this).removeClass('animated flash');
        });
        $('#title-breadcrumb-option-demo').find('.demo-layout').remove();
        return false;
    });
    // CALL FUNCTION RESPONSIVE TABS
    fakewaffle.responsiveTabs(['xs', 'sm']);

    // BEGIN SEARCH FORM ON TOPBAR
    $('#topbar-search').on('click', function(e) {
        $(this).addClass('open');
        $(this).find('.form-control').focus();

        $('#topbar-search .form-control').on('blur', function(e) {
            $(this).closest('#topbar-search').removeClass('open');
            $(this).unbind('blur');
        });
    });
    // END SEARCH FORM ON TOPBAR

    // BEGIN DATERANGE PICKER ON BREADCRUMB
    $('.reportrange').daterangepicker({
            customClass: 'reportrange_drp',
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],

            },
            startDate: moment().subtract('days', 6),
            endDate: moment(),
            opens: 'left',
        },
        function(start, end) {
            $('.reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('.reportrange  input[name="datestart"]').val(start.format("YYYY-MM-DD"));
            $('.reportrange  input[name="endstart"]').val(end.format("YYYY-MM-DD"));

        }
    );

    function isInvalidDate(d) {
        return isNaN(Date.parse(d));
    }

    if ($('.reportrange  input[name="datestart"]').val()) {
        $start = $('.reportrange  input[name="datestart"]').val().format('MMMM D, YYYY');
    } else {
        $start = moment().subtract('days', 6).format('MMMM D, YYYY');
    }

    if ($('.reportrange  input[name="endstart"]').val()) {
        $end = $('.reportrange  input[name="endstart"]').val().format('MMMM D, YYYY');
    } else {
        $end = moment().format('MMMM D, YYYY');
    }
    
    $('.reportrange span').html($start + ' - ' + $end);
    // Statement Overview

    $('.overviewrange').daterangepicker({
            ranges: {
                'All Time':[null,null],
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
            //startDate: $start,
            //endDate: $end,
            opens: 'left'
        },
        function(start, end) {
            if(isInvalidDate(start)){   
                $('.overviewrange span').html('All Time');
                $('.overviewrange input[name="datestart"]').val('');
                $('.overviewrange input[name="endstart"]').val('');
            }else{
                $('.overviewrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('.overviewrange input[name="datestart"]').val(start.format("YYYY-MM-DD"));
                $('.overviewrange input[name="endstart"]').val(end.format("YYYY-MM-DD"));
            }
        }
    );

    //Release Manager Date Picker
    $('.releaserange').daterangepicker({
            ranges: {
                'Last Week': [moment().subtract('week', 1).startOf('week'), moment().subtract('week', 1).endOf('week')],
                'Last 2 Week': [moment().subtract('week', 2).startOf('week'), moment().subtract('week', 1).endOf('week')],
                'Last 3 Week': [moment().subtract('week', 3).startOf('week'), moment().subtract('week', 1).endOf('week')],
                'Last 4 Week': [moment().subtract('week', 4).startOf('week'), moment().subtract('week', 1).endOf('week')],
            },
            // startDate: moment().subtract('days', 29),
            // endDate: moment(),
            opens: 'right'
        },
        function(start, end) {
            $('.releaserange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('.releaserange input[name="from"]').val(start.format("YYYY-MM-DD"));
            $('.releaserange input[name="to"]').val(end.format("YYYY-MM-DD"));
        }
    );
    //Playlist Manager Date Picker
    $('.playlistrange').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
            // startDate: moment().subtract('days', 29),
            // endDate: moment(),
            opens: 'right'
        },
        function(start, end) {
            $('.playlistrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('.playlistrange input[name="from"]').val(start.format("YYYY-MM-DD"));
            $('.playlistrange input[name="to"]').val(end.format("YYYY-MM-DD"));
        }
    );
    //Release Manager Date Picker
    $('.statementrange').daterangepicker({
            ranges: {
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
                'Last 2 Month': [moment().subtract('month', 2).startOf('month'), moment().subtract('month', 1).endOf('month')],
                'Last 3 Month': [moment().subtract('month', 3).startOf('month'), moment().subtract('month', 1).endOf('month')],
                'Last 4 Month': [moment().subtract('month', 4).startOf('month'), moment().subtract('month', 1).endOf('month')],
            },
            // startDate: moment().subtract('days', 29),
            // endDate: moment(),
            opens: 'right'
        },
        function(start, end) {
            $('.statementrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('.statementrange input[name="from"]').val(start.format("YYYY-MM-DD"));
            $('.statementrange input[name="to"]').val(end.format("YYYY-MM-DD"));
        }
    );
    //$('.releaserange span').html(moment().subtract('days', 6).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    //Review Release Date Picker
    $('.reviewrange').daterangepicker({
            ranges: {
                'Today': [moment().endOf('day'), moment().endOf('day')],
                'Yesterday': [moment().subtract(1, 'day').endOf('day'), moment().endOf('day')],
                'This Week': [moment().subtract('week', 0).startOf('week'), moment().endOf('day')],
                'Last Week': [moment().subtract('week', 1).startOf('week'), moment().subtract('week', 1).endOf('week')],
                'Last 2 Week': [moment().subtract('week', 2).startOf('week'), moment().subtract('week', 1).endOf('week')],
                'Last 30 Days': [moment().subtract('days', 30), moment().endOf('day')],
            },
            // startDate: moment().subtract('days', 29),
            // endDate: moment(),
            opens: 'right'
        },
        function(start, end) {
            $('.reviewrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('.reviewrange input[name="from"]').val(start.format("YYYY-MM-DD"));
            $('.reviewrange input[name="to"]').val(end.format("YYYY-MM-DD"));
        }
    );
    //Banner Add/Edit Date Picker
    $('.bannerrange').daterangepicker({
            ranges: {
                '1 Week': [moment(), moment().add('days', 6)],
                '2 Week': [moment(), moment().add('days', 13)],
                '3 Week': [moment(), moment().add('days', 20)],
                '4 Week': [moment(), moment().add('days', 27)],
            },
            // startDate: moment().subtract('days', 29),
            // endDate: moment(),
            opens: 'right'
        },
        function(start, end) {
            $('.bannerrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('.bannerrange input[name="from"]').val(start.format("YYYY-MM-DD"));
            $('.bannerrange input[name="to"]').val(end.format("YYYY-MM-DD"));
        }
    );

    //END PLUGINS DATE RANGE PICKER

    //function relman_tracks(release_id)
    $(".relman-track").click(function() {
        var ajaxurl = $("#rel_manager_trkpath").val() + '/' + $(this).data('id');
        $.ajax({
            url: ajaxurl,
            type: "POST",
            dataType: "html",
            success: function(data) {
                $('#rel-man-tracks').html('');
                $('#rel-man-tracks').html(data);
            },
            error: function() {
                alert('error!');
            }
        });
    });

    $("#save_mixes").click(function() {
        $("#rel_manage_trk").trigger("submit");
    });

});
$(".modal").on("hidden.bs.modal", function() {
    console.log('close');
    var modal_open = jQuery('body').find('div[aria-hidden="false"]').length;
    console.log(modal_open);
    if (modal_open > 0) {
        jQuery('body').addClass('modal-open');
    }
});
$(function() {

    var audio = $('audio')[0];

    $(document).on('click', '.n_player a', function(e) {
        e.preventDefault();
        var parent = $(this).parent().parent();
        $('.audio_player').removeClass('current_track');
        $(parent).addClass('current_track');
        audio = $(parent).find('audio')[0];

        $('.audio_player').find('i').removeClass('fa-stop-circle').addClass('fa-play-circle');


        $('audio').each(function() {
            this.pause(); // Stop playing           
        });

        if ($(parent).find('audio').hasClass('playing')) {
            audio.pause(); // Stop playing           
            $(parent).find('audio').removeClass('playing')
        } else {
            $(this).find('i').toggleClass('fa-play-circle fa-stop-circle');
            if (audio.currentTime == 0) {
                track_play();
            }
            audio.play();
            $('audio').removeClass('playing');
            $(parent).find('audio').addClass('playing');

        }
        calling(audio, parent);
    });

    function calling(audio, parent) {
        audio.ontimeupdate = () => {
            $(parent).find('.n_progress').css('width', audio.currentTime / audio.duration * 100 + '%');
            $(parent).find('.n_timer').text(formatTime(audio.currentTime));
        };

        audio.onended = () => {
            $(this).find('i').toggleClass('fa-play-circle fa-pause-circle');
        };

        $(document).on('click', '.n_progress-bar', function(e) {
            e.preventDefault();
            var audio = $(this).parent().parent().find('audio')[0];
            audio.currentTime = e.offsetX / $(this).width() * audio.duration;
            $('audio').each(function() {
                this.pause(); // Stop playing              
            });
            $('.audio_player').removeClass('current_track');
            $(audio).parent().addClass('current_track');
            audio.play();
        });
    }




    function formatTime(seconds) {
        let minutes = Math.floor(seconds / 60);
        seconds = Math.floor(seconds % 60);
        seconds = (seconds >= 10) ? seconds : '0' + seconds;
        return minutes + ':' + seconds;
    }
});
$(".modal.fade").on('hide.bs.modal', function() {
    // do it here
    $('audio').each(function() {
        this.pause(); // Stop playing
        this.currentTime = 0; // Reset time
    });
});
$(".promotion_for_wrap input[name=check_all]").on('click', function() {
    if ($(this).prop('checked')) {
        $(".promotion_for_wrap input").attr('checked', true);
    } else {
        $(".promotion_for_wrap input").attr('checked', false);
    }
});