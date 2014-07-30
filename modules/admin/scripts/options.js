var swfu3=null;
$(document).ready(function() {

    function uploadImagePackStart(file) {

    	
    	return true;
    }
    function fileImagePackQueueError(file, errorCode, message) {
    	
    }
    function uploadImagePackProgress(file, bytesLoaded, bytesTotal) {
    	
    	  var perc = Math.round(bytesLoaded * 100 / bytesTotal);
    	    $("#progressdiv").html("Файл <b>" + file.name + "</b> загружен на " + perc + "%</br>Байт загружено:" + bytesLoaded + "(всего " + bytesTotal + ")");    }

    function uploadImagePackSuccess(file, serverData) {

    	 var ar = serverData.split('~@~');
    	    $("#loadedthings table").append('<tr><td><img width="128px" src="/' + ar[0] + '" /></td><td><input style="width:500px;" name="twheader-' + ar[1] + '" type="text"/><br/><textarea style="width:500px;height:150px;" name="twarea-' + ar[1] + '" class="twarea"></textarea></td></tr>');
    	    $("#uploadedpic").val($("#uploadedpic").val()+ar[1]+";");

    }
    function uploadImagePackComplete(file) {
    	$("#progressdiv").html('');
    }
    function fileImagePackDialogComplete(numFilesSelected, numFilesQueued) {
    

    		this.startUpload();
    		
    }

    if ($("#packimage_ph").length > 0){
        SWFUpload.onload = function () {
            var settings = {
                flash_url: "/_scripts/swfupload/swfupload.swf",
                upload_url: "/_ajax/admin/do.php?act=uploadimagepack&galid=" + $("#foto-gallery").val() ,
                file_size_limit: "100 MB",
                file_types: "*.jpg",
                file_types_description: "Jpeg Picture",
                file_upload_limit: 250,
                file_queue_limit: 0,
                debug: false,

                // Button Settings
                button_placeholder_id: "packimage_ph",
                button_width: 180,
                button_height: 30,
                button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
                button_cursor: SWFUpload.CURSOR.HAND,

                // The event handler functions are defined in handlers.js
                swfupload_loaded_handler: swfUploadLoaded,
                 upload_start_handler: uploadImagePackStart,//da
                upload_progress_handler: uploadImagePackProgress,
                upload_success_handler: uploadImagePackSuccess,
                upload_complete_handler: uploadImagePackComplete,
                upload_error_handler: fileImagePackQueueError,
                file_dialog_complete_handler: fileImagePackDialogComplete,
                // SWFObject settings
                minimum_flash_version: "9.0.28",
                    swfupload_pre_load_handler: swfUploadPreLoad,
                    swfupload_load_failed_handler: swfUploadLoadFailed
            };

            swfu3 = new SWFUpload(settings);
        }}
        
});