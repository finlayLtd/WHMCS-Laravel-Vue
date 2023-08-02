<template>
	<section class="dashboard">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center title-button-wrapper">
				<h2 class="title mb-0">{{ $t('Support_Ticket') }}</h2>
			</div>



			<template v-if="user && user.permissions.split(',').includes('tickets')">
				<div class="sub-section server-list-tab">
					<div class="row justify-content-between align-items-center ">

						<div class="row mb-5 pe-0">

							<div class="col-md-9 d-flex pe-0 flex-wrap">

								<div class="sort-servers order-2 order-md-1">
									<div id="toggleButton" class="sort-item-active btn-chevron chevron-dark"
										style="width: 160px;" @click="sortBy = !sortBy">
										<span>{{ $t('Sort_by') }}</span>
									</div>
									<div class="sorting-items" v-if="sortBy">
										<ul>
											<li class="touch-item" @click="setOrder('date', 'desc')">{{ $t('Opened_latest')
											}}</li>
											<li class="touch-item" @click="setOrder('date', 'asc')">{{ $t('Opened_oldest')
											}}</li>
											<li class="touch-item" @click="setOrder('lastreply', 'desc')">{{
												$t('Last_Reply_latest') }}</li>
											<li class="touch-item" @click="setOrder('date', 'asc')">{{
												$t('Last_Reply_oldest') }}</li>
										</ul>
									</div>
								</div>

								<ul class="nav nav-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0" id="pills-tab"
									role="tablist">
									<li class="nav-item" role="presentation">
										<button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill"
											data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all"
											aria-selected="true">All</button>
									</li>
									<li v-for="statu in status" :key="statu.title" class="nav-item" role="presentation">
										<button :id="getTabLabelId(statu.title)" class="nav-link" data-bs-toggle="pill"
											:data-bs-target="'#' + getTabId(statu.title)" type="button" role="tab"
											:aria-controls="getTabId(statu.title)" :aria-selected="false">

											{{ statu.title }}
										</button>
									</li>
								</ul>
							</div>
							<div class="col-md-3 text-end">
								<button type="submit" class="btn btn-dark hover-dark-light d-inline" id="create-ticket"
									@click="openModal = true">{{ $t('Create_Ticket') }}</button>
							</div>

						</div>


						<div class="tab-content" id="pills-tabContent">

							<div class="tab-pane fade show active" id="pills-all" role="tabpanel"
								aria-labelledby="pills-all-tab">

								<div class="row mb-5">

									<h5 v-if="!tickets || tickets.length === 0">{{ $t('No_tickets_found') }}</h5>

									<div v-else v-for="ticket in paginatedTickets" :key="ticket.id"
										class="col-12 col-lg-6 col-md-6 col-sm-12">
										<div class="card-item p-4 mb-4 support-item flex-column">
											<div class="d-flex justify-content-between support-item-header">
												<router-link :to="{
													name: 'ticket-detail',
													params: { id: ticket.id },
												}">
													<div class="support-item-title">
														<img class="me-2" src="assets/img/support.svg" alt="">
														<span style="color:rgba(23, 30, 38, 0.5);"> {{ $t('Ticket') }}#{{
															ticket.tid }}</span>
													</div>
													<h3 class="detail" style="margin-top: 10px;">
														{{ $t('Opened_at') }} : {{ formatDate(ticket.date) }}
													</h3>
													<h3 class="detail" style="margin-top: 5px;">
														{{ $t('Last_reply_at') }} : {{ formatDate(ticket.lastreply) }}
													</h3>
												</router-link>
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
												<p class="fs-15 mb-0" v-html="ticket.subject"></p>
											</div>
										</div>
									</div>

								</div>
								<div class="w-100 server-list-pagination">

									<Pagination :currentPage="params.page" :totalPages="totalPages"
										@page-changed="onPageChanged" />
								</div>
							</div>

							<div v-for="statu in status" :key="statu.title" class="tab-pane fade"
								:id="getTabId(statu.title)" :aria-labelledby="getTabLabelId(statu.title)">
								<div class="row mb-5">

									<h5
										v-if="!getTicketsByStatus(statu.title) || getTicketsByStatus(statu.title).length === 0">
										{{ $t('No_tickets_found') }}</h5>
									<div v-else v-for="ticket in getTicketsByStatus(statu.title)" :key="ticket.id"
										class="col-12 col-lg-6 col-md-6 col-sm-12">
										<div class="card-item p-4 mb-4 support-item flex-column">
											<div class="d-flex justify-content-between support-item-header">
												<a :href="'/ticket-detail/' + ticket.id">
													<div class="support-item-title">
														<img class="me-2" src="assets/img/support.svg" alt="">
														<span style="color: rgba(23, 30, 38, 0.5);">{{ $t('Ticket') }}#{{
															ticket.tid }}</span>
													</div>
													<h3 class="detail" style="margin-top: 10px;">
														{{ $t('Opened_at') }} : {{ formatDate(ticket.date) }}
													</h3>
													<h3 class="detail" style="margin-top: 5px;">
														{{ $t('Last_reply_at') }} : {{ formatDate(ticket.lastreply) }}
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
								<div class="w-100 server-list-pagination">
									<Pagination :currentPage="params.page" :totalPages="totalFilterPages[statu.title]"
										@page-changed="onPageChanged" />
								</div>
							</div>


						</div>






					</div>
				</div>
			</template>

			<template v-else>
				<NoPermission />
			</template>

		</div>
	</section>




	<div class="modal modal-ticket" v-if="openModal">
		<div class="modal-inner">
			<div class="modal-close" @click="openModal = false">
				<img class="close-dark" src="assets/img/close.svg" alt="">
				<img class="close-light" src="assets/img/close-light.svg" alt="">

			</div>
			<div class="modal-content">

				<div class="modal-header">
					<div class="modal-title">
						<h2>{{ $t('New_ticket') }}</h2>
						<h3>{{ $t('Create_new_ticket_now') }}.</h3>
					</div>
				</div>
				<div class="modal-main">
					<div class="amounts">
						<h4>{{ $t('Subject') }}</h4>
						<input class="mb-3" name="subject" type="text" placeholder="Write subject" v-model="subject">

						<h4>{{ $t('Describe_the_problem') }}</h4>
						<textarea class="mb-3" name="message" id="" cols="30" rows="8" v-model="message"></textarea>

						<h4>{{ $t('Department') }}*</h4>
						<select name="department" id="department" v-model="selectedDepartment">
							<option :value="department.id" v-for="department in departments" :key="department.id">{{
								department.name }}</option>
						</select>

						<div v-if="orders.length > 0">
							<h4>{{ $t('Service_related') }}</h4>

							<select name="service" id="service" v-model="selectedService">
								<option value="0">- {{ $t('None') }} -</option>
								<template v-for="orderInfo in orders">
									<template v-for="orderValue in orderInfo.lineitems.lineitem" :key="orderValue.relid">
										<option :value="orderValue.relid">
											{{ orderValue.product }} - {{ orderValue.status }}
										</option>
									</template>
								</template>
							</select>
						</div>

						<button class="btn-dark d-block w-100 mt-5" id="open-ticket"
							:disabled="subject == '' || selectedDepartment == 0" @click="createTicket()">{{ $t('Create_Ticket')
							}}</button>
					</div>
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
// toast
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import Pagination from '@/components/Pagination.vue';
import NoPermission from '@/components/NoPermission.vue';
const $toast = useToast();

