<template>
  <div class="sub-section server-list-tab vl-parent">
    <loading v-model:active="isLoading" :is-full-page="false"
                 />
    <div
      class="d-flex justify-content-between align-items-center title-button-wrapper"
    ></div>
    <div class="row justify-content-between align-items-center">
      <div class="row mb-5 pe-0">
        <h3 class="col-md-3 sub-title">My Products & Services</h3>

        <div class="col-md-9 d-flex justify-content-end pe-0 flex-wrap">
          <div class="sort-servers order-2 order-md-1">
            <div
              id="toggleButton"
              class="sort-item-active btn-chevron chevron-dark"
              @click="sortBy = !sortBy"
            >
              <span>Sort by name</span>
            </div>
            <div class="sorting-items" v-if="sortBy">
              <ul>
                <li @click="setOrder('regdate', 'desc')">Created date</li>
                <li @click="setOrder('nextduedate', 'asc')">Expiration date</li>
                
              </ul>
            </div>
          </div>

          <ul class="nav nav-pills four-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0 flex-nowrap" id="pills-tab" role="tablist">
            <li v-for="state in states" :key="state" class="nav-item" role="presentation" >
              <button
              v-if="state_order?.[state] && state!='Fraud'"
                :class="['nav-link', state === 'Active' ? 'active' : '']"
                :id="'pills-' + state + '-tab'"
                data-bs-toggle="pill"
                :data-bs-target="'#pills-' + state"
                type="button"
                role="tab"
                :aria-controls="'pills-' + state"
                :aria-selected="state === 'Active'"
              >
                {{ state }}
              </button>
            </li>
          </ul>

        </div>
      </div>
      <div class="tab-content" id="pills-tabContent">
        
                 <!-- s -->
  
    
      <div v-for="state in states" :key="state" :class="['tab-pane', {'fade': state !== 'Active'}, {'show active': state === 'Active'}]"
           :id="'pills-' + state"
           role="tabpanel"
           :aria-labelledby="'pills-' + state + '-tab'">
        <div class="row mb-5">
          <div v-if="state_order?.[state]" v-for="order in state_order[state]" :key="order.orderid" class="col-12 col-lg-4 col-md-6 col-sm-12">
            <div class="card-item p-4 mb-4">
              <div class="server-list-item">
                <div class="server-list-item-wrapper">
                  <div class="image-wrapper">
                    <img :src="'assets/img/' + order.sys_log + '-logo.png'" alt="">
                  </div>
                  <div class="list-item-detail">
                    <h2 class="list-name">{{ order.name }}</h2>
                    <h3 class="detail">{{ order.configoptions.configoption[1].value }}</h3>
                    <div v-if="state !== 'Cancelled'" class="server-list-options">
                      <div class="options-toggle dropdown-toggle hideIcon" style="padding-right: 10px; padding-left: 10px;" data-bs-toggle="dropdown"></div>
                      <div class="options-toggle-dropdown dropdown-menu dropdown-menu-end">
                        <ul>
                          <li>
                            <router-link
                              class="logo-wrapper d-flex align-items-center col-md-2 text-dark text-decoration-none order-lg-1"
                              :to="{ name: 'overview', params: { id: order.orderid } }"
                            >
                              Launch Control Panel
                            </router-link>
                          </li>
                          <li>
                            <router-link
                              class="logo-wrapper d-flex align-items-center col-md-2 text-dark text-decoration-none order-lg-1"
                              to="/balance"
                            >
                              View Invoices
                            </router-link> 
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div v-if="state === 'Active'" class="server-list-item">
                <div class="server-list-item-wrapper">
                  <div class="image-wrapper">
                    <img class="dark-img-filter" src="assets/img/cloud-connection.png" alt="">
                  </div>
                  <div class="list-item-detail">
                    <h2 class="list-name">{{ order.dedicatedip }}</h2>
                    <h3 class="detail">Created at  {{ order.regdate }}</h3>
                    <h3 class="detail" style="margin-top:5px;">Due date at  &nbsp;{{ order.nextduedate }}</h3>
                  </div>
                  <div v-if="state === 'Active'" class="server-list-options">
                    <button class="active-badge"><span class="active-dot"></span>Active</button>
                  </div>
                </div>
              </div>
              <div class="server-list-item">
                <div class="server-list-item-wrapper">
                  <div class="image-wrapper">
                    <img :src="'assets/img/' + order.flag + '.png'" alt="">
                  </div>
                  <div class="list-item-detail">
                    <h2 class="list-name">{{ order.groupname }}</h2>
                    <h3 class="detail">Hostname : {{ order.domain }}</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-if="state === 'Active' && (!state_order?.[state] || state_order?.[state]?.length === 0)">
            <h5 style="margin-top: 20px; text-align: center;">No Active Product </h5>
          </div>
        </div>
      </div>
    
  



      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref, onBeforeUnmount } from "vue";
import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/css/index.css';
import { useStore } from 'vuex';
import { commonApis } from '@/apis/commonApis';
import { showLoader } from '@/plugins/loading.js';
// toast
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
const $toast = useToast();
const sortBy = ref(false);
const store = useStore();
const user = computed(() => store.state.auth.user)
const commonApi = commonApis()
const servers = ref([]);
const states = ref([]);
const state_order = ref([]);
const params = ref(
	{'client_id': user.value.client_id , orderby:'', order:''}
)
const isLoading = ref(false);
const getServersData = ()=>{
		// showLoader(true);
    isLoading.value = true;
		commonApi.runGetApi('/servers' , params.value).then((res)=>{
      isLoading.value = false;
		sortBy.value = false;
		servers.value = res.data.products;
		states.value = res.data.states;
		state_order.value = res.data.state_order;
	
   
	}).catch((e)=>{
	console.log(e);
  isLoading.value = false;

	})
}

function setOrder(orderBy , order) {
    params.value.orderby = orderBy
    // params.value.order = order
    getServersData()
  }

getServersData()
</script>

<style scoped>
.hide-icon::after {
  display: none !important; /* hide the ::after pseudo-element */
}

.dropdown-toggle:empty::after {
  display: none !important;
}
</style>
