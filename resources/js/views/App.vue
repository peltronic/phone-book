<template>
  <div>
    <h1>Hello World App!</h1>
    <CreateContactForm />
    <ListContacts />
  </div>
</template>

<script>

//import Hello from '@components/Hello'
import ListContacts from '@components/Contacts/List'
import CreateContactForm from '@components/Contacts/CreateForm'

export default {
  name: 'App',
  components: {
    //Hello,
    ListContacts,
    CreateContactForm,
  },

}
</script>

<style lang="scss" scoped>
.content {
}
</style>
