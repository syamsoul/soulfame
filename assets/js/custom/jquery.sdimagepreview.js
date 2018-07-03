$.fn.sdImagePreview = function(theObj=null){
    var execBefore = null;
    var execAfter = null;
    var file_change = false;

    if(theObj!=null){
        if(theObj.execBefore != undefined) execBefore = theObj.execBefore;
        if(theObj.execAfter != undefined) execAfter = theObj.execAfter;
    }

    var preview_el  = $(this).attr("data-target-preview");
    var val_el      = $(this).attr("data-target-val");

    $(preview_el).on('load', function(){
        if(file_change) if(execAfter!=null) execAfter();
        file_change = false;
    });

    var readFile = function(){
        var FR = new FileReader();

        FR.addEventListener("load", function(e) {
            if(execBefore!=null) execBefore();
            $(val_el).val(e.target.result);
            $(preview_el).attr("src", e.target.result);
        });

        FR.readAsDataURL( this.files[0] );
        file_change = true;
    }

    $(this)[0].addEventListener("change", readFile);
}
