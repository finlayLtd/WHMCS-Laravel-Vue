<template>
    <section class="overview" style="position: relative;">


<div class="container">
    <div class="d-flex flex-column justify-content-start align-items-start title-button-wrapper">
        <div class="overview-header">
            <h2 class="title mb-0">Switch Account</h2>
        </div>
    </div>


    <div class="sub-section overview-tab">
        <div class="row justify-content-between align-items-center ">

            <div class="tab-content settings-tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-userManagement" role="tabpanel" aria-labelledby="pills-userManagement-tab">
                    <div class="tab-inner mb-3">
                        <div class="row">
                            <h3 class="title mb-4">Choose account to login and manage</h3>
                        </div>
                        <div class="divider"></div>
                        <div class="row px-2 pt-4 px-lg-4 pt-lg-4">
                            <div class="w-100 mb-5 support-table">
                                <table class="table">
                                    <!-- <tbody>
                                    @foreach ($clients as $item)
                                        <tr>
                                            <td>
                                                    <input type="hidden" id="switching_email" name="switching_email"  value="{{ $item['email'] }}">
                                                    <button stype="submit" style="background: none;  border: none;  padding: 10px;">{{ $item['email'] }}</button>
                                                    @if($item['email'] == $originUserData['email'])
                                                        <span class="badge bg-info">Owner</span>
                                                    @endif
                                                    @if($item['email'] == Auth::user()->email)
                                                        <span class="badge bg-info">Current logged in account</span>
                                                    @endif
                                                    <br>
                                            </td>
                                        </tr>
                                    @endforeach	
                                    </tbody> -->

                                    <tbody>
                                        <tr v-for="(client, index) in clients" :key="index">
                                            <td>
                                            <button
                                                @click="switchAccount(client.email, client.client_id)"
                                                style="background: none; border: none; padding: 10px;"

                                            >
                                                {{ client.email }}
                                            </button>
                                            <span v-if="client.email == user.email" class="badge bg-info">Owner</span>
                                            &nbsp;
                                            <span v-if="client.client_id == user.client_id" class="badge bg-info">Current logged in account</span>
                                            <br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</template>

<script setup>
import { computed, onMounted, ref, onBeforeUnmount, watch } from "vue";
import { commonApis } from "@/apis/commonApis";
import { useStore } from "vuex";
import useAuth from "@/composables/auth";
import { showLoader } from "@/plugins/loading.js";
import Pagination from '@/components/Pagination.vue'; 

import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const $toast = useToast({
      toastOptions: {
        zIndex: 99999, // set a high z-index value
      },
    });

const commonApi = commonApis();
const sortBy = ref(false);
const openModal = ref(false);
const store = useStore();
const user = computed(() => store.state.auth.user);
const clients = ref([]);


const params = ref({
  client_id: user.value.client_id,
});

const getCurrentState = () => {
  showLoader(true);
  commonApi
    .runGetApi("/getCurrentState", params.value)
    .then((res) => {
      showLoader(false);
      clients.value = res.data.clients;
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

getCurrentState();


const switchAccount = (email,client_id) => {
  showLoader(true);

  commonApi
    .runPostApi("/switch", {
        switching_email: email,
        client_id: client_id,
    })
    .then((res) => {
      showLoader(false);
      if (res.data.result == "success") {
        useAuth().getUser();
        $toast.success("Successfully switched account!");
		
      } else $toast.warning("Cannot connect to whmcs api.");
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};
</script>

<style scoped>

</style>
