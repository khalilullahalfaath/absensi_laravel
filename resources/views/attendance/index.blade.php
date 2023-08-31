@extends('layout/app')

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Attendance Form</h4>
                </div>
                <div class="card-body">
                    <p>Pembukaan check-in hanya pada jam 07:00-09:00</p>
                    <form method="POST" action="{{route('user.attendance.create')}}">
                        @csrf
                        <div class="form-group mt-3">
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                            <label for="attendance_type">Attendance Type</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="attendance_type" id="checkin" value="checkin" required>
                                <label class="form-check-label" for="checkin">Check-in</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="attendance_type" id="checkout" value="checkout" required>
                                <label class="form-check-label" for="checkout">Check-out</label>
                            </div>
                        </div>
                        <div class="text-center mt-3 mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" id="refreshLocation">Refresh Location</button>
                        </div>
                    </form>
                    <div id="map" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const map = L.map('map').setView([0, 0], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    const marker = L.marker([0, 0]).addTo(map);

    const refreshLocationButton = document.getElementById('refreshLocation');
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');

    const successCallback = (position) => {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        latitudeInput.value = latitude;
        longitudeInput.value = longitude;

        marker.setLatLng([latitude, longitude]);
        map.setView([latitude, longitude], 13);
    };

    const errorCallback = (error) => {
        console.log(error);
    };

    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

    refreshLocationButton.addEventListener('click', () => {
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    });
</script>
@endsection
