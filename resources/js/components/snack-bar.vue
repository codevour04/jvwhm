<template>
    <v-snackbar
      v-model="isAlertDisplay"
      :timeout="3000"
      :color="alertType"
      right
      absolute
      top
      transition="slide-x-reverse-transition"
    >
      {{ alertMessage }}

      <template v-slot:action="{ attrs }">
        <v-btn
          icon
          v-bind="attrs"
          @click="isAlertDisplay = false"
        >
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>
    </v-snackbar>
</template>

<script>
  export default {
    props: {
      message: String
    },
    data: () => ({
      text: '',
      isAlertDisplay: false,
      alertType:"",
      alertMessage: "" 
    }),
    created () {
      this.$root.$on('alert', (data) => {
        this.isAlertDisplay = true
        this.alertType = data.type
        this.alertMessage = data.message
      })
    }
  }
</script>