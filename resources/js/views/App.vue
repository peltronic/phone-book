<template>
  <div>
    <h1>Hello World App!</h1>
    <CreateContactForm />
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
