import{A as B,D,b as N,d as j,f as n,r as M,o as T,c as z,h as e,a as L,i as R,t as o,m as F,w as a,E as i,j as u,z as c}from"./app-5f59d904.js";import{c as G}from"./commonApis-4afe13c5.js";const H={class:"dashboard"},I={class:"container"},J={class:"title-button-wrapper ticket-detail"},K=e("img",{class:"status-arrow",src:"/assets/img/status-arrow.svg",alt:""},null,-1),O={class:"ticket-status-title color-in-work"},Q={class:"title mb-0 mt-2"},W={class:"sub-section server-list-tab"},X={class:"row justify-content-between align-items-center"},Y={class:"row mb-5 pe-0"},Z={class:"col-12"},ee={class:"card-item p-4 mb-4 support-item flex-column"},se=e("br",null,null,-1),le={class:"well",id:"invitePermissions"},te={class:"checkbox-inline"},oe=e("br",null,null,-1),ne={class:"checkbox-inline"},ae=e("br",null,null,-1),ie={class:"checkbox-inline"},ue=e("br",null,null,-1),ce={class:"checkbox-inline"},re=e("br",null,null,-1),de={class:"checkbox-inline"},pe=e("br",null,null,-1),me={class:"checkbox-inline"},_e=e("br",null,null,-1),ve={class:"checkbox-inline"},be=e("br",null,null,-1),he={class:"checkbox-inline"},fe=e("br",null,null,-1),ke={class:"checkbox-inline"},ge=e("br",null,null,-1),$e={class:"checkbox-inline"},xe=e("br",null,null,-1),ye={class:"checkbox-inline"},Ve=e("br",null,null,-1),we={class:"checkbox-inline"},Ue=e("br",null,null,-1),Ce={class:"checkbox-inline"},Pe=e("br",null,null,-1),Ee={__name:"permission-detail",setup(Ae){const V=B.useToast(),y=D(),w=G(),C=N(),P=j(()=>C.state.auth.user),r=n(!1),d=n(!1),p=n(!1),m=n(!1),_=n(!1),v=n(!1),b=n(!1),h=n(!1),f=n(!1),k=n(!1),g=n(!1),$=n(!1),x=n(!1),U=n([]);n({client_id:P.value.client_id,orderby:"",order:""});const A=()=>{c(!0),w.runPostApi("/get_permission_detail_per_ser",{user_id:y.params.id}).then(s=>{c(!1),U.value=s.data.permissions,S()}).catch(s=>{c(!1),console.log(s)})},S=()=>{U.value.forEach(s=>{s==="profile"?r.value=!0:s==="contacts"?d.value=!0:s==="products"?p.value=!0:s==="manageproducts"?m.value=!0:s==="productsso"?_.value=!0:s==="domains"?v.value=!0:s==="managedomains"?b.value=!0:s==="invoices"?h.value=!0:s==="quotes"?f.value=!0:s==="tickets"?k.value=!0:s==="affiliates"?g.value=!0:s==="emails"?$.value=!0:s==="orders"&&(x.value=!0)})};A();const q=()=>{c(!0),w.runPostApi("/edit_user_permissions",{user_id:y.params.id,profile:r.value,contacts:d.value,products:p.value,manageproducts:m.value,productsso:_.value,domains:v.value,managedomains:b.value,invoices:h.value,quotes:f.value,tickets:k.value,affiliates:g.value,emails:$.value,orders:x.value}).then(s=>{c(!1),s.data.result=="success"?V.success("Successfully edited permissions!"):V.warning("Cannot connect to whmcs api!")}).catch(s=>{c(!1),console.log(s)})};return(s,l)=>{const E=M("router-link");return T(),z("section",H,[e("div",I,[e("div",J,[L(E,{to:"/settings"},{default:R(()=>[K]),_:1}),e("h3",O,o(s.$t("Manage_Permissions")),1),e("h2",Q,o(F(y).params.email),1)]),e("div",W,[e("div",X,[e("div",Y,[e("div",Z,[e("div",ee,[e("h3",null,o(s.$t("Permissions")),1),se,e("div",le,[e("label",te,[a(e("input",{type:"checkbox",name:"profile","onUpdate:modelValue":l[0]||(l[0]=t=>r.value=t)},null,512),[[i,r.value]]),u(" "+o(s.$t("permission_detail_1")),1)]),oe,e("label",ne,[a(e("input",{type:"checkbox",name:"contacts","onUpdate:modelValue":l[1]||(l[1]=t=>d.value=t)},null,512),[[i,d.value]]),u(" "+o(s.$t("permission_detail_2")),1)]),ae,e("label",ie,[a(e("input",{type:"checkbox",name:"products","onUpdate:modelValue":l[2]||(l[2]=t=>p.value=t)},null,512),[[i,p.value]]),u(" "+o(s.$t("permission_detail_3")),1)]),ue,e("label",ce,[a(e("input",{type:"checkbox",name:"manageproducts","onUpdate:modelValue":l[3]||(l[3]=t=>m.value=t)},null,512),[[i,m.value]]),u(" "+o(s.$t("permission_detail_4")),1)]),re,e("label",de,[a(e("input",{type:"checkbox",name:"productsso","onUpdate:modelValue":l[4]||(l[4]=t=>_.value=t)},null,512),[[i,_.value]]),u(" "+o(s.$t("permission_detail_5")),1)]),pe,e("label",me,[a(e("input",{type:"checkbox",name:"domains","onUpdate:modelValue":l[5]||(l[5]=t=>v.value=t)},null,512),[[i,v.value]]),u(" "+o(s.$t("permission_detail_6")),1)]),_e,e("label",ve,[a(e("input",{type:"checkbox",name:"managedomains","onUpdate:modelValue":l[6]||(l[6]=t=>b.value=t)},null,512),[[i,b.value]]),u(" "+o(s.$t("permission_detail_7")),1)]),be,e("label",he,[a(e("input",{type:"checkbox",name:"invoices","onUpdate:modelValue":l[7]||(l[7]=t=>h.value=t)},null,512),[[i,h.value]]),u(" "+o(s.$t("permission_detail_8")),1)]),fe,e("label",ke,[a(e("input",{type:"checkbox",name:"quotes","onUpdate:modelValue":l[8]||(l[8]=t=>f.value=t)},null,512),[[i,f.value]]),u(" "+o(s.$t("permission_detail_9")),1)]),ge,e("label",$e,[a(e("input",{type:"checkbox",name:"tickets","onUpdate:modelValue":l[9]||(l[9]=t=>k.value=t)},null,512),[[i,k.value]]),u(" "+o(s.$t("permission_detail_10")),1)]),xe,e("label",ye,[a(e("input",{type:"checkbox",name:"affiliates","onUpdate:modelValue":l[10]||(l[10]=t=>g.value=t)},null,512),[[i,g.value]]),u(" "+o(s.$t("permission_detail_11")),1)]),Ve,e("label",we,[a(e("input",{type:"checkbox",name:"emails","onUpdate:modelValue":l[11]||(l[11]=t=>$.value=t)},null,512),[[i,$.value]]),u(" "+o(s.$t("permission_detail_12")),1)]),Ue,e("label",Ce,[a(e("input",{type:"checkbox",name:"orders","onUpdate:modelValue":l[12]||(l[12]=t=>x.value=t)},null,512),[[i,x.value]]),u(" "+o(s.$t("permission_detail_13")),1)]),Pe]),e("button",{class:"btn btn-dark mt-4",onClick:l[13]||(l[13]=t=>q())},o(s.$t("Save_Changes")),1)])])])])])])])}}};export{Ee as default};
