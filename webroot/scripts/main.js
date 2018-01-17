var mainHeader;
var mainFooter;
var mainContent;

ready((function(){

  mainHeader = document.getElementById('main-header');
  mainFooter = document.getElementById('main-footer');
  mainContent = document.getElementById('main-content');

  function contentMinHeight() {
    var marginTop = window.getComputedStyle(mainContent)['margin-top'];
    var marginBottom = window.getComputedStyle(mainContent)['margin-bottom'];
    var exteriorsElemsHeight = outerHeight(mainHeader) + outerHeight(mainFooter);
    mainContent.style.minHeight = "calc(100vh - ("+exteriorsElemsHeight+"px + "+marginTop+" + "+marginBottom+"))";
  } contentMinHeight();

  window.addEventListener("resize", contentMinHeight);

})())
