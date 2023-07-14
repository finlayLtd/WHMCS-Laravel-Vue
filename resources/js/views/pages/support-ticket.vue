<template>
    <section class="dashboard">
	<div class="container">
		<div class="d-flex justify-content-between align-items-center title-button-wrapper">
			<h2 class="title mb-0">Support Ticket</h2>
		</div>


		<div class="sub-section server-list-tab">
        <div class="row justify-content-between align-items-center ">

          	<div class="row mb-5 pe-0">

					<div class="col-md-9 d-flex pe-0 flex-wrap">

						<div class="sort-servers order-2 order-md-1" >
							<div id="toggleButton" class="sort-item-active btn-chevron chevron-dark" style="width: 160px;" @click="sortBy = !sortBy">
								<span>Sort by</span>
							</div>
							<div class="sorting-items" v-if="sortBy">
								<ul>
									<li class="touch-item" @click="setOrder('date' , 'desc')">Opened-latest</li>
									<li class="touch-item" @click="setOrder('date' , 'asc')">Opened-oldest</li>
									<li class="touch-item" @click="setOrder('lastreply' , 'desc')">Last-Reply-latest</li>
									<li class="touch-item" @click="setOrder('date' , 'asc')">Last-Reply-oldest</li>
								</ul>
							</div>
						</div>

		              <ul class="nav nav-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0" id="pills-tab" role="tablist">
		                <li class="nav-item" role="presentation">
		                  <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">All</button>
		                </li>
		                <li v-for="statu in status" :key="statu.title" class="nav-item" role="presentation">
							<button
								:id="getTabLabelId(statu.title)"
								class="nav-link"
								data-bs-toggle="pill"
								:data-bs-target="'#'+getTabId(statu.title)"
								type="button"
								role="tab"
								:aria-controls="getTabId(statu.title)"
								:aria-selected="false"
							>
								{{ statu.title }}
							</button>
						</li>                              
		              </ul>
		            </div>
		            <div class="col-md-3 text-end">
                        <button type="submit" class="btn btn-dark hover-dark-light d-inline" id="create-ticket" @click="openModal=true">Create Ticket</button>			
		            </div>

		        </div> 


            <div class="tab-content" id="pills-tabContent">

              <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">

                <div class="row mb-5">
				
					<h5 v-if="!tickets || tickets.length === 0">No tickets found</h5>
					
					<div v-else v-for="ticket in tickets" :key="ticket.id" class="col-12 col-lg-6 col-md-6 col-sm-12">
						<div class="card-item p-4 mb-4 support-item flex-column">
						<div class="d-flex justify-content-between support-item-header">
							<a :href="'/ticket-detail/' + ticket.id">
							<div class="support-item-title">
								<img class="me-2" src="assets/img/support.svg" alt="">
								<span style="color:rgba(23, 30, 38, 0.5);"> Ticket#{{ ticket.tid }}</span>
							</div>
							<h3 class="detail" style="margin-top: 10px;">
								Opened at : {{ formatDate(ticket.date) }}
							</h3>
							<h3 class="detail" style="margin-top: 5px;">
								Last reply at : {{ formatDate(ticket.lastreply) }}
							</h3>
							</a>
							<div class="support-item-status">
							<div v-if="ticket.status === 'Answered'" class="successful-cell">
								<span class="fs-15 color-in-work">{{ ticket.status }}</span>
							</div>
							<div v-else-if="ticket.status === 'Closed'" class="cancelled-cell">
								<span class="fs-15 color-in-work">{{ ticket.status }}</span>
							</div>
							<div v-else class="in-progress-cell">
								<span class="fs-15 color-in-work">{{ ticket.status }}</span>
							</div>
							</div>
						</div>
						<div class="support-item-detail">
							<p class="fs-15 mb-0">{{ ticket.subject }}</p>
						</div>
						</div>
					</div>
					
                </div>

              </div>

            <div v-for="statu in status" :key="statu.title" class="tab-pane fade" :id="getTabId(statu.title)" :aria-labelledby="getTabLabelId(statu.title)">
				<div class="row mb-5">
					<h5 v-if="!getTicketsByStatus(statu.title) || getTicketsByStatus(statu.title).length === 0">No tickets found</h5>
					<div v-else v-for="ticket in getTicketsByStatus(statu.title)" :key="ticket.id" class="col-12 col-lg-6 col-md-6 col-sm-12">
					<div class="card-item p-4 mb-4 support-item flex-column">
						<div class="d-flex justify-content-between support-item-header">
						<a :href="'/ticket-detail/' + ticket.id">
							<div class="support-item-title">
							<img class="me-2" src="assets/img/support.svg" alt="">
							<span style="color: rgba(23, 30, 38, 0.5);">Ticket#{{ ticket.tid }}</span>
							</div>
							<h3 class="detail" style="margin-top: 10px;">
							Opened at : {{ formatDate(ticket.date) }}
							</h3>
							<h3 class="detail" style="margin-top: 5px;">
							Last reply at : {{ formatDate(ticket.lastreply) }}
							</h3>
						</a>
						<div class="support-item-status">
							<div v-if="ticket.status === 'Answered'" class="successful-cell">
							<span class="fs-15 color-in-work">{{ ticket.status }}</span>
							</div>
							<div v-else-if="ticket.status === 'Closed'" class="cancelled-cell">
							<span class="fs-15 color-in-work">{{ ticket.status }}</span>
							</div>
							<div v-else class="in-progress-cell">
							<span class="fs-15 color-in-work">{{ ticket.status }}</span>
							</div>
						</div>
						</div>
						<div class="support-item-detail">
						<p class="fs-15 mb-0">{{ ticket.subject }}</p>
						</div>
					</div>
					</div>
				</div>
			</div>


            </div>






        </div>
		</div>
	</div>
</section>		

<div class="modal modal-ticket" v-if="openModal">
	<div class="modal-inner">
			<div class="modal-close" @click="openModal=false">
				<img class="close-dark" src="assets/img/close.svg" alt="">
				<img class="close-light" src="assets/img/close-light.svg" alt="">

			</div>		
		<div class="modal-content">

			<div class="modal-header">
				<div class="modal-title">
					<h2>New ticket</h2>
					<h3>Create new ticket now.</h3>
				</div>
			</div>
			<div class="modal-main">
				<div class="amounts">
					<h4>Subject</h4>
					<input class="mb-3" type="text" placeholder="Write subject">

					<h4>Describe the problem</h4>
					<textarea class="mb-3" name="" id="" cols="30" rows="8" ></textarea>

					<h4>Server related*</h4>
					<select name="" id="">
						<option value="Server">Server</option>
						<option value="Server2">Server2</option>
					</select>

				</div>
				<button class="btn-dark d-block w-100 mt-5" >Create Ticket</button>
			</div>
		</div>
	</div>
</div>	
</template>

<script setup>
import { computed, onMounted, ref, onBeforeUnmount, watch } from "vue";
import { commonApis } from '@/apis/commonApis';
import { useStore } from 'vuex';
import useAuth from "@/composables/auth";
import { showLoader } from '@/plugins/loading.js';

const commonApi = commonApis()
const sortBy = ref(false);
const openModal = ref(false);
const store = useStore();
const user = computed(() => store.state.auth.user)
const tickets = ref([]);
const status = ref([]);

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

</script>

<style scoped>

</style>
