import{k as u,G as E,H as T,s as j,o as z,x as k,r as V,b as x,d as b,e,f as p,y as $,l as F,m as U,w as C,z as B,n as i,F as M,A as S,h as I,g as N,t as g,B as L}from"./app-1c59e5b4.js";function O(){const w=u([]),d=u({name:""}),c=E(),r=u({}),a=u(!1),t=T("$swal"),h=async(l=1,s="",o="",m="",n="created_at",P="desc")=>{axios.get("/api/users?page="+l+"&search_id="+s+"&search_title="+o+"&search_global="+m+"&order_column="+n+"&order_direction="+P).then(A=>{w.value=A.data})};return{users:w,user:d,getUsers:h,getUser:async l=>{axios.get("/api/users/"+l).then(s=>{d.value=s.data.data})},storeUser:async l=>{if(a.value)return;a.value=!0,r.value={};let s=new FormData;for(let o in l)l.hasOwnProperty(o)&&s.append(o,l[o]);axios.post("/api/users",s).then(o=>{c.push({name:"users.index"}),t({icon:"success",title:"User saved successfully"})}).catch(o=>{var m;(m=o.response)!=null&&m.data&&(r.value=o.response.data.errors)}).finally(()=>a.value=!1)},updateUser:async l=>{a.value||(a.value=!0,r.value={},axios.put("/api/users/"+l.id,l).then(s=>{c.push({name:"users.index"}),t({icon:"success",title:"User updated successfully"})}).catch(s=>{var o;(o=s.response)!=null&&o.data&&(r.value=s.response.data.errors)}).finally(()=>a.value=!1))},deleteUser:async l=>{t({title:"Are you sure?",text:"You won't be able to revert this action!",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes, delete it!",confirmButtonColor:"#ef4444",timer:2e4,timerProgressBar:!0,reverseButtons:!0}).then(s=>{s.isConfirmed&&axios.delete("/api/users/"+l).then(o=>{h(),c.push({name:"users.index"}),t({icon:"success",title:"User deleted successfully"})}).catch(o=>{t({icon:"error",title:"Something went wrong"})})})},validationErrors:r,isLoading:a}}const Y={class:"row justify-content-center my-2"},G={class:"col-md-12"},H={class:"card border-0"},R={class:"card-header bg-transparent"},q=e("h5",{class:"float-start"},"Users",-1),J={class:"card-body shadow-sm"},K={class:"mb-4"},Q={class:"table-responsive"},W={class:"table"},X={class:"px-6 py-3 bg-gray-50 text-left"},Z={class:"px-6 py-3 bg-gray-50 text-left"},ee=e("th",{class:"px-6 py-3 text-start"},null,-1),te=e("th",{class:"px-6 py-3 text-start"},null,-1),se={class:"px-6 py-3 text-start"},ae={class:"select-none"},le={class:"px-6 py-3 text-left"},ne={class:"select-none"},oe={class:"px-6 py-3 text-left"},re={class:"select-none"},ie={class:"px-6 py-3 bg-gray-50 text-left"},ce={class:"select-none"},de=e("th",{class:"px-6 py-3 bg-gray-50 text-left"}," Actions ",-1),ue={class:"px-6 py-4 text-sm"},ve={class:"px-6 py-4 text-sm"},pe={class:"px-6 py-4 text-sm"},_e={class:"px-6 py-4 text-sm"},me={class:"px-6 py-4 text-sm"},xe=["onClick"],he={class:"card-footer"},ye={__name:"index",setup(w){const d=u(""),c=u(""),r=u(""),a=u("created_at"),t=u("desc"),{users:h,getUsers:v,deleteUser:D}=O(),{can:y}=j();z(()=>{v()});const f=l=>{a.value=l,t.value=t.value==="asc"?"desc":"asc",v(1,d.value,c.value,r.value,a.value,t.value)};return k(d,(l,s)=>{v(1,l,c.value,r.value)}),k(c,(l,s)=>{v(1,d.value,l,r.value)}),k(r,_.debounce((l,s)=>{v(1,d.value,c.value,l)},200)),(l,s)=>{const o=V("router-link"),m=V("Pagination");return x(),b("div",Y,[e("div",G,[e("div",H,[e("div",R,[q,p(y)("user-list")?(x(),$(o,{key:0,to:{name:"users.create"},class:"btn btn-primary btn-sm float-end"},{default:F(()=>[N(" Create Category ")]),_:1},8,["to"])):U("",!0)]),e("div",J,[e("div",K,[C(e("input",{"onUpdate:modelValue":s[0]||(s[0]=n=>r.value=n),type:"text",placeholder:"Search...",class:"form-control w-25"},null,512),[[B,r.value]])]),e("div",Q,[e("table",W,[e("thead",null,[e("tr",null,[e("th",X,[C(e("input",{"onUpdate:modelValue":s[1]||(s[1]=n=>d.value=n),type:"text",class:"inline-block mt-1 form-control",placeholder:"Filter by ID"},null,512),[[B,d.value]])]),e("th",Z,[C(e("input",{"onUpdate:modelValue":s[2]||(s[2]=n=>c.value=n),type:"text",class:"inline-block mt-1 form-control",placeholder:"Filter by Title"},null,512),[[B,c.value]])]),ee,te]),e("tr",null,[e("th",se,[e("div",{class:"flex flex-row",onClick:s[3]||(s[3]=n=>f("id"))},[e("div",{class:i(["font-medium text-uppercase",{"font-bold text-blue-600":a.value==="id"}])}," ID ",2),e("div",ae,[e("span",{class:i({"text-blue-600":t.value==="asc"&&a.value==="id",hidden:t.value!==""&&t.value!=="asc"&&a.value==="id"})},"↑",2),e("span",{class:i({"text-blue-600":t.value==="desc"&&a.value==="id",hidden:t.value!==""&&t.value!=="desc"&&a.value==="id"})},"↓",2)])])]),e("th",le,[e("div",{class:"flex flex-row",onClick:s[4]||(s[4]=n=>f("title"))},[e("div",{class:i(["font-medium text-uppercase",{"font-bold text-blue-600":a.value==="title"}])}," Name ",2),e("div",ne,[e("span",{class:i({"text-blue-600":t.value==="asc"&&a.value==="title",hidden:t.value!==""&&t.value!=="asc"&&a.value==="title"})},"↑",2),e("span",{class:i({"text-blue-600":t.value==="desc"&&a.value==="title",hidden:t.value!==""&&t.value!=="desc"&&a.value==="title"})},"↓",2)])])]),e("th",oe,[e("div",{class:"flex flex-row",onClick:s[5]||(s[5]=n=>f("email"))},[e("div",{class:i(["font-medium text-uppercase",{"font-bold text-blue-600":a.value==="email"}])}," Email ",2),e("div",re,[e("span",{class:i({"text-blue-600":t.value==="asc"&&a.value==="email",hidden:t.value!==""&&t.value!=="asc"&&a.value==="email"})},"↑",2),e("span",{class:i({"text-blue-600":t.value==="desc"&&a.value==="email",hidden:t.value!==""&&t.value!=="desc"&&a.value==="email"})},"↓",2)])])]),e("th",ie,[e("div",{class:"flex flex-row items-center justify-between cursor-pointer",onClick:s[6]||(s[6]=n=>f("created_at"))},[e("div",{class:i(["leading-4 font-medium text-gray-500 uppercase tracking-wider",{"font-bold text-blue-600":a.value==="created_at"}])}," Created at ",2),e("div",ce,[e("span",{class:i({"text-blue-600":t.value==="asc"&&a.value==="created_at",hidden:t.value!==""&&t.value!=="asc"&&a.value==="created_at"})},"↑",2),e("span",{class:i({"text-blue-600":t.value==="desc"&&a.value==="created_at",hidden:t.value!==""&&t.value!=="desc"&&a.value==="created_at"})},"↓",2)])])]),de])]),e("tbody",null,[(x(!0),b(M,null,S(p(h).data,n=>(x(),b("tr",{key:n.id},[e("td",ue,g(n.id),1),e("td",ve,g(n.name),1),e("td",pe,g(n.email),1),e("td",_e,g(n.created_at),1),e("td",me,[p(y)("user-edit")?(x(),$(o,{key:0,to:{name:"users.edit",params:{id:n.id}},class:"badge bg-primary"},{default:F(()=>[N("Edit ")]),_:2},1032,["to"])):U("",!0),p(y)("user-delete")?(x(),b("a",{key:1,href:"#",onClick:L(P=>p(D)(n.id),["prevent"]),class:"ms-2 badge bg-danger"},"Delete",8,xe)):U("",!0)])]))),128))])])])]),e("div",he,[I(m,{data:p(h),limit:3,onPaginationChangePage:s[7]||(s[7]=n=>p(v)(n,d.value,c.value,r.value,a.value,t.value)),class:"mt-4"},null,8,["data"])])])])])}}};export{ye as default};
