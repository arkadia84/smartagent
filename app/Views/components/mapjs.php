<script>
        // map control functions
        let fullScreen=()=>{
            if(document.getElementById('map-container').classList.contains("col-md-9")){
                document.getElementById('map-container').classList.remove("col-md-9")
                document.getElementById('map-container').classList.add("col-md-12")
                document.getElementById('bar-container').style.display='none'
                map.resize()
                document.getElementById('side-bar-btn').innerHTML=`<i class="bi bi-caret-left-fill"></i>`
            }else{
                document.getElementById('map-container').classList.remove("col-md-12")
                document.getElementById('map-container').classList.add("col-md-9")
                document.getElementById('bar-container').style.display='block'
                map.resize()
                document.getElementById('side-bar-btn').innerHTML=`<i class="bi bi-caret-right-fill"></i>`
            }   
        },
        goHome=()=>{
            map.flyTo({
                center: [115.14083969067292,-8.393090919502285],zoom: 9.3
            })
        },
        goGeolocate=()=>{
            document.getElementsByClassName('maplibregl-ctrl-geolocate')[0].click()
            map.on('load',()=>{
                geolocate.trigger()
                geolocate.on('geolocate', () => {
                    alert('A geolocate event has occurred.')
                })
            })
        },
        goToPoint=(x,y)=>{
            map.flyTo({
                center: [x,y],zoom: 16
            })
        }
        // populate real estate list
        datasample.features.forEach(el => {
            let childEl=`<button onclick="goToPoint(`+el.properties.Longitude+`,`+el.properties.Latitude+`)" class="list-group-item list-group-item-action" aria-current="true">
                            <div class="row">
                                <div class="col-3"><img src="`+el.properties.Cover+`" class="card-img-top" alt="..."></div>
                                <div class="col-9"><div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">`+el.properties.Title+`</h5>
                                    <small>3 days ago</small>
                                </div>
                                <p class="mb-1">Some placeholder content in a paragraph.</p>
                                <small>And some small print.</small></div>
                            </div>     
                        </button>`
            document.getElementById('real-estate-list').insertAdjacentHTML( 'beforeend', childEl );
        });
        // draw the map
        let map = new maplibregl.Map({
            container: 'map',
            center: [115.14083969067292,-8.393090919502285],
            zoom: 9.3,
            style: {
                version: 8,
                sources: {
                    osm: {
                        type: 'raster',
                        tiles: ['https://a.tile.openstreetmap.org/{z}/{x}/{y}.png'],
                        tileSize: 256,
                        attribution: '&copy; OpenStreetMap Contributors',
                        maxzoom: 22
                    },
                },
                layers: [
                {
                    id: 'osm',
                    type: 'raster',
                    source: 'osm'
                }]
            }
        }),
        geolocate = new maplibregl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true
            },
            trackUserLocation: true
        })
        map.addControl(geolocate)
        // map on load function
        map.on('load', () => {
            map.addSource('real-estate', {
                'type': 'geojson',
                'data': datasample
            })
            map.addLayer({
                'id': 'lyr-real-estate',
                'type': 'circle',
                'source': 'real-estate',
                "paint": {
                    "circle-radius": 6,
                    "circle-color": '#1ABC9C',
                    "circle-stroke-width": .5,
                    "circle-stroke-color":'#2C3E50'
                }
            })
        })
 </script>