<template>
	<div class="d-flex justify-center align-end pt-4">
        <v-avatar size="100">
			<img
			alt="user"
			:src="url"
			>
        </v-avatar>
        <div>
          	<v-file-input v-model="image" @change="changeAvatar"
          	:rules="uploadRules"
			type="file"
			accept="image/.jpg, image/.jpeg, image/.png"
			prepend-icon="mdi-camera"
			hide-input
			></v-file-input>
        </div>
    </div>
</template>

<script>
	export default {
		data: () => ({
			image: null,
			url: "/images/profile-card/default.jpg",
      		uploadRules: [v => !v || v.size < 2000000 || 'Avatar size should be less than 2 MB!'],
		}),
		methods: {
			changeAvatar (files) {
				if (!files) return false

					console.log(files.type);
				if (files.type !== "image/png" && files.type !== "image/jpeg") {
					let data = {
						type: "error",
						message: "Only jpeg and png images are allowed"
					}
					this.$root.$emit("alert", data)
					return false

				} else if (files.size > 2000000) {
					let data = {
						type: "error",
						message: "File size should be less than 2 MB!"
					}
					this.$root.$emit("alert", data)
					return false

				} 

				this.url = URL.createObjectURL(files)
				this.$root.$emit("change-avatar", files)
			}
		}
	}
</script>