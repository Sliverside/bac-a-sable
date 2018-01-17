(function(){
    var toogleBacktrace = document.getElementsByClassName("debugger-toggleBacktrace");
    Array.prototype.forEach.call(toogleBacktrace, function(el) {
      el.addEventListener('click', function(){
        var backtrace = el.nextSibling.firstChild;
        if (backtrace.currentStyle ? backtrace.currentStyle.display == "none" :
        getComputedStyle(backtrace, null).display == "none") {
          backtrace.style.display = "block";
        }else {
          backtrace.style.display = "none";
        }
      });
    });
})()
