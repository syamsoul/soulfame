'use strict';
//  Author: AdminDesigns.com
//
//  This file is reserved for changes made by the user
//  as it's often a good idea to seperate your work from
//  the theme. It makes modifications, and future theme
//  updates much easier
//

//  Place custom scripts below this line
///////////////////////////////////////
$.fn.hasAttr = function(attrName){
    var is_has_attr = $(this).attr(attrName);
    if (typeof is_has_attr !== typeof undefined && is_has_attr !== false) return true;
    return false;
}

function toastrArr(jsonobj){
    for(var i in jsonobj) toastr[jsonobj[i].type](jsonobj[i].msg);
}

function get_noti(ignore_open=false){
    if(!$('#alert_menu').hasClass('open') || ignore_open){
        $.ajax({
            url: BASE_PATH+"/ajax/general",
            method: "POST",
            data: {action: "getNoti"}
        }).done(function(res){
            handleAjaxResult(res, function(res){
                $($("#alert_menu").find("button.dropdown-toggle")[0]).find('.noti_count').remove();

                if(res.unread > 0){
                    $($("#alert_menu").find("button.dropdown-toggle")[0]).append("<b class=\"noti_count\">"+res.unread+"</b>");

                    var html_li_str = "";
                    for(var i in res.row){
                        html_li_str += "<li class=\"each_noti\" onclick=\"get_noti_details("+res.row[i]['xid']+");\">";
                        html_li_str += "<span class=\"glyphicons glyphicons-bell text-orange2 fs16 mr15\"></span>"+res.row[i]['title'];
                        html_li_str += "<div class=\"each_noti_datetime\"><span class=\"text-muted\">"+res.row[i]['created_at']+"</span></div>";
                        html_li_str += "</li>";
                    }
                    $($("#alert_menu").find("ul.noti_list")[0]).html(html_li_str);

                }else $($("#alert_menu").find("ul.noti_list")[0]).html("<li class=\"each_noti each_noti_disabled\">No notifications</li>");
            });
        });
    }
}

function get_noti_details(xid, execAfter=null){
    var n_m = $('#noti_modal');
    n_m.find('.noti_title').html("");
    n_m.find('.noti_desc').html("");

    $.ajax({
        url: BASE_PATH+"/ajax/general",
        method: "POST",
        data: {action: "getNoti", xid: xid}
    }).done(function(res){
        handleAjaxResult(res, function(res){
            n_m.find('#curr_noti_view').val(res.id);
            n_m.find('.noti_title').html(res.title);
            n_m.find('.noti_desc').html(res.desc);
            n_m.modal('show');
            if(execAfter!=null) execAfter(xid);
        });
    });
}

function handleAjaxResult(res, execAfter){
    try{
        res = JSON.parse(res);
        execAfter(res);
    }catch(exception){
        toastr['error'](res);
    }
}
