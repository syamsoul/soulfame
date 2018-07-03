function SDPopulateLang(var_lang){
    /* **
    ** Author: Syamsoul Azrien Muda (+60139584638)
    ** Required Library: JQuery
    ** ************************** */

    var mainclass = this;

    var options = {
        prefix: "lang-",
        child_prefix: "c-",
        jquery_el: ".",
    };

    var objOrStr = function(index, val, parent_el=null, prefix_c_s=null){
        var prefix = options.prefix;
        var child_prefix = options.child_prefix;
        var jquery_el = options.jquery_el;

        if(prefix_c_s == null) prefix_c_s = prefix + child_prefix;

        if(typeof(val) == "object"){
            $.each(val, function (index2, val2) {
                if(val.constructor === Array){
                    if(typeof(val2) == "string"){
                        if(parent_el == null) $($(jquery_el+prefix+index)[index2]).html(val2);
                        else $(parent_el.find(jquery_el+prefix_c_s+index)[index2]).html(val2);
                    }else if(typeof(val2) == "object"){
                        $.each(val2, function (index3, val3) {
                            if(parent_el == null){ objOrStr(index3, val3, $($(jquery_el+prefix+index)[index2]));}
                            else {objOrStr(index3, val3, $(parent_el.find(jquery_el+prefix_c_s+index)[index2]), prefix_c_s+child_prefix);}
                        });
                    }
                }else{
                    if(parent_el == null) objOrStr(index2, val2, $(jquery_el+prefix+index));
                    else objOrStr(index2, val2, parent_el.find(jquery_el+prefix_c_s+index), prefix_c_s+child_prefix);
                }
            });
        }else if(typeof(val) == "string"){
            var theElement = null;
            if(parent_el == null) theElement = $(jquery_el+prefix+index);
            else theElement = parent_el.find(jquery_el+prefix_c_s+index);

            if(theElement.is("[flang-replace-attr]") && theElement.attr('flang-replace-attr')) {
                var replc_attr = JSON.parse( theElement.attr('flang-replace-attr').replace(new RegExp("'", 'g'), "\"") );
                for(var i in replc_attr) val = val.replace(new RegExp("{{"+i+"}}", 'g'), replc_attr[i]);
            }

            theElement.html(val);
        }
    };

    this.update = function(){
        $.each(var_lang, function (index, val) {
            if(val != null && val !=undefined){
                objOrStr(index, val);
            }
        });
    }

    this.setOpt = function(obj){
        $.each(obj, function(index, val){
            options[index] = val;
        });

        return mainclass;
    }
};
