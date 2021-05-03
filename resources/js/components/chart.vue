<template>
  <v-app>
    <v-container fluid>
      <v-row>
        <v-col :xs="12" :sm="4"
          :md="4"
          :lg="4"
          :xl="4"
          :cols="12"
          >
          <v-card
            class="mt-4 mx-auto"
          >
            <v-sheet
              class="v-sheet--offset mx-auto"
              color="cyan"
              elevation="12"
              max-width="calc(100% - 32px)"
            >
              <v-sparkline
                :labels="labels"
                :value="first"
                color="white"
                line-width="2"
                padding="16"
              ></v-sparkline>
            </v-sheet>
            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                1st Timer
              </div>
              <div class="subheading font-weight-light grey--text">
                The data is not real at the moment
              </div>
              <v-divider class="my-2"></v-divider>
              <v-select v-model="chartOfmonth"
                  prepend-icon="mdi-clock"
                  :items="months"
                ></v-select>
              <!-- <v-icon
                class="mr-2"
                small
              >
                mdi-clock
              </v-icon>
              <span class="caption grey--text font-weight-light">
              </span> -->
            </v-card-text>
          </v-card>
        </v-col>
        <v-col :xs="12" :sm="4"
          :md="4"
          :lg="4"
          :xl="4"
          :cols="12"
          >
          <v-card
            class="mt-4 mx-auto"
          >
            <v-sheet
              class="v-sheet--offset mx-auto"
              color="cyan"
              elevation="12"
              max-width="calc(100% - 32px)"
            >
              <v-sparkline
                :labels="labels"
                :value="second"
                color="white"
                line-width="2"
                padding="16"
              ></v-sparkline>
            </v-sheet>
            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                2nd Timer
              </div>
              <div class="subheading font-weight-light grey--text">
                The data is not real at the moment
              </div>
              <v-divider class="my-2"></v-divider>
              <v-select v-model="chartOfmonth"
                  prepend-icon="mdi-clock"
                  :items="months"
                ></v-select>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col :xs="12" :sm="4"
          :md="4"
          :lg="4"
          :xl="4"
          :cols="12"
          >
          <v-card
            class="mt-4 mx-auto"
          >
            <v-sheet
              class="v-sheet--offset mx-auto"
              color="cyan"
              elevation="12"
              max-width="calc(100% - 32px)"
            >
              <v-sparkline
                :labels="labels"
                :value="third"
                color="white"
                line-width="2"
                padding="16"
              ></v-sparkline>
            </v-sheet>
            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                3rd Timer
              </div>
              <div class="subheading font-weight-light grey--text">
                The data is not real at the moment
              </div>
              <v-divider class="my-2"></v-divider>
              <v-select v-model="chartOfmonth"
                  prepend-icon="mdi-clock"
                  :items="months"
                ></v-select>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col :xs="12" :sm="4"
          :md="4"
          :lg="4"
          :xl="4"
          :cols="12"
          >
          <v-card
            class="mt-4 mx-auto"
          >
            <v-sheet
              class="v-sheet--offset mx-auto"
              color="cyan"
              elevation="12"
              max-width="calc(100% - 32px)"
            >
              <v-sparkline
                :labels="labels"
                :value="fourth"
                color="white"
                line-width="2"
                padding="16"
              ></v-sparkline>
            </v-sheet>
            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                4th Timer
              </div>
              <div class="subheading font-weight-light grey--text">
                The data is not real at the moment
              </div>
              <v-divider class="my-2"></v-divider>
              <v-select v-model="chartOfmonth"
                  prepend-icon="mdi-clock"
                  :items="months"
                ></v-select>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col :xs="12" :sm="4"
          :md="4"
          :lg="4"
          :xl="4"
          :cols="12"
          >
          <v-card
            class="mt-4 mx-auto"
          >
            <v-sheet
              class="v-sheet--offset mx-auto"
              color="cyan"
              elevation="12"
              max-width="calc(100% - 32px)"
            >
              <v-sparkline
                :labels="labels"
                :value="fifth"
                color="white"
                line-width="2"
                padding="16"
              ></v-sparkline>
            </v-sheet>
            <v-card-text class="pt-0">
              <div class="title font-weight-light mb-2">
                5th Timer
              </div>
              <div class="subheading font-weight-light grey--text">
                The data is not real at the moment
              </div>
              <v-divider class="my-2"></v-divider>
              <v-select v-model="chartOfmonth"
                  prepend-icon="mdi-clock"
                  :items="months"
                ></v-select>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
      labels: [
        'Feb. 7',
        'Feb. 14',
        'Feb. 21',
        'Feb. 28',
      ],
      first: [
          200,
          475,
          510,
          640,
      ],
      second :[
          375,
          510,
          360,
          540, 
      ],
      third: [
          200,
          475,
          510,
          640,
      ],
      fourth :[
          175,
          510,
          460,
          640, 
      ],
      fifth :[
          375,
          510,
          360,
          540, 
      ],
      months: [
      'Month of January',
      'Month of February',
      'Month of March',
      'Month of April',
      'Month of May',
      'Month of June',
      'Month of July',
      'Month of August',
      'Month of September',
      'Month of October',
      'Month of November',
      'Month of December',
      ],
      chartOfmonth: 'Month of February'
    }),
  }
</script>

<style>
  .v-sheet--offset {
    top: -24px;
    position: relative;
  }
</style>