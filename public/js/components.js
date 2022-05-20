Vue.component('autocomplete-input', {
	template: `
		<input type="text" class="input" placeholder="Започнете да пишете за търсене..." ref="autocomplete">
	`,

	data: function () {
		return {
			instance: null,
			place: null,
			lat: null,
			lng: null,
			city: null
		};
	},

	mounted: function () {
		this.instance = new google.maps.places.Autocomplete(
			(this.$refs.autocomplete),
			{types: ['geocode']}
		);

		this.instance.addListener('place_changed', () => {
			this.place = this.instance.getPlace();
			this.$emit('input', this.place);

			this.lat = this.place.geometry.location.lat();
			this.lng = this.place.geometry.location.lng();
			this.city = this.place.address_components[0]["short_name"];
		});
	}
});