<template>
  <v-app>
    <v-card width="500"
    :loading="loading"
    class="mx-auto my-12"
  >
    <template slot="progress">
      <v-progress-linear
        color="deep-purple"
        height="10"
        indeterminate
      ></v-progress-linear>
    </template>
    <v-card-text>
        <v-form
    ref="form"
    v-model="valid"
    lazy-validation
  >
    <v-text-field
      v-model="email"
      :rules="emailRules"
      label="E-mail"
      required
    ></v-text-field>
    <v-text-field
    label="Password"
            v-model="password"
            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
            :rules="passwordRules"
            :type="show1 ? 'text' : 'password'"
            name="input-10-1"
            counter
            @click:append="show1 = !show1"
          ></v-text-field>
    <v-btn
      :disabled="!valid"
      color="success"
      class="mr-4"
      @click="validate"
    >
      Login
    </v-btn>

    <v-btn href="register"
      color="error"
      class="mr-4"
    >
      Register
    </v-btn>
  </v-form>
    </v-card-text>
  </v-card>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
      loading: false,
      show1: false,
      password: '',
      passwordRules: [
        v => !!v || 'Password is Required.'
      ],
      valid: true,
      email: '',
      emailRules: [
        v => !!v || 'E-mail is Required'
      ],
      select: null
    }),

    methods: {
      validate () {
        if (this.$refs.form.validate()) {
          let data = {
            email: this.email,
            password: this.password
          }

          const form = new FormData();

          form.append('email', this.email);
          form.append('password', this.password);

          axios.post('login', form)
          .then(response => (console.log(response)))
          .catch(error => (console.log(error)));
        }
      },
      reset () {
        this.$refs.form.reset()
      },
      resetValidation () {
        this.$refs.form.resetValidation()
      },
    },
  }
</script>