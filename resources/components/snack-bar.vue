<template>
    <v-snackbar
      v-model="isAlertDisplay"
      :timeout="3000"
      color="success"
      right
      absolute
      top
      transition="slide-x-reverse-transition"
    >
      {{ message }}

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
      isAlertDisplay: false
    }),
    created () {
      this.$root.$on('alert', () => (this.isAlertDisplay = true))
    }
  }
</script>