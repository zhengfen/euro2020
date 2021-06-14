<template>
  <carousel :loop="true" :autoplay="true" :autoplayTimeout="autoplayTimeout" :per-page="1" :pagination-enabled="false" >
    <slide>
      <ranking-view :key="cnt" />
    </slide>
    <slide>
      <phase-view :key="cnt" />
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
      default: 10000
    }
  },
  components: {
    Carousel,
    Slide
  }, 
  data(){
    return {
      cnt: 0
    }
  },
  created(){
    this.setTimer();
  },
  methods:{
    setTimer(){
      setInterval(this.updateCounter, 60*1000); 
    },
    updateCounter(){
      this.cnt++; 
      console.log(this.cnt); 
    }
  } 
}
</script>

<style>
</style>