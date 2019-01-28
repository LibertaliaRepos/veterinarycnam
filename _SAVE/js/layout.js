var src = new Array();
var i = 0;

src[i++] = '../bower_components/jquery/dist/jquery.js';
src[i++] = '../bower_components/what-input/dist/what-input.js';
src[i++] = '../bower_components/foundation-sites/dist/js/foundation.js';
src[i++] = 'https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.5.1//js/froala_editor.pkgd.min.js';
src[i++] = '../js/init.js';
src[i++] = '../js/ajax.js';
src[i++] = '../js/modifDetails.js';
src[i++] = '../js/modifEmployees.js';
src[i++] = '../js/schedulesModif.js';
src[i++] = '../js/conseils.js';
src[i++] = '../js/appointment.js';
src[i++] = '../js/inscription.js';
src[i++] = '../js/memberDetails.js';
src[i++] = '../js/googleMap.js';

for (var j = 0; j < i; ++j) {
    document.write('<script src="'+ src[j] +'"></script>');
}
document.write('<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxTE-vsnAFqupCpWG9D3Q7e-l0-3Yh_Gs&callback=initMap"></script>')