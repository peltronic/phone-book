<template>
  <div v-if="!isLoading" class="container create-form contacts">

    <h4>Contact Create Form</h4>

  </div>
</template>

<script>

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
  }),

  created() { },

  mounted() { },

  methods: {
  },

  //name: 'ContactsCreateForm',
}
</script>

<style lang="scss" scoped>
</style>
