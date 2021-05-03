<template>	
<v-autocomplete
v-model="city"
:items="cities"
label="City"
@change="selectCity"
></v-autocomplete>
</template>

<script>
	export default {
		data: () => ({
			cities: [],
			city: null
		}),
		created () {
			this.cities = Philippines.city_mun.map(city => city.name);
		},
		methods : {
			selectCity () {
				console.log(this.city)
				this.$root.$emit('selectCity', this.city)
			}
		}
	}
</script>