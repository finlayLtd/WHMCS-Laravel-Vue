import{o,c,h as s,t,F as n}from"./app-4c139354.js";const d={class:"tab-inner mb-3"},a={class:"row"},_={class:"title"},l={class:"description mb-4"},r=s("div",{class:"divider"},null,-1),p={class:"row px-0 px-lg-4 pt-4"},m={class:"col-md-12 d-flex flex-column align-items-center text-center"},h={class:"fs-15"},f={class:"fs-16"},u={class:"fs-15"},y=s("p",{class:"fs-15"},"mstsc",-1),v={class:"fs-14 mb-0 sub-detail",style:{"max-width":"500px"}},w={__name:"connect",props:{order_product_info:{type:Object},system:{type:String}},setup(i){return(e,b)=>(o(),c("div",d,[s("div",a,[s("h3",_,t(e.$t("Connect")),1),s("p",l,t(e.$t("Connecting_to_your_virtual_machine"))+". ",1)]),r,s("div",p,[s("div",m,[i.system.indexOf("windows")==-1?(o(),c(n,{key:0},[s("p",h,t(e.$t("cmd_title")),1),s("p",f," ssh root@"+t(i.order_product_info.dedicatedip),1)],64)):(o(),c(n,{key:1},[s("p",u,t(e.$t("cmd_1")),1),y],64)),s("p",v,t(e.$t("cmd_2")),1)])])]))}};export{w as default};