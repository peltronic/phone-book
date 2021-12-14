<template>
  <div v-if="!isLoading" class="container create-form contacts">

    <h4>Contact Create Form</h4>

    <b-form @submit="onSubmit" @reset="onReset" v-if="isFormVisible">

      <b-form-group label="First Name*">
        <b-form-input v-model="form.firstname" placeholder="Enter first name" required></b-form-input>
      </b-form-group>

      <b-form-group label="Last Name">
        <b-form-input v-model="form.lastname" placeholder="Enter last name" ></b-form-input>
      </b-form-group>

      <b-form-group label="Phone Number*">
        <b-form-input v-model="form.phonenumber" placeholder="Enter last name" ></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary">Submit</b-button>
      <b-button type="reset" variant="danger">Reset</b-button>

    </b-form>

  </div>
</template>

<script>

import { eventBus } from '@/eventBus'

export default {

  props: {
    //slug: null,
  },

  computed: {

    isLoading() {
      return false
      //return !this.slug
    },

  },

  data: () => ({
    form: {
      firstname: '',
      lastname: '',
      phonenumber: '',
    },
    isFormVisible: true,
  }),

  methods: {

    async onSubmit(event) {
      event.preventDefault()
      //console.log(JSON.stringify(this.form))
      await this.storeContact()
    },

    onReset(event) {
      event.preventDefault()
    },

    async storeContact() {
      let response = null
      const payload = this.form

      try {
        response = await axios.post(`/api/contacts`, payload)
        eventBus.$emit('contact-created', { })
      } catch (e) {
        console.log('err', { e, })
        if ( e.response?.status === 422 ) {
        } else {
          this.formErr = `Save failed, please try again (${e.message})`
        }
        //this.isBusy = false
        return
      }
      const json = response.data
    },
  },

  created() { },

  mounted() { },


  //name: 'ContactsCreateForm',
}
</script>

<style lang="scss" scoped>
</style>
