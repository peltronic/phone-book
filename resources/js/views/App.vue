<template>
  <div>
    <h1>Hello World App!</h1>
    <Hello />
  </div>
</template>

<script>

import Hello from '@components/Hello'

export default {
  name: 'App',
  components: {
    Hello,
  },

}
</script>

<style lang="scss" scoped>
.content {
}
</style>
