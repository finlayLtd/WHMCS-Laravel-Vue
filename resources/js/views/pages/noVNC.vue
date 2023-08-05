<template>
  <div> 
    <iframe :srcdoc="html" style="width: 100%; min-height: 768px;"></iframe>
  </div>
</template>

<script setup>
import { computed, onMounted, ref, onBeforeUnmount, watch } from "vue";
import { commonApis } from "@/apis/commonApis";
import { useStore } from "vuex";
import useAuth from "@/composables/auth";
import { showLoader } from "@/plugins/loading.js";
import { useRoute } from "vue-router";
const route = useRoute();
// toast
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
const $toast = useToast();

const commonApi = commonApis();
const store = useStore();
const user = computed(() => store.state.auth.user);

const params = ref({
  client_id: user.value.client_id,
  orderby: "",
  order: "",
});

const html = ref('<div></div>')

const getVNCContent = () => {
  showLoader(true);
  commonApi
    .runPostApi("/overview/noVNC-connect", {
      id: route.params.id,
    })
    .then((res) => {
      showLoader(false);
      html.value = res.data;
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

getVNCContent();
</script>

<style scoped>
</style>
