import{N as le,H as ce,I as de,_ as ue,f as w,B as pe,b as me,d as _e,r as ve,o as d,c as u,a as F,m as he,h as s,t as r,l as N,F as O,s as z,y as G,i as W,j as X,x as ge,p as fe,q as be}from"./app-77f58f2c.js";import{c as ye}from"./commonApis-55ba6f04.js";import{P as we}from"./Pagination-8fbba9da.js";import{N as ke}from"./NoPermission-ae3dbda3.js";var J={exports:{}};(function(x,H){(function(M,f){x.exports=f(le)})(ce,k=>(()=>{var M={657:(e,a)=>{Object.defineProperty(a,"__esModule",{value:!0}),a.default=(i,h)=>{const b=i.__vccOpts||i;for(const[B,L]of h)b[B]=L;return b}},976:e=>{e.exports=k}},f={};function m(e){var a=f[e];if(a!==void 0)return a.exports;var i=f[e]={exports:{}};return M[e](i,i.exports,m),i.exports}m.d=(e,a)=>{for(var i in a)m.o(a,i)&&!m.o(e,i)&&Object.defineProperty(e,i,{enumerable:!0,get:a[i]})},m.o=(e,a)=>Object.prototype.hasOwnProperty.call(e,a),m.r=e=>{typeof Symbol<"u"&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})};var P={};return(()=>{m.r(P),m.d(P,{Component:()=>D,LoadingPlugin:()=>ae,default:()=>ie,useLoading:()=>U});var e=m(976);function a(t){var l;typeof t.remove<"u"?t.remove():(l=t.parentNode)==null||l.removeChild(t)}function i(t,l,g){let v=arguments.length>3&&arguments[3]!==void 0?arguments[3]:{};const S=(0,e.h)(t,l,v),_=document.createElement("div");return _.classList.add("vld-container"),g.appendChild(_),(0,e.render)(S,_),S.component}function h(){return typeof window<"u"}const b=h()?window.HTMLElement:Object,B=["aria-busy"],L={class:"vl-icon"};function A(t,l,g,v,S,_){return(0,e.openBlock)(),(0,e.createBlock)(e.Transition,{name:t.transition},{default:(0,e.withCtx)(()=>[(0,e.withDirectives)((0,e.createElementVNode)("div",{tabindex:"0",class:(0,e.normalizeClass)(["vl-overlay vl-active",{"vl-full-page":t.isFullPage}]),"aria-busy":t.isActive,"aria-label":"Loading",style:(0,e.normalizeStyle)({zIndex:t.zIndex})},[(0,e.createElementVNode)("div",{class:"vl-background",onClick:l[0]||(l[0]=(0,e.withModifiers)(function(){return t.cancel&&t.cancel(...arguments)},["prevent"])),style:(0,e.normalizeStyle)(t.bgStyle)},null,4),(0,e.createElementVNode)("div",L,[(0,e.renderSlot)(t.$slots,"before"),(0,e.renderSlot)(t.$slots,"default",{},()=>[((0,e.openBlock)(),(0,e.createBlock)((0,e.resolveDynamicComponent)(t.loader),{color:t.color,width:t.width,height:t.height},null,8,["color","width","height"]))]),(0,e.renderSlot)(t.$slots,"after")])],14,B),[[e.vShow,t.isActive]])]),_:3},8,["name"])}const E={mounted(){this.enforceFocus&&document.addEventListener("focusin",this.focusIn)},methods:{focusIn(t){if(!this.isActive||t.target===this.$el||this.$el.contains(t.target))return;let l=this.container?this.container:this.isFullPage?null:this.$el.parentElement;(this.isFullPage||l&&l.contains(t.target))&&(t.preventDefault(),this.$el.focus())}},beforeUnmount(){document.removeEventListener("focusin",this.focusIn)}},o=["width","height","stroke"],C=[(0,e.createStaticVNode)('<g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="2"><circle stroke-opacity=".25" cx="18" cy="18" r="18"></circle><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.8s" repeatCount="indefinite"></animateTransform></path></g></g>',1)];function n(t,l,g,v,S,_){return(0,e.openBlock)(),(0,e.createElementBlock)("svg",{viewBox:"0 0 38 38",xmlns:"http://www.w3.org/2000/svg",width:t.width,height:t.height,stroke:t.color},C,8,o)}const $=(0,e.defineComponent)({name:"spinner",props:{color:{type:String,default:"#000"},height:{type:Number,default:64},width:{type:Number,default:64}}});var y=m(657);const j=(0,y.default)($,[["render",n]]),p=["fill","width","height"],K=[(0,e.createStaticVNode)('<circle cx="15" cy="15" r="15"><animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate><animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate></circle><circle cx="60" cy="15" r="9" fill-opacity="0.3"><animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate><animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate></circle><circle cx="105" cy="15" r="15"><animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate><animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate></circle>',3)];function Q(t,l,g,v,S,_){return(0,e.openBlock)(),(0,e.createElementBlock)("svg",{viewBox:"0 0 120 30",xmlns:"http://www.w3.org/2000/svg",fill:t.color,width:t.width,height:t.height},K,8,p)}const R=(0,e.defineComponent)({name:"dots",props:{color:{type:String,default:"#000"},height:{type:Number,default:240},width:{type:Number,default:60}}}),Y=(0,y.default)(R,[["render",Q]]),Z=["height","width","fill"],ee=[(0,e.createStaticVNode)('<rect x="0" y="13" width="4" height="5"><animate attributeName="height" attributeType="XML" values="5;21;5" begin="0s" dur="0.6s" repeatCount="indefinite"></animate><animate attributeName="y" attributeType="XML" values="13; 5; 13" begin="0s" dur="0.6s" repeatCount="indefinite"></animate></rect><rect x="10" y="13" width="4" height="5"><animate attributeName="height" attributeType="XML" values="5;21;5" begin="0.15s" dur="0.6s" repeatCount="indefinite"></animate><animate attributeName="y" attributeType="XML" values="13; 5; 13" begin="0.15s" dur="0.6s" repeatCount="indefinite"></animate></rect><rect x="20" y="13" width="4" height="5"><animate attributeName="height" attributeType="XML" values="5;21;5" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate><animate attributeName="y" attributeType="XML" values="13; 5; 13" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate></rect>',3)];function te(t,l,g,v,S,_){return(0,e.openBlock)(),(0,e.createElementBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 30 30",height:t.height,width:t.width,fill:t.color},ee,8,Z)}const se=(0,e.defineComponent)({name:"bars",props:{color:{type:String,default:"#000"},height:{type:Number,default:40},width:{type:Number,default:40}}}),ne={Spinner:j,Dots:Y,Bars:(0,y.default)(se,[["render",te]])},oe=(0,e.defineComponent)({name:"VueLoading",mixins:[E],props:{active:Boolean,programmatic:Boolean,container:[Object,Function,b],isFullPage:{type:Boolean,default:!0},enforceFocus:{type:Boolean,default:!0},lockScroll:Boolean,transition:{type:String,default:"fade"},canCancel:Boolean,onCancel:{type:Function,default:()=>{}},color:String,backgroundColor:String,opacity:Number,width:Number,height:Number,zIndex:Number,loader:{type:String,default:"spinner"}},components:ne,emits:["hide","update:active"],data(){return{isActive:this.active}},mounted(){document.addEventListener("keyup",this.keyPress)},methods:{cancel(){!this.canCancel||!this.isActive||(this.hide(),this.onCancel.apply(null,arguments))},hide(){this.$emit("hide"),this.$emit("update:active",!1),this.programmatic&&(this.isActive=!1,setTimeout(()=>{const t=this.$el.parentElement;(0,e.render)(null,t),a(t)},150))},disableScroll(){this.isFullPage&&this.lockScroll&&document.body.classList.add("vl-shown")},enableScroll(){this.isFullPage&&this.lockScroll&&document.body.classList.remove("vl-shown")},keyPress(t){t.keyCode===27&&this.cancel()}},watch:{active(t){this.isActive=t},isActive(t){t?this.disableScroll():this.enableScroll()}},computed:{bgStyle(){return{background:this.backgroundColor,opacity:this.opacity}}},beforeUnmount(){document.removeEventListener("keyup",this.keyPress)}}),D=(0,y.default)(oe,[["render",A]]);function U(){let t=arguments.length>0&&arguments[0]!==void 0?arguments[0]:{},l=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};return{show(){let g=arguments.length>0&&arguments[0]!==void 0?arguments[0]:t,v=arguments.length>1&&arguments[1]!==void 0?arguments[1]:l;const _={...t,...g,...{programmatic:!0,lockScroll:!0,isFullPage:!1,active:!0}};let q=_.container;_.container||(q=document.body,_.isFullPage=!0);const re={...l,...v};return{hide:i(D,_,q,re).ctx.hide}}}}const ae=function(t){let l=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},g=arguments.length>2&&arguments[2]!==void 0?arguments[2]:{};const v=U(l,g);t.config.globalProperties.$loading=v,t.provide("$loading",v)},ie=D})(),P})())})(J);var Ce=J.exports;const $e=de(Ce);const I=x=>(fe("data-v-3db0eab0"),x=x(),be(),x),Se={class:"sub-section server-list-tab vl-parent"},Ne=I(()=>s("div",{class:"d-flex justify-content-between align-items-center title-button-wrapper"},null,-1)),xe={class:"row justify-content-between align-items-center"},Pe={class:"row mb-5 pe-0"},Be={class:"col-md-3 sub-title"},Le={class:"col-md-9 d-flex justify-content-end pe-0 flex-wrap"},Me={class:"sort-servers order-2 order-md-1"},Ae={key:0,class:"sorting-items"},Ee={class:"nav nav-pills four-pills mb-3 mb-md-0 order-1 order-md-2 mb-lg-0 flex-nowrap",id:"pills-tab",role:"tablist"},je=["id","data-bs-target","aria-controls","aria-selected","onClick"],Fe={key:0,class:"tab-content",id:"pills-tabContent"},Te=["id","aria-labelledby"],Ie={class:"row mb-5"},Ve={class:"card-item p-4 mb-4"},De={class:"server-list-item"},Oe={class:"server-list-item-wrapper"},ze={class:"image-wrapper"},Xe=["src"],He={class:"list-item-detail"},Ue={class:"list-name"},qe={class:"detail"},Ge={key:0,class:"server-list-options"},We=I(()=>s("div",{class:"options-toggle dropdown-toggle hideIcon",style:{"padding-right":"10px","padding-left":"10px"},"data-bs-toggle":"dropdown"},null,-1)),Je={class:"options-toggle-dropdown dropdown-menu dropdown-menu-end"},Ke={key:0,class:"server-list-item"},Qe={class:"server-list-item-wrapper"},Re=I(()=>s("div",{class:"image-wrapper"},[s("img",{class:"dark-img-filter",src:"assets/img/cloud-connection.png",alt:""})],-1)),Ye={class:"list-item-detail"},Ze={class:"list-name"},et={class:"detail"},tt={class:"detail",style:{"margin-top":"5px"}},st={key:0,class:"server-list-options"},nt={class:"active-badge"},ot=I(()=>s("span",{class:"active-dot"},null,-1)),at={class:"server-list-item"},it={class:"server-list-item-wrapper"},rt={class:"image-wrapper"},lt=["src"],ct={class:"list-item-detail"},dt={class:"list-name"},ut={class:"detail"},pt={key:1},mt={style:{"margin-top":"20px","text-align":"center"}},_t={class:"w-100 server-list-pagination"},T=9,vt={__name:"services",setup(x){w(0);function H(o){let c=a.value;const C=(i.value.page-1)*T,n=C+T;return c[o].slice(C,n)}pe.useToast();const k=w(!1),M=me(),f=_e(()=>M.state.auth.user),m=ye(),P=w([]),e=w([]),a=w([]),i=w({client_id:f.value.client_id,orderby:"",order:"",page:1}),h=w(!1),b=w(1);function B(o){i.value.page=o}const L=o=>{let c=a.value;b.value=Math.ceil(c[o].length/T)},A=()=>{h.value=!0,m.runGetApi("/servers",i.value).then(o=>{h.value=!1,k.value=!1,P.value=o.data.products,e.value=o.data.states,a.value=o.data.state_order;let c=a.value;b.value=Math.ceil(c.Active.length/T)}).catch(o=>{console.log(o),h.value=!1})};function E(o,c){i.value.orderby=o,A()}return A(),(o,c)=>{const C=ve("router-link");return d(),u("div",Se,[F(he($e),{active:h.value,"onUpdate:active":c[0]||(c[0]=n=>h.value=n),"is-full-page":!1},null,8,["active"]),Ne,s("div",xe,[s("div",Pe,[s("h3",Be,r(o.$t("services_title")),1),s("div",Le,[s("div",Me,[s("div",{id:"toggleButton",class:"sort-item-active btn-chevron chevron-dark",onClick:c[1]||(c[1]=n=>k.value=!k.value)},[s("span",null,r(o.$t("Sort_by_name")),1)]),k.value?(d(),u("div",Ae,[s("ul",null,[s("li",{onClick:c[2]||(c[2]=n=>E("regdate"))},r(o.$t("Created_date")),1),s("li",{onClick:c[3]||(c[3]=n=>E("nextduedate"))},r(o.$t("Expiration_date")),1)])])):N("",!0)]),s("ul",Ee,[(d(!0),u(O,null,z(e.value,n=>{var $;return d(),u("li",{key:n,class:"nav-item",role:"presentation"},[($=a.value)!=null&&$[n]&&n!="Fraud"?(d(),u("button",{key:0,class:G(["nav-link",n==="Active"?"active":""]),id:"pills-"+n+"-tab","data-bs-toggle":"pill","data-bs-target":"#pills-"+n,type:"button",role:"tab","aria-controls":"pills-"+n,"aria-selected":n==="Active",onClick:y=>L(n)},r(o.$t(n)),11,je)):N("",!0)])}),128))])])]),f.value&&f.value.permissions.split(",").includes("products")?(d(),u("div",Fe,[(d(!0),u(O,null,z(e.value,n=>{var $,y,V,j;return d(),u("div",{key:n,class:G(["tab-pane",{fade:n!=="Active"},{"show active":n==="Active"}]),id:"pills-"+n,role:"tabpanel","aria-labelledby":"pills-"+n+"-tab"},[s("div",Ie,[($=a.value)!=null&&$[n]?(d(!0),u(O,{key:0},z(H(n),p=>(d(),u("div",{key:p.orderid,class:"col-12 col-lg-4 col-md-6 col-sm-12"},[s("div",Ve,[s("div",De,[s("div",Oe,[s("div",ze,[s("img",{src:"assets/img/"+p.sys_log+"-logo.png",alt:""},null,8,Xe)]),s("div",He,[s("h2",Ue,r(p.name),1),s("h3",qe,r(p.configoptions.configoption[1].value),1),n!=="Cancelled"?(d(),u("div",Ge,[We,s("div",Je,[s("ul",null,[s("li",null,[F(C,{class:"logo-wrapper d-flex align-items-center col-md-2 text-dark text-decoration-none order-lg-1",to:{name:"overview",params:{id:p.orderid}}},{default:W(()=>[X(r(o.$t("Launch_Control_Panel")),1)]),_:2},1032,["to"])]),s("li",null,[F(C,{class:"logo-wrapper d-flex align-items-center col-md-2 text-dark text-decoration-none order-lg-1",to:"/balance"},{default:W(()=>[X(r(o.$t("View_Invoices")),1)]),_:1})])])])])):N("",!0)])])]),n==="Active"?(d(),u("div",Ke,[s("div",Qe,[Re,s("div",Ye,[s("h2",Ze,r(p.dedicatedip),1),s("h3",et,r(o.$t("Created_at"))+" "+r(p.regdate),1),s("h3",tt,r(o.$t("Due_date_at"))+"  "+r(p.nextduedate),1)]),n==="Active"?(d(),u("div",st,[s("button",nt,[ot,X(r(o.$t("Active")),1)])])):N("",!0)])])):N("",!0),s("div",at,[s("div",it,[s("div",rt,[s("img",{src:"assets/img/"+p.flag+".png",alt:""},null,8,lt)]),s("div",ct,[s("h2",dt,r(p.groupname),1),s("h3",ut,r(o.$t("Hostname"))+" : "+r(p.domain),1)])])])])]))),128)):N("",!0),n==="Active"&&(!((y=a.value)!=null&&y[n])||((j=(V=a.value)==null?void 0:V[n])==null?void 0:j.length)===0)?(d(),u("div",pt,[s("h5",mt,r(o.$t("No_Active_Product")),1)])):N("",!0)])],10,Te)}),128))])):(d(),ge(ke,{key:1}))]),s("div",_t,[F(we,{currentPage:i.value.page,totalPages:b.value,onPageChanged:B},null,8,["currentPage","totalPages"])])])}}},xt=ue(vt,[["__scopeId","data-v-3db0eab0"]]);export{$e as L,xt as S};