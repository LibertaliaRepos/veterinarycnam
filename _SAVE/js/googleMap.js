function initMap(callback) {
    var DEBUG_AJAX = true;
    var xhr = getXhr();
    var url = '../php/index.php?EX=AJAX_mapData';
    
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.send();
    
    xhr.onreadystatechange = function() {
        if (xhr.status === 200 && xhr.readyState == 4) {
            var data = JSON.parse(xhr.responseText);
            
            if (DEBUG_AJAX) {console.log(data);}
            
            
            var location = {lat: parseFloat(data.lat), lng: parseFloat(data.lng)};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: location
            });
            
            var marker = new google.maps.Marker({
                position: location,
                map: map,
                title: 'CAT CLINIC'
            });
            
            var size = new google.maps.Size({
                width: 15,
                height: 20,
                widthUnit: 'px',
                heightUnit: 'px'
            });
            
            var infoWindow = new google.maps.InfoWindow({
                content: data.info,
//                position: location,
                maxWidth: 350
            });
            
//            infoWindow.open(map);
            

                marker.addListener('click', function() {infoWindow.open(map, marker);});
        }
    };
};



