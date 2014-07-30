function swfUploadPreLoad() {
   
	var self = this;
	var loading = function () {

		var longLoad = function () {

		};
		this.customSettings.loadingTimeout = setTimeout(function () {
				longLoad.call(self)
			},
			15 * 1000
		);
	};
	
	this.customSettings.loadingTimeout = setTimeout(function () {
			loading.call(self);
		},
		1*1000
	);
}

function swfUploadLoaded() {
	var self = this;
	clearTimeout(this.customSettings.loadingTimeout);
	
	//document.getElementById("btnBrowse").onclick = function () { self.selectFiles(); };
	//document.getElementById("btnCancel").onclick = function () { self.cancelQueue(); };
}
   
function swfUploadLoadFailed() {
	clearTimeout(this.customSettings.loadingTimeout);

}
   
   
function fileQueued(file) {
	


}

function fileQueueError(file, errorCode, message) {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			doalert("You have attempted to queue too many files.\n" + (message === 0 ? "You have reached the upload limit." : "You may select " + (message > 1 ? "up to " + message + " files." : "one file.")));
			return;
		}

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			doalert("File is too big.");
			this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			doalert("Cannot upload Zero Byte files.");
			this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			doalert("Invalid File Type.");
			this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		default:
			if (file !== null) {
				doalert("Unhandled Error");
			}
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
    $("#btnCancel").attr("disabled", "");

		this.startUpload();
		
}

function uploadStart(file) {

    beginwait();
	return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
    var perc = Math.round(bytesLoaded * 100 / bytesTotal);
$("#finding-nemo-text").html("<span style=\"font-size:9pt\">Файл <b>" + file.name + "</b> загружен на " + perc + "%</br>Байт загружено:"+bytesLoaded+"(всего "+bytesTotal+")</span>");
}

function uploadSuccess(file, serverData) {
    endwait();
    $("#upepic-" + $("#admwe1current-pic-field").val() + " table").append("<tr><td><img src=\"" + serverData + "\" width=\"100px\"/></td><td>" + serverData + "</td></tr>");
    //$("#" + $("#admwe1current-pic-field").val()).append("<img src=\""+serverData+"\"/>");
    $("#upepic-" + $("#admwe1current-pic-field").val()).show();
}

function uploadError(file, errorCode, message) {

		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			doalert("Upload Error: " + message);
			this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			doalert("Upload Failed.");
			this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			doalert("Server (IO) Error");
			this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			doalert("Security Error");
			this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			doalert("Upload limit exceeded.");
			this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			doalert("Failed Validation.  Upload skipped.");
			this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			// If there aren't any files left (they were all cancelled) disable the cancel button
			if (this.getStats().files_queued === 0) {
				document.getElementById(this.customSettings.cancelButtonId).disabled = true;
			}
			doalert("Cancelled");
			progress.setCancelled();
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			doalert("Stopped");
			break;
		default:
			doalert("Unhandled Error: " + errorCode);
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
}
endwait();
}

function uploadComplete(file) {
    dontneedafile();
}

// This event comes from the Queue Plugin
function queueComplete(numFilesUploaded) {

   // endwait();
}
