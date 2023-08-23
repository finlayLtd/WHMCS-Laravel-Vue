<template>
    <div class="vl-parent">
        <loading v-model:active="anlaytics_loading" :is-full-page="false" />
        <div class="row">
            <div id="cpu-container" class="col-md-6 col-sm-12">
                <Chart :key="componentKey" :data="{
                    chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                    },
                    title: {
                        text: $t('CPU_Usage'),
                        align: 'left',
                        style: {
                            color: revertColor(chart_color),
                        },
                    },
                    // chart options
                    tooltip: {
                        formatter: function () {
                            return (
                                'Time: ' +
                                Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +
                                '<br/>' +
                                $t('CPU_Usage_rate') + ':' +
                                this.y +
                                '%'
                            );
                        },
                    },
                    xAxis: {
                        type: 'datetime',
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    yAxis: {
                        title: {
                            text: $t('CPU_Usage_rate'),
                        },
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    legend: {
                        enabled: false,
                    },
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1,
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [
                                        1,
                                        Highcharts.color(
                                            Highcharts.getOptions().colors[0]
                                        )
                                            .setOpacity(0)
                                            .get('rgba'),
                                    ],
                                ],
                            },
                            marker: {
                                radius: 2,
                            },
                            lineWidth: 1,
                            states: {
                                hover: {
                                    lineWidth: 1,
                                },
                            },
                            threshold: null,
                        },
                    },

                    series: [
                        {
                            name: $t('CPU'),
                            data: cpu_data_state.map(([date, value]) => [
                                new Date(date).getTime(),
                                value,
                            ]),
                        },
                    ],
                }" v-if="cpu_data_state">
                </Chart>
            </div>
            <div id="ram-container" class="col-md-6 col-sm-12">
                <Chart :key="componentKey" :data="{
                    chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                    },
                    title: {
                        text: $t('RAM_Usage'),
                        align: 'left',
                        style: {
                            color: revertColor(chart_color),
                        },
                    },
                    // chart options
                    tooltip: {
                        formatter: function () {
                            return (
                                'Time: ' +
                                Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +
                                '<br/>' +
                                $t('RAM_Usage_rate') + ': ' +
                                this.y +
                                'MB'
                            );
                        },
                    },
                    xAxis: {
                        type: 'datetime',
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    yAxis: {
                        title: {
                            text: $t('RAM_Usage_rate'),
                        },
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    legend: {
                        enabled: false,
                    },
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1,
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [
                                        1,
                                        Highcharts.color(
                                            Highcharts.getOptions().colors[0]
                                        )
                                            .setOpacity(0)
                                            .get('rgba'),
                                    ],
                                ],
                            },
                            marker: {
                                radius: 2,
                            },
                            lineWidth: 1,
                            states: {
                                hover: {
                                    lineWidth: 1,
                                },
                            },
                            threshold: null,
                        },
                    },

                    series: [
                        {
                            name: $t('RAM'),
                            data: ram_data_state.map(([date, value]) => [
                                new Date(date).getTime(),
                                value,
                            ]),
                        },
                    ],
                }" v-if="ram_data_state">
                </Chart>
            </div>
        </div>
        <div class="row mt-2">
            <div id="disk-container" class="col-md-6 col-sm-12">
                <Chart :key="componentKey" :data="{
                    chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                    },
                    title: {
                        text: $t('Disk_Usage'),
                        align: 'left',
                        style: {
                            color: revertColor(chart_color),
                        },
                    },
                    // chart options
                    tooltip: {
                        formatter: function () {
                            return (
                                'Time: ' +
                                Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +
                                '<br/>' +
                                $t('Disk_Usage') + ': ' +
                                this.y +
                                'MB'
                            );
                        },
                    },
                    xAxis: {
                        type: 'datetime',
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    yAxis: {
                        title: {
                            text: $t('Disk_Usage'),
                        },
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    legend: {
                        enabled: false,
                    },
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1,
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [
                                        1,
                                        Highcharts.color(
                                            Highcharts.getOptions().colors[0]
                                        )
                                            .setOpacity(0)
                                            .get('rgba'),
                                    ],
                                ],
                            },
                            marker: {
                                radius: 2,
                            },
                            lineWidth: 1,
                            states: {
                                hover: {
                                    lineWidth: 1,
                                },
                            },
                            threshold: null,
                        },
                    },

                    series: [
                        {
                            name: $t('Disk'),
                            data: disk_data_state.map(([date, value]) => [
                                new Date(date).getTime(),
                                value,
                            ]),
                        },
                    ],
                }" v-if="disk_data_state">
                </Chart>
            </div>
            <div id="inode-container" class="col-md-6 col-sm-12">

                <Chart :key="componentKey" :data="{
                    chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                    },
                    title: {
                        text: $t('Inode_Information'),
                        align: 'left',
                        style: {
                            color: revertColor(chart_color),
                        },
                    },
                    // chart options
                    tooltip: {
                        formatter: function () {
                            return (
                                'Time: ' +
                                Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +
                                '<br/>' +
                                $t('Inode_Information') + ': ' +
                                this.y +
                                'Blocks'
                            );
                        },
                    },
                    xAxis: {
                        type: 'datetime',
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    yAxis: {
                        title: {
                            text: $t('Inode_Information'),
                        },
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    legend: {
                        enabled: false,
                    },
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1,
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [
                                        1,
                                        Highcharts.color(
                                            Highcharts.getOptions().colors[0]
                                        )
                                            .setOpacity(0)
                                            .get('rgba'),
                                    ],
                                ],
                            },
                            marker: {
                                radius: 2,
                            },
                            lineWidth: 1,
                            states: {
                                hover: {
                                    lineWidth: 1,
                                },
                            },
                            threshold: null,
                        },
                    },

                    series: [
                        {
                            name: $t('Inode'),
                            data: inode_data_state.map(([date, value]) => [
                                new Date(date).getTime(),
                                value,
                            ]),
                        },
                    ],
                }" v-if="inode_data_state">
                </Chart>
            </div>
        </div>
        <div class="row mt-2">
            <div id="net-in-container" class="col-md-6 col-sm-12">
                <Chart :key="componentKey" :data="{
                    chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                    },
                    title: {
                        text: $t('Network_Download_Information'),
                        align: 'left',
                        style: {
                            color: revertColor(chart_color),
                        },
                    },
                    // chart options
                    tooltip: {
                        formatter: function () {
                            return (
                                'Time: ' +
                                Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +
                                '<br/>' +
                                $t('Download_rate') + ': ' +
                                this.y +
                                'MB'
                            );
                        },
                    },
                    xAxis: {
                        type: 'datetime',
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    yAxis: {
                        title: {
                            text: $t('Download_rate'),
                        },
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    legend: {
                        enabled: false,
                    },
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1,
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [
                                        1,
                                        Highcharts.color(
                                            Highcharts.getOptions().colors[0]
                                        )
                                            .setOpacity(0)
                                            .get('rgba'),
                                    ],
                                ],
                            },
                            marker: {
                                radius: 2,
                            },
                            lineWidth: 1,
                            states: {
                                hover: {
                                    lineWidth: 1,
                                },
                            },
                            threshold: null,
                        },
                    },

                    series: [
                        {
                            name: $t('Network_Download'),
                            data: net_in_data_state.map(([date, value]) => [
                                new Date(date).getTime(),
                                value,
                            ]),
                        },
                    ],
                }" v-if="net_in_data_state">
                </Chart>
            </div>
            <div id="net-out-container" class="col-md-6 col-sm-12">
                <Chart :key="componentKey" :data="{
                    chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                    },
                    title: {
                        text: $t('Network_Upload_Information'),
                        align: 'left',
                        style: {
                            color: revertColor(chart_color),
                        },
                    },
                    // chart options
                    tooltip: {
                        formatter: function () {
                            return (
                                'Time: ' +
                                Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +
                                '<br/>' +
                                $t('Upload_rate') + ': ' +
                                this.y +
                                'MB'
                            );
                        },
                    },
                    xAxis: {
                        type: 'datetime',
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    yAxis: {
                        title: {
                            text: $t('Upload_rate'),
                        },
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    legend: {
                        enabled: false,
                    },
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1,
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [
                                        1,
                                        Highcharts.color(
                                            Highcharts.getOptions().colors[0]
                                        )
                                            .setOpacity(0)
                                            .get('rgba'),
                                    ],
                                ],
                            },
                            marker: {
                                radius: 2,
                            },
                            lineWidth: 1,
                            states: {
                                hover: {
                                    lineWidth: 1,
                                },
                            },
                            threshold: null,
                        },
                    },

                    series: [
                        {
                            name: $t('Network_Upload'),
                            data: net_out_data_state.map(([date, value]) => [
                                new Date(date).getTime(),
                                value,
                            ]),
                        },
                    ],
                }" v-if="net_out_data_state">
                </Chart>
            </div>
        </div>
        <div class="row mt-2">
            <div id="net-total-container" class="col-md-6 col-sm-12">
                <Chart :key="componentKey" :data="{
                    chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                    },
                    title: {
                        text: $t('Network_Information'),
                        align: 'left',
                        style: {
                            color: revertColor(chart_color),
                        },
                    },
                    // chart options
                    tooltip: {
                        formatter: function () {
                            return (
                                'Time: ' +
                                Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +
                                '<br/>' +
                                $t('Network_Usage_rate') + ': ' +
                                this.y +
                                'MB'
                            );
                        },
                    },
                    xAxis: {
                        type: 'datetime',
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    yAxis: {
                        title: {
                            text: $t('Network_Usage_rate'),
                        },
                        labels: {
                            style: {
                                color: revertColor(chart_color),
                            },
                        },
                    },
                    legend: {
                        enabled: false,
                    },
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1,
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [
                                        1,
                                        Highcharts.color(
                                            Highcharts.getOptions().colors[0]
                                        )
                                            .setOpacity(0)
                                            .get('rgba'),
                                    ],
                                ],
                            },
                            marker: {
                                radius: 2,
                            },
                            lineWidth: 1,
                            states: {
                                hover: {
                                    lineWidth: 1,
                                },
                            },
                            threshold: null,
                        },
                    },

                    series: [
                        {
                            name: $t('Network'),
                            data: net_total_data_state.map(([date, value]) => [
                                new Date(date).getTime(),
                                value,
                            ]),
                        },
                    ],
                }" v-if="net_total_data_state">
                </Chart>
            </div>
        </div>
    </div>
