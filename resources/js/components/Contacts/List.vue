<template>
  <div v-if="!isLoading" class="container list contacts">

    <div class="d-flex justify-content-between align-items-center my-3">
      <h4 class="my-0">Contact List</h4>
      <b-form-input v-model="qStr" class="w-50" placeholder="Type to search..."></b-form-input>
    </div>

    <b-table striped small sort-icon-left 
      :items="items"
      :fields="fields"
    >
      <template #cell(name)="data">
        <div class="">
          {{ `${data.item.firstname} ${data.item.lastname}` }}
        </div>
      </template>
    </b-table>

  </div>
</template>

<script>
import { eventBus } from '@/eventBus'
import { DateTime } from 'luxon'

export default {

  props: {
    //slug: null,
  },

  computed: {

    isLoading() {
      return false
      //return !this.slug
    },

    fields() {
      return [
        { key: 'name', label: 'Name',  sortable: true, tdClass: 'align-middle' },
        { key: 'phonenumbers', label: 'Phone',  formatter: v => this.toCsv( v.map( o => `${this.formatPhone(o)}` ) ), sortable: false, tdClass: 'align-middle' },
        { key: 'created_at', label: 'Date Added', formatter: v => DateTime.fromISO(v).toFormat('MMMM dd, yyyy'), sortable: true, tdClass: 'align-middle' },

        //{ key: 'formctrl', label: '', tdClass: 'align-middle' },
      ]
    },

  },

  data: () => ({
    items: null,
    qStr: '',
  }),

  methods: {
    async getData(qStr=null) {
      //console.log('getData()')
      try {
        //const params = qStr ? { by: 'name',  q: qStr } : {}
        const params = qStr ? { q: qStr } : {}
        //const params = qStr ? { by: 'number',  q: qStr } : {}
        const response = await axios.get(`/api/contacts`, { params } )
        this.items = response.data.data
        //return response.data
      } catch (error) {
        return []
      }
    },

    formatPhone(obj) {
      if ( obj.country && obj.country !== '' ) {
        //return `${obj['phonenumber']} (${obj.country})`
        return `${obj['formatted']} (${obj.country})`
      }
      //return `${obj['phonenumber']}`
      return `${obj['formatted']}`
    },

    toCsv(arrayIn) {
      //console.log('arrayIn', { arrayIn })
      return arrayIn.join(', ')
    },

  },

  watch: {
    qStr(newVal,oldVal) {
      if (newVal!==oldVal ) {
        if ( newVal==='' ) {
          this.getData()
        } else {
          this.getData(newVal)
        }
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
// may be broken in current version(?): https://getbootstrap.com/docs/5.1/migration/#helpers
::v-deep .sr-only { // temp hack fix
  display: none;
}
</style>
