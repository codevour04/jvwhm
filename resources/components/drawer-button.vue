<template>
<v-app-bar-nav-icon @click.stop="drawer"></v-app-bar-nav-icon>
</template>

<script>
	
export default {
	methods: {
		drawer () {
        	this.$root.$emit('drawerNavIcon')
      	}
	}
}

</script>