</template>
<script setup>
import { computed, onMounted, ref, onBeforeUnmount, watch, watchEffect } from "vue";
import { commonApis } from "@/apis/commonApis";
import { useStore } from "vuex";
// import useAuth from "@/composables/auth";
// import { showLoader } from "@/plugins/loading.js";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
// import { useRouter } from "vue-router";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';

import { useRoute } from "vue-router";

import Highcharts from "highcharts";
import Chart from "../Chart.vue";

const store = useStore();

const props = defineProps({
    vpsid: {
        type: String,
        default: "tertiary",
    },
});

const $toast = useToast({
    toastOptions: {
        zIndex: 99999, // set a high z-index value
    },
});

const commonApi = commonApis();

const anlaytics_loading = ref(false);
const cpu_data_state = ref([]);
const inode_data_state = ref([]);
const ram_data_state = ref([]);
const disk_data_state = ref([]);
const net_in_data_state = ref([]);
const net_out_data_state = ref([]);
const net_total_data_state = ref([]);
const chart_color = ref(document.documentElement.getAttribute('data-theme') == 'dark' ? '#1C1C1E' : '#ffffff');
const componentKey = ref(1);
const analysis_data = ref([]);

watch(() => store.state.theme.theme, (newVal, oldVal) => {
    if (newVal == 'dark') chart_color.value = '#1C1C1E';
    else chart_color.value = '#ffffff';
    componentKey.value = componentKey.value + 1;
});

