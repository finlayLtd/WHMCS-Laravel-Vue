import{Q as o,R as a,S as r}from"./app-4c139354.js";const t=o.create({baseURL:"http://87.121.221.161/api/",headers:{"X-Custom-Header":"foobar"}});t.interceptors.request.use(e=>{const s=localStorage.getItem("accessToken");return s&&(e.headers=e.headers||{},e.headers.Authorization=s?`Bearer ${JSON.parse(s)}`:""),e});t.interceptors.response.use(e=>e,e=>{var s;if(((s=e==null?void 0:e.response)==null?void 0:s.status)===401)localStorage.removeItem("userData"),localStorage.removeItem("accessToken"),localStorage.removeItem("userAbilities"),a.push("/login");else return Promise.reject(e)});const i=r("commonApis",{actions:{runGetApi(e,s){return t.get(e,{params:s})},runPostApi(e,s){return t.post(e,{params:s})}}});export{i as c};