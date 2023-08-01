<template>
  <section class="overview">
    <div class="container">
      <div
        class="d-flex flex-column justify-content-start align-items-start title-button-wrapper"
      >
        <a ref="customLink" style="display: none;" target="_blank">Custom Link</a>
        <div class="overview-header">
          <img
            class="not-filterable"
            :src="'/assets/img/' + sys_logo + '-logo.png'"
            alt=""
            v-if="sys_logo"
          />
          <h2 class="title mb-0" v-if="order_product_info">
            {{ order_product_info.domain }}
          </h2>
        </div>
        <div class="overview-info">
          <span v-if="dayDiff > 0">{{ $t('Created') }} {{ dayDiff }} {{ $t('days_ago') }}</span>
          <span v-else>{{ $t('Created_today') }}</span>
          <div
            class="alert alert-warning mt-2"
            id="alertUnpaidInvoice"
            v-if="invoiceInfo && invoiceInfo.status == 'Unpaid'"
          >
            {{ $t('interruption') }} 
            <a
              style="color: blue; cursor: pointer"
              @click="openInvoiceWindow(invoiceInfo.invoiceid)"
              target="_blank"
              >{{ $t('Pay_Invoice') }}</a
            >
          </div>
        </div>
      </div>

      <!-- if status is ative -->
      <div
        class="sub-section server-list-tab"
        v-if="status && status == 'Active'"
      >
        <div class="row justify-content-between align-items-center">
          <div class="row mb-5 pe-0 overview-cols">
            <div class="col-xl-4 col-lg-6 col-md-6 mb-4 mb-md-0">
              <div class="card-item vm-actions">
                <div class="due-date">
                  <div class="date-image-wrapper">
                    <img src="/assets/img/calendar.svg" alt="" />
                  </div>
                  <div class="due-date-info">
                    <h2 class="due-date-title">{{ $t('Due_Date') }}</h2>
                    <span v-if="order_product_info">{{
                       order_product_info.nextduedate 
                    }}</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 mb-4 mb-md-0">
              <div class="card-item info-table">
                <table v-if="order_product_info">
                  <tbody>
                    <tr>
                      <td>{{ $t('Public_IPv4') }}</td>
                      <td class="clipboard-input">
                        {{ order_product_info.dedicatedip }}
                      </td>
                      <td>
                        <img
                          src="/assets/img/copy.svg"
                          class="icon-clipboard"
                          @click="
                            copyToClipboard(order_product_info.dedicatedip)
                          "
                        />
                      </td>
                    </tr>

                    <tr>
                      <td>{{ $t('Username') }}</td>
                      <td class="clipboard-input" v-if="sys_logo == 'windows'">
                        Administrator
                      </td>
                      <td class="clipboard-input" v-else>
                        root
                      </td>
                      <td>
                        <img
                          src="/assets/img/copy.svg"
                          class="icon-clipboard"
                          @click="copyToClipboard(order_product_info.username)"
                        />
                      </td>
                    </tr>

                    <tr>
                      <td>{{ $t('Password') }}</td>
                      <td>
                        <input
                          class="clipboard-input"
                          disabled
                          :type="(show1)?'text':'password'"
                          :value="order_product_info.password"
                        />
                      </td>
                      <td>
                        <img
                          src="/assets/img/eye-open.svg"
                          class="icon-password eye-open"
                          v-if="show1"
                          @click="show1 = !show1"
                          
                        />
                        <img
                          src="/assets/img/eye.svg"
                          class="icon-password eye-closed"
                          v-else
                          @click="show1 = !show1"
                        />
                        
                        <img
                          src="/assets/img/copy.svg"
                          class="icon-clipboard"
                          @click="copyToClipboard(order_product_info.password)"
                        />
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 mb-4 mb-md-0">
              <div class="card-item info-table">
                <table>
                  <tbody v-if="detail_info">
                    <tr>
                      <td><img src="/assets/img/cpu.png" alt="" />CPU</td>
                      <td>{{ detail_info[0] }}</td>
                      <td></td>
                    </tr>

                    <tr>
                      <td><img src="/assets/img/ram.png" alt="" />Ram</td>
                      <td>{{ detail_info[1] }}</td>
                      <td></td>
                    </tr>

                    <tr>
                      <td>
                        <img src="/assets/img/hard-disk.png" alt="" />{{ $t('Storage') }}
                      </td>
                      <td>{{ detail_info[2] }}</td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="sub-section overview-tab" v-if="status == 'Active'">
        <div class="row justify-content-between align-items-center">
          <div class="row mb-2 mb-lg-5 pe-0">
            <div class="col-md-12 d-flex justify-content-start pe-0 flex-wrap">
              <ul
                class="nav nav-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0 flex-nowrap"
                id="pills-tab"
                role="tablist"
                v-if="order_product_info"
              >
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="pills-overview-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-overview"
                    type="button"
                    role="tab"
                    aria-controls="pills-overview"
                    aria-selected="true"
                  >
                  {{ $t('Overview') }}
                  </button>
                </li>
                <li
                  class="nav-item"
                  role="presentation"
                  v-if="order_product_info.status == 'Active'"
                >
                  <button
                    class="nav-link"
                    id="pills-analytics-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-analytics"
                    type="button"
                    role="tab"
                    aria-controls="pills-analytics"
                    aria-selected="false"
                  >
                  {{ $t('Analytics') }}
                  </button>
                </li>
                <li
                  class="nav-item"
                  role="presentation"
                  v-if="order_product_info.status == 'Active'"
                >
                  <button
                    class="nav-link"
                    id="pills-connect-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-connect"
                    type="button"
                    role="tab"
                    aria-controls="pills-connect"
                    aria-selected="false"
                  >
                  {{ $t('Connect') }}
                  </button>
                </li>

                <li
                  class="nav-item"
                  role="presentation"
                  v-if="order_product_info.status == 'Active'"
                >
                  <button
                    class="nav-link"
                    id="pills-reinstall-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-reinstall"
                    type="button"
                    role="tab"
                    aria-controls="pills-reinstall"
                    aria-selected="false"
                  >
                  {{ $t('Reinstall') }}
                  </button>
                </li>

                <li
                  class="nav-item"
                  role="presentation"
                  v-if="order_product_info.status == 'Active'"
                >
                  <button
                    class="nav-link"
                    id="pills-management-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-management"
                    type="button"
                    role="tab"
                    aria-controls="pills-management"
                    aria-selected="false"
                  >
                  {{ $t('IP_Address_Management') }}
                  </button>
                </li>

                <li
                  class="nav-item"
                  role="presentation"
                  v-if="order_product_info.status == 'Active'"
                >
                  <button
                    class="nav-link"
                    id="pills-vnc-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-vnc"
                    type="button"
                    role="tab"
                    aria-controls="pills-vnc"
                    aria-selected="false"
                  >
                  {{ $t('VNC') }}
                  </button>
                </li>

                <li
                  class="nav-item"
                  role="presentation"
                  v-if="order_product_info.status == 'Active'"
                >
                  <button
                    class="nav-link"
                    id="pills-dns-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-dns"
                    type="button"
                    role="tab"
                    aria-controls="pills-dns"
                    aria-selected="false"
                  >
                  {{ $t('ReverseDNS') }}
                  </button>
                </li>

                <li
                  class="nav-item"
                  role="presentation"
                  v-if="order_product_info.status == 'Active'"
                >
                  <button
                    class="nav-link"
                    id="pills-billing-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-billing"
                    type="button"
                    role="tab"
                    aria-controls="pills-billing"
                    aria-selected="false"
                  >
                  {{ $t('Billing') }}
                  </button>
                </li>

                <li
                  class="nav-item"
                  role="presentation"
                  v-if="order_product_info.status == 'Active'"
                >
                  <button
                    class="nav-link"
                    id="pills-settings-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#pills-settings"
                    type="button"
                    role="tab"
                    aria-controls="pills-settings"
                    aria-selected="false"
                  >
                  {{ $t('Settings') }}
                  </button>
                </li>
              </ul>
            </div>
          </div>

          <div class="tab-content" id="pills-tabContent">
            <!--overview-->
            <div
              class="tab-pane fade show active"
              id="pills-overview"
              role="tabpanel"
              aria-labelledby="pills-overview-tab"
            >
              <div class="tab-inner mb-3">
                <div class="row">
                  <h3 class="title">{{ $t('Overview') }}</h3>
                  <p class="description mb-4">
                    {{ $t('Information_on_virtual_machine_usage') }}
                  </p>
                </div>
                <div class="divider"></div>
                <div class="row px-2 pt-4 px-lg-4 pt-lg-4">
                  <div class="general-info d-flex w-100 mb-3">
                    <div class="col-12 col-lg-4 col-md-12">
                      <div class="col-content-wrapper sm-border-bottom">
                        <div class="img-wrapper">
                          <img
                            class="not-filterable"
                            :src="'/assets/img/' + flag + '.png'"
                            alt=""
                          />
                        </div>
                        <div class="info">
                          <h4 class="title2">
                            {{ order_product_info.groupname }}
                          </h4>
                          <p class="description2">
                            {{ order_product_info.domain }}
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-4 col-md-12">
                      <div class="col-content-wrapper sm-border-bottom">
                        <div class="img-wrapper">
                          <img
                            class="not-filterable"
                            :src="'/assets/img/' + sys_logo + '-logo.png'"
                            alt=""
                          />
                        </div>
                        <div class="info">
                          <h4 class="title2">{{ order_product_info.name }}</h4>
                          <p class="description2">{{ system }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-4 col-md-12">
                      <div class="col-content-wrapper">
                        <div class="img-wrapper">
                          <img
                            class="dark-img-filter"
                            src="/assets/img/cloud-connection.png"
                            alt=""
                          />
                        </div>
                        <div class="info">
                          <h4 class="title2">
                            {{ order_product_info.dedicatedip }}
                          </h4>
                          <p class="description2">
                            {{ $t('Created_at') }} {{ order_product_info.regdate }}
                          </p>
                        </div>
                        <div
                          class="server-list-options me-3 me-lg-4"
                          v-if="order_product_info.status == 'Active'"
                        >
                          <button class="active-badge">
                            <span class="active-dot"></span>{{ $t('Active') }}
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div
                    class="d-flex justify-content-end px-0 server-btn-options"
                    v-if="order_product_info.status == 'Active'"
                  >
                    <button
                      class="btn img-btn me-0 me-lg-2"
                      @click="TurnOnVPS(vpsid)"
                    >
                      <i class="fa fa-play" style="color: #3fbb27"></i
                      >&nbsp;&nbsp;{{ $t('Start') }}
                    </button>
                    <button
                      class="btn img-btn me-0 me-lg-2"
                      @click="TurnOffVPS(vpsid)"
                    >
                      <img src="/assets/img/power.svg" alt="" />{{ $t('Shutdown') }}
                    </button>
                  </div>
                </div>
              </div>
              <div
                class="tab-inner"
                v-if="order_product_info.status == 'Active'"
              >
                <div class="row">
                  <h3 class="title fs-17">{{ $t('Resource_Usage') }}</h3>
                </div>
                <div class="row px-12 pt-3">
                  <div
                    class="general-info bg-white overview-col5 d-flex w-100 mb-4"
                  >
                    <div class="col-md-4 col-sm-12">
                      <div class="col-content-wrapper sm-border-bottom">
                        <div class="img-wrapper">
                          <img src="/assets/img/cpu.png" alt="" />
                        </div>
                        <div class="info">
                          <h4 class="title2">CPU</h4>
                          <p class="description2">
                            <span>{{ cpu.percent }}%</span> of
                            {{ detail_info[0] }} CPU
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                      <div class="col-content-wrapper sm-border-bottom">
                        <div class="img-wrapper">
                          <img src="/assets/img/ram.png" alt="" />
                        </div>
                        <div class="info">
                          <h4 class="title2">RAM</h4>
                          <p class="description2">
                            <span v-if="vps_info && vpsid && vps_info.vps_data">
                              <!-- {{number_format(($vps_info['vps_data'][$vpsid]['used_ram']/$vps_info['vps_data'][$vpsid]['ram'])*100, 2)}} -->
                              {{
                                (
                                  (vps_info.vps_data[vpsid].used_ram /
                                    vps_info.vps_data[vpsid].ram) *
                                  100
                                ).toFixed(2)
                              }}
                              %
                            </span>
                            of {{ detail_info[1] }}
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                      <div class="col-content-wrapper sm-border-bottom">
                        <div class="img-wrapper">
                          <img src="/assets/img/hard-disk.png" alt="" />
                        </div>
                        <div class="info">
                          <h4 class="title2">{{ $t('Storage') }}</h4>
                          <p class="description2" v-if="vps_info">
                            <span>
                              <!-- {{number_format($vps_info['vps_data'][$vpsid]['used_disk'], 2)}}  -->
                              {{
                                vps_info.vps_data[vpsid].used_disk.toFixed(2)
                              }}
                              %
                            </span>
                            of
                            {{ vps_info.vps_data[vpsid].disk }}
                            GB
                          </p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                      <div class="col-content-wrapper sm-border-bottom">
                        <div class="img-wrapper">
                          <img src="/assets/img/speedometer.png" alt="" />
                        </div>
                        <div class="info">
                          <h4 class="title2">{{ $t('Network_Speed') }}</h4>
                          <p class="description2" v-if="vps_info">
                            <span>{{ vps_info.vps_data[vpsid].used_bandwidth.toFixed(2) }}</span> Mbps
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- display when only in active state -->
            <!--analytics-->
            <div
              class="tab-pane fade"
              id="pills-analytics"
              role="tabpanel"
              aria-labelledby="pills-analytics-tab"
              v-if="order_product_info.status == 'Active'"
            >
              <div class="row">
                <div id="cpu-container" class="col-md-6 col-sm-12">
                  <Chart
                    :key="componentKey"
                    :data="{
                      chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                      },
                      title: {
                        text: 'CPU Usage',
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
                            'CPU Usage rate: ' +
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
                          text: 'CPU Usage rate',
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
                          name: 'CPU',
                          data: cpu_data_state.map(([date, value]) => [
                            new Date(date).getTime(),
                            value,
                          ]),
                        },
                      ],
                    }"
                    v-if="cpu_data_state"
                  >
                  </Chart>
                </div>
                <div id="ram-container" class="col-md-6 col-sm-12">
                  <Chart
                  :key="componentKey"
                    :data="{
                      chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                      },
                      title: {
                        text: 'RAM Usage',
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
                            'RAM Usage rate: ' +
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
                          text: 'RAM Usage rate',
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
                          name: 'RAM',
                          data: ram_data_state.map(([date, value]) => [
                            new Date(date).getTime(),
                            value,
                          ]),
                        },
                      ],
                    }"
                    v-if="ram_data_state"
                  >
                  </Chart>
                </div>
              </div>
              <div class="row mt-2">
                <div id="disk-container" class="col-md-6 col-sm-12">
                  <Chart
                  :key="componentKey"
                    :data="{
                      chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                      },
                      title: {
                        text: 'Disk Usage',
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
                            'Disk Usage rate: ' +
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
                          text: 'Disk Usage rate',
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
                          name: 'Disk',
                          data: disk_data_state.map(([date, value]) => [
                            new Date(date).getTime(),
                            value,
                          ]),
                        },
                      ],
                    }"
                    v-if="disk_data_state"
                  >
                  </Chart>
                </div>
                <div id="inode-container" class="col-md-6 col-sm-12">

                  <Chart
                  :key="componentKey"
                    :data="{
                      chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                      },
                      title: {
                        text: 'Inode Information',
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
                            'Innode Usage rate: ' +
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
                          text: 'Inode Usage rate',
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
                          name: 'Inode',
                          data: inode_data_state.map(([date, value]) => [
                            new Date(date).getTime(),
                            value,
                          ]),
                        },
                      ],
                    }"
                    v-if="inode_data_state"
                  >
                  </Chart>
                </div>
              </div>
              <div class="row mt-2">
                <div id="net-in-container" class="col-md-6 col-sm-12">
                  <Chart
                  :key="componentKey"
                    :data="{
                      chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                      },
                      title: {
                        text: 'Network Download Information',
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
                            'Download rate: ' +
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
                          text: 'Network Download rate',
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
                          name: 'Network Download',
                          data: net_in_data_state.map(([date, value]) => [
                            new Date(date).getTime(),
                            value,
                          ]),
                        },
                      ],
                    }"
                    v-if="net_in_data_state"
                  >
                  </Chart>
                </div>
                <div id="net-out-container" class="col-md-6 col-sm-12">
                  <Chart
                  :key="componentKey"
                    :data="{
                      chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                      },
                      title: {
                        text: 'Network Upload Information',
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
                            'Upload rate: ' +
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
                          text: 'Network Upload rate',
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
                          name: 'Network Upload',
                          data: net_out_data_state.map(([date, value]) => [
                            new Date(date).getTime(),
                            value,
                          ]),
                        },
                      ],
                    }"
                    v-if="net_out_data_state"
                  >
                  </Chart>
                </div>
              </div>
              <div class="row mt-2">
                <div id="net-total-container" class="col-md-6 col-sm-12">
                  <Chart
                  :key="componentKey"
                    :data="{
                      chart: {
                        type: 'area',
                        backgroundColor: chart_color,
                      },
                      title: {
                        text: 'Network Information',
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
                            'Network Usage rate: ' +
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
                          text: 'Network rate',
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
                          name: 'Network',
                          data: net_total_data_state.map(([date, value]) => [
                            new Date(date).getTime(),
                            value,
                          ]),
                        },
                      ],
                    }"
                    v-if="net_total_data_state"
                  >
                  </Chart>
                </div>
              </div>
            </div>
            <!--connect-->
            <div
              class="tab-pane fade"
              id="pills-connect"
              role="tabpanel"
              aria-labelledby="pills-connect-tab"
              v-if="order_product_info.status == 'Active'"
            >
              <div class="tab-inner mb-3">
                <div class="row">
                  <h3 class="title">{{ $t('Connect') }}</h3>
                  <p class="description mb-4">
                    {{ $t('Connecting_to_your_virtual_machine') }}.
                  </p>
                </div>
                <div class="divider"></div>
                <div class="row px-0 px-lg-4 pt-4">
                  <div
                    class="col-md-12 d-flex flex-column align-items-center text-center"
                  >
                    <template v-if="system.indexOf('windows') == -1">
                      <p class="fs-15">
                        {{ $t('cmd_title') }}
                      </p>
                      <p class="fs-16">
                        ssh root@{{ order_product_info.dedicatedip }}
                      </p>
                    </template>
                    <template v-else>
                      <p class="fs-15">
                        {{ $t('cmd_1') }}
                      </p>
                      <p class="fs-15">mstsc</p>
                    </template>
                    <p class="fs-14 mb-0 sub-detail" style="max-width: 500px">
                      {{ $t('cmd_2') }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <!--reinstall-->
            <div
              class="tab-pane fade"
              id="pills-reinstall"
              role="tabpanel"
              aria-labelledby="pills-reinstall-tab"
              v-if="order_product_info.status == 'Active'"
            >
              <div class="tab-inner mb-3">
                <div class="row">
                  <h3 class="title">{{ $t('Reinstall') }}</h3>
                  <p class="description mb-4">
                    {{ $t('Reinstall_your_Virtual_Machine') }}.
                  </p>
                </div>
                <div class="divider"></div>
                <div class="row px-0 pt-4">
                  <p class="fs-13-5">{{ $t('Select_an_Operating_System') }}</p>
                  <div class="form-group d-flex">
                    <select
                      name="oslist"
                      id="Operating-system"
                      class="form-control"
                      style="height: 40px !important; max-width: 300px"
                      v-model="selected_os_id"
                    >
                      <option
                        v-for="os in oslists"
                        :key="os.osid"
                        :value="os.osid"
                      >
                        <img
                          :src="'/assets/img/' + os.group_name + '-logo.png'"
                        />
                        {{ os.name }}
                      </option>
                    </select>

                    <input
                      id="format-disk"
                      type="checkbox"
                      class="format-disk"
                      style="
                        width: 20px;
                        height: 20px;
                        padding: 0;
                        margin-top: 10px;
                        margin-left: 20px;
                      "
                      v-model="format_disk"
                    />
                    <label for="format-disk" style="line-height: 40px"
                      >&nbsp;{{ $t('Format_Primary_Disk_Only') }}</label
                    >
                  </div>

                  <div
                    id="newPassword1"
                    class="form-group has-feedback has-success mt-3"
                  >
                    <label
                      for="inputNewPassword1-os"
                      class="col-sm-4 control-label"
                      >{{ $t('New_Password') }}</label
                    >
                    <div class="col-sm-5" style="position: relative">
                      <input
                        :type="(show2)?'text':'password'"
                        class="form-control"
                        name="newpw"
                        id="inputNewPassword1"
                        v-model="newPassword1"
                        autocomplete="off"
                      />
                      <img
                        src="/assets/img/eye-open.svg"
                        class="settings-password-img icon-password eye-open"
                        v-if="show2"
                      />
                      <img
                        src="/assets/img/eye.svg"
                        class="settings-password-img icon-password eye-closed"
                        v-else
                      />
                      <br />

                      <div class="progress" id="passwordStrengthBar">
                        <div
                          class="progress-bar progress-bar-success"
                          role="progressbar"
                          aria-valuenow="0"
                          aria-valuemin="0"
                          aria-valuemax="100"
                          :style="'width: '+passwordStrength+'%'"
                        >
                          <span class="rating"
                            >{{ $t('Password_Rating') }}: {{ passwordStrength }}%</span
                          >
                        </div>
                      </div>

                      <div class="alert alert-info" style="text-align: left">
                        <strong>{{ $t('tips_title') }}
                        </strong><br />
                        {{ $t('tips_content1') }}
                        <br />
                        {{ $t('tips_content2') }}
                        <br />{{ $t('tips_content3') }}
                      </div>
                    </div>
                  </div>
                  <div
                    id="newPassword2"
                    class="form-group has-feedback has-success"
                  >
                    <label
                      for="inputNewPassword2"
                      class="col-sm-4 control-label"
                      >{{ $t('Confirm_New_Password') }}</label
                    >
                    <div class="col-sm-5" style="position: relative">
                      <input
                        class="form-control"
                        name="confirmpw"
                        id="inputNewPassword2"
                        v-model="newPassword2"
                        autocomplete="off"
                        :type="(show3)?'text':'password'"
                      />
                      <img
                        src="/assets/img/eye-open.svg"
                        class="settings-password-img icon-password eye-open"
                        v-if="show3"
                        @click="show3 = !show3"
                      />
                      <img
                        src="/assets/img/eye.svg"
                        class="settings-password-img icon-password eye-closed"
                        @click="show3 = !show3"
                        v-else
                      />
                      
                      <div id="inputNewPassword2-os-Msg" v-if="newPassword1 != newPassword2 && newPassword1!=''">
                        <p class="help-block" id="nonMatchingPasswordResult">{{ $t('password_not_match') }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="overview-button-wrapper pt-0 mt-4">
                    <div class="col-sm-5">
                      <button
                        id="submitButton"
                        class="btn-dark px-4 me-2 hover-dark-light"
                        @click="rebuildOS(vpsid)"
                        :disabled="
                          newPassword1 != newPassword2 ||
                          newPassword1 == '' ||
                          newPassword2 == '' ||
                          selected_os_id == null ||
                          passwordStrength < 80 
                        "
                      >
                      {{ $t('Reinstall') }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--management-->
            <div
              class="tab-pane fade"
              id="pills-management"
              role="tabpanel"
              aria-labelledby="pills-management-tab"
              v-if="order_product_info.status == 'Active'"
            >
              <div class="tab-inner management mb-3">
                <div class="row">
                  <h3 class="title mb-4">{{ $t('IP_Address_Management') }}</h3>
                  <p class="description mb-4">
                    {{ $t('Virtual_Machines_IP_Address_Management') }}.
                  </p>
                </div>
                <div class="divider"></div>
                <div class="row px-0 pt-4">
                  <div
                    class="col-md-12 d-flex flex-column flex-lg-row align-items-start"
                  >
                    <div class="tab-content w-100" id="pills-tabContent">
                      <!--ipv4m-->
                      <div
                        class="tab-pane fade show active"
                        id="pills-ipv4m"
                        role="tabpanel"
                        aria-labelledby="pills-ipv4m-tab"
                      >
                        <div class="tab-inner py-0">
                          <h3 class="fs-15 mb-1">{{ $t('IP_Address_Assignment') }}</h3>
                          <p class="fs-13 mb-0 inner-sub-title">
                            {{ $t('Assign_floating_IP_address_to_VM') }}
                          </p>
                          <div class="divider my-3"></div>
                          <p class="fs-12 inner-sub-title2">
                            {{ $t('Assigned_IP_Address_List') }}
                          </p>
                          <div class="inner-table p-3">
                            <table class="w-100 table-flex-col" v-if="ip_list">
                              <tbody>
                                <tr v-for="ip in ip_list.ips" :key="ip.ip">
                                  <td>{{ ip.ip }}</td>
                                  <td v-if="ip.primary">{{ $t('Primary') }}</td>
                                  <td v-else></td>
                                  <td v-if="ip.primary">
                                    {{ $t('mainip_desc') }}
                                  </td>
                                  <td v-else></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>

                          <div class="divider my-3"></div>

                          <p class="fs-13-5">{{ $t('Choose_Primary_IP') }}</p>

                          <div class="overview-select d-inline-block mb-3">
                            <select
                              name="iplist"
                              id="primary-ip"
                              v-model="selected_ip"
                              v-if="ip_list"
                            >
                              <template
                                v-for="ip in ip_list.ips"
                                :key="ip.ipid"
                              >
                                <option v-if="ip.primary != 1" :value="ip.ipid">
                                  {{ ip.ip }}
                                </option>
                              </template>
                            </select>
                          </div>

                          <div class="overview-button-wrapper pt-0 d-flex">
                            <button
                              class="btn-dark px-4 me-2 hover-dark-light"
                              @click="assignPrimaryIp(vpsid)"
                              :disabled="selected_ip == '0.0.0.0'"
                            >
                            {{ $t('Assign_as_Primary_IP') }}
                            </button>
                          </div>

                          <p class="fs-14 mt-4 mb-2 inner-sub-title2">
                            {{ $t('ipset_desc') }}
                            
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--vnc-->
            <div
              class="tab-pane fade"
              id="pills-vnc"
              role="tabpanel"
              aria-labelledby="pills-vnc-tab"
              v-if="order_product_info.status == 'Active'"
            >
              <div class="tab-inner mb-3">
                <div class="row">
                  <h3 class="title mb-4">{{ $t('VNC') }}</h3>
                  <p class="description mb-4">
                    {{ $t('remote_desc') }}
                  </p>
                </div>
                <div class="divider"></div>
                <div class="row px-0 pt-4">
                  <div class="col-md-12 d-flex justify-content-center">
                    <div class="overview-button-wrapper pt-0">
                      <router-link :to="{ name: 'noVNC', params: { id: vpsid } }" class="btn-dark px-4 hover-dark-light" target="_blank">
                        {{ $t('Connect_VNC') }}
                      </router-link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--DNS-->
            <div
              class="tab-pane fade"
              id="pills-dns"
              role="tabpanel"
              aria-labelledby="pills-dns-tab"
              v-if="order_product_info.status == 'Active'"
            >
              <div class="tab-inner mb-3">
                <div class="row">
                  <h3 class="title mb-4">{{ $t('ReverseDNS_Management') }}</h3>
                </div>
                <div class="d-flex reverseDNSContainer">
                  <select name="iplist" id="rdns-ip" class="form-select" v-model="selected_rdns_ip" style="margin-right: 10px; margin-bottom: 10px; width: auto;">
                    <option
                      v-for="ip in ip_list.ips"
                      :key="ip.ip"
                      :value="ip.ip"
                    >
                      {{ ip.ip }}
                    </option>
                  </select>
                  <input
                    class="form-control"
                    id="dns-content"
                    type="text"
                    style="width: auto; margin-right: 10px;  margin-bottom: 10px; "
                    v-model="newDNS"
                  />
                  <button
                    class="btn-dark px-4 me-2 hover-dark-light"
                    type="submit"
                    style="padding: 0px 20px; margin-bottom: 10px; "
                    @click="addRDNS()"
                    :disabled="newDNS == '' || selected_rdns_ip == ''"
                  >
                    {{ $t('Add_Reverse_DNS') }}
                  </button>
                </div>
                <div class="support-table">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">{{ $t('ID') }}</th>
                        <th scope="col">{{ $t('IP_address') }}</th>
                        <th scope="col">{{ $t('Name') }}</th>
                        <th scope="col">{{ $t('Domain') }}</th>
                        <th scope="col">{{ $t('Action') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="rdns in rdnslist" :key="rdns.id">
                        <td>{{ rdns.id }}</td>
                        <td>{{ order_product_info.dedicatedip }}</td>
                        <td>{{ rdns.name }}</td>
                        <td>{{ rdns.content }}</td>
                        <td @click="deleteRdns(rdns.id)">
                          <i
                            class="fa fa-trash-can"
                            style="color: red; cursor: pointer"
                          ></i>
                        </td>
                      </tr>
                      <tr v-if="rdnslist.length == 0">
                        <td>id1</td>
                        <td>{{ order_product_info.dedicatedip }}</td>
                        <td>NA</td>
                        <td>NA</td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!--billing-->
            <div
              :class="
                order_product_info.status != 'Active'
                  ? 'tab-pane fade  show active'
                  : 'tab-pane fade'
              "
              id="pills-billing"
              role="tabpanel"
              aria-labelledby="pills-billing-tab"
            >
              <div class="tab-inner billing mb-3">
                <div class="row">
                  <h3 class="title mb-4">{{ $t('Billing') }}</h3>
                  <p class="description mb-4">
                    {{ $t('billing_desc') }}
                  </p>
                </div>
                <div class="divider"></div>
                <div class="row px-0 pt-4">
                  <div
                    class="col-md-12 d-flex flex-column flex-lg-row align-items-start"
                  >
                    <ul
                      class="nav nav-pills mb-3 mb-md-0 mb-lg-0 d-flex flex-column inner-tab-pills flex-nowrap sc-mobile no-border-mobile"
                      id="pills-tab"
                      role="tablist"
                    >
                      <li class="nav-item mb-2" role="presentation">
                        <button
                          class="nav-link"
                          id="pills-renew-tab"
                          data-bs-toggle="pill"
                          data-bs-target="#pills-renew"
                          type="button"
                          role="tab"
                          aria-controls="pills-renew"
                          aria-selected="false"
                        >
                        {{ $t('Renew_Service') }}
                        </button>
                      </li>

                      <li class="nav-item mb-2" role="presentation">
                        <button
                          class="nav-link active"
                          id="pills-invoices-tab"
                          data-bs-toggle="pill"
                          data-bs-target="#pills-invoices"
                          type="button"
                          role="tab"
                          aria-controls="pills-invoices"
                          aria-selected="false"
                        >
                        {{ $t('Invoice') }}
                        </button>
                      </li>

                      <li class="nav-item" role="presentation">
                        <button
                          class="nav-link"
                          id="pills-refund-tab"
                          data-bs-toggle="pill"
                          data-bs-target="#pills-refund"
                          type="button"
                          role="tab"
                          aria-controls="pills-refund"
                          aria-selected="false"
                        >
                        {{ $t('Refund') }}
                        </button>
                      </li>
                    </ul>

                    <div class="tab-content w-100" id="pills-tabContent">
                      <!--renew-->
                      <div
                        class="tab-pane fade"
                        id="pills-renew"
                        role="tabpanel"
                        aria-labelledby="pills-renew-tab"
                      >
                        <div class="tab-inner py-0 p-mb-0">
                          <h3 class="fs-15 mb-1">{{ $t('Renew_Service') }}</h3>
                          <div
                            class="divider divider-inner"
                            style="margin: 20px 0"
                          ></div>

                          <div class="tab-inner">
                            <div class="row">
                              <div class="text-center">
                                <p class="fs-14 mb-0">{{ $t('Current_Due_Date') }}</p>
                                <p class="fs-15 mb-0" style="font-weight: 500">
                                  {{ order_product_info.nextduedate }}
                                </p>

                                <div
                                  class="overview-button-wrapper d-flex flex-column align-items-center justify-content-center" v-if="invoiceInfo && invoiceInfo.status == 'Unpaid'"
                                >
                                  <button class="btn btn-primary" @click="openInvoiceWindow(invoiceInfo.invoiceid)">
                                    {{ $t('Renew_Service') }}
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>

                          <p
                            class="fs-13 mt-2 inner-sub-title"
                            style="
                              max-width: 474px;
                              text-align: center;
                              margin: 0 auto;
                              color: rgba(23, 30, 38, 0.75);
                            "
                          >
                          {{ $t('invoice_due_desc') }}
                          </p>
                        </div>
                      </div>

                      <!--invoices-->
                      <div
                        class="tab-pane fade active show"
                        id="pills-invoices"
                        role="tabpanel"
                        aria-labelledby="pills-invoices-tab"
                      >
                        <div class="tab-inner py-0 p-mb-0">
                          <div class="support-table p-0">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th scope="col">{{ $t('Invoice_ID') }}</th>
                                  <th scope="col">{{ $t('Invoice_Date') }}</th>
                                  <th scope="col">{{ $t('Due_Date') }}</th>
                                  <th scope="col">{{ $t('Date_Paid') }}</th>
                                  <th scope="col">{{ $t('Amount') }}</th>
                                  <th scope="col">{{ $t('Status') }}</th>
                                  <th scope="col" class="text-center">
                                    {{ $t('View_Invoice') }}
                                  </th>
                                </tr>
                              </thead>
                              <tbody v-if="invoiceInfo">
                                <tr>
                                  <td>{{ invoiceInfo.invoiceid }}</td>
                                  <td class="date-cell">
                                    {{ invoiceInfo.date }}
                                  </td>
                                  <td class="date-cell">
                                    {{ invoiceInfo.duedate }}
                                  </td>
                                  <td class="date-cell">
                                    {{ invoiceInfo.datepaid }}
                                  </td>
                                  <td class="remaining-cell">
                                    <span>€ {{ invoiceInfo.subtotal }}</span>
                                  </td>
                                  <td
                                    class="successful-cell"
                                    v-if="invoiceInfo.status == 'Paid'"
                                  >
                                    <span>
                                      {{ invoiceInfo.status }}
                                    </span>
                                  </td>
                                  <td
                                    class="cancelled-cell"
                                    v-else-if="invoiceInfo.status == 'Unpaid'"
                                  >
                                    <span>
                                      {{ invoiceInfo.status }}
                                    </span>
                                  </td>
                                  <td class="in-progress-cell" v-else>
                                    <span>
                                      {{ invoiceInfo.status }}
                                    </span>
                                  </td>
                                  <td class="text-center">
                                    <a
                                      @click="
                                        openInvoiceWindow(invoiceInfo.invoiceid)
                                      "
                                      target="_blank"
                                      ><img
                                        src="/assets/img/eye-open.svg"
                                        class="icon-password view-invoice"
                                    /></a>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>

                      <!--create ticket for refund-->
                      <div
                        class="tab-pane fade"
                        id="pills-refund"
                        role="tabpanel"
                        aria-labelledby="pills-refund-tab"
                      >
                        <div class="tab-inner py-0 p-mb-0">
                          <h3 class="fs-15 mb-1">{{ $t('Refund_Request') }}</h3>
                          <div
                            class="divider divider-inner"
                            style="margin: 20px 0"
                          ></div>

                          <div class="tab-inner">
                            <div class="row">
                              <div class="text-center">
                                <p class="fs-14 mb-0">
                                  {{ $t('refund_title') }}
                                </p>

                                <div
                                  class="overview-button-wrapper d-flex flex-column align-items-center justify-content-center"
                                >
                                  <button
                                    class="btn-dark px-4 hover-dark-light"
                                    id="open-ticket"
                                    @click="openModal = true"
                                  >
                                  {{ $t('Open_Ticket') }}
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>

                          <p
                            class="fs-13 mt-2 inner-sub-title"
                            style="
                              max-width: 474px;
                              text-align: center;
                              margin: 0 auto;
                              color: rgba(23, 30, 38, 0.75);
                            "
                          >
                          {{ $t('approval_terms') }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--settings-->
            <div
              class="tab-pane fade"
              id="pills-settings"
              role="tabpanel"
              aria-labelledby="pills-settings-tab"
              v-if="order_product_info.status == 'Active'"
            >
              <div class="row mb-5 pe-0">
                <div class="tab-inner settings mb-3">
                  <div class="row">
                    <h3 class="title mb-4">{{ $t('Settings') }}</h3>
                    <p class="description mb-4">
                    </p>
                  </div>
                  <div class="divider"></div>
                  <div class="row px-0 pt-4">
                    <div
                      class="col-md-12 d-flex flex-column flex-lg-row align-items-start"
                    >
                      <ul
                        class="nav nav-pills mb-3 mb-md-0 mb-lg-0 d-flex flex-column inner-tab-pills"
                        id="pills-tab"
                        role="tablist"
                      >
                        <li class="nav-item mb-2" role="presentation">
                          <button
                            class="nav-link active"
                            id="pills-password-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#pills-password"
                            type="button"
                            role="tab"
                            aria-controls="pills-password"
                            aria-selected="false"

                          >
                          {{ $t('Change_Password') }}
                          </button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button
                            class="nav-link"
                            id="pills-host-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#pills-host"
                            type="button"
                            role="tab"
                            aria-controls="pills-host"
                            aria-selected="false"
                          >
                          {{ $t('Change_Hostname') }}
                          </button>
                        </li>
                      </ul>

                      <div class="tab-content w-100" id="pills-tabContent">
                        <!--password-->
                        <div
                          class="tab-pane fade show active"
                          id="pills-password"
                          role="tabpanel"
                          aria-labelledby="pills-password-tab"
                        >
                          <div class="tab-inner py-0 p-mb-0">
                            <h3 class="fs-15 mb-1">{{ $t('Change_Password') }}</h3>
                            <div class="divider" style="margin: 20px 0"></div>
                            <div
                              id="newPassword1-os"
                              class="form-group has-feedback has-success mt-3"
                            >
                              <label
                                for="inputNewPassword1-os"
                                class="col-sm-4 control-label"
                                >{{ $t('New_Server_Password') }}</label
                              >
                              <div class="col-sm-5" style="position: relative">
                                <input
                                  :type="(show2)?'text':'password'"
                                  class="form-control"
                                  name="newpw"
                                  id="inputNewPassword1-os"
                                  autocomplete="off"
                                  v-model="newPassword1"
                                />
                                <img
                                  src="/assets/img/eye-open.svg"
                                  class="settings-password-img icon-password eye-open"
                                  v-if="show2"
                                  @click="show2 = !show2"
                                />
                                <img
                                  src="/assets/img/eye.svg"
                                  class="settings-password-img icon-password eye-closed"
                                  v-else
                                  @click="show2 = !show2"
                                />
                                <br />

                                <div
                                  class="progress"
                                  id="passwordStrengthBar-os"
                                >
                                  <div
                                    class="progress-bar progress-bar-success"
                                    role="progressbar"
                                    aria-valuenow="0"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                    :style="'width: '+passwordStrength+'%'"
                                  >
                                    <span class="rating"
                                      >{{ $t('Password_Rating') }}: {{ passwordStrength }}%</span
                                    >
                                  </div>
                                </div>

                                <div class="alert alert-info" style="text-align: left">
                                  <strong>{{ $t('tips_title') }}
                                  </strong><br />
                                  {{ $t('tips_content1') }}
                                  <br />
                                  {{ $t('tips_content2') }}
                                  <br />{{ $t('tips_content3') }}
                                </div>
                              </div>
                            </div>
                            <div
                              id="newPassword2-os"
                              class="form-group has-feedback has-success"
                            >
                              <label
                                for="inputNewPassword2-os"
                                class="col-sm-4 control-label"
                                >{{ $t('Confirm_New_Password') }}</label
                              >
                              <div class="col-sm-5" style="position: relative">
                                <input
                                  :type="(show3)?'text':'password'"
                                  class="form-control"
                                  name="confirmpw"
                                  id="inputNewPassword2-os"
                                  autocomplete="off"
                                  v-model="newPassword2"
                                />
                                <img
                                  src="/assets/img/eye-open.svg"
                                  class="settings-password-img icon-password eye-open"
                                  @click="show3 = !show3"
                                  v-if="show3"
                                />
                                <img
                                  src="/assets/img/eye.svg"
                                  class="settings-password-img icon-password eye-closed"
                                  @click="show3 = !show3"
                                  v-else
                                />
                                
                                <div id="inputNewPassword2-os-Msg" v-if="newPassword1 != newPassword2 && newPassword1!=''">
                                  <p class="help-block" id="nonMatchingPasswordResult">{{ $t('password_not_match') }}</p>
                                </div>
                              </div>
                            </div>
                            <div class="overview-button-wrapper pt-0 mt-4">
                              <div class="col-sm-5">
                                <button
                                  id="submitButtonOS"
                                  class="btn-dark px-4 me-2 hover-dark-light"
                                  @click="changePWD(vpsid)"
                                  :disabled = "newPassword1 != newPassword2 || newPassword1=='' || newPassword2=='' || passwordStrength < 80"
                                >
                                {{ $t('Change_Password') }}
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!--host-->
                        <div
                          class="tab-pane fade"
                          id="pills-host"
                          role="tabpanel"
                          aria-labelledby="pills-host-tab"
                        >
                          <div class="tab-inner py-0 p-mb-0">
                            <h3 class="fs-15 mb-1">{{ $t('Change_Hostname') }}</h3>

                            <div class="divider" style="margin: 20px 0"></div>

                            <p class="fs-13-5">{{ $t('New_hostname') }}</p>

                            <div class="overview-input mb-4">
                              <input
                                type="text"
                                placeholder="Write new hostname"
                                id="hostname"
                                v-model="hostname"
                              />
                              <div id="inputHostNameMsg"></div>
                            </div>

                            <div class="overview-button-wrapper pt-0 mb-4">
                              <button
                                class="btn-dark px-4 me-2 hover-dark-light"
                                @click="changeHostName(vpsid)"
                                :disabled = "hostname==''"
                              >
                              {{ $t('Change_Hostname') }}
                              </button>
                            </div>
                            <p class="fs-13-5 mb-0 inner-sub-title">
                              {{ $t('changed_hostname') }}
                              
                            </p>
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
      </div>

      <!-- if status is not active -->
      <div
        class="alert alert-warning mt-2"
        id="alertUnpaidInvoice"
        v-if="status != 'Active'"
      >
      {{ $t('not_activated') }}
        
      </div>

      <div class="support-table" v-if="status != 'Active'">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">{{ $t('Invoice_ID') }}</th>
              <th scope="col">{{ $t('Invoice_Date') }}</th>
              <th scope="col">{{ $t('Due_Date') }}</th>
              <th scope="col">{{ $t('Date_Paid') }}</th>
              <th scope="col">{{ $t('Amount') }}</th>
              <th scope="col">{{ $t('Status') }}</th>
              <th scope="col" class="text-center">
                {{ $t('View_Invoice') }}
              </th>
            </tr>
          </thead>
          <tbody v-if="invoiceInfo">
            <tr>
              <td>{{ invoiceInfo.invoiceid }}</td>
              <td class="date-cell">{{ invoiceInfo.date }}</td>
              <td class="date-cell">{{ invoiceInfo.duedate }}</td>
              <td class="date-cell">{{ invoiceInfo.datepaid }}</td>
              <td class="remaining-cell">
                <span>€ {{ invoiceInfo.subtotal }}</span>
              </td>
              <td class="successful-cell" v-if="invoiceInfo.status == 'Paid'">
                <span>
                  {{ invoiceInfo.status }}
                </span>
              </td>
              <td
                class="cancelled-cell"
                v-else-if="invoiceInfo.status == 'Unpaid'"
              >
                <span>
                  {{ invoiceInfo.status }}
                </span>
              </td>
              <td class="in-progress-cell" v-else>
                <span>
                  {{ invoiceInfo.status }}
                </span>
              </td>
              <td class="text-center">
                <a
                  @click="openInvoiceWindow(invoiceInfo.invoiceid)"
                  target="_blank"
                >
                  <img
                    src="/assets/img/eye-open.svg"
                    class="icon-password view-invoice"
                  />
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- modal -->
    <div class="modal modal-ticket" v-if="openModal">
      <div class="modal-inner">
        <div class="modal-close" @click="openModal = false">
          <img class="close-dark" src="/assets/img/close.svg" alt="" />
          <img class="close-light" src="/assets/img/close-light.svg" alt="" />
        </div>
        <div class="modal-content">
          <div class="modal-header">
            <div class="modal-title">
              <h2>{{ $t('New_ticket') }}</h2>
              <h3>{{ $t('Create_new_ticket_now.') }}</h3>
            </div>
          </div>
          <div class="modal-main">
            <div class="amounts">
              <!-- <form id="openTicket" enctype="multipart/form-data" method="POST" action="{{route('ticket.open"> -->
              <h4>{{ $t('Subject') }}</h4>
              <input
                class="mb-3"
                name="subject"
                type="text"
                placeholder="Write subject"
                v-model="subject"
              />

              <h4>{{ $t('Describe_the_problem') }}</h4>
              <textarea
                class="mb-3"
                name="message"
                id=""
                cols="30"
                rows="8"
                v-model="message"
              ></textarea>

              <h4>{{ $t('Department') }}*</h4>
              <select name="department" id="department" v-model="selectedDepartment">
                <option
                  v-for="department in departments"
                  :key="department.id"
                  :value="department.id"
                >
                  {{ department.name }}
                </option>
              </select>

                <h4>{{ $t('Service_related') }}</h4>
                <select name="service" id="service" v-model="selectedService">
                  <option value="0">- None -</option>
                  <option :value="selectedService">{{ $t('Current_Vps_Service') }}</option>
                </select>

              <button class="btn-dark d-block w-100 mt-5" id="create-ticket" :disabled="subject=='' || selectedDepartment==0" @click="createTicket()">
                {{ $t('Create_Ticket') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, ref, onBeforeUnmount, watch, watchEffect } from "vue";
import { commonApis } from "@/apis/commonApis";
import { useStore } from "vuex";
import useAuth from "@/composables/auth";
import { showLoader } from "@/plugins/loading.js";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useRouter } from "vue-router";

import { useRoute } from "vue-router";

import Highcharts from "highcharts";

import Chart from "./Chart.vue";
const customLink = ref(null);
const store = useStore();
const cpu_data_state = ref([]);
const inode_data_state = ref([]);
const ram_data_state = ref([]);
const disk_data_state = ref([]);
const net_in_data_state = ref([]);
const net_out_data_state = ref([]);
const net_total_data_state = ref([]);
const theme_state = computed(() => store.getters["theme/theme"]);
const chart_color = ref(document.documentElement.getAttribute('data-theme') == 'dark' ? '#1C1C1E' : '#ffffff');
const componentKey = ref(1);

watch(() => store.state.theme.theme, (newVal, oldVal) => {
  if(newVal == 'dark') chart_color.value = '#1C1C1E';
  else chart_color.value = '#ffffff';
  componentKey.value = componentKey.value +1;
});

const route = useRoute();

const router = useRouter();
const $toast = useToast({
  toastOptions: {
    zIndex: 99999, // set a high z-index value
  },
});

const commonApi = commonApis();
const openModal = ref(false);

// eye show
const show1 = ref(false);
const show2 = ref(false);
const show3 = ref(false);


const user = computed(() => store.state.auth.user);

const analysis_data = ref([]);
const relid = ref(null);
const order_id = ref(null);
const order_product_info = ref([]);
const dayDiff = ref(null);
const detail_info = ref([]);
const flag = ref(null);
const sys_logo = ref("windows");
const system = ref(null);
const vpsid = ref(0);
const vps_info = ref(null);
const oslists = ref([]);
const cpu = ref(null);
const invoiceInfo = ref(null);
const departments = ref([]);
const ip_list = ref(null);
const status = ref("Active");
const rdnslist = ref(null);

// selected Values
const format_disk = ref(false);
const selected_os_id = ref(null);
const newPassword1 = ref("");
const newPassword2 = ref("");
const selected_ip = ref("0.0.0.0");
const newDNS = ref("");
const selected_rdns_ip = ref("");
const selected_rdns_id = ref(null);

// for creating tickets
const selectedService = ref(0);
const selectedDepartment = ref(0);
const subject = ref('Refund request');
const message = ref('I want to cancel this service.');

// settings
const hostname = ref('');

const params = ref({
  client_id: user.value.client_id,
});

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

function copyToClipboard(text) {
  // Copy the generated hostname to the clipboard
  var copyTextarea = document.createElement("textarea");
  copyTextarea.value = text;
  document.body.appendChild(copyTextarea);
  copyTextarea.select();
  document.execCommand("copy");
  document.body.removeChild(copyTextarea);
  $toast.success("Copied");
}

function TurnOnVPS(vpsid) {
  showLoader(true);
  commonApi
    .runPostApi("/overview/turnon", {
      vpsid: vpsid,
    })
    .then((res) => {
      showLoader(false);
      if (res.status == 200) {
        $toast.success("VPS has been started successfully");
      } else {
        $toast.error(res.data);
      }
    })
    .catch((e) => {
      showLoader(false);
      $toast.error(e);
    });
}

function TurnOffVPS(vpsid) {
  showLoader(true);
  commonApi
    .runPostApi("/overview/turnoff", {
      vpsid: vpsid,
    })
    .then((res) => {
      showLoader(false);
      if (res.status == 200) {
        $toast.success("Shutdown signal has been sent to the VPS");
      } else {
        $toast.error(res.data);
      }
    })
    .catch((e) => {
      showLoader(false);
      $toast.error(e);
    });
}

function assignPrimaryIp(vpsid) {
  var reorder_ips = [];
  var iplist = ip_list.value.ips;

  var ipid = selected_ip.value;
  const index = iplist.findIndex((obj) => obj.ipid === ipid);
  if (index > -1) {
    const obj = iplist.splice(index, 1)[0];
    iplist.unshift(obj);
  }

  iplist.forEach(function (element) {
    reorder_ips.push(element.ip);
  });

  showLoader(true);
  commonApi
    .runPostApi("/overview/changeip", {
      vpsid: vpsid,
      reorder_ips: reorder_ips,
    })
    .then((res) => {
      showLoader(false);
      if (res.status == 200) {
        $toast.success(
          "Your IP settings have been saved.Your IP settings will be changed when the VPS is booted again"
        );
      } else {
        $toast.error(res.data);
      }
    })
    .catch((e) => {
      showLoader(false);
      $toast.error(e);
    });
}

function changeHostName(vpsid) {
  showLoader(true);
  commonApi
    .runPostApi("/overview/checkhostName", {
      hostname: hostname.value
    })
    .then((res) => {
      if(res.data== 'Already Exist.'){
        showLoader(false);
        $toast.error('Inputed New hostname already exist');
      } else{
        commonApi
          .runPostApi("/overview/changehostName", {
            vpsid: vpsid,
            hostname: hostname.value
          })
          .then((res) => {
            showLoader(false);
            if (res.status == 200) {
              $toast.success("Your hostname will be changed when the VPS is booted again");
            } else {
              $toast.error(res.data);
            }
          })
          .catch((e) => {
            showLoader(false);
            $toast.error(e);
          });
      }
    })
    .catch((e) => {
      showLoader(false);
      $toast.error(e);
    });
}

function rebuildOS(vpsid) {
  showLoader(true);
  commonApi
    .runPostApi("/overview/rebuild", {
      vpsid: vpsid,
      format_disk_flag: format_disk.value,
      selected_osid: selected_os_id.value,
      root_pwd: newPassword1.value,
    })
    .then((res) => {
      showLoader(false);
      if (res.status == 200) {
        $toast.success(
          "VPS is being rebuilt, hence no actions are allowed to be performed on this VPS"
        );
      } else {
        $toast.error(res.data);
      }
    })
    .catch((e) => {
      showLoader(false);
      $toast.error(e);
    });
}

function changePWD(vpsid) {
  showLoader(true);
  commonApi
    .runPostApi("/overview/changepwd", {
      vpsid: vpsid,
      root_pwd: newPassword1.value,
    })
    .then((res) => {
      showLoader(false);
      if (res.status == 200) {
        $toast.success("VPS password will be changed after you SHUTDOWN and START the VPS from the panel.");
      } else {
        $toast.error(res.data);
      }
    })
    .catch((e) => {
      showLoader(false);
      $toast.error(e);
    });
}

function addRDNS() {
  showLoader(true);
  commonApi
    .runPostApi("/overview/addrdns", {
      ip: selected_rdns_ip.value,
      domain: newDNS.value,
    })
    .then((res) => {
      showLoader(false);
      if (res.status == 200) {
        $toast.success("Added successfully");
        rdnslist.value = res.data.rdnslist;
      } else {
        $toast.error(res.data);
      }
    })
    .catch((e) => {
      showLoader(false);
      $toast.error(e);
    });
}

function deleteRdns(id) {
  showLoader(true);
  commonApi
    .runPostApi("/overview/deleterdns", {
      ip: selected_rdns_ip.value,
      rdns_record_id: id,
    })
    .then((res) => {
      showLoader(false);
      if (res.status == 200) {
        $toast.success("Deleted successfully");
        rdnslist.value = res.data.rdnslist;
      } else {
        $toast.error(res.data);
      }
    })
    .catch((e) => {
      showLoader(false);
      $toast.error(e);
    });
}

const createTicket = () => {
  showLoader(true);

  commonApi
    .runPostApi("/ticket-create", {
      subject: subject.value,
      message: message.value,
      department: selectedDepartment.value,
      service: selectedService.value,
    })
    .then((res) => {
      showLoader(false);
      if (res.data.result == "success") {
        $toast.success("Successfully created ticket!");
		openModal.value = false;
      } else $toast.warning("Cannot connect to whmcs api.");
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

const getOverviewData = () => {
  showLoader(true);
  commonApi
    .runPostApi("/overview", {
      id: route.params.id,
    })
    .then((res) => {
      showLoader(false);
      analysis_data.value = res.data.analysis_data;
      relid.value = res.data.relid;
      selectedService.value = res.data.relid;
      order_id.value = res.data.order_id;
      order_product_info.value = res.data.order_product_info;
      dayDiff.value = res.data.dayDiff;
      detail_info.value = res.data.detail_info;
      flag.value = res.data.flag;
      sys_logo.value = res.data.sys_logo;
      system.value = res.data.system;
      vpsid.value = res.data.vpsid;
      vps_info.value = res.data.vps_info;
      oslists.value = res.data.oslists;
      if(oslists.value && oslists.value.length !=0) selected_os_id.value = res.data.oslists[0].osid;
      cpu.value = res.data.cpu;

      invoiceInfo.value = res.data.invoiceInfo;
      departments.value = res.data.departments;
      if(departments.value && departments.value.length !=0) selectedDepartment.value = res.data.departments[0].id;
      ip_list.value = res.data.ip_list;
      status.value = res.data.status;
      rdnslist.value = res.data.rdnslist;

      selected_rdns_ip.value = order_product_info.value.dedicatedip;

      // render
      renderChat(analysis_data.value, "#1C1C1E");
    })
    .catch((e) => {
      showLoader(false);
      console.log(e);
    });
};

getOverviewData();

function ucfirst(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

function renderChat(data, color) {
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
      // io_read_data.push([val[1], val[9] * 1]);
      // io_write_data.push([val[1], val[10] * 1]);
      // Display the average speed of available data
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

const passwordStrength = computed(() => {
  var pwStrengthErrorThreshold = 50;
    var pwStrengthWarningThreshold = 75;

			var pw = newPassword1.value;

			// Check if the password contains any disallowed special symbols
  if (/[^A-Za-z0-9!@]/.test(pw)) {
    // Set password strength to 0 if disallowed special symbols are found
    return 10;
  }

			// Update the previous password value

			var pwlength = (pw.length);
			if (pwlength > 7) pwlength = 5;
			else pwlength = 2;

			var numnumeric = pw.replace(/[0-9]/g, "");
			var numeric = (pw.length - numnumeric.length);
			if (numeric > 3) numeric = 3;

			// Update the regular expression to only match "!" and "@"
			var symbols = pw.replace(/[!@]/g, "");
			var numsymbols = (pw.length - symbols.length);
			if (numsymbols > 3) numsymbols = 3;

			var numupper = pw.replace(/[A-Z]/g, "");
			var upper = (pw.length - numupper.length);
			if (upper > 3) upper = 3;
			var pwstrength = ((pwlength * 10) - 20) + (numeric * 10) + (numsymbols * 15) + (upper * 10);
			if (pwstrength < 0) pwstrength = 0;
			if (pwstrength > 100) pwstrength = 100;
  
        return pwstrength;
});


</script>

<style scoped>

@media screen and (max-width: 767px) {
    .reverseDNSContainer {
      display: block !important;
      /* Your styles here */
    }
  }
</style>
