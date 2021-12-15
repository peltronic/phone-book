<template>
  <div v-if="!isLoading" class="container" id="view-show_timeline">

    <h4>Hello Component</h4>

    <b-card
      title="Card Title"
      img-src="https://picsum.photos/600/300/?image=25"
      img-alt="Image"
      img-top
      tag="article"
      style="max-width: 20rem;"
      class="mb-2"
    >
      <b-card-text>
        Some quick example text to build on the card title and make up the bulk of the card's content.
      </b-card-text>

      <b-button href="#" variant="primary">Go somewhere</b-button>
    </b-card>

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

