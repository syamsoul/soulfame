$.fn.updateSelect2 = function(opt_arr){
    var main = $(this);
    if (main.hasClass("select2-hidden-accessible")) main.select2('destroy');
    main.html("");

    for(var i in opt_arr) {
        var val=i, label=opt_arr[i], allowed_typeof = ['string', 'number'];
        if(typeof label == "object" && ($.inArray(typeof label['val'], allowed_typeof) > -1 && $.inArray(typeof label['label'], allowed_typeof) > -1)) val=label['val'], label=label['label'];
        main.append("<option value='"+val+"'>"+label+"</option>");
    }
    main.select2();

    return main;
}
