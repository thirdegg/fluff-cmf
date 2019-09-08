$.generateUid = function() {
    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
    }
    return s4() + s4() + s4() + s4() + s4() + s4() + s4() + s4();
};

$.popup = function(url,name,callback) {
    var w = window.open(url,name,'width=800,height=600');
    w.opener.callback = callback;
    return w;
};

$.popupResult = function(w,data) {
    console.log(w);
    try {
        w.opener.callback(data);
        w.close();
    } catch (err) {
        console.log(err);
    }
    return false;
}
