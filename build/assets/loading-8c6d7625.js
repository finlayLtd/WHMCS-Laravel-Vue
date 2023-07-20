import{I as o,L as a,M as r}from"./app-c4a345d8.js";const t=o.create({baseURL:"http://87.120.88.249/api/",headers:{"X-Custom-Header":"foobar"}});t.interceptors.request.use(s=>{const e=localStorage.getItem("accessToken");return e&&(s.headers=s.headers||{},s.headers.Authorization=e?`Bearer ${JSON.parse(e)}`:""),s});t.interceptors.response.use(s=>s,s=>{var e;if(((e=s==null?void 0:s.response)==null?void 0:e.status)===401)localStorage.removeItem("userData"),localStorage.removeItem("accessToken"),localStorage.removeItem("userAbilities"),a.push("/login");else return Promise.reject(s)});const l=r("commonApis",{actions:{runGetApi(s,e){return t.get(s,{params:e})},runPostApi(s,e){return t.post(s,{params:e})}}});function p(s){if(s){const e=document.createElement("div");e.id="loading-bg",e.style.display="block",e.style.zIndex="9999",e.innerHTML=`
        <div class="loading_new" style="margin: auto;">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
      `;const n=document.getElementById("app");n?n.insertBefore(e,n.firstChild):console.error('Element with ID "app" not found.')}else{const e=document.getElementById("loading-bg");e&&e.parentNode.removeChild(e)}}export{l as c,p as s};
