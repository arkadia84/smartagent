<style>
        :root {
            --primary: #2C3E50;
            --secondary: #1ABC9C;
            --neutral1:#ECF0F1;
            --neutral2:#7F8C8D;
            --accent1:#F39C12;
            --accent2:#27AE60;
            --complementary:#8E44AD;
        }
        body{background-color:var(--neutral1);font-family: 'Lato', sans-serif;}
        h1, h2, h3, h4, h5, h6 {font-family: 'Montserrat', sans-serif;}
        button, .highlight {font-family: 'Roboto', sans-serif;}
        .control-btn{background-color:var(--secondary);border-color:var(--primary)}
        .control-btn:hover{background-color:var(--accent1)}
        #dashboard-container{height:100vh;width:100vw;}
        #map{height:100%;width:100%;}
        #side-bar-btn{position:absolute;z-index:1000;right:0;top:.5em;
            border-top-right-radius:0;border-bottom-right-radius: 0;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            background-color:var(--neutral1);border-color:var(--neutral1);
        }
        /* info label style */
        #info-img{
            height:180px;
            /* width:100%; */
        }
        /* control style*/
        .maplibregl-ctrl-geolocate{display:none!important;}
</style>