const get_analysis_data = () => {
    anlaytics_loading.value = true;
    commonApi
        .runPostApi("/overview/analysis_data", {
            vpsid: props.vpsid,
        })
        .then((res) => {
            anlaytics_loading.value = false;
            if (res.data.analysis_data) {
                analysis_data.value = res.data.analysis_data;
                renderChart(analysis_data.value, "#1C1C1E");
                componentKey.value = componentKey.value + 1;
            }
        })
        .catch((e) => {
            anlaytics_loading.value = false;
            $toast.error(e);
        });
};

get_analysis_data();

function renderChart(data, color) {
    //For showing up the average download and upload speed
    var avg_download = 0;
    var avg_upload = 0;
    var avg_io_read = 0;
    var avg_io_write = 0;
    var count = 0;
    var cpu_data = new Array();
    var inode_data = new Array();
    var ram_data = new Array();
    var disk_data = new Array();
    var ntw_in_data = new Array();
    var ntw_out_data = new Array();
    var ntw_total_data = new Array();
    var io_read_data = new Array();
    var io_write_data = new Array();

    if (data) {
        data.forEach(function (val, key) {
            //Array is in format [vpsid, time, status, disk, inode, ram, cpu, net_in, net_out]
            cpu_data.push([val[1], val[6] * 1]);
            inode_data.push([val[1], val[4] * 1]);
            ram_data.push([val[1], val[5] * 1]);
            disk_data.push([val[1], val[3] * 1]);
            ntw_in_data.push([val[1], val[7] * 1]);
            ntw_out_data.push([val[1], val[8] * 1]);
            ntw_total_data.push([val[1], parseInt(val[7]) + parseInt(val[8])]);
            avg_download += parseInt(val[7]);
            avg_upload += parseInt(val[8]);
            avg_io_read += parseInt(val[9]);
            avg_io_write += parseInt(val[10]);
            count++;
        });
        // Calculating the average Downloading Speed per month
        avg_download = (avg_download / count / 1024 / 1024).toFixed(5);
        // Calculating the average Uploading Speed per month
        avg_upload = (avg_upload / count / 1024 / 1024).toFixed(5);
        // Calculating the average I/O read per month
        avg_io_read = (avg_io_read / count / 1024 / 1024).toFixed(5);
        // Calculating the average I/O write per month
        avg_io_write = (avg_io_write / count / 1024 / 1024).toFixed(5);

        cpu_data_state.value = cpu_data;
        inode_data_state.value = inode_data;
        ram_data_state.value = ram_data;
        disk_data_state.value = disk_data;
        net_in_data_state.value = ntw_in_data;
        net_out_data_state.value = ntw_out_data;
        net_total_data_state.value = ntw_total_data;
    }
}

function revertColor(color) {
    // Convert the color to RGB format
    var r = parseInt(color.substring(1, 3), 16);
    var g = parseInt(color.substring(3, 5), 16);
    var b = parseInt(color.substring(5, 7), 16);

    // Calculate the inverted color
    var invertedR = 255 - r;
    var invertedG = 255 - g;
    var invertedB = 255 - b;

    // Convert the inverted color back to hex format
    var invertedColor =
        "#" +
        invertedR.toString(16).padStart(2, "0") +
        invertedG.toString(16).padStart(2, "0") +
        invertedB.toString(16).padStart(2, "0");

    return invertedColor;
}
</script>