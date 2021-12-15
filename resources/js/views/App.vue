<template>
  <div class="container">

    <h1 class="mt-3 mb-5">Phone Book Demo App by PSG</h1>

    <CreateContactForm class="OFF-mb-5" />

    <ListContacts />

  </div>
</template>

<script>

import { eventBus } from '@/eventBus'
import ListContacts from '@components/Contacts/List'
import CreateContactForm from '@components/Contacts/CreateForm'

export default {
  name: 'App',
  components: {
    ListContacts,
    CreateContactForm,
  },

}
</script>

<style lang="scss" scoped>
.content {
}
</style>
