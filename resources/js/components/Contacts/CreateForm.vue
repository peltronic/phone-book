<template>
  <div v-if="!isLoading" class="create-form contacts">

    <section v-if="isFormVisible">
      <div class="d-flex justify-content-between align-items-center">
        <h4>Contact Create Form</h4>

        <div class="h1 clickable m-0" @click="hideForm()">
          <b-icon icon="x"></b-icon>
        </div>
      </div>

      <b-form @submit="onSubmit" @reset="onReset">

        <b-row>
          <b-col>
            <label for="firstname" class="form-label">First Name*</label>
            <b-form-input 
              v-model="form.firstname" 
              @focus="clearVerr('firstname')" 
              id="firstname" 
              :class="{ 'is-invalid' : hasVerr('firstname') }" 
              aria-describedby="verr-firstname" 
              placeholder="Enter first name" 
            ></b-form-input>
            <div id="verr-firstname" class="invalid-feedback">{{ hasVerr('firstname') }}</div>
          </b-col>

          <b-col>
            <label for="lastname" class="form-label">Last Name</label>
            <b-form-input v-model="form.lastname" id="lastname" placeholder="Enter last name"></b-form-input>
          </b-col>
        </b-row>

        <b-row class="mt-3">
          <b-col sm="6">

            <label for="phonenumber" class="form-label">Phone*</label>

            <div class="d-flex">
              <b-form-input 
                v-model="form.phonenumber" 
                v-mask="selectedMask"
                @focus="clearVerr('phonenumber')" 
                id="phonenumber" 
                :class="{ 'is-invalid' : hasVerr('phonenumber') }" 
                aria-describedby="verr-phonenumber" 
                placeholder="Enter phone number" 
              ></b-form-input>

              <div class="ms-3">
                <country-flag v-if="selectedFlag" :country="selectedFlag" :shadow="true" size="normal"  />
              </div>

            </div>

            <!-- 
            v-mask="'(###) ###-####'"
            @keydown.native="filterPhonenumber"  
            -->
            <div id="verr-phonenumber" class="invalid-feedback">{{ hasVerr('phonenumber') }}</div>
          </b-col>
        </b-row>

        <div class="mt-3">
          <b-button type="submit" variant="primary">Submit</b-button>
          <b-button @click="onReset" type="reset" variant="secondary">Reset</b-button>
        </div>

      </b-form>

      <!--
      <h1>Test: {{ selectedCountry }} | {{ selectedMask }}</h1>
      -->

    </section>

    <section v-else>
      <b-button @click="isFormVisible=true" variant="primary">New Contact</b-button>
    </section>

    <hr />

  </div>
</template>

<script>

import Vue from 'vue'
import { eventBus } from '@/eventBus'

export default {

  props: { },

  computed: {

    isLoading() {
      return false // Add any data dependencies on which rendering the template should wait
    },

    selectedFlag() {
      if ( !this.selectedCountry ) {
        return null
      }
      // Override cases where country-flag plugin uses a different code
      switch (this.selectedCountry) {
        case 'uk':
          return 'gb'
        default:
          return this.selectedCountry
      }
    },

    selectedCountry() {
      const match = this.form.phonenumber.match(/^(\+?\d{1,3}|\d{1,4})/g)
      //console.log('selectedCountry', { phone: this.form.phonenumber, match, })
      if (match) {
        switch (match[0]) {
          case '+1':
            return 'us'
          case '+44':
            return 'uk'
          case '+03':
            return 'jp'
          default:
            return null
        }
      }
    },

    selectedMask() {
      switch (this.selectedCountry) {
        case 'us':
          return '+# (###) ###-####'
        case 'uk':
          return '+## ###-####-####'
        case 'jp':
          return '+## ##-####-####'
      }
    },

  },

  data: () => ({
    form: {
      firstname: '',
      lastname: '',
      phonenumber: '',
    },
    verrors: {}, // validation errors
    isFormVisible: true, // false,
  }),

  methods: {

    filterPhonenumber(e) {
      const allowed = [ '-','+',' ', '(', ')', 'Backspace',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
      ]
      console.log('filterPhonenumber', { allowed, key: e.key })
      const isAllowed = allowed.includes(e.key)
      if (!isAllowed) {
        e.preventDefault()
      }
      return
    },

    hideForm() {
      this.isFormVisible = false
      this.resetForm()
    },

    hasVerr(field) {
      return this.verrors?.hasOwnProperty(field) ? (this.verrors[field]?.[0]||'') : false
    },

    clearVerr(field) {
      console.log(`clearVerr ${field}`)
      Vue.delete(this.verrors, field)
    },

    async onSubmit(e) {
      e.preventDefault()
      try { 
        const response = await this.storeContact()
        this.hideForm()
        eventBus.$emit('contact-created', { })
      } catch (e) {
        if ( e.response?.status === 422 ) {
          this.verrors = e?.response?.data?.errors || {}
          console.log('validation err', { 
            e, 
            message: e.message,
            response_data: e.response.data,
            response_data_message: e.response.data.message,
            response_data_errors: e.response.data.errors,
          })
        } else {
          console.log('other err', { e, })
          this.formErr = `Save failed, please try again (${e.message})`
        }
        //this.isBusy = false
      }
    },

    onReset(e) {
      e.preventDefault()
      this.resetForm()
    },

    resetForm() {
      this.verrors = {}
      this.form.firstname = ''
      this.form.lastname = ''
      this.form.phonenumber = ''
    },

    async storeContact() {
      const payload = this.form
      if ( this.selectedCountry ) {
        payload.country = this.selectedCountry
      }
      const response = await axios.post(`/api/contacts`, payload)
      return response
    },
  },

  created() { },

  mounted() { },


  //name: 'ContactsCreateForm',
}
</script>

<style lang="scss" scoped>
.clickable {
  cursor: pointer;
}
</style>
