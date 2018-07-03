$.fn.multiSelect2 = function(msObj={}){
    /*require loudev MultiSelect JS (Jquery)*/
    var atel = $(this);

    var updateMS = function(data){
        var newlisthtml="";
        for(var i in data){
            if(typeof data[i] == "string") newlisthtml += "<option value=\""+i+"\">"+data[i]+"</option>";
            else if(typeof data[i] != "string" && typeof data[i] == "object"){
                var hasItem = false, newlisthtml2 = "";
                for(var j in data[i]) if(typeof data[i][j] == "string"){
                    hasItem = true;
                    newlisthtml2 += "<option value=\""+j+"\">"+data[i][j]+"</option>";
                }
                if(hasItem) newlisthtml += "<optgroup label='"+i+"'>"+newlisthtml2+"</optgroup>"
            }
        }
        atel.html(newlisthtml);
        if(atel.attr('data-msloaded') == undefined){
            atel.attr('data-msloaded', 'loaded');
            atel.multiSelect("destroy");
            atel.multiSelect(msObj);
        }else{
            atel.multiSelect('refresh');
        }
    }

    return {
        atel    : $(this),
        update  : function(data){
            updateMS(data);
        }
    };


}
