<template>
    <div class="tab-inner mb-3">
        <div class="row">
            <h3 class="title">{{ $t('Connect') }}</h3>
            <p class="description mb-4">
                {{ $t('Connecting_to_your_virtual_machine') }}.
            </p>
        </div>
        <div class="divider"></div>
        <div class="row px-0 px-lg-4 pt-4">
            <div class="col-md-12 d-flex flex-column align-items-center text-center">
                <template v-if="(system.indexOf('windows') != -1) || (system.indexOf('Windows') != -1)">
                    <p class="fs-15">
                        {{ $t('cmd_1') }}
                    </p>
                    <p class="fs-15">mstsc</p>
                </template>
                <template v-else>
                    <p class="fs-15">
                        {{ $t('cmd_title') }}
                    </p>
                    <p class="fs-16">
                        ssh root@{{ order_product_info.dedicatedip }}
                    </p>
                </template>
                <p class="fs-14 mb-0 sub-detail" style="max-width: 500px">
                    {{ $t('cmd_2') }}
                </p>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from "vue";

const props = defineProps({
    order_product_info: {
        type: Object,
    },
    system: {
        type: String,
    },
});

</script>