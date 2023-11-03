<template>
    <div style="margin-top: 60px ;">
        <div class="container">
            <h1 class="main-header-server">Create Server</h1>

            <div style="margin-top: 50px;">
                <div class="px-4 choose-os-div">
                    <h2 class="choose-os-header">Choose a OS</h2>
                    <hr class="server-seprater">

                    <div>
                        <div class="choose-server-row">
                            <div class="single-os-div" :class="activeOS == index ? 'active-os-div' : ''"
                                v-for="(singleOs, index) in osList" :key="index" @click="activeOS = index">
                                <div>
                                    <img src="/assets/img/os.svg" class="" alt="Os">
                                    <p class="os-name">{{ singleOs.name }}</p>
                                </div>
                                <div class="p-0 dropdown">
                                    <button class="os-drop-down-btn dropdown-toggle" id="dropdownMenuLink"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <div>
                                            <p>Windows Server 2012 R2</p>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6" viewBox="0 0 8 6"
                                                fill="none">
                                                <path d="M0.800003 0.833328L4 4.16666L7.2 0.833328" stroke="#171E26"
                                                    stroke-width="1.2" />
                                            </svg>
                                        </div>
                                    </button>
                                    <ul class="dropdown-menu border border-1 p-1" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item rounded" href="#">Action</a></li>
                                        <li><a class="dropdown-item rounded" href="#">Another action</a></li>
                                        <li><a class="dropdown-item rounded" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin: 30px 0;">
                <div class="px-4 choose-os-div">
                    <h2 class="choose-os-header">Choose a Datecenter region</h2>
                    <hr class="server-seprater">

                    <div>
                        <div class="choose-server-row">
                            <div class="single-region-div" :class="activeOrigin == index ? 'active-os-div' : ''"
                                v-for="(singleOrigin, index) in originList" :key="index" @click="activeOrigin = index">
                                <div>
                                    <img src="/assets/img/us.svg" class="" alt="Os">
                                    <p class="os-name">{{ singleOrigin.name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="px-4 choose-os-div pb-0">
                    <h2 class="choose-os-header">Choose a Datecenter region</h2>
                    <div>
                        <Table :data="tableData" :headings="tableHeader">
                            <template #memory="{ tdata }">
                                <p>{{ tdata.memory }}</p>
                            </template>
                            <template #vcpus="{ tdata }">
                                <p>{{ tdata.vcpus }}</p>
                            </template>
                            <template #bandwidth="{ tdata }">
                                <p>{{ tdata.bandwidth }}</p>
                            </template>
                            <template #storage="{ tdata }">
                                <p>{{ tdata.storage }}</p>
                            </template>
                            <template #con="{ tdata }">
                                <p>{{ tdata.con }}</p>
                            </template>
                            <template #mprice="{ tdata }">
                                <p>{{ tdata.mprice }}</p>
                            </template>
                            <template #hprice="{ tdata }">
                                <p>{{ tdata.hprice }}</p>
                            </template>
                            <template #isSelecterd="{ tdata }">
                                <div class="choose-btn-selected" v-if="tdata.isSelecterd">
                                    <img src="/assets/img/check.svg" alt="check">
                                    <p>Selected</p>
                                </div>
                                <div class="choose-btn" v-else>
                                    <p>Choose</p>
                                </div>
                            </template>
                        </Table>
                    </div>
                </div>
            </div>

            <div class="container" style="margin-top: 30px;">

                <div class="row">
                    <div class="col-12 col-lg-3 ps-lg-0">
                        <div class="con-div">
                            <h2 class="choose-os-header">Configure Server</h2>
                            <hr class="server-seprater">
                            <div class="number-config">
                                <input type="text" v-model="configNum">
                                <div>
                                    <button @click="configNum--">
                                        <img src="/assets/img/up.svg" alt="up">
                                    </button>
                                    <button @click="configNum++">
                                        <img src="/assets/img/up.svg" style="transform: rotate(180deg);" alt="soun">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-9 pe-lg-0 config-2">
                        <div class="con-div">
                            <h2 class="choose-os-header">Configure Server</h2>
                            <hr class="server-seprater">
                            <form>
                                <div>
                                    <label for="hname" class="form-label">Hostname</label>
                                    <div class="form-filds">
                                        <input type="email">
                                        <p class="randome-btn">Random</p>
                                    </div>
                                </div>
                                <div style="margin-top: 20px;">
                                    <label for="hname" class="form-label">Root password</label>
                                    <div class="form-filds">
                                        <input type="password">
                                        <p class="randome-btn">Random</p>
                                    </div>
                                </div>

                                <button type="submit" class="btn-submit">Password Rating: 100%</button>
                            </form>

                            <div class="d-flex justify-content-end">
                                <button class="btn create-server-btn" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    @click="modelOpen = true">Create Server</button>

                                <div class="modal modal-ticket" v-if="modelOpen">
                                    <div class="model-child">
                                        <div class="d-flex align-items-center justify-content-between model-header">
                                            <p class="model-header-text">VPS BASIC</p>
                                            <p @click="modelOpen = false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 14 14" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.58632 7.00173L0 12.5889L1.41432 14.003L7.00042 8.41605L12.5869 14.0035L14.0013 12.5894L8.41453 7.00173L14.0013 1.4141L12.5869 0L7.00042 5.5874L1.41432 0.000423431L0 1.41453L5.58632 7.00173Z"
                                                        fill="white" />
                                                </svg>
                                            </p>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between model-body-li">
                                            <p class="model-body-key">Monthly</p>
                                            <p class="model-body-value">€9.00 EUR</p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between model-body-li">
                                            <p class="model-body-key">Datacenter</p>
                                            <p class="model-body-value">Netherlands</p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between model-body-li">
                                            <p class="model-body-key">Quantity</p>
                                            <p class="model-body-value">1 VPS</p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between model-body-li">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <img src="/assets/img/Ubuntu.svg" alt="os">
                                                <p class="model-body-key ms-2">OS</p>
                                            </div>
                                            <p class="model-body-value">ubuntu-18.04</p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between model-body-li">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <img src="/assets/img/cable.svg" alt="os">
                                                <p class="model-body-key ms-2">IPs</p>
                                            </div>
                                            <p class="model-body-value">1</p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between model-body-li">
                                            <p class="model-body-key">Host Name</p>
                                            <p class="model-body-value">6C1D13cjiUo</p>
                                        </div>
                                        <div style="margin: 24px 0;">
                                            <div class="payment-head-div">
                                                <p class="paymet-head">Payment method</p>
                                            </div>
                                        </div>

                                        <ul class="px-4 my-3">
                                            <li> <input type="radio" name="method"> <label
                                                    class="method-text">Cryptocurrency</label> </li>
                                            <li class="py-3"> <input type="radio" name="method"> <label
                                                    class="method-text">Perfect Money</label> </li>
                                            <li> <input type="radio" name="method"> <label class="method-text">Account Funds
                                                    (available $335.25)</label> </li>
                                        </ul>

                                        <div class="checkout-btn">
                                            <button class="btn w-100">Checkout</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup >
import { ref } from 'vue'
import Table from './components/Table.vue'
const configNum = ref(0)
const modelOpen = ref(false)

const osList = ref([
    {
        name: 'Windows'
    },
    {
        name: 'Ubuntu'
    },
    {
        name: 'Debian'
    },
    {
        name: 'AlmaLinux'
    },
    {
        name: 'Fedora'
    },
    {
        name: 'Rocky'
    },
    {
        name: 'Fedora'
    },
    {
        name: 'Centos'
    },
])

const activeOS = ref(0)
const activeOrigin = ref(0)

const originList = ref([
    {
        name: 'Netherlands'
    },
    {
        name: 'United States'
    }
])

const tableHeader = ref([
    {
        name: "Memory",
        slotName: "memory",
    },
    {
        name: "vCPUs",
        slotName: "vcpus",
    },
    {
        name: "Bandwidth",
        slotName: "bandwidth",
    },
    {
        name: "Storage",
        slotName: "storage",
    },
    {
        name: "Connection",
        slotName: "con",
    },
    {
        name: "Monthly Price",
        slotName: "mprice",
    },
    {
        name: "Hourly Price",
        slotName: "hprice",
    },
    {
        name: "",
        slotName: "isSelecterd",
    },
])

const tableData = ref([
    {
        memory: '#123',
        vcpus: '1 vCPUs',
        bandwidth: '1 TB',
        storage: '25 GB',
        con: '10 Gbps',
        mprice: '$4.95/m',
        hprice: '$4.95/m',
        isSelecterd: true
    },
    {
        memory: '#123',
        vcpus: '1 vCPUs',
        bandwidth: '1 TB',
        storage: '25 GB',
        con: '10 Gbps',
        mprice: '$4.95/m',
        hprice: '$4.95/m',
        isSelecterd: false
    },
    {
        memory: '#123',
        vcpus: '1 vCPUs',
        bandwidth: '1 TB',
        storage: '25 GB',
        con: '10 Gbps',
        mprice: '$4.95/m',
        hprice: '$4.95/m',
        isSelecterd: false
    },
    {
        memory: '#123',
        vcpus: '1 vCPUs',
        bandwidth: '1 TB',
        storage: '25 GB',
        con: '10 Gbps',
        mprice: '$4.95/m',
        hprice: '$4.95/m',
        isSelecterd: false
    },
    {
        memory: '#123',
        vcpus: '1 vCPUs',
        bandwidth: '1 TB',
        storage: '25 GB',
        con: '10 Gbps',
        mprice: '$4.95/m',
        hprice: '$4.95/m',
        isSelecterd: false
    },
])
</script>