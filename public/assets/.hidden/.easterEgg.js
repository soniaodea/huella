$(function () {
    let hits = 0;

    $("html").on("keyup", function (e) {
       !hits&&38===e.keyCode||1===hits&&38===e.keyCode||2===hits&&40===e.keyCode||3===hits&&40===e.keyCode||4===hits&&37===e.keyCode||5===hits&&39===e.keyCode||6===hits&&37===e.keyCode?hits++:7===hits&&39===e.keyCode&&$("html").append("<style>html,img{-webkit-filter:invert(100%)!important}@media (-webkit-min-device-pixel-ratio:2){html{transform:translateZ(0)}}*,:after,:before,button,input,input[type=file],select,textarea{font-family: 'Input Mono', 'Source Code Pro', Menlo, Consolas, monospace !important}input[type=button],input[type=file]::-webkit-file-upload-button,input[type=submit]{font-family: 'Input Mono', 'Source Code Pro', Menlo, Consolas, monospace !important;-webkit-appearance:button!important}</style><audio autoplay src='assets/.hidden/.easterEgg.mp3'/>");
   });
});
