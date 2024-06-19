import{M as l,T as e}from"./News-CshRQUbm.js";import{n as i}from"./Artisan-CHLSoHl4.js";const o={data(){return{columns:[{name:"ID",slug:"id",sortable:!0,width:75},{name:this.$t("First name"),slug:"first_name",sortable:!0},{name:this.$t("Last name"),slug:"last_name",sortable:!0},{name:this.$t("Region"),slug:"region.name",sortable:!0}]}},mixins:[l,e]};var r=function(){var t=this,s=t._self._c;return s("div",{staticClass:"vue-component",attrs:{id:"students-table"}},[s("DynamicTable",{ref:"table",attrs:{"route-source":t.routeSource,columns:t.columns,"initial-sorting":t.sorting,"enable-search":!0,id:"students"},scopedSlots:t._u([{key:"region.name",fn:function({row:a}){return[t._v(" "+t._s(a.region.name)+" ")]}},{key:"actions",fn:function({row:a}){return[s("a",{staticClass:"btn text-primary me-2",attrs:{href:"javascript:void(0)",title:t.$t("View details")},on:{click:function(v){return t.openModal("modal",a)}}},[s("i",{staticClass:"fa-duotone fa-eye"})])]}}])}),s("div",{ref:"modal",staticClass:"modal",attrs:{tabindex:"-1"}},[s("div",{staticClass:"modal-dialog modal-dialog-centered"},[s("div",{staticClass:"modal-content"},[s("div",{staticClass:"modal-header bg-primary text-white"},[s("h5",{staticClass:"modal-title"},[t._v(" "+t._s(t.$t("User details"))+" ")]),s("button",{staticClass:"btn-close",attrs:{type:"button","data-bs-dismiss":"modal","aria-label":"Close"}})]),t.entry?s("div",{staticClass:"modal-body"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col"},[s("div",{staticClass:"form-group"},[s("label",{staticClass:"control-label"},[t._v(t._s(t.$t("Name")))]),s("input",{staticClass:"form-control-plaintext",attrs:{type:"text",readonly:"",id:"name"},domProps:{value:t.entry.fullName}})])]),s("div",{staticClass:"col"},[s("div",{staticClass:"form-group"},[s("label",{staticClass:"control-label"},[t._v(t._s(t.$t("Phone number")))]),s("a",{staticClass:"form-control-plaintext",attrs:{href:"tel:"+t.entry.phoneNumber}},[t._v(" "+t._s(t.entry.phoneNumber)+" ")])])])]),s("div",{staticClass:"row"},[s("div",{staticClass:"col"},[s("div",{staticClass:"form-group"},[s("label",{staticClass:"control-label"},[t._v(t._s(t.$t("Date of birth")))]),s("input",{staticClass:"form-control-plaintext",attrs:{type:"text",readonly:"",id:"dob"},domProps:{value:t.entry.date_of_birth+" ("+t.entry.age+")"}})])]),s("div",{staticClass:"col"},[s("label",{staticClass:"control-label"},[t._v(t._s(t.$t("Gender")))]),s("div",{staticClass:"form-control-plaintext",attrs:{id:"gender"}},[t._v(" "+t._s(t.entry.gender)+" ")])])]),s("div",{staticClass:"row"},[s("div",{staticClass:"col"},[s("label",{staticClass:"control-label"},[t._v(t._s(t.$t("Region")))]),s("div",{staticClass:"form-control-plaintext",attrs:{id:"region"}},[t._v(" "+t._s(t.entry.region.name)+" ")])]),s("div",{staticClass:"col"},[s("label",{staticClass:"control-label"},[t._v(t._s(t.$t("District")))]),s("div",{staticClass:"form-control-plaintext",attrs:{id:"district"}},[t._v(" "+t._s(t.entry.district.name)+" ")])])]),s("div",{staticClass:"row"},[s("div",{staticClass:"col"},[s("label",{staticClass:"control-label"},[t._v(t._s(t.$t("Institution")))]),s("div",{staticClass:"form-control-plaintext",attrs:{id:"institution"}},[t._v(" "+t._s(t.entry.institution.name)+" ")])]),s("div",{staticClass:"col"},[s("label",{staticClass:"control-label"},[t._v(t._s(t.$t("Grade")))]),s("div",{staticClass:"form-control-plaintext",attrs:{id:"grade"}},[t._v(" "+t._s(t.entry.grade)+" ")])])])]):t._e()])])])],1)},n=[],c=i(o,r,n,!1,null,null);const d=c.exports,m=Object.freeze(Object.defineProperty({__proto__:null,default:d},Symbol.toStringTag,{value:"Module"}));export{m as _};