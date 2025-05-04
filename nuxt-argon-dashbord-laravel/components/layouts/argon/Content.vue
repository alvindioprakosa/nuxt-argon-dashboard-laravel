<template>
  <div class="content">
    <FadeTransition :duration="200" mode="out-in">
      <router-view />
    </FadeTransition>
  </div>
</template>

<script>
import { FadeTransition } from 'vue2-transitions';

export default {
  name: "ContentWithTransition",
  components: {
    FadeTransition
  }
};
</script>

<style scoped>
/* Optional: fallback fade if not defined in FadeTransition */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
