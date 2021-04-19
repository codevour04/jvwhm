@extends('layouts.backend')

@section('content')
<h1>hellow</h1>

<h2>{{ $person }}</h2>
{{-- <template>
  <v-app>
      <v-container fluid>
        <v-row
        align="center"
        justify="center"
        >
          <v-col
          cols="12"
          sm="8"
          md="4"
          >
            <v-card class="elevation-12">
              <v-toolbar
              color="primary"
              dark
              flat
              >
              </v-toolbar>
              <v-card-text>
                <v-form
                ref="form"
                lazy-validation
                >
                  <v-text-field
                  v-model="editPerson.leader"
                  label="Leader"
                  required
                  :rules="leaderRules"
                  ></v-text-field>
                  <v-text-field
                  v-model="editPerson.firstname"
                  label="Firstname"
                  required
                  :rules="firstnameRules"
                  ></v-text-field>
                  <v-text-field
                  v-model="editPerson.lastname"
                  label="Surname"
                  required
                  :rules="lastnameRules"
                  ></v-text-field>
                  <v-text-field
                  v-model="editPerson.middlename"
                  label="Middlename"
                  ></v-text-field>
                  <v-menu
                  ref="menu"
                  v-model="menu"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                      v-model="editPerson.birthdate"
                      label="Birthday date"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      ></v-text-field>
                    </template>
                    <v-row justify="center">
                      <v-date-picker dense
                      ref="picker"
                      v-model="editPerson.birthdate"
                      :max="new Date().toISOString().substr(0, 10)"
                      min="1950-01-01"
                      @change="save"
                      ></v-date-picker>
                    </v-row>
                  </v-menu>
                <v-text-field
                v-model="editPerson.address"
                label="Address"
                ></v-text-field>
                <v-autocomplete
                v-model="editPerson.city"
                :items="cities"
                label="City"
                ></v-autocomplete>
                <v-text-field
                v-model="editPerson.contact_number"
                label="Contact number"
                ></v-text-field>
                <v-btn
                :loading="loading"
                :disabled="loading"
                color="success"
                class="mr-4"
                @click="validate"
                >
                Update
                </v-btn>
              </v-form>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template> --}}

@endsection