import{E as i,B as d,b as u,d as l,f as s,o as m,c as p,h as _,A as t}from"./app-77f58f2c.js";import{c as h}from"./commonApis-55ba6f04.js";const f=["srcdoc"],x={__name:"noVNC",setup(v){const a=i();d.useToast();const c=h(),n=u(),r=l(()=>n.state.auth.user);s({client_id:r.value.client_id,orderby:"",order:""});const o=s("<div></div>");return(()=>{t(!0),c.runPostApi("/overview/noVNC-connect",{id:a.params.id}).then(e=>{t(!1),o.value=e.data}).catch(e=>{t(!1),console.log(e)})})(),(e,N)=>(m(),p("div",null,[_("iframe",{srcdoc:o.value,style:{width:"100%","min-height":"768px"}},null,8,f)]))}};export{x as default};