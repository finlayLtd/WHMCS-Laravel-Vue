import{D as T,A as L,f as _,b as D,d as $,r as A,o as a,c as o,h as e,a as F,i as M,t as i,m as V,F as B,s as H,l as c,w as N,B as S,j as R,z as l}from"./app-5f59d904.js";import{c as j}from"./commonApis-4afe13c5.js";const q={class:"dashboard"},E={class:"container"},I={class:"title-button-wrapper ticket-detail"},P=e("img",{class:"status-arrow",src:"/assets/img/status-arrow.svg",alt:""},null,-1),z={class:"ticket-status-title color-in-work"},O={class:"title mb-0 mt-2"},U={class:"sub-section server-list-tab"},G={class:"row justify-content-between align-items-center"},J={class:"row mb-5 pe-0"},K={class:"col-12"},Q={class:"card-item p-4 mb-4 support-item flex-column"},W={key:0,class:"message-item-wrapper"},X={key:0,class:"message-item message-received"},Y={class:"message-item-header"},Z={class:"message-sender"},ee={class:"fs-15"},se={class:"message-sent-time fs-13"},te={class:"message-content-wrapper"},ae={key:0,class:"message-body"},oe=["innerHTML"],ie={key:1,class:"message-body message-attachment-body",style:{width:"fit-content"}},ne=["onClick","data-lightbox"],le=e("img",{src:"/assets/img/download_icon.png",style:{width:"24px"},alt:""},null,-1),ce={class:"text-decoration-underline"},de={key:1,class:"message-item message-sent"},re={class:"message-item-header"},_e={class:"message-sender"},me={class:"fs-15"},ue={class:"message-sent-time fs-13"},he={class:"message-content-wrapper"},pe={key:0,class:"message-body"},ge=["innerHTML"],ve={key:1,class:"message-body message-attachment-body",style:{width:"fit-content","margin-left":"auto"}},fe=["onClick","data-lightbox"],ke=e("img",{src:"/assets/img/download_icon.png",style:{width:"24px"},alt:""},null,-1),ye={class:"text-decoration-underline"},be={class:"message-send-area-wrapper mt-4"},we={class:"upload-attachment"},xe=e("label",{class:"file-label",for:"file"},null,-1),Ce=["value"],Te={class:"message-box"},Le={key:0},De={key:0,id:"file-name",style:{"overflow-wrap":"anywhere"}},$e=e("span",{id:"file-name",style:{"overflow-wrap":"anywhere"}},null,-1),Ae={class:"mt-1",style:{"text-align":"right"}},Fe=["disabled"],He={__name:"ticket-detail",setup(Me){const h=T();L.useToast();const p=_(null),v=j(),k=D(),y=$(()=>k.state.auth.user),d=_({}),m=_(""),r=_(null),g=_("");_({client_id:y.value.client_id,orderby:"",order:""});const b=()=>{l(!0),v.runPostApi("/get-ticketDetails",{id:h.params.id}).then(t=>{l(!1),d.value=t.data.ticket_detail}).catch(t=>{l(!1),console.log(t)})},w=t=>{r.value=t.target.files[0],g.value=t.target.files[0].name},f=t=>{l(!0),v.runPostApi("/download-file",{id:t}).then(n=>{l(!1),n.data.result=="success"&&(p.value.href=n.data.redirect_url,p.value.click())}).catch(n=>{l(!1),console.log(n)})},x=()=>{l(!0);const t=new FormData;r.value!=null&&t.append("file",r.value),t.append("ticket_id",h.params.id),t.append("message",m.value);const n={"Content-Type":"multipart/form-data"};axios.post("/api/sendReply",t,{headers:n}).then(u=>{l(!1),d.value=u.data.ticket_detail,m.value="",r.value=null}).catch(u=>{l(!1),console.log(u)})};return b(),(t,n)=>{const u=A("router-link");return a(),o("section",q,[e("div",E,[e("a",{ref_key:"customLink",ref:p,style:{display:"none"},target:"_blank"},"Custom Link",512),e("div",I,[F(u,{to:"/support-ticket"},{default:M(()=>[P]),_:1}),e("h3",z,i(d.value.status),1),e("h2",O,i(t.$t("Ticket"))+"#"+i(V(h).params.id),1)]),e("div",U,[e("div",G,[e("div",J,[e("div",K,[e("div",Q,[d.value.replies?(a(),o("div",W,[(a(!0),o(B,null,H(d.value.replies.reply,s=>(a(),o("div",{key:s.replyid,style:{"margin-bottom":"20px"}},[s.requestor_type=="Owner"?(a(),o("div",X,[e("div",Y,[e("div",Z,[e("span",ee,i(s.requestor_name),1),e("span",se,i(s.date),1)])]),e("div",te,[s.message&&s.message!=" "?(a(),o("div",ae,[e("div",{style:{"text-align":"left"},innerHTML:s.message},null,8,oe)])):c("",!0),s.attachment?(a(),o("div",ie,[e("a",{class:"blackColor",onClick:C=>f(s.replyid),"data-lightbox":"image-r"+s.replyid,style:{cursor:"pointer"}},[le,e("span",ce,i(s.attachment),1)],8,ne)])):c("",!0)])])):(a(),o("div",de,[e("div",re,[e("div",_e,[e("span",me,i(s.name),1),e("span",ue,i(s.date),1)])]),e("div",he,[s.message&&s.message!=" "?(a(),o("div",pe,[e("div",{innerHTML:s.message,style:{"text-align":"left"}},null,8,ge)])):c("",!0),s.attachment?(a(),o("div",ve,[e("div",null,[e("a",{class:"blackColor",onClick:C=>f(s.replyid),"data-lightbox":"image-r"+s.replyid,style:{cursor:"pointer"}},[ke,e("span",ye,i(s.attachment),1)],8,fe)])])):c("",!0)])]))]))),128))])):c("",!0),e("div",be,[e("div",we,[xe,e("input",{name:"file",type:"file",style:{display:"none"},id:"file",onChange:w,ref:"fileInput"},null,544),e("input",{name:"ticket_id",type:"hidden",id:"ticket_id",value:d.value.id},null,8,Ce)]),e("div",Te,[N(e("textarea",{id:"message",name:"message",class:"p-3",cols:"30",rows:"5",placeholder:"Type messages..","onUpdate:modelValue":n[0]||(n[0]=s=>m.value=s)},null,512),[[S,m.value]]),r.value?(a(),o("div",Le,[R(i(t.$t("File_Selected"))+": ",1),g.value!=""?(a(),o("span",De,i(g.value),1)):c("",!0),$e])):c("",!0)])]),e("div",Ae,[e("button",{class:"btn-dark change-profile-btn fs-15",style:{"margin-right":"0px"},onClick:n[1]||(n[1]=s=>x()),disabled:m.value==""&&r.value==null},i(t.$t("Send")),9,Fe)])])])])])])])])}}};export{He as default};