const commonApi = commonApis()
const sortBy = ref(false);
const openModal = ref(false);
const store = useStore();
const user = computed(() => store.state.auth.user)
const tickets = ref([]);
const departments = ref([]);
const orders = ref([]);
const status = ref([]);
const selectedService = ref(0);
const selectedDepartment = ref(0);
const subject = ref('');
const message = ref('');
const totalPages = ref(0);
const onlyShow = ref(['All', 'Open', 'Answered', 'Customer-Reply', 'Closed'])
const params = ref(
	{ 'client_id': user.value.client_id, orderby: '', order: '', page: 1 }
)
const perPage = 8;
const paginatedTickets = computed(() => {
	const startIndex = (params.value.page - 1) * perPage;
	const endIndex = startIndex + perPage;
	return tickets.value.slice(startIndex, endIndex);
});
const getTicketsData = () => {
	showLoader(true);
	commonApi.runGetApi('/support-ticket', params.value).then((res) => {
		showLoader(false);
		sortBy.value = false;
		tickets.value = res.data.tickets;
		const filteredStatus = computed(() => {
			return res?.data?.status?.filter(statu => onlyShow.value.includes(statu.title));
		});
		status.value = filteredStatus.value;
		// for create ticket
		departments.value = res.data.departments
		orders.value = res.data.orders
		const totalTickets = res.data.totalTickets;

		totalPages.value = Math.ceil(totalTickets / perPage);


	}).catch((e) => {
		console.log(e)

	})
}

getTicketsData()
function formatDate(date) {
	return new Date(date).toISOString().slice(0, 10);
}
function onPageChanged(page) {
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
const totalFilterPages = ref([]);
function getTicketsByStatus(ticketStatus) {
	const filterTickets = tickets.value.filter((ticket) => ticket.status === ticketStatus);
	const filterticketsPaged = computed(() => {
		const startIndex = (params.value.page - 1) * perPage;
		const endIndex = startIndex + perPage;
		return filterTickets.slice(startIndex, endIndex);
	});


	totalFilterPages.value[ticketStatus] = Math.ceil(filterTickets.length / perPage);
	return filterticketsPaged.value;
}


function setOrder(orderBy, order) {
	params.value.orderby = orderBy
	params.value.order = order
	getTicketsData()
}

const createTicket = () => {
	showLoader(true);

	commonApi
		.runPostApi("/ticket-create", {
			subject: subject.value,
			message: message.value,
			department: selectedDepartment.value,
			message: message.value,
			service: selectedService.value,
		})
		.then((res) => {
			showLoader(false);
			if (res.data.result == "success") {
				tickets.value = res.data.tickets;
				$toast.success("Successfully opened ticket!");
				openModal.value = false;
			} else $toast.warning("Cannot connect to whmcs api.");
		})
		.catch((e) => {
			showLoader(false);
			console.log(e);
		});
};
useAuth().getUser();
</script>

<style scoped></style>
