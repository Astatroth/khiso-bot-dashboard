/*!
 * vue-i18n v8.28.2 
 * (c) 2022 kazuya kawaguchi
 * Released under the MIT License.
 */var J=["compactDisplay","currency","currencyDisplay","currencySign","localeMatcher","notation","numberingSystem","signDisplay","style","unit","unitDisplay","useGrouping","minimumIntegerDigits","minimumFractionDigits","maximumFractionDigits","minimumSignificantDigits","maximumSignificantDigits"],it=["dateStyle","timeStyle","calendar","localeMatcher","hour12","hourCycle","timeZone","formatMatcher","weekday","era","year","month","day","hour","minute","second","timeZoneName"];function D(t,e){typeof console<"u"&&console.warn("[vue-i18n] "+t)}function st(t,e){typeof console<"u"&&console.error("[vue-i18n] "+t)}var w=Array.isArray;function k(t){return t!==null&&typeof t=="object"}function ot(t){return typeof t=="boolean"}function v(t){return typeof t=="string"}var lt=Object.prototype.toString,ct="[object Object]";function $(t){return lt.call(t)===ct}function y(t){return t==null}function P(t){return typeof t=="function"}function j(){for(var t=[],e=arguments.length;e--;)t[e]=arguments[e];var n=null,a=null;return t.length===1?k(t[0])||w(t[0])?a=t[0]:typeof t[0]=="string"&&(n=t[0]):t.length===2&&(typeof t[0]=="string"&&(n=t[0]),(k(t[1])||w(t[1]))&&(a=t[1])),{locale:n,params:a}}function L(t){return JSON.parse(JSON.stringify(t))}function ut(t,e){if(t.delete(e))return t}function ht(t){var e=[];return t.forEach(function(n){return e.push(n)}),e}function x(t,e){return!!~t.indexOf(e)}var ft=Object.prototype.hasOwnProperty;function pt(t,e){return ft.call(t,e)}function I(t){for(var e=arguments,n=Object(t),a=1;a<arguments.length;a++){var r=e[a];if(r!=null){var i=void 0;for(i in r)pt(r,i)&&(k(r[i])?n[i]=I(n[i],r[i]):n[i]=r[i])}}return n}function S(t,e){if(t===e)return!0;var n=k(t),a=k(e);if(n&&a)try{var r=w(t),i=w(e);if(r&&i)return t.length===e.length&&t.every(function(l,u){return S(l,e[u])});if(!r&&!i){var o=Object.keys(t),s=Object.keys(e);return o.length===s.length&&o.every(function(l){return S(t[l],e[l])})}else return!1}catch{return!1}else return!n&&!a?String(t)===String(e):!1}function mt(t){return t.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&apos;")}function _t(t){return t!=null&&Object.keys(t).forEach(function(e){typeof t[e]=="string"&&(t[e]=mt(t[e]))}),t}function gt(t){t.prototype.hasOwnProperty("$i18n")||Object.defineProperty(t.prototype,"$i18n",{get:function(){return this._i18n}}),t.prototype.$t=function(e){for(var n=[],a=arguments.length-1;a-- >0;)n[a]=arguments[a+1];var r=this.$i18n;return r._t.apply(r,[e,r.locale,r._getMessages(),this].concat(n))},t.prototype.$tc=function(e,n){for(var a=[],r=arguments.length-2;r-- >0;)a[r]=arguments[r+2];var i=this.$i18n;return i._tc.apply(i,[e,i.locale,i._getMessages(),this,n].concat(a))},t.prototype.$te=function(e,n){var a=this.$i18n;return a._te(e,a.locale,a._getMessages(),n)},t.prototype.$d=function(e){for(var n,a=[],r=arguments.length-1;r-- >0;)a[r]=arguments[r+1];return(n=this.$i18n).d.apply(n,[e].concat(a))},t.prototype.$n=function(e){for(var n,a=[],r=arguments.length-1;r-- >0;)a[r]=arguments[r+1];return(n=this.$i18n).n.apply(n,[e].concat(a))}}function vt(t){t===void 0&&(t=!1);function e(){this!==this.$root&&this.$options.__INTLIFY_META__&&this.$el&&this.$el.setAttribute("data-intlify",this.$options.__INTLIFY_META__)}return t?{mounted:e}:{beforeCreate:function(){var n=this.$options;if(n.i18n=n.i18n||(n.__i18nBridge||n.__i18n?{}:null),n.i18n){if(n.i18n instanceof c){if(n.__i18nBridge||n.__i18n)try{var a=n.i18n&&n.i18n.messages?n.i18n.messages:{},r=n.__i18nBridge||n.__i18n;r.forEach(function(p){a=I(a,JSON.parse(p))}),Object.keys(a).forEach(function(p){n.i18n.mergeLocaleMessage(p,a[p])})}catch{}this._i18n=n.i18n,this._i18nWatcher=this._i18n.watchI18nData()}else if($(n.i18n)){var i=this.$root&&this.$root.$i18n&&this.$root.$i18n instanceof c?this.$root.$i18n:null;if(i&&(n.i18n.root=this.$root,n.i18n.formatter=i.formatter,n.i18n.fallbackLocale=i.fallbackLocale,n.i18n.formatFallbackMessages=i.formatFallbackMessages,n.i18n.silentTranslationWarn=i.silentTranslationWarn,n.i18n.silentFallbackWarn=i.silentFallbackWarn,n.i18n.pluralizationRules=i.pluralizationRules,n.i18n.preserveDirectiveContent=i.preserveDirectiveContent),n.__i18nBridge||n.__i18n)try{var o=n.i18n&&n.i18n.messages?n.i18n.messages:{},s=n.__i18nBridge||n.__i18n;s.forEach(function(p){o=I(o,JSON.parse(p))}),n.i18n.messages=o}catch{}var l=n.i18n,u=l.sharedMessages;u&&$(u)&&(n.i18n.messages=I(n.i18n.messages,u)),this._i18n=new c(n.i18n),this._i18nWatcher=this._i18n.watchI18nData(),(n.i18n.sync===void 0||n.i18n.sync)&&(this._localeWatcher=this.$i18n.watchLocale()),i&&i.onComponentInstanceCreated(this._i18n)}}else this.$root&&this.$root.$i18n&&this.$root.$i18n instanceof c?this._i18n=this.$root.$i18n:n.parent&&n.parent.$i18n&&n.parent.$i18n instanceof c&&(this._i18n=n.parent.$i18n)},beforeMount:function(){var n=this.$options;n.i18n=n.i18n||(n.__i18nBridge||n.__i18n?{}:null),n.i18n?n.i18n instanceof c?(this._i18n.subscribeDataChanging(this),this._subscribing=!0):$(n.i18n)&&(this._i18n.subscribeDataChanging(this),this._subscribing=!0):this.$root&&this.$root.$i18n&&this.$root.$i18n instanceof c?(this._i18n.subscribeDataChanging(this),this._subscribing=!0):n.parent&&n.parent.$i18n&&n.parent.$i18n instanceof c&&(this._i18n.subscribeDataChanging(this),this._subscribing=!0)},mounted:e,beforeDestroy:function(){if(this._i18n){var n=this;this.$nextTick(function(){n._subscribing&&(n._i18n.unsubscribeDataChanging(n),delete n._subscribing),n._i18nWatcher&&(n._i18nWatcher(),n._i18n.destroyVM(),delete n._i18nWatcher),n._localeWatcher&&(n._localeWatcher(),delete n._localeWatcher)})}}}}var Z={name:"i18n",functional:!0,props:{tag:{type:[String,Boolean,Object],default:"span"},path:{type:String,required:!0},locale:{type:String},places:{type:[Array,Object]}},render:function(t,e){var n=e.data,a=e.parent,r=e.props,i=e.slots,o=a.$i18n;if(o){var s=r.path,l=r.locale,u=r.places,p=i(),f=o.i(s,l,bt(p)||u?dt(p.default,u):p),h=r.tag&&r.tag!==!0||r.tag===!1?r.tag:"span";return h?t(h,n,f):f}}};function bt(t){var e;for(e in t)if(e!=="default")return!1;return!!e}function dt(t,e){var n=e?yt(e):{};if(!t)return n;t=t.filter(function(r){return r.tag||r.text.trim()!==""});var a=t.every(kt);return t.reduce(a?Ft:Y,n)}function yt(t){return Array.isArray(t)?t.reduce(Y,{}):Object.assign({},t)}function Ft(t,e){return e.data&&e.data.attrs&&e.data.attrs.place&&(t[e.data.attrs.place]=e),t}function Y(t,e,n){return t[n]=e,t}function kt(t){return!!(t.data&&t.data.attrs&&t.data.attrs.place)}var X={name:"i18n-n",functional:!0,props:{tag:{type:[String,Boolean,Object],default:"span"},value:{type:Number,required:!0},format:{type:[String,Object]},locale:{type:String}},render:function(t,e){var n=e.props,a=e.parent,r=e.data,i=a.$i18n;if(!i)return null;var o=null,s=null;v(n.format)?o=n.format:k(n.format)&&(n.format.key&&(o=n.format.key),s=Object.keys(n.format).reduce(function(h,_){var g;return x(J,_)?Object.assign({},h,(g={},g[_]=n.format[_],g)):h},null));var l=n.locale||i.locale,u=i._ntp(n.value,l,o,s),p=u.map(function(h,_){var g,F=r.scopedSlots&&r.scopedSlots[h.type];return F?F((g={},g[h.type]=h.value,g.index=_,g.parts=u,g)):h.value}),f=n.tag&&n.tag!==!0||n.tag===!1?n.tag:"span";return f?t(f,{attrs:r.attrs,class:r.class,staticClass:r.staticClass},p):p}};function wt(t,e,n){K(t,n)&&Q(t,e,n)}function $t(t,e,n,a){if(K(t,n)){var r=n.context.$i18n;Tt(t,n)&&S(e.value,e.oldValue)&&S(t._localeMessage,r.getLocaleMessage(r.locale))||Q(t,e,n)}}function Mt(t,e,n,a){var r=n.context;if(!r){D("Vue instance does not exists in VNode context");return}var i=n.context.$i18n||{};!e.modifiers.preserve&&!i.preserveDirectiveContent&&(t.textContent=""),t._vt=void 0,delete t._vt,t._locale=void 0,delete t._locale,t._localeMessage=void 0,delete t._localeMessage}function K(t,e){var n=e.context;return n?n.$i18n?!0:(D("VueI18n instance does not exists in Vue instance"),!1):(D("Vue instance does not exists in VNode context"),!1)}function Tt(t,e){var n=e.context;return t._locale===n.$i18n.locale}function Q(t,e,n){var a,r,i=e.value,o=Ct(i),s=o.path,l=o.locale,u=o.args,p=o.choice;if(!s&&!l&&!u){D("value type not supported");return}if(!s){D("`path` is required in v-t directive");return}var f=n.context;p!=null?t._vt=t.textContent=(a=f.$i18n).tc.apply(a,[s,p].concat(tt(l,u))):t._vt=t.textContent=(r=f.$i18n).t.apply(r,[s].concat(tt(l,u))),t._locale=f.$i18n.locale,t._localeMessage=f.$i18n.getLocaleMessage(f.$i18n.locale)}function Ct(t){var e,n,a,r;return v(t)?e=t:$(t)&&(e=t.path,n=t.locale,a=t.args,r=t.choice),{path:e,locale:n,args:a,choice:r}}function tt(t,e){var n=[];return t&&n.push(t),e&&(Array.isArray(e)||$(e))&&n.push(e),n}var d;function B(t,e){e===void 0&&(e={bridge:!1}),B.installed=!0,d=t,d.version&&Number(d.version.split(".")[0]),gt(d),d.mixin(vt(e.bridge)),d.directive("t",{bind:wt,update:$t,unbind:Mt}),d.component(Z.name,Z),d.component(X.name,X);var n=d.config.optionMergeStrategies;n.i18n=function(a,r){return r===void 0?a:r}}var et=function(){this._caches=Object.create(null)};et.prototype.interpolate=function(t,e){if(!e)return[t];var n=this._caches[t];return n||(n=Lt(t),this._caches[t]=n),Ot(n,e)};var It=/^(?:\d)+/,Dt=/^(?:\w)+/;function Lt(t){for(var e=[],n=0,a="";n<t.length;){var r=t[n++];if(r==="{"){a&&e.push({type:"text",value:a}),a="";var i="";for(r=t[n++];r!==void 0&&r!=="}";)i+=r,r=t[n++];var o=r==="}",s=It.test(i)?"list":o&&Dt.test(i)?"named":"unknown";e.push({value:i,type:s})}else r==="%"?t[n]!=="{"&&(a+=r):a+=r}return a&&e.push({type:"text",value:a}),e}function Ot(t,e){var n=[],a=0,r=Array.isArray(e)?"list":k(e)?"named":"unknown";if(r==="unknown")return n;for(;a<t.length;){var i=t[a];switch(i.type){case"text":n.push(i.value);break;case"list":n.push(e[parseInt(i.value,10)]);break;case"named":r==="named"&&n.push(e[i.value]);break}a++}return n}var b=0,O=1,nt=2,rt=3,U=0,E=1,R=2,T=3,M=4,H=5,V=6,A=7,W=8,C=[];C[U]={ws:[U],ident:[T,b],"[":[M],eof:[A]},C[E]={ws:[E],".":[R],"[":[M],eof:[A]},C[R]={ws:[R],ident:[T,b],0:[T,b],number:[T,b]},C[T]={ident:[T,b],0:[T,b],number:[T,b],ws:[E,O],".":[R,O],"[":[M,O],eof:[A,O]},C[M]={"'":[H,b],'"':[V,b],"[":[M,nt],"]":[E,rt],eof:W,else:[M,b]},C[H]={"'":[M,b],eof:W,else:[H,b]},C[V]={'"':[M,b],eof:W,else:[V,b]};var xt=/^\s?(?:true|false|-?[\d.]+|'[^']*'|"[^"]*")\s?$/;function Wt(t){return xt.test(t)}function Nt(t){var e=t.charCodeAt(0),n=t.charCodeAt(t.length-1);return e===n&&(e===34||e===39)?t.slice(1,-1):t}function jt(t){if(t==null)return"eof";var e=t.charCodeAt(0);switch(e){case 91:case 93:case 46:case 34:case 39:return t;case 95:case 36:case 45:return"ident";case 9:case 10:case 13:case 160:case 65279:case 8232:case 8233:return"ws"}return"ident"}function St(t){var e=t.trim();return t.charAt(0)==="0"&&isNaN(t)?!1:Wt(e)?Nt(e):"*"+e}function Et(t){var e=[],n=-1,a=U,r=0,i,o,s,l,u,p,f,h=[];h[O]=function(){o!==void 0&&(e.push(o),o=void 0)},h[b]=function(){o===void 0?o=s:o+=s},h[nt]=function(){h[b](),r++},h[rt]=function(){if(r>0)r--,a=M,h[b]();else{if(r=0,o===void 0||(o=St(o),o===!1))return!1;h[O]()}};function _(){var g=t[n+1];if(a===H&&g==="'"||a===V&&g==='"')return n++,s="\\"+g,h[b](),!0}for(;a!==null;)if(n++,i=t[n],!(i==="\\"&&_())){if(l=jt(i),f=C[a],u=f[l]||f.else||W,u===W||(a=u[0],p=h[u[1]],p&&(s=u[2],s=s===void 0?i:s,p()===!1)))return;if(a===A)return e}}var z=function(){this._cache=Object.create(null)};z.prototype.parsePath=function(t){var e=this._cache[t];return e||(e=Et(t),e&&(this._cache[t]=e)),e||[]},z.prototype.getPathValue=function(t,e){if(!k(t))return null;var n=this.parsePath(e);if(n.length===0)return null;for(var a=n.length,r=t,i=0;i<a;){var o=r[n[i]];if(o==null)return null;r=o,i++}return r};var Rt=/<\/?[\w\s="/.':;#-\/]+>/,Ht=/(?:@(?:\.[a-zA-Z]+)?:(?:[\w\-_|./]+|\([\w\-_:|./]+\)))/g,Vt=/^@(?:\.([a-zA-Z]+))?:/,At=/[()]/g,at={upper:function(t){return t.toLocaleUpperCase()},lower:function(t){return t.toLocaleLowerCase()},capitalize:function(t){return""+t.charAt(0).toLocaleUpperCase()+t.substr(1)}},G=new et,c=function(t){var e=this;t===void 0&&(t={}),!d&&typeof window<"u"&&window.Vue&&B(window.Vue);var n=t.locale||"en-US",a=t.fallbackLocale===!1?!1:t.fallbackLocale||"en-US",r=t.messages||{},i=t.dateTimeFormats||t.datetimeFormats||{},o=t.numberFormats||{};this._vm=null,this._formatter=t.formatter||G,this._modifiers=t.modifiers||{},this._missing=t.missing||null,this._root=t.root||null,this._sync=t.sync===void 0?!0:!!t.sync,this._fallbackRoot=t.fallbackRoot===void 0?!0:!!t.fallbackRoot,this._fallbackRootWithEmptyString=t.fallbackRootWithEmptyString===void 0?!0:!!t.fallbackRootWithEmptyString,this._formatFallbackMessages=t.formatFallbackMessages===void 0?!1:!!t.formatFallbackMessages,this._silentTranslationWarn=t.silentTranslationWarn===void 0?!1:t.silentTranslationWarn,this._silentFallbackWarn=t.silentFallbackWarn===void 0?!1:!!t.silentFallbackWarn,this._dateTimeFormatters={},this._numberFormatters={},this._path=new z,this._dataListeners=new Set,this._componentInstanceCreatedListener=t.componentInstanceCreatedListener||null,this._preserveDirectiveContent=t.preserveDirectiveContent===void 0?!1:!!t.preserveDirectiveContent,this.pluralizationRules=t.pluralizationRules||{},this._warnHtmlInMessage=t.warnHtmlInMessage||"off",this._postTranslation=t.postTranslation||null,this._escapeParameterHtml=t.escapeParameterHtml||!1,"__VUE_I18N_BRIDGE__"in t&&(this.__VUE_I18N_BRIDGE__=t.__VUE_I18N_BRIDGE__),this.getChoiceIndex=function(s,l){var u=Object.getPrototypeOf(e);if(u&&u.getChoiceIndex){var p=u.getChoiceIndex;return p.call(e,s,l)}var f=function(h,_){return h=Math.abs(h),_===2?h?h>1?1:0:1:h?Math.min(h,2):0};return e.locale in e.pluralizationRules?e.pluralizationRules[e.locale].apply(e,[s,l]):f(s,l)},this._exist=function(s,l){return!s||!l?!1:!!(!y(e._path.getPathValue(s,l))||s[l])},(this._warnHtmlInMessage==="warn"||this._warnHtmlInMessage==="error")&&Object.keys(r).forEach(function(s){e._checkLocaleMessage(s,e._warnHtmlInMessage,r[s])}),this._initVM({locale:n,fallbackLocale:a,messages:r,dateTimeFormats:i,numberFormats:o})},m={vm:{configurable:!0},messages:{configurable:!0},dateTimeFormats:{configurable:!0},numberFormats:{configurable:!0},availableLocales:{configurable:!0},locale:{configurable:!0},fallbackLocale:{configurable:!0},formatFallbackMessages:{configurable:!0},missing:{configurable:!0},formatter:{configurable:!0},silentTranslationWarn:{configurable:!0},silentFallbackWarn:{configurable:!0},preserveDirectiveContent:{configurable:!0},warnHtmlInMessage:{configurable:!0},postTranslation:{configurable:!0},sync:{configurable:!0}};c.prototype._checkLocaleMessage=function(t,e,n){var a=[],r=function(i,o,s,l){if($(s))Object.keys(s).forEach(function(f){var h=s[f];$(h)?(l.push(f),l.push("."),r(i,o,h,l),l.pop(),l.pop()):(l.push(f),r(i,o,h,l),l.pop())});else if(w(s))s.forEach(function(f,h){$(f)?(l.push("["+h+"]"),l.push("."),r(i,o,f,l),l.pop(),l.pop()):(l.push("["+h+"]"),r(i,o,f,l),l.pop())});else if(v(s)){var u=Rt.test(s);if(u){var p="Detected HTML in message '"+s+"' of keypath '"+l.join("")+"' at '"+o+"'. Consider component interpolation with '<i18n>' to avoid XSS. See https://bit.ly/2ZqJzkp";i==="warn"?D(p):i==="error"&&st(p)}}};r(e,t,n,a)},c.prototype._initVM=function(t){var e=d.config.silent;d.config.silent=!0,this._vm=new d({data:t,__VUE18N__INSTANCE__:!0}),d.config.silent=e},c.prototype.destroyVM=function(){this._vm.$destroy()},c.prototype.subscribeDataChanging=function(t){this._dataListeners.add(t)},c.prototype.unsubscribeDataChanging=function(t){ut(this._dataListeners,t)},c.prototype.watchI18nData=function(){var t=this;return this._vm.$watch("$data",function(){for(var e=ht(t._dataListeners),n=e.length;n--;)d.nextTick(function(){e[n]&&e[n].$forceUpdate()})},{deep:!0})},c.prototype.watchLocale=function(t){if(t){if(!this.__VUE_I18N_BRIDGE__)return null;var e=this,n=this._vm;return this.vm.$watch("locale",function(r){n.$set(n,"locale",r),e.__VUE_I18N_BRIDGE__&&t&&(t.locale.value=r),n.$forceUpdate()},{immediate:!0})}else{if(!this._sync||!this._root)return null;var a=this._vm;return this._root.$i18n.vm.$watch("locale",function(r){a.$set(a,"locale",r),a.$forceUpdate()},{immediate:!0})}},c.prototype.onComponentInstanceCreated=function(t){this._componentInstanceCreatedListener&&this._componentInstanceCreatedListener(t,this)},m.vm.get=function(){return this._vm},m.messages.get=function(){return L(this._getMessages())},m.dateTimeFormats.get=function(){return L(this._getDateTimeFormats())},m.numberFormats.get=function(){return L(this._getNumberFormats())},m.availableLocales.get=function(){return Object.keys(this.messages).sort()},m.locale.get=function(){return this._vm.locale},m.locale.set=function(t){this._vm.$set(this._vm,"locale",t)},m.fallbackLocale.get=function(){return this._vm.fallbackLocale},m.fallbackLocale.set=function(t){this._localeChainCache={},this._vm.$set(this._vm,"fallbackLocale",t)},m.formatFallbackMessages.get=function(){return this._formatFallbackMessages},m.formatFallbackMessages.set=function(t){this._formatFallbackMessages=t},m.missing.get=function(){return this._missing},m.missing.set=function(t){this._missing=t},m.formatter.get=function(){return this._formatter},m.formatter.set=function(t){this._formatter=t},m.silentTranslationWarn.get=function(){return this._silentTranslationWarn},m.silentTranslationWarn.set=function(t){this._silentTranslationWarn=t},m.silentFallbackWarn.get=function(){return this._silentFallbackWarn},m.silentFallbackWarn.set=function(t){this._silentFallbackWarn=t},m.preserveDirectiveContent.get=function(){return this._preserveDirectiveContent},m.preserveDirectiveContent.set=function(t){this._preserveDirectiveContent=t},m.warnHtmlInMessage.get=function(){return this._warnHtmlInMessage},m.warnHtmlInMessage.set=function(t){var e=this,n=this._warnHtmlInMessage;if(this._warnHtmlInMessage=t,n!==t&&(t==="warn"||t==="error")){var a=this._getMessages();Object.keys(a).forEach(function(r){e._checkLocaleMessage(r,e._warnHtmlInMessage,a[r])})}},m.postTranslation.get=function(){return this._postTranslation},m.postTranslation.set=function(t){this._postTranslation=t},m.sync.get=function(){return this._sync},m.sync.set=function(t){this._sync=t},c.prototype._getMessages=function(){return this._vm.messages},c.prototype._getDateTimeFormats=function(){return this._vm.dateTimeFormats},c.prototype._getNumberFormats=function(){return this._vm.numberFormats},c.prototype._warnDefault=function(t,e,n,a,r,i){if(!y(n))return n;if(this._missing){var o=this._missing.apply(null,[t,e,a,r]);if(v(o))return o}if(this._formatFallbackMessages){var s=j.apply(void 0,r);return this._render(e,i,s.params,e)}else return e},c.prototype._isFallbackRoot=function(t){return(this._fallbackRootWithEmptyString?!t:y(t))&&!y(this._root)&&this._fallbackRoot},c.prototype._isSilentFallbackWarn=function(t){return this._silentFallbackWarn instanceof RegExp?this._silentFallbackWarn.test(t):this._silentFallbackWarn},c.prototype._isSilentFallback=function(t,e){return this._isSilentFallbackWarn(e)&&(this._isFallbackRoot()||t!==this.fallbackLocale)},c.prototype._isSilentTranslationWarn=function(t){return this._silentTranslationWarn instanceof RegExp?this._silentTranslationWarn.test(t):this._silentTranslationWarn},c.prototype._interpolate=function(t,e,n,a,r,i,o){if(!e)return null;var s=this._path.getPathValue(e,n);if(w(s)||$(s))return s;var l;if(y(s))if($(e)){if(l=e[n],!(v(l)||P(l)))return null}else return null;else if(v(s)||P(s))l=s;else return null;return v(l)&&(l.indexOf("@:")>=0||l.indexOf("@.")>=0)&&(l=this._link(t,e,l,a,"raw",i,o)),this._render(l,r,i,n)},c.prototype._link=function(t,e,n,a,r,i,o){var s=n,l=s.match(Ht);for(var u in l)if(l.hasOwnProperty(u)){var p=l[u],f=p.match(Vt),h=f[0],_=f[1],g=p.replace(h,"").replace(At,"");if(x(o,g))return s;o.push(g);var F=this._interpolate(t,e,g,a,r==="raw"?"string":r,r==="raw"?void 0:i,o);if(this._isFallbackRoot(F)){if(!this._root)throw Error("unexpected error");var N=this._root.$i18n;F=N._translate(N._getMessages(),N.locale,N.fallbackLocale,g,a,r,i)}F=this._warnDefault(t,g,F,a,w(i)?i:[i],r),this._modifiers.hasOwnProperty(_)?F=this._modifiers[_](F):at.hasOwnProperty(_)&&(F=at[_](F)),o.pop(),s=F?s.replace(p,F):s}return s},c.prototype._createMessageContext=function(t,e,n,a){var r=this,i=w(t)?t:[],o=k(t)?t:{},s=function(f){return i[f]},l=function(f){return o[f]},u=this._getMessages(),p=this.locale;return{list:s,named:l,values:t,formatter:e,path:n,messages:u,locale:p,linked:function(f){return r._interpolate(p,u[p]||{},f,null,a,void 0,[f])}}},c.prototype._render=function(t,e,n,a){if(P(t))return t(this._createMessageContext(n,this._formatter||G,a,e));var r=this._formatter.interpolate(t,n,a);return r||(r=G.interpolate(t,n,a)),e==="string"&&!v(r)?r.join(""):r},c.prototype._appendItemToChain=function(t,e,n){var a=!1;return x(t,e)||(a=!0,e&&(a=e[e.length-1]!=="!",e=e.replace(/!/g,""),t.push(e),n&&n[e]&&(a=n[e]))),a},c.prototype._appendLocaleToChain=function(t,e,n){var a,r=e.split("-");do{var i=r.join("-");a=this._appendItemToChain(t,i,n),r.splice(-1,1)}while(r.length&&a===!0);return a},c.prototype._appendBlockToChain=function(t,e,n){for(var a=!0,r=0;r<e.length&&ot(a);r++){var i=e[r];v(i)&&(a=this._appendLocaleToChain(t,i,n))}return a},c.prototype._getLocaleChain=function(t,e){if(t==="")return[];this._localeChainCache||(this._localeChainCache={});var n=this._localeChainCache[t];if(!n){e||(e=this.fallbackLocale),n=[];for(var a=[t];w(a);)a=this._appendBlockToChain(n,a,e);var r;w(e)?r=e:k(e)?e.default?r=e.default:r=null:r=e,v(r)?a=[r]:a=r,a&&this._appendBlockToChain(n,a,null),this._localeChainCache[t]=n}return n},c.prototype._translate=function(t,e,n,a,r,i,o){for(var s=this._getLocaleChain(e,n),l,u=0;u<s.length;u++){var p=s[u];if(l=this._interpolate(p,t[p],a,r,i,o,[a]),!y(l))return l}return null},c.prototype._t=function(t,e,n,a){for(var r,i=[],o=arguments.length-4;o-- >0;)i[o]=arguments[o+4];if(!t)return"";var s=j.apply(void 0,i);this._escapeParameterHtml&&(s.params=_t(s.params));var l=s.locale||e,u=this._translate(n,l,this.fallbackLocale,t,a,"string",s.params);if(this._isFallbackRoot(u)){if(!this._root)throw Error("unexpected error");return(r=this._root).$t.apply(r,[t].concat(i))}else return u=this._warnDefault(l,t,u,a,i,"string"),this._postTranslation&&u!==null&&u!==void 0&&(u=this._postTranslation(u,t)),u},c.prototype.t=function(t){for(var e,n=[],a=arguments.length-1;a-- >0;)n[a]=arguments[a+1];return(e=this)._t.apply(e,[t,this.locale,this._getMessages(),null].concat(n))},c.prototype._i=function(t,e,n,a,r){var i=this._translate(n,e,this.fallbackLocale,t,a,"raw",r);if(this._isFallbackRoot(i)){if(!this._root)throw Error("unexpected error");return this._root.$i18n.i(t,e,r)}else return this._warnDefault(e,t,i,a,[r],"raw")},c.prototype.i=function(t,e,n){return t?(v(e)||(e=this.locale),this._i(t,e,this._getMessages(),null,n)):""},c.prototype._tc=function(t,e,n,a,r){for(var i,o=[],s=arguments.length-5;s-- >0;)o[s]=arguments[s+5];if(!t)return"";r===void 0&&(r=1);var l={count:r,n:r},u=j.apply(void 0,o);return u.params=Object.assign(l,u.params),o=u.locale===null?[u.params]:[u.locale,u.params],this.fetchChoice((i=this)._t.apply(i,[t,e,n,a].concat(o)),r)},c.prototype.fetchChoice=function(t,e){if(!t||!v(t))return null;var n=t.split("|");return e=this.getChoiceIndex(e,n.length),n[e]?n[e].trim():t},c.prototype.tc=function(t,e){for(var n,a=[],r=arguments.length-2;r-- >0;)a[r]=arguments[r+2];return(n=this)._tc.apply(n,[t,this.locale,this._getMessages(),null,e].concat(a))},c.prototype._te=function(t,e,n){for(var a=[],r=arguments.length-3;r-- >0;)a[r]=arguments[r+3];var i=j.apply(void 0,a).locale||e;return this._exist(n[i],t)},c.prototype.te=function(t,e){return this._te(t,this.locale,this._getMessages(),e)},c.prototype.getLocaleMessage=function(t){return L(this._vm.messages[t]||{})},c.prototype.setLocaleMessage=function(t,e){(this._warnHtmlInMessage==="warn"||this._warnHtmlInMessage==="error")&&this._checkLocaleMessage(t,this._warnHtmlInMessage,e),this._vm.$set(this._vm.messages,t,e)},c.prototype.mergeLocaleMessage=function(t,e){(this._warnHtmlInMessage==="warn"||this._warnHtmlInMessage==="error")&&this._checkLocaleMessage(t,this._warnHtmlInMessage,e),this._vm.$set(this._vm.messages,t,I(typeof this._vm.messages[t]<"u"&&Object.keys(this._vm.messages[t]).length?Object.assign({},this._vm.messages[t]):{},e))},c.prototype.getDateTimeFormat=function(t){return L(this._vm.dateTimeFormats[t]||{})},c.prototype.setDateTimeFormat=function(t,e){this._vm.$set(this._vm.dateTimeFormats,t,e),this._clearDateTimeFormat(t,e)},c.prototype.mergeDateTimeFormat=function(t,e){this._vm.$set(this._vm.dateTimeFormats,t,I(this._vm.dateTimeFormats[t]||{},e)),this._clearDateTimeFormat(t,e)},c.prototype._clearDateTimeFormat=function(t,e){for(var n in e){var a=t+"__"+n;this._dateTimeFormatters.hasOwnProperty(a)&&delete this._dateTimeFormatters[a]}},c.prototype._localizeDateTime=function(t,e,n,a,r,i){for(var o=e,s=a[o],l=this._getLocaleChain(e,n),u=0;u<l.length;u++){var p=o,f=l[u];if(s=a[f],o=f,!(y(s)||y(s[r])))break}if(y(s)||y(s[r]))return null;var h=s[r],_;if(i)_=new Intl.DateTimeFormat(o,Object.assign({},h,i));else{var g=o+"__"+r;_=this._dateTimeFormatters[g],_||(_=this._dateTimeFormatters[g]=new Intl.DateTimeFormat(o,h))}return _.format(t)},c.prototype._d=function(t,e,n,a){if(!n){var r=a?new Intl.DateTimeFormat(e,a):new Intl.DateTimeFormat(e);return r.format(t)}var i=this._localizeDateTime(t,e,this.fallbackLocale,this._getDateTimeFormats(),n,a);if(this._isFallbackRoot(i)){if(!this._root)throw Error("unexpected error");return this._root.$i18n.d(t,n,e)}else return i||""},c.prototype.d=function(t){for(var e=[],n=arguments.length-1;n-- >0;)e[n]=arguments[n+1];var a=this.locale,r=null,i=null;return e.length===1?(v(e[0])?r=e[0]:k(e[0])&&(e[0].locale&&(a=e[0].locale),e[0].key&&(r=e[0].key)),i=Object.keys(e[0]).reduce(function(o,s){var l;return x(it,s)?Object.assign({},o,(l={},l[s]=e[0][s],l)):o},null)):e.length===2&&(v(e[0])&&(r=e[0]),v(e[1])&&(a=e[1])),this._d(t,a,r,i)},c.prototype.getNumberFormat=function(t){return L(this._vm.numberFormats[t]||{})},c.prototype.setNumberFormat=function(t,e){this._vm.$set(this._vm.numberFormats,t,e),this._clearNumberFormat(t,e)},c.prototype.mergeNumberFormat=function(t,e){this._vm.$set(this._vm.numberFormats,t,I(this._vm.numberFormats[t]||{},e)),this._clearNumberFormat(t,e)},c.prototype._clearNumberFormat=function(t,e){for(var n in e){var a=t+"__"+n;this._numberFormatters.hasOwnProperty(a)&&delete this._numberFormatters[a]}},c.prototype._getNumberFormatter=function(t,e,n,a,r,i){for(var o=e,s=a[o],l=this._getLocaleChain(e,n),u=0;u<l.length;u++){var p=o,f=l[u];if(s=a[f],o=f,!(y(s)||y(s[r])))break}if(y(s)||y(s[r]))return null;var h=s[r],_;if(i)_=new Intl.NumberFormat(o,Object.assign({},h,i));else{var g=o+"__"+r;_=this._numberFormatters[g],_||(_=this._numberFormatters[g]=new Intl.NumberFormat(o,h))}return _},c.prototype._n=function(t,e,n,a){if(!c.availabilities.numberFormat)return"";if(!n){var r=a?new Intl.NumberFormat(e,a):new Intl.NumberFormat(e);return r.format(t)}var i=this._getNumberFormatter(t,e,this.fallbackLocale,this._getNumberFormats(),n,a),o=i&&i.format(t);if(this._isFallbackRoot(o)){if(!this._root)throw Error("unexpected error");return this._root.$i18n.n(t,Object.assign({},{key:n,locale:e},a))}else return o||""},c.prototype.n=function(t){for(var e=[],n=arguments.length-1;n-- >0;)e[n]=arguments[n+1];var a=this.locale,r=null,i=null;return e.length===1?v(e[0])?r=e[0]:k(e[0])&&(e[0].locale&&(a=e[0].locale),e[0].key&&(r=e[0].key),i=Object.keys(e[0]).reduce(function(o,s){var l;return x(J,s)?Object.assign({},o,(l={},l[s]=e[0][s],l)):o},null)):e.length===2&&(v(e[0])&&(r=e[0]),v(e[1])&&(a=e[1])),this._n(t,a,r,i)},c.prototype._ntp=function(t,e,n,a){if(!c.availabilities.numberFormat)return[];if(!n){var r=a?new Intl.NumberFormat(e,a):new Intl.NumberFormat(e);return r.formatToParts(t)}var i=this._getNumberFormatter(t,e,this.fallbackLocale,this._getNumberFormats(),n,a),o=i&&i.formatToParts(t);if(this._isFallbackRoot(o)){if(!this._root)throw Error("unexpected error");return this._root.$i18n._ntp(t,e,n,a)}else return o||[]},Object.defineProperties(c.prototype,m);var q;Object.defineProperty(c,"availabilities",{get:function(){if(!q){var t=typeof Intl<"u";q={dateTimeFormat:t&&typeof Intl.DateTimeFormat<"u",numberFormat:t&&typeof Intl.NumberFormat<"u"}}return q}}),c.install=B,c.version="8.28.2";export{c as V};
