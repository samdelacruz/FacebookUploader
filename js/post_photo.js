$("#fb_image").fileinput(({
    'uploadAsync' : true,
    'showPreview': false,
    'allowedFileExtensions' : ['jpg', 'jpeg', 'png','gif'],
    'maxFilesNum' : 1,
    'uploadUrl' : 'http://localhost:8888/photo.php',
    'dropZoneEnabled' : false,
    'layoutTemplates' : {
        actionUpload: ''
    },
    'uploadExtraData' : function () {
        return {'fb_status' : $("#fb_status").val()};
    }
}));

$('#fb_image').on('filebatchuploadsuccess', function(event, data) {
    document.getElementById('fb_status').value = '';
    var response = data.response;
    var parsedData = JSON.parse(response);
    if(parsedData.url) {
        output = '<strong>Post Successful: </strong><a target="_blank" href="' + parsedData.url + '">View on Facebook</a>';
    } else {
        output = "<pre>" + data + "</pre>";
    }
    $(".result").html(output);
    $(".result").removeClass("hidden");
});

$('#fb_image').on('filebrowse', function(event) {
    console.log("file browse triggered");
    $(".result").html("");
    $(".result").addClass("hidden");
});