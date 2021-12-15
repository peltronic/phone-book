<template>
  <div v-if="!isLoading" class="list contacts">

    <div class="d-flex justify-content-between align-items-center my-3">
      <h4 class="my-0">Contact List</h4>
      <b-form-input v-model="qStr" class="w-50" placeholder="Type to search..."></b-form-input>
    </div>

    <!-- ++++++++++++ -->

    <b-table striped small sort-icon-left 
      id="contacts-table"
      :items="items" 
      :fields="fields" 
      :per-page="perPage"
      :current-page="currentPage"
    >

      <template #cell(name)="data">
        <div class="">
          {{ `${data.item.firstname} ${data.item.lastname||''}` }}
        </div>
      </template>

      <template #cell(formctrl)="data">
        <div @click="showModal(data.item.id)" class="clickable h4 m-0 text-right">
          <b-icon icon="x" variant="danger"></b-icon>
        </div>
      </template>

    </b-table>

    <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage" aria-controls="contacts-table"></b-pagination>

    <!-- ++++++++++++ -->

    <b-modal id="modal-delete-contact" v-model="isModalVisible">

      <template #modal-title>Confirm Delete</template>

      <template>
        <p class="my-2 text-left">Are you sure you want to delete this contact?</p>
      </template>

      <template #modal-footer>
        <div class="text-right">
          <b-btn class="" variant="secondary" @click="hideModal">Cancel</b-btn>
          <b-btn class="" variant="primary" @click="doDelete(selectedId)">Yes, Delete Permanently</b-btn>
        </div>
      </template>

    </b-modal>

  </div>
</template>

<script>
import { eventBus } from '@/eventBus'
import { DateTime } from 'luxon'

export default {

  props: {
  },

  computed: {

    isLoading() {
      return false // Add any data dependencies on which rendering the template should wait
    },

    fields() {
      return [
        { key: 'name', label: 'Name',  sortable: true, tdClass: 'align-middle' },
        { key: 'phonenumbers', label: 'Phone',  formatter: v => this.toCsv( v.map( o => `${this.formatPhone(o)}` ) ), sortable: false, tdClass: 'align-middle' },
        { key: 'created_at', label: 'Date Added', formatter: v => DateTime.fromISO(v).toFormat('MMMM dd, yyyy'), sortable: true, tdClass: 'align-middle' },
        { key: 'formctrl', label: '', tdClass: 'align-middle' },
      ]
    },

    rows() { // row count for pagination
      return this.items.length
    }
  },

  data: () => ({
    items: [], // table data items (rows)
    qStr: '', // query string for table search
    isModalVisible: false,
    selectedId: null, // the contact id (primary) of the selected row, if any

    perPage: 10,
    currentPage: 1,
  }),

  methods: {

    // Fetch data from server
    async getData(qStr=null) {
      try {
        const params = qStr ? { q: qStr } : {}
        const response = await axios.get(`/api/contacts`, { params } )
        this.items = response.data.data
      } catch (error) {
        return []
      }
    },

    async doDelete() {
      try {
        const response = await axios.delete(`/api/contacts/${this.selectedId}`)
        this.hideModal()
        await this.getData() // update table
      } catch (err) {
        // %TODO: display feedback to user if error
        console.log('doDelete()', { err });
      }
    },

    // Format how we display the form field (individual numbers)
    formatPhone(obj) {
      if ( obj.country && obj.country !== '' ) {
        return `${obj['formatted']} (${obj.country.toUpperCase()})`
      }
      return `${obj['formatted']}`
    },

    toCsv(arrayIn) {
      return arrayIn.join(', ')
    },

    showModal(id) {
      this.selectedId = id
      this.isModalVisible = true
    },

    hideModal() {
      this.isModalVisible = false
      this.selectedId = null
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
.clickable {
  cursor: pointer;
}

// may be broken in current version(?): https://getbootstrap.com/docs/5.1/migration/#helpers
::v-deep .sr-only { // temp hack fix
  display: none;
}
</style>
