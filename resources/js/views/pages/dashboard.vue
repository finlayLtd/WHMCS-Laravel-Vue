<template>
  <section class="dashboard">

    <div class="container">
      <div
        class="d-flex justify-content-between align-items-center title-button-wrapper position-relative"
      >
        <h2 class="title mb-0">{{ $t('Dashboard') }}</h2>
        <button
          type="submit"
          class="btn btn-dark btn-chevron chevron-dark hover-dark-light options-toggle dropdown-toggle"
          data-bs-toggle="dropdown"
        >
        {{ $t('Create_server') }}
        </button>

        <div
          class="options-toggle-dropdown create-server dropdown-menu dropdown-menu-end"
        >
          <ul>
            <li>
              <router-link to="/create-vps-server"
                >{{ $t('Create_VPS_Server') }}</router-link
              >
            </li>
          </ul>
        </div>
      </div>

      <div class="sub-section server-list-tab vl-parent">
        <loading v-model:active="isLoading" :is-full-page="false"
                   />
        <div class="row justify-content-between align-items-center">
          <div class="col-md-12">
            <div class="w-100 mb-2 mb-lg-5">
              <h3 class="sub-title">{{ $t('Support_Tickets') }}</h3>
              <div class="topTicketBar">
                <div class="sort-servers order-2 order-md-1">
                  <div
                    id="toggleButton"
                    class="sort-item-active btn-chevron chevron-dark topSortBox"
                    style="width: 160px"
                    @click="sortBy = !sortBy"
                  >
                    <span>{{ $t('Sort_by') }}...</span>
                  </div>
                  <div class="sorting-items" v-if="sortBy">
                    <ul>
                      <li class="touch-item" @click="setOrder('date', 'desc')">
                        {{ $t('Opened_latest') }}
                      </li>
                      <li class="touch-item" @click="setOrder('date', 'asc')">
                        {{ $t('Opened_oldest') }}
                      </li>
                      <li
                        class="touch-item"
                        @click="setOrder('lastreply', 'desc')"
                      >
                        {{ $t('Last_Reply_latest') }}
                      </li>
                      <li class="touch-item" @click="setOrder('date', 'asc')">
                        {{ $t('Last_Reply_oldest') }}
                      </li>
                    </ul>
                  </div>
                </div>

                <ul
                  class="nav nav-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0 topFilterBox"
                  id="pills-tab"
                  role="tablist"
                >
                  <li class="nav-item" role="presentation">
                    <button
                      class="nav-link active"
                      id="pills-all-tab"
                      data-bs-toggle="pill"
                      data-bs-target="#pills-all"
                      type="button"
                      role="tab"
                      aria-controls="pills-all"
                      aria-selected="true"
                      @click="ticketStatus = 'All'"
                    >
                      All
                    </button>
                  </li>
                  <li
                    v-for="statu in status"
                    :key="statu.title"
                    class="nav-item"
                    role="presentation"
                  >
                    <button
                      :id="getTabLabelId(statu.title)"
                      class="nav-link"
                      data-bs-toggle="pill"
                      :data-bs-target="'#' + getTabId(statu.title)"
                      type="button"
                      role="tab"
                      :aria-controls="getTabId(statu.title)"
                      :aria-selected="false"
                      @click="ticketStatus = statu.title"
                    >
                      {{ statu.title }}
                    </button>
                  </li>
                </ul>
              </div>
            </div>
            <div class="w-100 support-table mb-4">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">{{ $t('Ticket_No') }}</th>
                    <th scope="col">{{ $t('Title') }}</th>
                    <th scope="col">{{ $t('Priority') }}</th>
                    <th scope="col">{{ $t('Date_title') }}</th>
                    <th scope="col">{{ $t('Status') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="!tickets || tickets.length === 0">
                    <td colspan="5" style="text-align: center">
                      <h5 style="margin-top: 20px">{{ $t('No_tickets') }}</h5>
                    </td>
                  </tr>
                  <tr
                      v-else
                      v-for="ticket in filteredTickets"
                      :key="ticket.id"
                    >
                      <td>
                        <router-link
                            :to="{
                              name: 'ticket-detail',
                              params: { id: ticket.id},
                            }"
                          >
                          #{{ ticket.tid }}
                        </router-link>
                        </td>
                      <td v-html="ticket.subject"></td>
                      <td class="refund-request">{{ ticket.priority }}</td>
                      <td class="date-cell">{{ ticket.date }}</td>
                      <td :class="getCellClass(ticket.status)">
                        <span>
                          {{ ticket.status }}
                        </span>
                      </td>
                    </tr>
                </tbody>
              </table>
            </div>
            <div class="w-100 server-list-pagination">
              <Pagination :currentPage="params.page" :totalPages="totalFilterPages[ticketStatus]" @page-changed="onPageChanged" />
            </div>
          </div>
        </div>
      </div>

      <!-- have to replace here with services table componenet -->
      <ServicesTable />
    </div>
  </section>
</template>
  
<script setup>
import ServicesTable from "./tables/services.vue";
import { computed, onMounted, ref, onBeforeUnmount, watch } from "vue";
import { commonApis } from '@/apis/commonApis';
import { useStore } from 'vuex';
import useAuth from "@/composables/auth";
import { showLoader } from '@/plugins/loading.js';
import Pagination from '@/components/Pagination.vue'; 
import Loading from 'vue-loading-overlay';
      import 'vue-loading-overlay/dist/css/index.css';
      const isLoading = ref(false);
const commonApi = commonApis()
const sortBy = ref(false);
const store = useStore();
const user = computed(() => store.state.auth.user)
const tickets = ref([]);
const status = ref([]);
const totalPages = ref(0);
const ticketStatus = ref("All");

const onlyShow = ref(['All' , 'Open' , 'Answered' , 'Customer-Reply' , 'Closed'])


const params = ref(
	{'client_id': user.value.client_id , orderby:'', order:'' , page:1}
)
const perPage = 5;

const getTicketsData = ()=>{
	isLoading.value = true;
	commonApi.runGetApi('/support-ticket' , params.value).then((res)=>{
    isLoading.value = false;
	sortBy.value = false;
	tickets.value = res.data.tickets
  const filteredStatus = computed(() => {
      return res?.data?.status?.filter(statu => onlyShow.value.includes(statu.title));
    });
		status.value = filteredStatus.value;
    const totalTickets = res.data.totalTickets;
      
    totalPages.value = Math.ceil(totalTickets / perPage);
	// status.value = res.data.status
   
	}).catch((e)=>{
	console.log(e)
  isLoading.value = false;
	})
}

getTicketsData()
function formatDate(date) {
  return new Date(date).toISOString().slice(0, 10);
}

function onPageChanged(page) 
{
	params.value.page = page;
	//getTicketsData(); // Fetch tickets for the new page
}

function getTabId(title) {
  return `pills-${slugify(title)}`;
}

function getTabLabelId(title) {
  return `pills-${slugify(title)}-tab`;
}

function slugify(text) {
  return text.toLowerCase().replace(/ /g, '-');
}


function setOrder(orderBy , order) {
  params.value.orderby = orderBy
  params.value.order = order
  getTicketsData()
}

function getCellClass(status) {
  if (status == "Answered") return "successful-cell";
  if (status == "Closed") return "cancelled-cell";
  return "in-progress-cell";
}
const totalFilterPages = ref([]);
const filteredTickets = computed(() => {
  let ticketData;
  if (ticketStatus.value === "All") {
    ticketData = tickets.value;
  }
  else
  {
    ticketData = tickets.value.filter(
    (ticket) => ticket.status === ticketStatus.value
    );

  }

  

  const paginatedTickets = computed(() => {
  const startIndex = (params.value.page - 1) * perPage;
  const endIndex = startIndex + perPage;
    return ticketData.slice(startIndex, endIndex);
  });
  totalFilterPages.value[ticketStatus.value] = Math.ceil(ticketData.length / perPage); 
  return paginatedTickets.value
  
});
</script>
  
  <style scoped>
  .topTicketBar{
    display: flex; justify-content: space-between;
  }
  .topFilterBox{

  }
  @media screen and (max-width: 767px) {
    .topTicketBar {
      display: block;
      /* Your styles here */
    }
    .topFilterBox{
      float:right;
      margin-top: 10px;
    }
    .topSortBox{
      float: right;
    }
  }
</style>
  