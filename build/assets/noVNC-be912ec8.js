import{E as d,B as u,b as l,d as m,f as s,o as p,c as _,h,A as t}from"./app-9b2e2238.js";import{c as f}from"./commonApis-3c849663.js";const v=["srcdoc"],B={__name:"noVNC",setup(C){const a=d(),r=u.useToast(),c=f(),n=l(),i=m(()=>n.state.auth.user);s({client_id:i.value.client_id,orderby:"",order:""});const o=s("<div></div>");return(()=>{t(!0),c.runPostApi("/overview/noVNC-connect",{id:a.params.id}).then(e=>{t(!1),o.value=e.data}).catch(e=>{t(!1),r.error(e)})})(),(e,V)=>(p(),_("div",null,[h("iframe",{srcdoc:o.value,style:{width:"100%","min-height":"768px"}},null,8,v)]))}};export{B as default};
