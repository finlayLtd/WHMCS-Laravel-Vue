import{C as F,D as S,o as E,E as k,b as t,d as a,e,B,w as m,z as C,t as u,f as o,F as D,A as q,v as M}from"./app-1c59e5b4.js";import{u as V}from"./categories-1c8ad344.js";import{d as _,u as L,a as R,r as T,m as j}from"./rules-9cc51195.js";const z={class:"row justify-content-center my-5"},A={class:"col-md-6"},N={class:"card border-0 shadow-sm"},P={class:"card-body"},U=["onSubmit"],G={class:"mb-3"},H=e("label",{for:"post-title",class:"form-label"}," Title ",-1),I={class:"text-danger mt-1"},J={class:"text-danger mt-1"},K={class:"mt-4"},O=["disabled"],Q={class:""},W={key:0},X={key:1},te={__name:"Edit",setup(Y){_("required",T),_("min",j);const v={name:"required|min:3"},{validate:h,errors:p,resetForm:Z}=L({validationSchema:v}),{value:f}=R("name",null,{initialValue:""}),{category:r,getCategory:b,updateCategory:g,validationErrors:y,isLoading:i}=V(),s=F({name:f}),w=S();function x(){h().then(d=>{d.valid&&g(s)})}return E(()=>{b(w.params.id)}),k(()=>{s.id=r.value.id,s.name=r.value.name}),(d,c)=>{var l;return t(),a("div",z,[e("div",A,[e("div",N,[e("div",P,[e("form",{onSubmit:B(x,["prevent"])},[e("div",G,[H,m(e("input",{"onUpdate:modelValue":c[0]||(c[0]=n=>s.name=n),id:"post-title",type:"text",class:"form-control"},null,512),[[C,s.name]]),e("div",I,u(o(p).name),1),e("div",J,[(t(!0),a(D,null,q((l=o(y))==null?void 0:l.name,n=>(t(),a("div",null,u(n),1))),256))])]),e("div",K,[e("button",{disabled:o(i),class:"btn btn-primary"},[m(e("div",Q,null,512),[[M,o(i)]]),o(i)?(t(),a("span",W,"Processing...")):(t(),a("span",X,"Save"))],8,O)])],40,U)])])])])}}};export{te as default};
