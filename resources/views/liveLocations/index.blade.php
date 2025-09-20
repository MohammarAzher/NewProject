@extends('layouts.main')
@section('css')

    @vite(['resources/js/app.js'])
    {{-- Load JS --}}
 <style>
        #map {
            height: 600px;
            width: 100%;
            z-index: 1;
        }
    </style>
@endsection
@section('content')
 <!-- App hero header starts -->
  <div class="app-hero-header d-flex align-items-center">

    <!-- Breadcrumb starts -->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <i class="ri-home-8-line lh-1 pe-3 me-3 border-end"></i>
        <a href="{{route('login')}}">Home</a>
      </li>
      <li class="breadcrumb-item text-primary" aria-current="page">
        Roles
      </li>
    </ol>
    <!-- Breadcrumb ends -->
 <!-- Sales stats starts -->
    <div class="ms-auto d-lg-flex  flex-row">
         <div class="col-12">
            <input type="text" id="searchBox" placeholder="Search agent...">
            <select id="areaFilter" class="form-control mb-2 col-12">
                <option value="">All IBCs</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <!-- Sales stats ends -->

  </div>
  <!-- App Hero header ends -->


  <!-- App body starts -->
  <div class="app-body">
    <div class="row gx-3">
        <div class="col-sm-12">
          <div class="card">





            <div id="map"></div>
            </div>
        </div>
      </div>
  </div>
@endsection
@section('JScript')

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAOVYRIgupAurZup5y1PRh8Ismb1A3lLao&callback=initialize"></script>


 <script>
        let map;
        let markers = {};

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 8,
                center: { lat: 25.3960, lng: 68.3578 } // default Sindh center
            });

            loadLocations();
        }

        function loadLocations(areaId = '') {
            axios.get(`{{route('live.locations.fetch')}}?area_id=${areaId}`)
                .then(res => {
                    clearMarkers();
                    res.data.forEach(user => {
                        if (user.latest_live_location) {

                            let areas = user.areas.map(a => a.name).join(', ');
                            addMarker({
                                name: user.name,
                                code: user.code,
                                areas: areas,
                                lat: user.latest_live_location.latitude,
                                lng: user.latest_live_location.longitude,
                                updated_at: user.latest_live_location.updated_at
                            });
                        }
                    });
                });
        }






        function addMarker(loc) {
            let marker = new google.maps.Marker({
                position: { lat: parseFloat(loc.lat), lng: parseFloat(loc.lng) },
                map: map,
                title: loc.name
            });
            console.log(loc);
            // Prepare InfoWindow content
            let content = `
                <div>
                    <strong>RO Name:</strong> ${loc.name ?? '-'} <br>
                    <strong>RO Code:</strong> ${loc.code ?? '-'} <br>
                    <strong>IBC:</strong> ${loc.areas ?? '-'} <br>
                    <strong>Last Seen:</strong> ${loc.updated_at ?? '-'}
                </div>
            `;

            let infoWindow = new google.maps.InfoWindow({
                content: content
            });

            // Show on click
            marker.addListener("click", () => {
                infoWindow.open(map, marker);
            });

            markers[loc.id] = marker;
        }

        function clearMarkers() {
            for (let id in markers) {
                markers[id].setMap(null);
            }
            markers = {};
        }

        // Dropdown filter
        document.getElementById('areaFilter').addEventListener('change', function() {
            loadLocations(this.value);
        });

        // Search + zoom
        document.getElementById('searchBox').addEventListener('keyup', function() {
            let search = this.value.toLowerCase();
            for (let id in markers) {
                let marker = markers[id];
                if (marker.getTitle().toLowerCase().includes(search)) {
                    map.setZoom(14);
                    map.setCenter(marker.getPosition());
                }
            }
        });




         // Listen to Laravel Echo events
            document.addEventListener("DOMContentLoaded", function () {

                window.Echo.channel("live-locations")
                    .listen(".location.updated", (data) => {
                        console.log(data);
                            let loc = data.location;
                            selectedIbcId = document.getElementById('areaFilter').value;

                            if(selectedIbcId == '')
                            {
                                if (loc.ibc_id !== selectedIbcId) {
                                    alert(selectedIbcId);
                                    return;
                                }
                            }


                            if (markers[loc.user_id]) {
                                markers[loc.user_id].setPosition({
                                    lat: parseFloat(loc.latitude),
                                    lng: parseFloat(loc.longitude)
                                });
                            } else {
                                addMarker({
                                    id: loc.user_id,
                                    lat: parseFloat(loc.latitude),
                                    lng: parseFloat(loc.longitude),
                                    username: loc.agent.username,
                                    ibc: loc.agent.ibc
                                });
                            }
                    });
            });





        window.onload = initMap;
    </script>

