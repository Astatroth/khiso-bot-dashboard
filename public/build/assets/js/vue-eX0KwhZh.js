var m=Object.defineProperty;var f=(i,a,r)=>a in i?m(i,a,{enumerable:!0,configurable:!0,writable:!0,value:r}):i[a]=r;var c=(i,a,r)=>(f(i,typeof a!="symbol"?a+"":a,r),r);import{_ as h}from"./Artisan-CHLSoHl4.js";import{_ as b}from"./News-CshRQUbm.js";import{_ as g,a as y,b as w}from"./Olympiad-BgJGcGrt.js";import{_ as T}from"./Seo-BYQ-J4Hk.js";import{_ as M}from"./Student-D73GE5zC.js";import{_ as v}from"./Telegram-FkYv6tcR.js";import{_ as q}from"./TranslationManager-DCKl07Ok.js";import{V as l}from"./vue-ROl3rvO-.js";import{V as _}from"./vue-i18n-DAWOLBlH.js";import{V as k}from"./vue-cookies-IN-XQBb0.js";import"./vuejs-paginate-DpguzPcy.js";import"./jquery-B7BXwPI6.js";(async()=>{class i{constructor(e){c(this,"i18n",null);this.i18n=e}get(e,s){this.request("get",e,s)}post(e,s){this.request("post",e,s)}put(e,s){this.request("put",e,s)}patch(e,s){this.request("patch",e,s)}delete(e,s){this.request("delete",e,s)}request(e,s,t={}){axios.interceptors.request.clear();let u={method:e,url:s};t.payload&&(e==="get"?u.url+="?"+this.implodeRequestParameters(t.payload):u.data=t.payload),t.headers&&(u.headers=t.headers),typeof t.before=="function"&&axios.interceptors.request.use(o=>(t.before(),o)),axios(u).then(o=>{t.success&&typeof t.success=="function"&&t.success(o.data)}).catch(o=>{if(o.response.status)switch(o.response.status){case 419:window.location.reload();break;case 400:case 406:toastr.error(o.response.data.message);break;case 405:case 422:for(let d in o.response.data.errors)toastr.error(o.response.data.errors[d]);break;case 500:default:toastr.error(this.i18n.t("status.server_error"));break}typeof t.fail=="function"&&t.fail(o.response)}).finally(()=>{t.done&&typeof t.done=="function"&&t.done()})}implodeRequestParameters(e){return new URLSearchParams(e)}}window.Vue=l;let a={};await axios.get("/messages.json").then(n=>{a=n.data}).catch(n=>{toastr.error(n.config.url+": "+n.message)});const r=new _({locale:document.documentElement.lang,messages:a});l.prototype.$backend=new i(r),l.use(k);const p=Object.assign({"./Modules/Artisan/ArtisanUi.vue":h,"./Modules/News/NewsTable.vue":b,"./Modules/Olympiad/OlympiadsTable.vue":g,"./Modules/Olympiad/QuestionsTable.vue":y,"./Modules/Olympiad/ResultsTable.vue":w,"./Modules/Seo/SeoTable.vue":T,"./Modules/Student/StudentsTable.vue":M,"./Modules/Telegram/TelegramChannelsTable.vue":v,"./Modules/TranslationManager/TranslationManager.vue":q});for(const n in p){const e=n.split("/").at(-1).split(".")[0];l.component(`${e}`,p[n].default)}document.getElementById("app")&&new l({el:"#app",i18n:r})})();
