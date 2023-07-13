<template>
  <section class="dashboard">
    <div class="container">
      <div
        class="d-flex justify-content-between align-items-center title-button-wrapper"
      >
        <h2 class="title mb-0">Balance</h2>
      </div>

      <div class="sub-section server-list-tab">
        <div class="row justify-content-between align-items-center">
          <div class="row pe-0">
            <div class="col-md-8 mb-4 mb-md-0">
              <div class="card-item">
                <div class="balance-card-header main-balance-header">
                  <div class="main-balance-wrapper">
                    <div class="balance-icon">
                      <img src="assets/img/wallet.svg" alt="" />
                    </div>
                    <div class="balance-title">
                      <h3>Main balance</h3>
                    </div>
                  </div>
                  <div class="balance">€<span>10.30</span></div>
                </div>
                <div class="balance-card-footer d-flex justify-content-end">
                  <button
                    class="btn-dark add-funds hover-dark-light"
                    @click="openModal = true"
                  >
                    Add Funds
                  </button>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card-item">
                <div class="balance-card-header credit-balance-header">
                  <div class="main-balance-wrapper">
                    <div class="balance-icon">
                      <img src="assets/img/empty-wallet.svg" alt="" />
                    </div>
                    <div class="balance-title">
                      <h3>Credit balance</h3>
                    </div>
                  </div>
                  <div class="balance">€<span>150</span></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="sub-section server-list-tab">
        <div class="row justify-content-between align-items-center">
          <div class="row mb-3 mb-lg-5 pe-0">
            <h3 class="col-md-3 sub-title pt-2">Transaction History</h3>

            <div
              class="col-md-9 d-flex justify-content-end pe-0 flex-wrap list-flex-nav"
            >
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
                    <li>Date-latest</li>
                    <li>Date-oldest</li>
                    <li>Price-highest</li>
                    <li>Price-lowest</li>
                  </ul>
                </div>
              </div>

              <ul
                class="nav nav-pills three-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0 flex-nowrap"
                id="pills-tab"
                role="tablist"
              >
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="pills-home-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-home"
                    type="button"
                    role="tab"
                    aria-controls="pills-home"
                    aria-selected="true"
                  >
                    Paid
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="pills-profile-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-profile"
                    type="button"
                    role="tab"
                    aria-controls="pills-profile"
                    aria-selected="false"
                  >
                    Cancelled
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="pills-profile-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-profile"
                    type="button"
                    role="tab"
                    aria-controls="pills-profile"
                    aria-selected="false"
                  >
                    In progress
                  </button>
                </li>
              </ul>
            </div>
          </div>

          <div class="tab-content" id="pills-tabContent">
            <div
              class="tab-pane fade show active"
              id="pills-home"
              role="tabpanel"
              aria-labelledby="pills-home-tab"
            >
              <div class="w-100 mb-5 support-table">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Invoice</th>
                      <th scope="col">Amount</th>
                      <th scope="col">Remaining balance</th>
                      <th scope="col">Date</th>
                      <th scope="col">Status</th>
                      <th scope="col" class="text-center">View Invoice</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>INV-3</td>
                      <td>€10.30</td>
                      <td class="remaining-cell"><span>€50.50</span></td>
                      <td class="date-cell">2023-13-03</td>
                      <td class="successful-cell"><span>Successful</span></td>
                      <td class="text-center">
                        <a href="#"
                          ><img
                            src="assets/img/eye-open.svg"
                            class="icon-password view-invoice"
                        /></a>
                      </td>
                    </tr>
                    <tr>
                      <td>INV-3</td>
                      <td>€10.30.</td>
                      <td class="remaining-cell"><span>€50.50</span></td>
                      <td class="date-cell">2023-13-03</td>
                      <td class="cancelled-cell"><span>Cancelled</span></td>
                      <td class="text-center">
                        <a href="#"
                          ><img
                            src="assets/img/eye-open.svg"
                            class="icon-password view-invoice"
                        /></a>
                      </td>
                    </tr>
                    <tr>
                      <td>INV-3</td>
                      <td>€10.30</td>
                      <td class="remaining-cell"><span>€50.50</span></td>
                      <td class="date-cell">2023-13-03</td>
                      <td class="in-progress-cell"><span>In progress</span></td>
                      <td class="text-center">
                        <a href="#"
                          ><img
                            src="assets/img/eye-open.svg"
                            class="icon-password view-invoice"
                        /></a>
                      </td>
                    </tr>
                    <tr>
                      <td>INV-3</td>
                      <td>€10.30</td>
                      <td class="remaining-cell"><span>€50.50</span></td>
                      <td class="date-cell">2023-13-03</td>
                      <td class="in-progress-cell"><span>In progress</span></td>
                      <td class="text-center">
                        <a href="#"
                          ><img
                            src="assets/img/eye-open.svg"
                            class="icon-password view-invoice"
                        /></a>
                      </td>
                    </tr>
                    <tr>
                      <td>INV-3</td>
                      <td>€10.30</td>
                      <td class="remaining-cell"><span>€50.50</span></td>
                      <td class="date-cell">2023-13-03</td>
                      <td class="in-progress-cell"><span>In progress</span></td>
                      <td class="text-center">
                        <a href="#"
                          ><img
                            src="assets/img/eye-open.svg"
                            class="icon-password view-invoice"
                        /></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="w-100 server-list-pagination">
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
                    <li class="page-item">
                      <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item active" aria-current="page">
                      <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">4</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">5</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">...</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">124</a>
                    </li>

                    <li class="page-item last">
                      <a class="page-link" href="#">Next</a>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>

            <div
              class="tab-pane fade"
              id="pills-profile"
              role="tabpanel"
              aria-labelledby="pills-profile-tab"
            >
              <div class="row mb-5 pe-0">
                <div class="support-table">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Number Ticket</th>
                        <th scope="col">Title</th>
                        <th scope="col">Request Type</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>#123</td>
                        <td>Name about yes request..</td>
                        <td class="refund-request">Refund Request</td>
                        <td class="date-cell">2023-13-03</td>
                        <td class="successful-cell"><span>Successful</span></td>
                      </tr>
                      <tr>
                        <td>#123</td>
                        <td>Name about yes request..</td>
                        <td class="refund-request">Refund Request</td>
                        <td class="date-cell">2023-13-03</td>
                        <td class="cancelled-cell"><span>Cancelled</span></td>
                      </tr>
                      <tr>
                        <td>#123</td>
                        <td>Name about yes request..</td>
                        <td class="refund-request">Refund Request</td>
                        <td class="date-cell">2023-13-03</td>
                        <td class="in-progress-cell">
                          <span>In progress</span>
                        </td>
                      </tr>
                      <tr>
                        <td>#123</td>
                        <td>Name about yes request..</td>
                        <td class="refund-request">Refund Request</td>
                        <td class="date-cell">2023-13-03</td>
                        <td class="in-progress-cell">
                          <span>In progress</span>
                        </td>
                      </tr>
                      <tr>
                        <td>#123</td>
                        <td>Name about yes request..</td>
                        <td class="refund-request">Refund Request</td>
                        <td class="date-cell">2023-13-03</td>
                        <td class="in-progress-cell">
                          <span>In progress</span>
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
  </section>

  <div class="modal modal-balance" v-if="openModal">
    <div class="modal-inner">
      <div class="modal-close" @click="openModal=false">
        <img class="close-dark" src="assets/img/close.svg" alt="" />
        <img class="close-light" src="assets/img/close-light.svg" alt="" />
      </div>
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title">
            <h2>Deposit</h2>
            <h3>Deposit cryptocurrency</h3>
          </div>
        </div>
        <div class="modal-main">
          <div class="main-title">
            <p>Choose Payment method</p>
          </div>
          <div class="modal-buttons">
            <button class="modal-payment">
              <img src="assets/img/bitcoin.png" alt="" /> Bitcoin
            </button>
            <button class="modal-payment">
              <img src="assets/img/litecoin.png" alt="" /> LiteCoin
            </button>
            <button class="modal-payment">
              <img src="assets/img/ethereum.png" alt="" /> Ethereum
            </button>
            <button class="modal-payment">
              <img src="assets/img/bitcoincash.png" alt="" /> Bitcoincash
            </button>
            <button class="modal-payment">
              <img src="assets/img/tether.png" alt="" /> Tether USDT
            </button>
            <button class="modal-payment">
              <img src="assets/img/zcash.png" alt="" /> ZCash
            </button>
            <button class="modal-payment">
              <img src="assets/img/monero.png" alt="" /> Monero
            </button>
            <button class="modal-payment">
              <img src="assets/img/bnb.png" alt="" /> BinanceCoin
            </button>
            <button class="modal-payment">
              <img src="assets/img/perfectmoney.png" alt="" /> Perfectmoney
            </button>
          </div>
          <div class="amounts">
            <h4>Amounts</h4>
            <input type="text" value="321" placeholder="" />
            <div class="amount-footer">
              <span>Amount of one deposit</span>
              <span>€10,00 - €1.000,00</span>
            </div>
          </div>
          <button class="btn-dark d-block">Continue</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref, onBeforeUnmount } from "vue";
const sortBy = ref(false);
const openModal = ref(false);
</script>

<style scoped>
</style>
