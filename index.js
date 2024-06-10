
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
        },
        infoModalClose=()=>{
            let infoModal=document.getElementById('info-modal')
            infoModal.style.display = "none";
            infoModal.className="modal fade";
        },
        realEstateControl=()=>{
            let nullSrc={
            "type": "FeatureCollection",
            "features": []}
            map.getSource('real-estate')._data.features.length>0?map.getSource('real-estate').setData(nullSrc):map.getSource('real-estate').setData(datasample)
        },
        statisticsControl=()=>{
            let nullSrc={
            "type": "FeatureCollection",
            "features": []}
            map.getSource('stats-grid')._data.features.length>0?map.getSource('stats-grid').setData(nullSrc):map.getSource('stats-grid').setData(grid)
        },
        zonePlanControl=()=>{
            let nullSrc={
            "type": "FeatureCollection",
            "features": []}
            map.getSource('zone-plan')._data.features.length>0?map.getSource('zone-plan').setData(nullSrc):map.getSource('zone-plan').setData(zonePlan)
        },
        populateList=(features)=>{
            // populate real estate list
            document.getElementById('real-estate-list').replaceChildren()
            features.forEach(el => {
                let childEl=`<button onclick="goToPoint(`+el.properties.Longitude+`,`+el.properties.Latitude+`)" class="list-group-item list-group-item-action" aria-current="true">
                                <div class="row">
                                    <div class="col-3"><img src="`+el.properties.Cover+`" class="card-img-top" alt="..."></div>
                                    <div class="col-9"><div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1"><b>`+el.properties.Title+`</b></p>
                                        <small>3 days ago</small>
                                    </div>
                                    <p class="mb-1">Some placeholder content in a paragraph.</p>
                                    <small>And some small print.</small></div>
                                </div>     
                            </button>`
                document.getElementById('real-estate-list').insertAdjacentHTML( 'beforeend', childEl );
            });  
        }
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
        // add controls
        geolocate = new maplibregl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true
            },
            trackUserLocation: true
        })
        ,geocoderApi = {
            forwardGeocode: async (config) => {
                const features = [];
                try {
                    const request =
                `https://nominatim.openstreetmap.org/search?q=${
                    config.query
                }&format=geojson&polygon_geojson=1&addressdetails=1`;
                    const response = await fetch(request);
                    const geojson = await response.json();
                    for (const feature of geojson.features) {
                        const center = [
                            feature.bbox[0] +
                        (feature.bbox[2] - feature.bbox[0]) / 2,
                            feature.bbox[1] +
                        (feature.bbox[3] - feature.bbox[1]) / 2
                        ];
                        const point = {
                            type: 'Feature',
                            geometry: {
                                type: 'Point',
                                coordinates: center
                            },
                            place_name: feature.properties.display_name,
                            properties: feature.properties,
                            text: feature.properties.display_name,
                            place_type: ['place'],
                            center
                        };
                        features.push(point);
                    }
                } catch (e) {
                    console.error(`Failed to forwardGeocode with error: ${e}`);
                }

                return {
                    features
                };
            }
        };
        map.addControl(
            new MaplibreGeocoder(geocoderApi, {
                maplibregl
            }),'top-left'
        );
        map.addControl(geolocate)
        // map on load function
        fetch('https://www.notion.com/nftydaddy/383f94eb39754b3bbd9130c8ad94cdc9?v=46e8bb0bc2f248b6b01cf994ab0cdb6b&pvs=4',
        {
            method: 'GET',
            headers: {
                Authorization: `Bearer secret_vwAgGyHilU5tKExktYcYEj0ZRtyuC2sCoTClIxAcaPR`,
                "Notion-Version": "2022-06-28",
                "Content-Type": "application/json",
            },
            // body: JSON.stringify({grant_type: '"authorization_code"'})
        }
        ).then((resp)=>{
            console.log(resp)
        })
        map.on('load', () => {
            map.addSource('real-estate', {
                'type': 'geojson',
                'data': datasample
            })
            map.addSource('stats-grid',{
                'type': 'geojson',
                'data': grid
            })
            // map.addSource('zone-plan',{
            //     'type': 'geojson',
            //     'data': zonePlan
            // })
            map.addLayer({
                'id':'lyr-stats-grid',
                'type':'fill',
                'source':'stats-grid',
                'layout': {},
                'paint': {
                    'fill-color': '#088',
                    'fill-opacity': 0.3
                }
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
            // map.addLayer({
            //     'id': 'lyr-zone-plan',
            //     'type':'fill',
            //     'source':'zone-plan',
            //     'layout': {},
            //     'paint': {
            //         'fill-color': '#F3E37C',
            //         'fill-opacity': 0.3
            //     }
            // })
            populateList(datasample.features)
            map.on('click', function (e) {
                let features = map.queryRenderedFeatures(e.point, { layers: ['lyr-real-estate'] });
                if (!features.length) {
                    return;
                }
                let feature = features[0],infoPopup=document.getElementById('info-modal'),
                title=document.getElementById('info-modalLabel'),image=document.getElementById('info-img'),
                address=document.getElementById('info-address')
                infoPopup.style.display = "block";
                infoPopup.style.backgroundColor = 'rgba(0,0,0,0.5)';
                infoPopup.className="modal fade show";
                console.log(feature)
                title.innerHTML=feature.properties.Title
                image.src=feature.properties.Cover
                address.innerHTML=feature.properties.Address
                document.getElementById('info-category').insertAdjacentHTML( 'beforeend', "<h5>"+feature.properties.Category+"</h5>" )
                document.getElementById('info-land').innerHTML=feature.properties["Land (sqm)"]+" sqm"
                document.getElementById('info-house').innerHTML=feature.properties["House (sqm)"]+" sqm"
                document.getElementById('info-pool').innerHTML=feature.properties["Pool size (sqm)"]+" sqm"
                document.getElementById('info-price').innerHTML=feature.properties["Price/Year"]
                document.getElementById('info-currency').innerHTML=feature.properties["Currency"]
                document.getElementById('info-tol').innerHTML=feature.properties["Type of Lease"]
                document.getElementById('info-link').setAttribute("href", feature.properties["Link"])
                document.getElementById('info-location').setAttribute("href", feature.properties["Location link"])
            })
            map.on('mousemove', (e)=>{
                let features = map.queryRenderedFeatures(e.point, { layers: ['lyr-real-estate'] });
                map.getCanvas().style.cursor = (features.length) ? 'pointer' : '';
            })
            map.on('moveend',(e)=>{
                let features = map.queryRenderedFeatures(e.point, { layers: ['lyr-real-estate']})
                populateList(features)
            })
        })