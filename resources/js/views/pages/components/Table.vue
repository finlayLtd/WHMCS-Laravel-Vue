<template>
    <div class="table-parrent" :class="overflow">
        <table class="w-100">
            <tr class="table-head" v-if="isHeadDisplay">
                <th v-for="(head, i) in headings" :key="i">
                    <template v-if="head.name == 'Price'">
                        <div v-if="current_plan == 'monthly'">Monthly</div>
                        <div v-if="current_plan == 'quarterly'">Quarterly</div>
                        <div v-if="current_plan == 'semiannually'">Semiannually</div>
                        <div v-if="current_plan == 'annually'">Annually</div>
                    </template>
                    <template v-else>
                        <div>{{ head.name }}</div>
                    </template>
                </th>
            </tr>

            <tr class="data-row" v-for="(tdata, ind) in data" :key="ind">
                <td v-for="(head, i) in headings" :key="i">
                    <slot :name="`${head.slotName}`" :tdata="tdata" :index="ind" />
                </td>
            </tr>
        </table>
    </div>
    <div class="mobile-head">
        <!-- <div class="mobile-child border" v-if="isHeadDisplay && mobileSingleHead">
            <div class="d-flex align-items-center"
                v-for="(head, i) in headingMobile.length ? headingMobile[0] : []" :key="i">
                <p class="text-primary-50 dark:text-white-50 text-[13px]  font-normal leading-[100%] tracking-[0.26px]">
                    {{ head.name }}
                </p>
            </div>
        </div> -->

        <div class="div-mobile" v-for="(tdata, ind) in data" :key="ind">
            <div v-for="(mHeading, mindex) in headingMobile" :key="mindex">
                <div class="d-flex align-items-center justify-content-between">
                    <div v-for="(singleHeading, sindex) in mHeading" :key="sindex" :class="sindex == 1 ? 'text-right' : ''"
                        class="[&:has(>.action-full)]:w-full">
                        <p class="mobile-head mb-2"
                            :class="[isHeadDisplay ? '' : 'hidden', singleHeading?.smHidden ? 'hidden' : '']">
                            {{ singleHeading.name }}
                        </p>
                        <div class="slot-text">
                            <slot :name="`${singleHeading.slotName}`" :tdata="tdata" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";

const arrayToMatrix = (array, columns) =>
    Array(Math.ceil(array.length / columns))
        .fill("")
        .reduce((acc, cur, index) => {
            return [...acc, [...array].splice(index * columns, columns)];
        }, []);

// const head = ref([...head])

const headingMobile = computed(() => {
    let sort = ref(
        [...props.headings].sort((a, b) => a?.mobileIndex - b?.mobileIndex)
    );
    return arrayToMatrix(
        [...sort.value.filter((item) => item?.mobileDisplay != false)],
        2
    );
    // return arrayToMatrix(props.headings , 2)
});
const props = defineProps({
    data: {
        required: true,
    },
    headings: {
        required: true,
    },
    headPosition: {
        default: 'justify-center',
    },
    dataPosition: {
        default: 'text-center'
    },
    current_plan: {
        default: 'monthly'
    },
    overflow: {
        default: ''
    },
    isHeadDisplay: {
        default: true
    },
    mobileSingleHead: {
        default: true
    }
});
</script>

<style>
.table-parrent {
    display: none;
    background-color: #ffffff;
    margin-top: 28px;
}

.table-head>th {
    padding: 16px 20px;
    border-top: 1px solid rgba(23, 30, 38, 0.08);
    border-bottom: 1px solid rgba(23, 30, 38, 0.08);
    color: rgba(23, 30, 38, 0.75) !important;
    font-family: Inter;
    font-size: 14px !important;
    font-style: normal;
    font-weight: 400 !important;
    line-height: 100%;
    /* 14px */
    letter-spacing: -0.14px;
}

.mobile-head {
    display: block;
}

.data-row>td {
    padding: 12px 22px;
    border-top: 1px solid rgba(23, 30, 38, 0.08);
    border-bottom: 1px solid rgba(23, 30, 38, 0.08);
    color: #171E26;
    font-family: Inter;
    font-size: 15px;
    font-style: normal;
    font-weight: 420;
    line-height: 100%;
    /* 15px */
    letter-spacing: 0.15px;
}

p {
    margin-bottom: 0;
}

.div-mobile>div {
    padding: 18px 0;
    border-top: 1px solid rgba(23, 30, 38, 0.08);
    border-bottom: 1px solid rgba(23, 30, 38, 0.08);
}

.div-mobile:first-child>div {
    border-top: 0;
}

.div-mobile:last-child>div {
    border-bottom: 0;
}

.text-right {
    text-align: right;
}

.slot-text {
    color: #171E26;
    font-family: Inter;
    font-size: 14px;
    font-style: normal;
    font-weight: 420;
    line-height: 100%;
    /* 14px */
    letter-spacing: 0.14px;
}

.mobile-head {
    color: rgba(23, 30, 38, 0.75);
    font-family: Inter;
    font-size: 12px;
    font-style: normal;
    font-weight: 400;
    line-height: 100%;
    /* 12px */
    letter-spacing: -0.12px;
}


@media screen and (min-width: 1024px) {
    .table-parrent {
        display: block;
    }

    .mobile-head {
        display: none;
    }

    .mobile-child {
        display: flex;
        padding: 1rem;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid rgba(23, 30, 38, 0.08);
        border-bottom: 1px solid rgba(23, 30, 38, 0.08);
    }
}
</style>