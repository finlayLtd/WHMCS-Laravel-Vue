import{k as r,G as f,H as h}from"./app-c4a345d8.js";function _(){const c=r([]),u=r({name:""}),a=f(),n=r({}),t=r(!1),o=h("$swal");return{permissions:c,permission:u,getPermissions:async(s=1,e="",i="",l="",m="created_at",p="desc")=>{axios.get("/api/permissions?page="+s+"&search_id="+e+"&search_title="+i+"&search_global="+l+"&order_column="+m+"&order_direction="+p).then(d=>{c.value=d.data})},getPermission:async s=>{axios.get("/api/permissions/"+s).then(e=>{u.value=e.data.data})},storePermission:async s=>{t.value||(t.value=!0,n.value={},axios.post("/api/permissions",s).then(e=>{a.push({name:"permissions.index"}),o({icon:"success",title:"Permission saved successfully"})}).catch(e=>{var i;(i=e.response)!=null&&i.data&&(n.value=e.response.data.errors)}).finally(()=>t.value=!1))},updatePermission:async s=>{t.value||(t.value=!0,n.value={},axios.put("/api/permissions/"+s.id,s).then(e=>{a.push({name:"permissions.index"}),o({icon:"success",title:"Permission updated successfully"})}).catch(e=>{var i;(i=e.response)!=null&&i.data&&(n.value=e.response.data.errors)}).finally(()=>t.value=!1))},deletePermission:async s=>{o({title:"Are you sure?",text:"You won't be able to revert this action!",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes, delete it!",confirmButtonColor:"#ef4444",timer:2e4,timerProgressBar:!0,reverseButtons:!0}).then(e=>{e.isConfirmed&&axios.delete("/api/permissions/"+s).then(i=>{getRoles(),a.push({name:"permissions.index"}),o({icon:"success",title:"Permission deleted successfully"})}).catch(i=>{o({icon:"error",title:"Something went wrong"})})})},validationErrors:n,isLoading:t}}export{_ as u};
