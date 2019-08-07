function fileUpload(form, actionUrl, infoDivId) {


    //Enabling info for upload
    document.getElementById(infoDivId).style = "display: block;";

    // Creating hidden iframe so page won't refresh
    var iframe = document.createElement("iframe");
    iframe.setAttribute("id", "uploadIframe");
    iframe.setAttribute("name", "uploadIframe");
    iframe.setAttribute("width", "0");
    iframe.setAttribute("height", "0");
    iframe.setAttribute("border", "0");
    iframe.setAttribute("style", "width: 0; height: 0; border: none;");

    // Adding iframe to form
    form.parentNode.appendChild(iframe);
    window.frames['uploadIframe'].name = "uploadIframe"; 

    var myIframe = document.getElementById("uploadIframe");
    var msgIframe;

    // Add event...
    var eventHandler = function () {

        if (myIframe.detachEvent){
            myIframe.detachEvent("onload", eventHandler); //removing event
        } else { 
            myIframe.removeEventListener("load", eventHandler, false); //removing listener
        }
        // Getting message from server (checking all possible locations in the dom)
        if (myIframe.contentDocument) {
            msgIframe = myIframe.contentDocument.body.innerHTML;
        } else if (myIframe.contentWindow) {
            msgIframe = myIframe.contentWindow.document.body.innerHTML;
        } else if (myIframe.document) {
            msgIframe = myIframe.document.body.innerHTML;
        }

        document.getElementById(infoDivId).innerHTML = msgIframe;

        // Deleting frame
        setTimeout('myIframe.parentNode.removeChild(myIframe)', 250); //TODO CHECK WHAT HAPPENDS IF YOU REMOVE SET TIMEOUT AND DELETE INSTANTLY
    }

    //When iframe is loaded (so file is uploaded) get message from server and delete event and listener
    if (myIframe.addEventListener) {
        myIframe.addEventListener("load", eventHandler, true);
    }
    if (myIframe.attachEvent) {
         myIframe.attachEvent("onload", eventHandler);
    }

    // Setting form properties
    form.setAttribute("target", "uploadIframe");
    form.setAttribute("action", actionUrl);
    form.setAttribute("method", "post");
    form.setAttribute("enctype", "multipart/form-data");
    form.setAttribute("encoding", "multipart/form-data");

    // Submitting the form
    form.submit();

    document.getElementById(infoDivId).innerHTML = "Η μεταφόρτωση του αρχείου έχει ξεκινήσει<br>Παρακαλώ περιμένετε...";

}