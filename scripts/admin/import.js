$(document).ready(function(){
    
    if($("#selectefiles").length>0){
    
        var target=$("#selectefiles")[0];
        var uploader = new qq.FineUploader({
        element: target, multiple: true,
        validation: {sizeLimit: 250000000,
        allowedExtensions: ['xls', 'xlsx']},
        debug: true,        text: {
            uploadButton: "Выбрать файлы Excel для Импорта"
        },
        request: {
            endpoint:  wwwpath+'importexcel'
        },
        callbacks: {
        onSubmit: function(id, fileName){
               
        },
        onProgress: function(id, fileName, loaded, total){
  
        }, 
        onError: function(response){
       alert('err'+response);
               console.log('error');   

        }, 
        onComplete: function(id, fileName, response){
        //  alert($.toJSON(response));
        }
        }
    });
    }
    
});