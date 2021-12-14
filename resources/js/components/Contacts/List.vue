<template>
  <div v-if="!isLoading" class="container list contacts">

    <h4>Contact List</h4>
    <b-table striped hover :items="items" ></b-table>

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
    items: null,
  }),

  methods: {
    async getData() {
      console.log('getData()')
      try {
        const response = await axios.get(`/api/contacts`)
        this.items = response.data.data
        //return response.data
      } catch (error) {
        return []
      }
    },

  },

  created() { 
    this.getData()

    eventBus.$on('contact-created', () => {
      this.getData()
    })

  },

  mounted() { },


  //name: 'ContactsList',

}
</script>

<style lang="scss" scoped>
</style>
