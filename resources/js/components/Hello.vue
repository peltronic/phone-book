<template>
  <div v-if="!isLoading" class="container-xl" id="view-show_timeline">

    <h4>Hello Component</h4>

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

}
</script>

<style lang="scss" scoped>
</style>

