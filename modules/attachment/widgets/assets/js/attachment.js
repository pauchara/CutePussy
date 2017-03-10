var attachments = new Vue({
    el: '#attachment',
    data: {
        showExistingAttachments: false,
        files: [],
        currentPage: 1,
        filesOnPage: 8,
        maxPage: null,
        selectedFile: null,
        acceptType: [],
        error: null,
    },
    created: function () {
        this.acceptType = acceptMime;
        $.ajax({
            url: '/web/attachment/default/count-page',
            success: function (data) {
                attachments.maxPage = Math.ceil(data/8);
            }
        });
    },

    methods: {
        changeStatusExistingAttachments: function () {
            this.loadFile();
            this.showExistingAttachments = !this.showExistingAttachments;
        },

        loadAjaxFiles: function () {
            if ( this.acceptType.length != 0 ) {
                var mimeFlag = false;
                for (var i= 0; i< this.acceptType.length; i++) {
                    if ((event.target.files[0].type).indexOf(this.acceptType[i]) != -1) {
                        mimeFlag = true;
                        break;
                    }console.log(event.target.files[0].type);
                }
                if(mimeFlag == false) {
                    this.error = 'incorrect mime type file';
                    return;
                } else {
                    this.error = null;
                }
            }
            console.log(mimeFlag);
            var fd = new FormData(document.getElementById('uploadFileForm'));
            fd.append($(event.target).attr('name'), event.target.files[0]);

            $.ajax({
                url: '/web/attachment/default/create-and-return',
                type: 'POST',
                data: fd,

                processData: false,
                contentType: false,
                success: function (data) {
                    attachments.showExistingAttachments = false;
                    attachments.selectedFile = data;
                }
            });
        },

        getFileInfo: function (event) {
            $.ajax({
                url: '/web/attachment/default/get-file-data',
                type: 'POST',
                data: {id: $(event.target).attr('file-id')},
                success: function (data) {
                    attachments.showExistingAttachments = false;
                    attachments.selectedFile = data;
                }
            });
        },

        loadFile: function () {
            $.ajax({
                url: '/web/attachment/default/get-file',
                type: 'POST',
                data: {
                    fileOnPage: this.filesOnPage,
                    currentPage: this.currentPage,

                },
                success: function (data) {
                    this.error = null;
                    attachments.files = data;
                },
                error: function () {
                    console.log('error load more file');
                },
            });
        },

        nextPage: function () {
            if(this.currentPage + 1 <= this.maxPage) {
                this.currentPage =  this.currentPage + 1;
            }
            this.loadFile();
        },

        previousPage: function () {
            if (this.currentPage > 1) {
                this.currentPage = this.currentPage - 1;

            }
            this.loadFile();
        },
    }
});
