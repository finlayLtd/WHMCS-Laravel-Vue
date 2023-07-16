<template>
  <section class="dashboard">
    <div class="container">
      <div
        class="d-flex justify-content-between align-items-center title-button-wrapper position-relative"
      >
        <h2 class="title mb-0">Dashboard</h2>
        <button
          type="submit"
          class="btn btn-dark btn-chevron chevron-dark hover-dark-light options-toggle dropdown-toggle"
          data-bs-toggle="dropdown"
        >
          Create Server
        </button>

        <div
          class="options-toggle-dropdown create-server dropdown-menu dropdown-menu-end"
        >
          <ul>
            <li>
              <router-link to="/create-vps-server"
                >Create VPS Server</router-link
              >
            </li>
          </ul>
        </div>
      </div>

      <div class="sub-section server-list-tab">
        <div class="row justify-content-between align-items-center">
          <div class="col-md-12">
            <div class="w-100 mb-2 mb-lg-5">
              <h3 class="sub-title">Support Tickets</h3>
              <div style="display: flex; justify-content: space-between;">
                <div class="sort-servers order-2 order-md-1">
                  <div
                    id="toggleButton"
                    class="sort-item-active btn-chevron chevron-dark"
                    style="width: 160px"
                    @click="sortBy = !sortBy"
                  >
                    <span>Sort by...</span>
                  </div>
                  <div class="sorting-items" v-if="sortBy">
                    <ul>
                      <li class="touch-item" @click="setOrder('date', 'desc')">
                        Opened-latest
                      </li>
                      <li class="touch-item" @click="setOrder('date', 'asc')">
                        Opened-oldest
                      </li>
                      <li
                        class="touch-item"
                        @click="setOrder('lastreply', 'desc')"
                      >
                        Last-Reply-latest
                      </li>
                      <li class="touch-item" @click="setOrder('date', 'asc')">
                        Last-Reply-oldest
                      </li>
                    </ul>
                  </div>
                </div>

                <ul
                  class="nav nav-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0"
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
                    <th scope="col">Ticket No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Priority</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="!tickets || tickets.length === 0">
                    <td colspan="5" style="text-align: center">
                      <h5 style="margin-top: 20px">No tickets</h5>
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
                      <td>{{ ticket.subject }}</td>
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
            <!-- pagination -->
            <!-- <div class="w-100 server-list-pagination">
                <nav aria-label="...">
                  <ul class="pagination">
                    <li class="page-item disabled first">
                      <a
                        class="page-link"
                        href="#"
                        tabindex="-1"
                        aria-disabled="true"
                        >Previous</a
                      >
                    </li>
                    <li class="page-item inner-page-item">
                      <a class="page-link" href="#">1</a>
                    </li>
                    <li
                      class="page-item inner-page-item active"
                      aria-current="page"
                    >
                      <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
  
                    <li class="page-item inner-page-item d-none d-lg-block">
                      <a class="page-link" href="#">4</a>
                    </li>
                    <li class="page-item inner-page-item d-none d-lg-block">
                      <a class="page-link" href="#">5</a>
                    </li>
                    <li class="page-item inner-page-item d-none d-lg-block">
                      <a class="page-link" href="#">...</a>
                    </li>
                    <li class="page-item d-none d-lg-block">
                      <a class="page-link" href="#">124</a>
                    </li>
  
                    <li class="page-item last">
                      <a class="page-link" href="#">Next</a>
                    </li>
                  </ul>
                </nav>
              </div> -->
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

const commonApi = commonApis()
const sortBy = ref(false);
const store = useStore();
const user = computed(() => store.state.auth.user)
const tickets = ref([]);
const status = ref([]);
const ticketStatus = ref("All");

console.log(user.value.client_id)


const params = ref(
	{'client_id': user.value.client_id , orderby:'', order:''}
)
const getTicketsData = ()=>{
	showLoader(true);
	commonApi.runGetApi('/support-ticket' , params.value).then((res)=>{
	showLoader(false);
	sortBy.value = false;
	console.log(res.data)
	tickets.value = res.data.tickets
	status.value = res.data.status
   
	}).catch((e)=>{
	console.log(e)

	})
}

getTicketsData()
function formatDate(date) {
  return new Date(date).toISOString().slice(0, 10);
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

function getTicketsByStatus(ticketStatus) {
  return tickets.value.filter((ticket) => ticket.status === ticketStatus);
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

const filteredTickets = computed(() => {
  if (ticketStatus.value === "All") {
    return tickets.value;
  }

  return tickets.value.filter(
    (ticket) => ticket.status === ticketStatus.value
  );
});
</script>
  
  <style scoped>
</style>
  