{{--
  let map;
    const markersMap = new Map(); // user_id -> Marker

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 24.8607, lng: 67.0011 },
            zoom: 10,
        });
    }

    function updateMarker(location) {
        const { user_id, latitude, longitude, agent, updated_at } = location;

        // Filter by IBC
        const selectedIbc = document.getElementById('ibcSelect').value;
        if (selectedIbc && agent.ibc !== selectedIbc) {
            return; // skip if not matching IBC
        }

        const position = { lat: parseFloat(latitude), lng: parseFloat(longitude) };

        if (markersMap.has(user_id)) {
            // Update existing marker
            const marker = markersMap.get(user_id);
            marker.setPosition(position);
            marker.info.setContent(markerPopupContent(agent, updated_at));
        } else {
            // Create new marker
            const marker = new google.maps.Marker({
                position,
                map,
            });

            const infoWindow = new google.maps.InfoWindow({
                content: markerPopupContent(agent, updated_at),
            });

            marker.addListener("click", () => {
                infoWindow.open(map, marker);
            });

            marker.info = infoWindow;
            markersMap.set(user_id, marker);
        }
    }

    function markerPopupContent(agent, updated_at) {
        return `
            <b>RO Name:</b> ${agent.username}<br>
            <b>RO Code:</b> ${agent.code ?? 'N/A'}<br>
            <b>IBC:</b> ${agent.ibc}<br>
            <b>Last Seen:</b> ${formatDate(updated_at)}
        `;
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return `${date.toLocaleTimeString()} <br> <b>Date:</b> ${date.toLocaleDateString()}`;
    }

    // Listen to Laravel Echo events
    document.addEventListener("DOMContentLoaded", function () {
        initMap();

        window.Echo.channel("live-locations")
            .listen(".location.updated", (data) => {
                console.log(data);
                updateMarker(data.location);
            });
    });

    // Clear & refresh markers when IBC changes
    document.getElementById('ibcSelect').addEventListener('change', () => {
        markersMap.forEach(marker => marker.setMap(null));
        markersMap.clear();
    });






















    // const map = L.map('map').setView([24.8607, 67.0011], 10);
    // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //     attribution: '© OpenStreetMap contributors',
    //     maxZoom: 22
    // }).addTo(map);

    // const markersMap = new Map();

    // // Function to add/update marker
    // function updateMarker(location) {
    //     const { user_id, latitude, longitude, agent, updated_at } = location;

    //     // Filter by IBC
    //     const selectedIbc = document.getElementById('ibcSelect').value;
    //     if (selectedIbc && agent.ibc !== selectedIbc) {
    //         return; // skip if not matching IBC
    //     }

    //     if (markersMap.has(user_id)) {
    //         const marker = markersMap.get(user_id);
    //         marker.setLatLng([latitude, longitude]);
    //         marker.setPopupContent(`
    //             <b>RO Name:</b> ${agent.username}<br>
    //             <b>RO Code:</b> ${agent.code ?? 'N/A'}<br>
    //             <b>IBC:</b> ${agent.ibc}<br>
    //             <b>Last Seen:</b> ${formatDate(updated_at)}
    //         `);
    //     } else {
    //         const marker = L.marker([latitude, longitude])
    //             .bindPopup(`
    //                 <b>RO Name:</b> ${agent.username}<br>
    //                 <b>RO Code:</b> ${agent.code ?? 'N/A'}<br>
    //                 <b>IBC:</b> ${agent.ibc}<br>
    //                 <b>Last Seen:</b> ${formatDate(updated_at)}
    //             `)
    //             .addTo(map);
    //         markersMap.set(user_id, marker);
    //     }
    // }

    // function formatDate(dateString) {
    //     const date = new Date(dateString);
    //     return `${date.toLocaleTimeString()} <br> <b>Date:</b> ${date.toLocaleDateString()}`;
    // }




    //      document.addEventListener("DOMContentLoaded", function () {
    //         window.Echo.channel("live-locations")
    //         .listen(".location.updated", (data) => {
    //             console.log(data);
    //             updateMarker(data.location);

    //         });
    //     });


    // // Clear & refresh markers when IBC changes
    // document.getElementById('ibcSelect').addEventListener('change', () => {
    //     markersMap.forEach(marker => map.removeLayer(marker));
    //     markersMap.clear();
    // });
</script> --}}
@endsection

