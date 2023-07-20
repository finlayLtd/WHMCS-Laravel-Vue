import{N as $,O as k,P as H}from"./app-c4a345d8.js";var w={exports:{}};const N=$(k);(function(B,S){(function(_,m){B.exports=m(N)})(H,T=>(()=>{var _={661:(n,i)=>{Object.defineProperty(i,"__esModule",{value:!0}),i.default=(a,h)=>{const c=a.__vccOpts||a;for(const[f,g]of h)c[f]=g;return c}},976:n=>{n.exports=T}},m={};function u(n){var i=m[n];if(i!==void 0)return i.exports;var a=m[n]={exports:{}};return _[n](a,a.exports,u),a.exports}u.d=(n,i)=>{for(var a in i)u.o(i,a)&&!u.o(n,a)&&Object.defineProperty(n,a,{enumerable:!0,get:i[a]})},u.o=(n,i)=>Object.prototype.hasOwnProperty.call(n,i),u.r=n=>{typeof Symbol<"u"&&Symbol.toStringTag&&Object.defineProperty(n,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(n,"__esModule",{value:!0})};var d={};return(()=>{u.r(d),u.d(d,{ToastComponent:()=>O,ToastPlugin:()=>y,ToastPositions:()=>o,default:()=>j,useToast:()=>b});var n=u(976);const i=(0,n.createElementVNode)("div",{class:"v-toast__icon"},null,-1),a=["innerHTML"];function h(e,t,s,r,l,p){return(0,n.openBlock)(),(0,n.createBlock)(n.Transition,{"enter-active-class":e.transition.enter,"leave-active-class":e.transition.leave},{default:(0,n.withCtx)(()=>[(0,n.withDirectives)((0,n.createElementVNode)("div",{ref:"root",role:"alert",class:(0,n.normalizeClass)(["v-toast__item",[`v-toast__item--${e.type}`,`v-toast__item--${e.position}`]]),onMouseover:t[0]||(t[0]=E=>e.toggleTimer(!0)),onMouseleave:t[1]||(t[1]=E=>e.toggleTimer(!1)),onClick:t[2]||(t[2]=function(){return e.whenClicked&&e.whenClicked(...arguments)})},[i,(0,n.createElementVNode)("p",{class:"v-toast__text",innerHTML:e.message},null,8,a)],34),[[n.vShow,e.isActive]])]),_:1},8,["enter-active-class","leave-active-class"])}function c(e){var t;typeof e.remove<"u"?e.remove():(t=e.parentNode)==null||t.removeChild(e)}function f(e,t,s){let r=arguments.length>3&&arguments[3]!==void 0?arguments[3]:{};const l=(0,n.h)(e,t,r),p=document.createElement("div");return p.classList.add("v-toast--pending"),s.appendChild(p),(0,n.render)(l,p),l.component}class g{constructor(t,s){this.startedAt=Date.now(),this.callback=t,this.delay=s,this.timer=setTimeout(t,s)}pause(){this.stop(),this.delay-=Date.now()-this.startedAt}resume(){this.stop(),this.startedAt=Date.now(),this.timer=setTimeout(this.callback,this.delay)}stop(){clearTimeout(this.timer)}}const o=Object.freeze({TOP_RIGHT:"top-right",TOP:"top",TOP_LEFT:"top-left",BOTTOM_RIGHT:"bottom-right",BOTTOM:"bottom",BOTTOM_LEFT:"bottom-left"});function P(e){return{all:e=e||new Map,on:function(t,s){var r=e.get(t);r?r.push(s):e.set(t,[s])},off:function(t,s){var r=e.get(t);r&&(s?r.splice(r.indexOf(s)>>>0,1):e.set(t,[]))},emit:function(t,s){var r=e.get(t);r&&r.slice().map(function(l){l(s)}),(r=e.get("*"))&&r.slice().map(function(l){l(t,s)})}}}const v=P(),C=(0,n.defineComponent)({name:"Toast",props:{message:{type:String,required:!0},type:{type:String,default:"success"},position:{type:String,default:o.BOTTOM_RIGHT,validator(e){return Object.values(o).includes(e)}},duration:{type:Number,default:3e3},dismissible:{type:Boolean,default:!0},onDismiss:{type:Function,default:()=>{}},onClick:{type:Function,default:()=>{}},queue:Boolean,pauseOnHover:{type:Boolean,default:!0}},data(){return{isActive:!1,parentTop:null,parentBottom:null,isHovered:!1}},beforeMount(){this.setupContainer()},mounted(){this.showNotice(),v.on("toast-clear",this.dismiss)},methods:{setupContainer(){if(this.parentTop=document.querySelector(".v-toast.v-toast--top"),this.parentBottom=document.querySelector(".v-toast.v-toast--bottom"),this.parentTop&&this.parentBottom)return;this.parentTop||(this.parentTop=document.createElement("div"),this.parentTop.className="v-toast v-toast--top"),this.parentBottom||(this.parentBottom=document.createElement("div"),this.parentBottom.className="v-toast v-toast--bottom");const e=document.body;e.appendChild(this.parentTop),e.appendChild(this.parentBottom)},shouldQueue(){return this.queue?this.parentTop.childElementCount>0||this.parentBottom.childElementCount>0:!1},dismiss(){this.timer&&this.timer.stop(),clearTimeout(this.queueTimer),this.isActive=!1,setTimeout(()=>{this.onDismiss.apply(null,arguments);const e=this.$refs.root;(0,n.render)(null,e),c(e)},150)},showNotice(){if(this.shouldQueue()){this.queueTimer=setTimeout(this.showNotice,250);return}const e=this.$refs.root.parentElement;this.correctParent.insertAdjacentElement("afterbegin",this.$refs.root),c(e),this.isActive=!0,this.duration&&(this.timer=new g(this.dismiss,this.duration))},whenClicked(){this.dismissible&&(this.onClick.apply(null,arguments),this.dismiss())},toggleTimer(e){!this.pauseOnHover||!this.timer||(e?this.timer.pause():this.timer.resume())}},computed:{correctParent(){switch(this.position){case o.TOP:case o.TOP_RIGHT:case o.TOP_LEFT:return this.parentTop;case o.BOTTOM:case o.BOTTOM_RIGHT:case o.BOTTOM_LEFT:return this.parentBottom}},transition(){switch(this.position){case o.TOP:case o.TOP_RIGHT:case o.TOP_LEFT:return{enter:"v-toast--fade-in-down",leave:"v-toast--fade-out"};case o.BOTTOM:case o.BOTTOM_RIGHT:case o.BOTTOM_LEFT:return{enter:"v-toast--fade-in-up",leave:"v-toast--fade-out"}}}},beforeUnmount(){v.off("toast-clear",this.dismiss)}});var M=u(661);const O=(0,M.default)(C,[["render",h]]),b=function(){let e=arguments.length>0&&arguments[0]!==void 0?arguments[0]:{};return{open(t){let s=null;typeof t=="string"&&(s=t);const l=Object.assign({},{message:s},e,t);return{dismiss:f(O,l,document.body).ctx.dismiss}},clear(){v.emit("toast-clear")},success(t){let s=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};return this.open(Object.assign({},{message:t,type:"success"},s))},error(t){let s=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};return this.open(Object.assign({},{message:t,type:"error"},s))},info(t){let s=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};return this.open(Object.assign({},{message:t,type:"info"},s))},warning(t){let s=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};return this.open(Object.assign({},{message:t,type:"warning"},s))},default(t){let s=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};return this.open(Object.assign({},{message:t,type:"default"},s))}}},y={install:function(e){let t=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},s=b(t);e.config.globalProperties.$toast=s,e.provide("$toast",s)}},j=y})(),d})())})(w);var x=w.exports;export{x as d};
