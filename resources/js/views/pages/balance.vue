<template>
  <section class="dashboard">


    <template v-if="user && user.permissions.split(',').includes('invoices')">
      <div class="container">
        <a ref="customLink" style="display: none;">Custom Link</a>
        <div class="d-flex justify-content-between align-items-center title-button-wrapper">
          <h2 class="title mb-0">{{ $t('Balance') }}</h2>
          <router-link to="/create-vps-server"
          class="btn btn-dark hover-dark-light">
          <i class="fa fa-shopping-cart"></i> Order now
          </router-link>
        </div>

        <div class="sub-section server-list-tab">
          <div class="row justify-content-between align-items-center">
            <div class="row mb-3 mb-lg-5 pe-0">
              <h3 class="col-md-3 sub-title pt-2">{{ $t('My_Invoices') }}</h3>

              <div class="col-md-9 d-flex justify-content-end pe-0 flex-wrap list-flex-nav">
                <div class="sort-servers order-2 order-md-1">
                  <div id="toggleButton" class="sort-item-active btn-chevron chevron-dark" @click="sortBy = !sortBy">
                    <span>{{ $t('Sort_by') }} &nbsp;&nbsp;</span>
                  </div>
                  <div class="sorting-items" v-if="sortBy">
                    <ul>
                      <li @click="setOrder('date', 'desc')">{{ $t('Date_latest') }}</li>
                      <li @click="setOrder('date', 'asc')">{{ $t('Date_oldest') }}</li>
                      <li @click="setOrder('total', 'desc')">{{ $t('Price_highest') }}</li>
                      <li @click="setOrder('total', 'asc')">{{ $t('Price_lowest') }}</li>
                    </ul>
                  </div>
                </div>

                <ul class="nav nav-pills three-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0 flex-nowrap" id="pills-tab"
                  role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                      type="button" role="tab" aria-controls="pills-home" aria-selected="true"
                      @click="invoiceStatus = 'All'">
                      {{ $t('All') }}
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                      type="button" role="tab" aria-controls="pills-profile" aria-selected="false"
                      @click="invoiceStatus = 'Paid'">
                      {{ $t('Paid') }}
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                      type="button" role="tab" aria-controls="pills-profile" aria-selected="false"
                      @click="invoiceStatus = 'Unpaid'">
                      {{ $t('Unpaid') }}
                    </button>
                  </li>
                </ul>
              </div>
            </div>

            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="w-100 mb-5 support-table">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">{{ $t('Invoice') }}</th>
                        <th scope="col">{{ $t('Amount') }}</th>
                        <th scope="col">{{ $t('Invoice_Date') }}</th>
                        <th scope="col">{{ $t('Due_Date') }}</th>
                        <th scope="col">{{ $t('Status') }}</th>
                        <th scope="col" class="text-center">{{ $t('View_Invoice') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-if="!invoices || invoices.length === 0">
                        <td colspan="6" style="text-align: center">
                          <h5 style="margin-top: 20px">{{ $t('No_invoice') }}</h5>
                        </td>
                      </tr>
                      <tr v-else v-for="invoice in filteredInvoices" :key="invoice.id">
                        <td><a style="color: blue; cursor: pointer" @click="openInvoiceWindow(invoice.id)">#{{ invoice.id }}</a></td>
                        <td>{{ invoice.currencyprefix }}{{ invoice.total }}</td>
                        <td class="date-cell">{{ formatDate(invoice.date) }}</td>
                        <td class="date-cell">
                          {{ formatDate(invoice.duedate) }}
                        </td>
                        <td :class="getCellClass(invoice.status)">
                          <span>
                            {{ $t(invoice.status) }}
                          </span>
                        </td>
                        <td class="text-center">
                          <a style="color: blue; cursor: pointer" @click="openInvoiceWindow(invoice.id)">
                            <img src="assets/img/eye-open.svg" class="icon-password view-invoice" />
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="w-100 server-list-pagination">
                  <Pagination :currentPage="params.page" :totalPages="totalFilterPages[invoiceStatus]"
                    @page-changed="onPageChanged" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>

    <template v-else>
      <NoPermission />
    </template>

  </section>

  <div class="modal modal-balance" v-if="openModal">
    <div class="modal-inner">
      <div class="modal-close" @click="openModal = false">
        <img class="close-dark" src="assets/img/close.svg" alt="" />
        <img class="close-light" src="assets/img/close-light.svg" alt="" />
      </div>
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title">
            <h2>{{ $t('Deposit') }}</h2>
            <h3>{{ $t('Deposit_cryptocurrency') }}</h3>
          </div>
        </div>
        <div class="modal-main">
          <div class="modal-buttons">
            <button class="modal-payment">
              <img src="assets/img/bitcoin.png" alt="" /> BTC
            </button>
            <button class="modal-payment">
              <img src="assets/img/litecoin.png" alt="" /> LTC
            </button>
            <button class="modal-payment">
              <img src="assets/img/ethereum.png" alt="" /> ETH
            </button>
            <button class="modal-payment">
              <img src="assets/img/bitcoincash.png" alt="" /> BCH
            </button>
            <button class="modal-payment">
              <img src="assets/img/tether.png" alt="" /> USDT
            </button>
            <button class="modal-payment">
              <img src="assets/img/zcash.png" alt="" /> ZEC
            </button>
            <button class="modal-payment">
              <img src="assets/img/monero.png" alt="" /> XMR
            </button>
            <button class="modal-payment">
              <img src="assets/img/bnb.png" alt="" /> BNB
            </button>
            <button class="modal-payment">
              <img src="assets/img/perfectmoney.png" alt="" /> PM EUR
            </button>
          </div>
          <div class="amounts">
            <div class="amount-footer">
              <span>{{ $t('Amount_of_one_deposit') }}</span>
              <span>€10,00 - €10.000,00</span>
            </div>
          </div>
          <button class="btn-dark d-block" @click="openAddFundsWindow()">
            {{ $t('Continue') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref, onBeforeUnmount, watch } from "vue";
import { commonApis } from "@/apis/commonApis";
import { useStore } from "vuex";
import useAuth from "@/composables/auth";
import { showLoader } from "@/plugins/loading.js";
import Pagination from '@/components/Pagination.vue';
import NoPermission from '@/components/NoPermission.vue';
useAuth().getUser();
const customLink = ref(null);
const commonApi = commonApis();
const sortBy = ref(false);
const openModal = ref(false);
const store = useStore();
const user = computed(() => store.state.auth.user);
const invoices = ref([]);
const invoiceStatus = ref("All");
const totalPages = ref(0);
const totalresults = ref(0);


const perPage = 15;

const params = ref({
  client_id: user.value.client_id,
  orderby: "",
  order: "",
  page: 1,
});

const getInvoicesData = () => {
  showLoader(true);
  commonApi
    .runGetApi("/get-invoices", params.value)
    .then((res) => {
      showLoader(false);
      sortBy.value = false;
      invoices.value = res.data.invoices;
      totalresults.value = res.data.totalresults;
      totalPages.value = Math.ceil(totalresults.value / perPage);
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

function onPageChanged(page) {
  params.value.page = page;
  //getTicketsData(); // Fetch tickets for the new page
}

const openAddFundsWindow = () => {
  showLoader(true);
  commonApi
    .runPostApi("/add_funds_sso")
    .then((res) => {
      showLoader(false);
      if (res.data.result == "success") {
        // openInNewTab(res.data.redirect_url);
        customLink.value.href = res.data.redirect_url;
        customLink.value.click();
      }
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

const openInNewTab = (url) => {
  const newWindow = window.open(url, '_blank', 'noopener,noreferrer')
  if (newWindow) newWindow.opener = null
}

const openInvoiceWindow = (invoice_id) => {

  showLoader(true);
  commonApi
    .runPostApi("/invoice_detail_sso", invoice_id)
    .then((res) => {
      showLoader(false);
      if (res.data.result == "success") {
        customLink.value.href = res.data.redirect_url;
        customLink.value.click();
      }
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

getInvoicesData();

function formatDate(date) {
  return new Date(date).toISOString().slice(0, 10);
}

function getCellClass(status) {
  if (status == "Paid") return "successful-cell";
  if (status == "Unpaid") return "cancelled-cell";
  return "in-progress-cell";
}
const totalFilterPages = ref([]);
const filteredInvoices = computed(() => {
  let invoiceData;
  if (invoiceStatus.value === "All") {
    invoiceData = invoices.value;
  } else {
    invoiceData = invoices.value.filter(
      (invoice) => invoice.status === invoiceStatus.value
    );
  }

  const paginatedInvoices = computed(() => {
    const startIndex = (params.value.page - 1) * perPage;
    const endIndex = startIndex + perPage;
    return invoiceData.slice(startIndex, endIndex);
  });
  totalFilterPages.value[invoiceStatus.value] = Math.ceil(invoiceData.length / perPage);
  return paginatedInvoices.value

});

function setOrder(orderBy, order) {
  params.value.orderby = orderBy;
  params.value.order = order;
  getInvoicesData();
}


useAuth().getUser();
</script>

<style scoped></style>
