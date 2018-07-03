$.fn.changeInit = function(execFunc){
    var jEl = $(this);

    var _obj = {
        setChange       : false,
        execOff         : function(){
            if(_obj.setChange){
                jEl.off("change");
                if(jEl.hasClass("select2-hidden-accessible")) jEl.select2();
                _obj.setChange = false;
            }
            return _obj;
        },
        execOn         : function(){
            if(!_obj.setChange) {
                jEl.change(function(){
                    execFunc(jEl);
                });
                _obj.setChange = true;
            }
            execFunc(jEl);

            return _obj;
        }
    };

    return _obj;
}
