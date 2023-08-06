import{B as $,E as N,f as _,b as D,d as A,r as B,o as a,c as o,h as e,a as F,i as M,t as i,l as d,m as V,F as H,s as S,w as E,C as I,j as P,x as R,A as l}from"./app-9b2e2238.js";import{c as j}from"./commonApis-3c849663.js";import{N as q}from"./NoPermission-e7874cbc.js";const O={class:"dashboard"},z={class:"container"},U={class:"title-button-wrapper ticket-detail"},G=e("img",{class:"status-arrow",src:"/assets/img/status-arrow.svg",alt:""},null,-1),J={key:0,class:"ticket-status-title color-in-work"},K={class:"title mb-0 mt-2"},Q={key:0,class:"sub-section server-list-tab"},W={class:"row justify-content-between align-items-center"},X={class:"row mb-5 pe-0"},Y={class:"col-12"},Z={class:"card-item p-4 mb-4 support-item flex-column"},ee={key:0,class:"message-item-wrapper"},se={key:0,class:"message-item message-received"},te={class:"message-item-header"},ae={class:"message-sender"},oe={class:"fs-15"},ie={class:"message-sent-time fs-13"},ne={class:"message-content-wrapper"},le={key:0,class:"message-body"},ce=["innerHTML"],de={key:1,class:"message-body message-attachment-body",style:{width:"fit-content"}},re=["onClick","data-lightbox"],_e=e("img",{src:"/assets/img/download_icon.png",style:{width:"24px"},alt:""},null,-1),ue={class:"text-decoration-underline"},me={key:1,class:"message-item message-sent"},he={class:"message-item-header"},pe={class:"message-sender"},ge={class:"fs-15"},ve={class:"message-sent-time fs-13"},fe={class:"message-content-wrapper"},ke={key:0,class:"message-body"},ye=["innerHTML"],be={key:1,class:"message-body message-attachment-body",style:{width:"fit-content","margin-left":"auto"}},we=["onClick","data-lightbox"],xe=e("img",{src:"/assets/img/download_icon.png",style:{width:"24px"},alt:""},null,-1),Ce={class:"text-decoration-underline"},Te={class:"message-send-area-wrapper mt-4"},Le={class:"upload-attachment"},$e=e("label",{class:"file-label",for:"file"},null,-1),Ne=["value"],De={class:"message-box"},Ae={key:0},Be={key:0,id:"file-name",style:{"overflow-wrap":"anywhere"}},Fe=e("span",{id:"file-name",style:{"overflow-wrap":"anywhere"}},null,-1),Me={class:"mt-1",style:{"text-align":"right"}},Ve=["disabled"],Pe={__name:"ticket-detail",setup(He){const f=$.useToast({toastOptions:{zIndex:99999}}),h=N(),p=_(null),k=j(),w=D(),g=A(()=>w.state.auth.user),c=_({}),u=_(""),r=_(null),v=_("");_({client_id:g.value.client_id,orderby:"",order:""});const y=t=>t.replace(/\n/g,"<br>"),x=()=>{l(!0),k.runPostApi("/get-ticketDetails",{id:h.params.id}).then(t=>{l(!1),t.data.result=="wrong_user"?f.error("No permission on this ticket!"):c.value=t.data.ticket_detail}).catch(t=>{l(!1),f.error(t)})},C=t=>{r.value=t.target.files[0],v.value=t.target.files[0].name},b=t=>{l(!0),k.runPostApi("/download-file",{id:t}).then(n=>{l(!1),n.data.result=="success"&&(p.value.href=n.data.redirect_url,p.value.click())}).catch(n=>{l(!1),console.log(n)})},T=()=>{l(!0);const t=new FormData;r.value!=null&&t.append("file",r.value),t.append("ticket_id",h.params.id),t.append("message",u.value);const n={"Content-Type":"multipart/form-data"};axios.post("/api/sendReply",t,{headers:n}).then(m=>{l(!1),c.value=m.data.ticket_detail,u.value="",r.value=null}).catch(m=>{l(!1),console.log(m)})};return x(),(t,n)=>{const m=B("router-link");return a(),o("section",O,[e("div",z,[e("a",{ref_key:"customLink",ref:p,style:{display:"none"},target:"_blank"},"Custom Link",512),e("div",U,[F(m,{to:"/support-ticket"},{default:M(()=>[G]),_:1}),c.value&&c.value.status?(a(),o("h3",J,i(t.$t(c.value.status)),1)):d("",!0),e("h2",K,i(t.$t("Ticket"))+"#"+i(V(h).params.id),1)]),g.value&&g.value.permissions.split(",").includes("tickets")?(a(),o("div",Q,[e("div",W,[e("div",X,[e("div",Y,[e("div",Z,[c.value.replies?(a(),o("div",ee,[(a(!0),o(H,null,S(c.value.replies.reply,s=>(a(),o("div",{key:s.replyid,style:{"margin-bottom":"20px"}},[s.requestor_type=="Owner"?(a(),o("div",se,[e("div",te,[e("div",ae,[e("span",oe,i(s.requestor_name),1),e("span",ie,i(s.date),1)])]),e("div",ne,[s.message&&s.message!=" "?(a(),o("div",le,[e("div",{style:{"text-align":"left"},innerHTML:y(s.message)},null,8,ce)])):d("",!0),s.attachment?(a(),o("div",de,[e("a",{class:"blackColor",onClick:L=>b(s.replyid),"data-lightbox":"image-r"+s.replyid,style:{cursor:"pointer"}},[_e,e("span",ue,i(s.attachment),1)],8,re)])):d("",!0)])])):(a(),o("div",me,[e("div",he,[e("div",pe,[e("span",ge,i(s.name),1),e("span",ve,i(s.date),1)])]),e("div",fe,[s.message&&s.message!=" "?(a(),o("div",ke,[e("div",{style:{"text-align":"left"},innerHTML:y(s.message)},null,8,ye)])):d("",!0),s.attachment?(a(),o("div",be,[e("div",null,[e("a",{class:"blackColor",onClick:L=>b(s.replyid),"data-lightbox":"image-r"+s.replyid,style:{cursor:"pointer"}},[xe,e("span",Ce,i(s.attachment),1)],8,we)])])):d("",!0)])]))]))),128))])):d("",!0),e("div",Te,[e("div",Le,[$e,e("input",{name:"file",type:"file",style:{display:"none"},id:"file",onChange:C,ref:"fileInput"},null,544),e("input",{name:"ticket_id",type:"hidden",id:"ticket_id",value:c.value.id},null,8,Ne)]),e("div",De,[E(e("textarea",{id:"message",name:"message",class:"p-3",cols:"30",rows:"5",placeholder:"Type messages..","onUpdate:modelValue":n[0]||(n[0]=s=>u.value=s)},null,512),[[I,u.value]]),r.value?(a(),o("div",Ae,[P(i(t.$t("File_Selected"))+": ",1),v.value!=""?(a(),o("span",Be,i(v.value),1)):d("",!0),Fe])):d("",!0)])]),e("div",Me,[e("button",{class:"btn-dark change-profile-btn fs-15",style:{"margin-right":"0px"},onClick:n[1]||(n[1]=s=>T()),disabled:u.value==""&&r.value==null},i(t.$t("Send")),9,Ve)])])])])])])):(a(),R(q,{key:1}))])])}}};export{Pe as default};
