
  new Vue({
    el: '#app',

    data: {
      start: {address: '', lat: '', lng: ''},
      end: {address: '', lat: '', lng: ''},
      stops: [],
      vehicles: vehicles,
      isOptions: false,
      services: {
        directionsService: null,
        directionsDisplay: null,
        directionsResult: null,
        distanceMatrix: null,
        trafficLayer: null
      },
      preferences: null,
      vehicleHash: '',
      distance: null,
      map: null,
      routeOptions: {
        avoidFerries: false,
        avoidHighways: false,
        avoidTolls: false,
        arrivalTime: null,
        departureTime: new Date(Date.now() + 3000),
        trafficModel: 'bestguess'
      },
      markers: addresses,
      mountedMarkers: [],
      isPlan: false,
      plan: {
        title: '',
        dateTime: null
      }
    },

    mounted () {
      this.map = new google.maps.Map(document.getElementById('hero-map'), {
        zoom: 7,
        center: {lat: 42.6620791, lng: 23.3144586}
      });

      this.services.trafficLayer = new google.maps.TrafficLayer;
      this.services.trafficLayer.setMap(this.map);

      this.services.directionsService = new google.maps.DirectionsService;
      this.services.directionsDisplay = new google.maps.DirectionsRenderer;

      this.services.directionsDisplay.setMap(this.map);

      this.mountMarkers();
    },

    methods: {
      addStop () {
        if (this.stops.length < 5) {
          this.stops.push({address: '', lat: '', lng: ''});
        }
      },

      removeStop (index) {
        this.stops.splice(index, 1);
      },

      calculateRoute () {
        let app = this;

        this.services.directionsService.route({
          origin: this.start.address.formatted_address,
          destination: this.end.address.formatted_address,
          waypoints: this.waypoints,
          optimizeWaypoints: false,
          travelMode: 'DRIVING',
          provideRouteAlternatives: true,
          avoidFerries: this.routeOptions.avoidFerries,
          avoidHighways: this.routeOptions.avoidHighways,
          avoidTolls: this.routeOptions.avoidTolls,
          drivingOptions: {
            departureTime: this.routeOptions.departureTime,
            trafficModel: this.routeOptions.trafficModel
          }
        }, function (response, status) {
          if (status === 'OK') {
            app.services.directionsResult = response;
            app.services.directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });

        app = this;

        this.services.distanceMatrix = new google.maps.DistanceMatrixService();
        this.services.distanceMatrix.getDistanceMatrix(
          {
            origins: [this.start.address.formatted_address],
            destinations: [this.end.address.formatted_address],
            travelMode: 'DRIVING',
            avoidHighways: this.routeOptions.avoidHighways,
            avoidTolls: this.routeOptions.avoidTolls
          },
          (response, status) => {
            if (status === 'OK') {
              this.distance = response;
              app.distance = response;

              // charges = Math.ceil(response.rows[0].elements[0].distance.value / (app.preferences.distance * 1000));
            }
        });

        let charges = Math.floor(545 / this.preferences.distance);
        for (let i = 1; i <= charges; i++) {
          let point = google.maps.geometry.spherical.interpolate(this.start.address.geometry.location, this.end.address.geometry.location, (1 / charges) * i);

          new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: this.map,
            center: point,
            radius: 10000
          });
        }
      },

      getNearbyPlaces (place) {
        axios.get('https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=AIzaSyBER1RnUBImbkBSJ4goKXOYGUkD4vrg-5o&language=bg&location=DDD&radius=2000&rankby=distance&type=cafe')
             .then(function (response) {

             })
             .catch(function (errors) { console.log(errors); });
      },

      mountMarkers () {
        this.markers.forEach((item) => {
          let marker = new google.maps.Marker({
            position: {lat: parseFloat(item.lat), lng: parseFloat(item.lng)},
            map: this.map
          });

          this.mountedMarkers.push(marker);
        });

        var markerCluster = new MarkerClusterer(this.map, this.mountedMarkers, {
          imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
        });
      },

      saveSearch () {
        let app = this;

        axios.post(urls.search, {start: this.start, end: this.end, stops: this.stops, preferences: this.preferences, routeOptions: this.routeOptions})
             .then(function (response) {
              if (response.data.isSucccess == true) {
                app.$message({
                  message: 'Успешно запаметихме текущото търсене.',
                  type: 'success'
                });
              }
              else
              {
                app.$message({
                  message: 'Възникна грешка при запаметяването на търсенето.',
                  type: 'error'
                });
              }
             })
             .catch(function (errors) { console.log(errors); });
      },

      planTrip () {
        let app = this;

        axios.post(urls.plan, {plan: this.plan, start: this.start, end: this.end, stops: this.stops, preferences: this.preferences, routeOptions: this.routeOptions})
             .then(function (response) {
              if (response.data.isSucccess == true) {
                app.$message({
                  message: 'Успешно запаметихме Вашето пътуване.',
                  type: 'success'
                });
              }
              else
              {
                app.$message({
                  message: 'Възникна грешка при запаметяването на пътуването.',
                  type: 'error'
                });
              }
             })
             .catch(function (errors) { console.log(errors); });
      }
    },

    watch: {
      vehicle: function (value) {
        this.preferences = value.make.specification;
      }
    },

    computed: {
      waypoints () {
        let waypoints = [];

        this.stops.forEach((item) => {
          waypoints.push({
            location: item.address.formatted_address,
            stopover: true
          });
        });

        return waypoints;
      },

      numberOfCharges () {
        if (this.distance != null) {
          return Math.floor(this.distance.rows[0].elements[0].distance.value / (this.preferences.distance * 1000));
        }

        return 0;
      },

      vehicle () {
        return _.find(this.vehicles, {hash: this.vehicleHash});
      }
    }
  });