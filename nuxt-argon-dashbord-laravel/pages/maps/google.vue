<template>
  <div>
    <!-- Header -->
    <base-header class="pb-6">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">{{ $route.name }}</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <route-breadcrumb />
          </nav>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <base-button size="sm" type="neutral">New</base-button>
          <base-button size="sm" type="neutral">Filters</base-button>
        </div>
      </div>
    </base-header>

    <!-- Map Section -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card border-0">
            <div id="map-custom" class="map-canvas" style="height: 600px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { API_KEY } from '@/util/API_KEY'

// Function to initialize Google Map
const initMap = (google) => {
  const lat = 40.748817
  const lng = -73.985428
  const color = "#5e72e4"
  const mapElement = document.getElementById("map-custom")

  const myLatlng = new google.maps.LatLng(lat, lng)

  const mapOptions = {
    zoom: 12,
    scrollwheel: false,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    styles: [
      {
        featureType: "administrative",
        elementType: "labels.text.fill",
        stylers: [{ color: "#444444" }]
      },
      {
        featureType: "landscape",
        elementType: "all",
        stylers: [{ color: "#f2f2f2" }]
      },
      {
        featureType: "poi",
        elementType: "all",
        stylers: [{ visibility: "off" }]
      },
      {
        featureType: "road",
        elementType: "all",
        stylers: [{ saturation: -100 }, { lightness: 45 }]
      },
      {
        featureType: "road.highway",
        elementType: "all",
        stylers: [{ visibility: "simplified" }]
      },
      {
        featureType: "road.arterial",
        elementType: "labels.icon",
        stylers: [{ visibility: "off" }]
      },
      {
        featureType: "transit",
        elementType: "all",
        stylers: [{ visibility: "off" }]
      },
      {
        featureType: "water",
        elementType: "all",
        stylers: [{ color }, { visibility: "on" }]
      }
    ]
  }

  const map = new google.maps.Map(mapElement, mapOptions)

  const marker = new google.maps.Marker({
    position: myLatlng,
    map,
    animation: google.maps.Animation.DROP,
    title: 'Hello World!'
  })

  const contentString = `
    <div class="info-window-content">
      <h2>Argon Dashboard PRO</h2>
      <p>A beautiful premium dashboard for Bootstrap 4.</p>
    </div>
  `

  const infowindow = new google.maps.InfoWindow({
    content: contentString
  })

  google.maps.event.addListener(marker, 'click', () => {
    infowindow.open(map, marker)
  })
}

// Load Google Maps and init map on mounted
onMounted(async () => {
  const GoogleMapsLoader = (await import('google-maps')).default
  GoogleMapsLoader.KEY = API_KEY
  GoogleMapsLoader.load(google => {
    initMap(google)
  })
})
</script>

<script>
export default {
  layout: 'DashboardLayout'
}
</script>
