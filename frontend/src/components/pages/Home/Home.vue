<template>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Doro Home</title>
  </head>
  <body class="bg-[url(/src/assets/img/default-bg.jpg)] bg-cover bg-center bg-fixed">
    <Notification />
    <section class="h-dvh place-items-center flex flex-col justify-center space-y-15 relative">
      <MainPanel />
      <BottomPanel />
    </section>
  </body>
</template>

<script setup>
import BottomPanel from "../../organisms/BottomPanel/BottomPanel.vue";
import MainPanel from "../../organisms/MainPanel/MainPanel.vue";
import Notification from "../../molecules/Notification/Notification.vue";
</script>

<style scoped>
body {
  font-family: "DM Sans", sans-serif;
}
</style>
