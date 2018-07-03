var SdFileUpload = function (file, post_name="upfile") {
    this.file = file;
    this.post_name = post_name;
    this.getType = function() {
        return this.file.type;
    };
    this.getSize = function() {
        return this.file.size;
    };
    this.getName = function() {
        return this.file.name;
    };
    this.doUpload = function(extraData = [], execHandling = null, execSuccess = null, execError = null) {
        var that = this;
        var formData = new FormData();

        // add assoc key values, this will be posts values
        formData.append(this.post_name, this.file, this.getName());
        for(var i in extraData) formData.append(i, extraData[i]);

        $.ajax({
            method: "POST",
            url: "",
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', function(event){
                        var percent = that.realProgressHandling(event);
                        if(execHandling != null) execHandling(percent);
                    }, false);
                }
                return myXhr;
            },
            success: function (res) {
                if(execSuccess != null) execSuccess(res);
            },
            error: function (error) {
                if(execError != null) execError(error);
            },
            async: true,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            timeout: 300000
        });
    };

    this.realProgressHandling = function (event) {
        var percent = 0;
        var position = event.loaded || event.position;
        var total = event.total;
        if (event.lengthComputable) {
            percent = Math.ceil(position / total * 100);
        }

        return percent;
    }
};
