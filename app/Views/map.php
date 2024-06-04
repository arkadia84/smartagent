<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFTyDaddy Map</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/maplibre-gl/dist/maplibre-gl.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        rel="stylesheet"
        href="https://unpkg.com/@maplibre/maplibre-gl-geocoder@1.2.0/dist/maplibre-gl-geocoder.css"
        type="text/css"
    />
    <?php echo view("components/mapstyle"); ?>
</head>
<body>
    <!-- Info Modal -->
    <div class="modal" id="info-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="info-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="info-modalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="infoModalClose()"></button>
        </div>
        <div class="modal-body row">
            <div class="col-12">
                <img id="info-img" class="card-img-top">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    SOLD
                    <span class="visually-hidden">unread messages</span>
                </span>
                </img>
            </div>
            <div class="col-12" id="info-category"></div>
            <div class="col-3">Address: </div>
            <div class="col-9" id="info-address"></div>
            <div class="col-12"><hr></div>
            <div class="col-3">Land: </div>
            <div class="col-3" id="info-land"></div>
            <div class="col-3">House: </div>
            <div class="col-3" id="info-house"></div>
        </div>
        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
            <button type="button" class="btn control-btn btn-primary">Contact Agency</button>
        </div>
        </div>
    </div>
    </div>
    <div class="row" id="dashboard-container">
        <div id="map-container" class="col-md-9">
            <div id="map">
                <button id="side-bar-btn" type="button" class="btn" onclick="fullScreen()"><i class="bi bi-caret-right-fill"></i></button>
            </div>
        </div>
        <div id="bar-container" class="col-md-3">
            <div class="row">
                <div class="col-12 mt-4">
                    <h1>Maps Logo</h1>
                </div>
                <div class="col-12"><hr></div>
                <div class="col-12"><h4>Map Panel Control</h4></div>
                <div class="col-12 btn-group mb-4" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary control-btn" onclick="goHome()"><i class="bi bi-house-door-fill"></i></button>
                    <button type="button" class="btn btn-primary control-btn" onclick="realEstateControl()"><i class="bi bi-geo-alt-fill"></i></button>
                    <button type="button" class="btn btn-primary control-btn"><i class="bi bi-pie-chart-fill"></i></button>
                    <button type="button" class="btn btn-primary control-btn" onclick="goGeolocate()"><i class="bi bi-crosshair2"></i></button>
                </div>
                <div class="col-12"><hr></div>
                <div class="col-12">
                    <h4>List of Real Estate</h4>
                    <div id="real-estate-list" class="list-group">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Lato:wght@300;400;700&family=Roboto:wght@400;500;700&display=swap"></script>
    <script src="https://unpkg.com/maplibre-gl/dist/maplibre-gl.js"></script>
    <script src="https://unpkg.com/@maplibre/maplibre-gl-geocoder@1.2.0/dist/maplibre-gl-geocoder.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <?php echo view("components/datasample"); ?>
    <?php echo view("components/mapjs"); ?>
</body>
</html>