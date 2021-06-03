<template>
  <carousel :loop="true" :autoplay="true" :autoplay-timeout="autoplayTimeout" :per-page="1" :pagination-enabled="false">
    <slide>
      <ranking-view />
    </slide>
    <slide>
      <phase-view />
    </slide>
  </carousel>
</template>

<script>
/**
 * slide 1 : ranking page
 */
import { Carousel, Slide } from 'vue-carousel';

export default {
  props:{
    autoplayTimeout:{
      type: Number,
      default: 5000
    }
  },
  components: {
    Carousel,
    Slide
  }
}
</script>

<style>
</style>