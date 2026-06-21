<template>
  <div class="loader"></div>
</template>

<style scoped>
/* From uiverse.io by @JulioCodesSM */
.loader {
  width: 50px;
  height: 50px;
  position: relative;
  transform: translateX(-25px);
  /* Compensating for the left of 50px in the keyframe. */
}

.loader::before,
.loader::after {
  content: "";
  position: absolute;
  width: inherit;
  height: inherit;
  border-radius: 50%;
  mix-blend-mode: multiply;
  animation: rotate9 1s infinite cubic-bezier(0.77, 0, 0.175, 1);
}

.loader::before {
  background-color: #fff5d3;
}

.loader::after {
  background-color: #0f9255;
  animation-delay: -0.5s;
}

@keyframes rotate9 {
  0%,
  100% {
    left: 50px;
  }

  25% {
    transform: scale(0.3);
  }

  50% {
    left: 0;
  }

  75% {
    transform: scale(1);
  }
}
</style>
