<template>
	<v-combobox
		v-model="person"
	    :items="people"
	    item-text="fullname"
	    label="Leader"
	    placeholder="John Doe" @change="selectPerson">
	</v-combobox>
</template>

<script>
	export default {
		data: () => ({
			people: [],
			person: null
		}),
		created () {
			axios.get('/person')
			.then(response => {
			this.people = response.data.data
			})
			.catch(error => (console.log(error)));
		},
		methods: {
			selectPerson () {
				this.$root.$emit('leader-dropdown', this.person)
			}
		}
	}
</script>