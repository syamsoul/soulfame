$.fn.sdThumbnailView = function(theObj={}){
    var fg          = {};
    var viewBtn     = {};
    var dloadBtn    = {};

    var ini = $(this);

    var initRender = function(){
        for(var i in ini){
            if(isNaN(i)) continue;
            var ini_temp = ini[i];

            if(theObj['view_text'] == undefined) theObj['view_text'] = 'View';
            if(theObj['download_text'] == undefined) theObj['download_text'] = 'Download';

            var pad_bottom = $(ini_temp).css('padding-bottom');
            var pad_left = $(ini_temp).css('padding-left');
            var pad_right = $(ini_temp).css('padding-right');

            $(ini_temp).css("position", "relative");

            fg[i] = $("<div></div>");
            fg[i].hide();
            fg[i].css({
                'background-color'  : 'rgba(0,0,0,0.4)',
                'position'          : 'absolute',
                'bottom'            : pad_bottom, 'left':pad_left, 'right':pad_right,
                'text-align'        : 'right',

            });

            var btnCss = {'cursor':'pointer', 'margin':'0 5px', 'color':'#ecf0f1',};

            viewBtn[i] = $('<span>' + theObj['view_text'] + '</span>');
            viewBtn[i].css(btnCss);
            initViewClick(i);

            dloadBtn[i] = $('<a>' + theObj['download_text'] + '</a>');
            dloadBtn[i].css(btnCss);
            initDloadClick(i);

            fg[i].append(viewBtn[i]);
            fg[i].append(dloadBtn[i]);
            $(ini_temp).append(fg[i]);
            $(ini_temp).hover(function(){
                var currentIndex = ini.index(this);
                fg[currentIndex].show();
            },function(){
                var currentIndex = ini.index(this);
                fg[currentIndex].hide();
            });
        }
    }

    var initViewClick = function(i){
        viewBtn[i].click(function(){
            var imgLoc = $(ini[i]).find('img').attr('src');
            var bg_temp = $("<div></div>");
            bg_temp.css({
                "display" : "table",
                "width":"100%",
                "height":"100%",
                "background-color":"rgba(0,0,0,0.6)",
                "position":"fixed",
                "z-index":"2450",
                "top":"0", "bottom":"0", "left":"0", "right":"0",
            });

            var bg_temp_2 = $("<div style='display:table-cell; vertical-align:middle; text-align:center; height:100%;'></div>");
            var img_preview = $("<div class='thumbnail' style='width:100%;max-width:800px;margin:0 auto;'><img src='"+imgLoc+"' width='100%' /></div>");

            var closeBtn = $('<button class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>');
            closeBtn.css({
                "position":"absolute",
                "top":"20px", "right":"20px",
                "border-radius": "9999px",
            });
            closeBtn.click(function(){
                bg_temp.remove();
            });
            bg_temp.click(function(e){
                if(e.target == bg_temp_2[0]) bg_temp.remove();
            });

            bg_temp_2.append(img_preview);
            bg_temp.append(bg_temp_2);
            bg_temp.append(closeBtn);
            $("body").append(bg_temp);
        });
    }

    var initDloadClick = function(i){
        var imgLoc = $(ini[i]).find('img').attr('src');
        var imgLocArr = imgLoc.split("/");

        dloadBtn[i].attr('href', imgLoc);
        dloadBtn[i].attr('download', imgLocArr[imgLocArr.length-1]);
    }

    initRender();
}
