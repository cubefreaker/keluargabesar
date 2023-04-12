// https://donatso.github.io/family-chart/ v0.0.0-beta-1 Copyright 2021 Donat Soric
!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e(require("d3")):"function"==typeof define&&define.amd?define(["d3"],e):(t="undefined"!=typeof globalThis?globalThis:t||self).f3=e(t.f3)}(this,(function(t){"use strict";function e(t){if(t&&t.__esModule)return t;var e=Object.create(null);return t&&Object.keys(t).forEach((function(n){if("default"!==n){var a=Object.getOwnPropertyDescriptor(t,n);Object.defineProperty(e,n,a.get?a:{enumerable:!0,get:function(){return t[n]}})}})),e.default=t,Object.freeze(e)}var n=e(t),a="object"==typeof window&&window.d3?window.d3:n;function r(t,e,n){return n.find((n=>n.id!==e.id&&(n.id===t.rels.mother||n.id===t.rels.father)))}function d(t,e,n){if(t.exiting=n,e)0!==t.depth||t.spouse?t.spouse?(t._x=t.spouse.x,t._y=t.spouse.y):t.is_ancestry?(t._x=t.parent.x,t._y=t.parent.y):(t._x=t.psx,t._y=t.parent.y):(t._x=t.x,t._y=t.y);else if(n){const e=t.x>0?1:-1,n=t.y>0?1:-1;t._x=t.x+400*e,t._y=t.y+400*n}}function i(t,e){const n=e?"rels":"_rels",a=e?"_rels":"rels";function r(e){t.data[n]&&t.data[n][e]&&(t.data[a]||(t.data[a]={}),t.data[a][e]=t.data[n][e],delete t.data[n][e])}t.is_ancestry||t.data.main?(r("father"),r("mother")):function(){if(!t.data[n]||!t.data[n].children)return;const e=t.data[n].children.slice(0),r=t.spouse?[t.spouse]:t.spouses||[];[t,...r].forEach((t=>e.forEach((e=>{t.data[n].children.includes(e)&&(t.data[a]||(t.data[a]={}),t.data[a].children||(t.data[a].children=[]),t.data[a].children.push(e),t.data[n].children.splice(t.data[n].children.indexOf(e),1))}))))}()}function s(t,e){t.forEach((t=>{t.data.hide_rels=e,i(t,e)}))}function o(t,e){const n=t.rels,a=[n.father,n.mother,...n.spouses||[],...n.children||[]].filter((t=>!!t)),r=[];for(let n=0;n<a.length;n++){if(!d(e.find((t=>t.id===a[n])),[t])){r.push(a[n]);break}}return 0===r.length;function d(t,n){let a;return i(t)&&(a=[t]),function t(r,d){if(a)return;d=[...d,r],s((function(t){i(t)&&(a=d)})),a||s(o);function s(t){const e=r.rels;[e.father,e.mother,...e.spouses||[],...e.children||[]].filter((t=>t&&![...n,...d].find((e=>e.id===t)))).forEach((e=>t(e)))}function o(n){const a=e.find((t=>t.id===n));t(a,d)}}(t,[t]),a}function i(t){return"object"==typeof t?t.id===e[0].id:t===e[0].id}}function c(t,e){return delete t.to_add,t}function l(t,e){return u(t,e),!1}function u(t,e){return o(t,e)?(e.forEach((e=>{for(let n in e.rels)e.rels.hasOwnProperty(n)&&(e.rels[n]===t.id?delete e.rels[n]:Array.isArray(e.rels[n])&&e.rels[n].includes(t.id)&&e.rels[n].splice(e.rels[n].findIndex((e=>e===t.id)),1))})),e.splice(e.findIndex((e=>e.id===t.id)),1),e.forEach((t=>{t.to_add&&u(t,e)})),0===e.length&&e.push(y({}).data[0]),{success:!0}):{success:!1,error:"checkIfRelativesConnectedWithoutPerson"}}function h(t,e){const n=t.data.rels;return[n.father,n.mother,...n.spouses||[],...n.children||[]].filter((t=>t)).every((t=>e.some((e=>e.data.id===t))))}function f(){var t=(new Date).getTime(),e=performance&&performance.now&&1e3*performance.now()||0;return"xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g,(function(n){var a=16*Math.random();return t>0?(a=(t+a)%16|0,t=Math.floor(t/16)):(a=(e+a)%16|0,e=Math.floor(e/16)),("x"===n?a:3&a|8).toString(16)}))}function p({datum:t,data_stash:e,rel_type:n,rel_datum:a}){function r(t){!function(){if(!a.rels.spouses)return;a.rels.spouses.forEach((t=>{const n=e.find((e=>e.id===t));n.to_add&&l(n,e)}))}(),a.rels.spouses||(a.rels.spouses=[]),a.rels.spouses.push(t.id),t.rels.spouses=[a.id]}"daughter"===n||"son"===n?function(t){t.data.other_parent&&(!function(n){"_new"===n&&(n=i().id);const d=e.find((t=>t.id===n));t.rels["M"===d.data.gender?"father":"mother"]=d.id,d.rels.hasOwnProperty("children")||(d.rels.children=[]);function i(){const t=_({rel_type:"spouse",rel_datum:a});return r(t),g({data_stash:e,datum:t}),t}d.rels.children.push(t.id)}(t.data.other_parent),delete t.data.other_parent);t.rels["M"===a.data.gender?"father":"mother"]=a.id,a.rels.children||(a.rels.children=[]);a.rels.children.push(t.id)}(t):"father"===n||"mother"===n?function(t){const n="M"===t.data.gender,r=a.rels[n?"father":"mother"];r&&l(e.find((t=>t.id===r)),e);a.rels[n?"father":"mother"]=t.id,function(){const r=a.rels[n?"mother":"father"];if(!r)return;const d=e.find((t=>t.id===r));t.rels.spouses=[r],d.rels.spouses||(d.rels.spouses=[]),d.rels.spouses.push(t.id)}(),t.rels.children=[a.id]}(t):"spouse"===n&&r(t)}function m({data:t,rels:e}){return{id:f(),data:t||{},rels:e||{}}}function _({data:t,rel_type:e,rel_datum:n}){const a=function(t,e){return["daughter","mother"].includes(e)||"spouse"===e&&"M"===t.data.gender?"F":"M"}(n,e);return m({data:t=Object.assign(t||{},{gender:a})})}function g({data_stash:t,datum:e}){t.push(e)}function y({data:t,version:e}){return{data:[m({data:t})],version:e}}function x({data_stash:t,main_id:e=null,is_vertical:n=!0,node_separation:d=250,level_separation:i=150}){var s;t=function(t){const e=[];for(let e=0;e<t.length;e++){const a=t[e];if(a.rels.children&&a.rels.children.length>0){a.rels.spouses||(a.rels.spouses=[]);const e="M"===a.data.gender;let r;a.rels.children.forEach((d=>{const i=t.find((t=>t.id===d));i.rels[e?"father":"mother"]===a.id&&(i.rels[e?"mother":"father"]||(r||(r=n(a),a.rels.spouses.push(r.id)),r.rels.children.push(i.id),i.rels[e?"mother":"father"]=r.id))}))}}return e.forEach((e=>t.push(e))),t;function n(t){const n=m({data:{gender:"M"===t.data.gender?"F":"M"},rels:{spouses:[t.id],children:[]}});return n.to_add=!0,e.push(n),n}}(t),(s=t).forEach((t=>{t.rels.children&&t.rels.children.sort(((e,n)=>{const a=s.find((t=>t.id===e)),d=s.find((t=>t.id===n)),i=r(a,t,s)||{},o=r(d,t,s)||{},c=t.rels.spouses.indexOf(i.id),l=t.rels.spouses.indexOf(o.id);return"M"===t.data.gender?c-l:l-c}))}));const o=null!==e?t.find((t=>t.id===e)):t[0],c=_(o,"children",!1),l=_(o,"parents",!0);t.forEach((t=>t.main=t===o)),function(t,e){const n=(t[0].x-e[0].x)/2;t.forEach((t=>t.x-=n)),e.forEach((t=>t.x+=n))}(l,c);const u=(f=c,(h=l).forEach((t=>{t.is_ancestry=!0})),h.forEach((t=>1===t.depth?t.parent=f[0]:null)),[...f,...h.slice(1)]);var h,f;!function({tree:t}){t.forEach((e=>{delete e.children,t.forEach((t=>{t.parent===e&&(t.is_ancestry?(e.parents||(e.parents=[]),e.parents.push(t)):(e.children||(e.children=[]),e.children.push(t)))}))}))}({tree:u}),function({tree:e,node_separation:n}){for(let a=e.length;a--;){const r=e[a];if(!r.is_ancestry&&r.data.rels.spouses&&r.data.rels.spouses.length>0){const a="M"===r.data.data.gender?-1:1;r.x+=r.data.rels.spouses.length/2*n*a,r.data.rels.spouses.forEach(((d,i)=>{const s={data:t.find((t=>t.id===d)),added:!0};s.x=r.x-n*(i+1)*a,s.y=r.y,s.sx=i>0?s.x:s.x+n/2*a,s.depth=r.depth,s.spouse=r,r.spouses||(r.spouses=[]),r.spouses.push(s),e.push(s),e.forEach((t=>t.data.rels.father===r.data.id&&t.data.rels.mother===s.data.id||t.data.rels.mother===r.data.id&&t.data.rels.father===s.data.id?t.psx=s.sx:null))}))}if(r.parents&&2===r.parents.length){const t=r.parents[0],e=r.parents[1],a=t.x-(t.x-e.x)/2,d=(t,e)=>a+n/2*(t.x<e.x?1:-1);e.x=d(t,e),t.x=d(e,t)}}}({tree:u,node_separation:d}),function({tree:t,is_vertical:e}){t.forEach((t=>{if(t.y*=t.is_ancestry?-1:1,!e){const e=t.x;t.x=t.y,t.y=e}}))}({tree:u,is_vertical:n});const p=function(t,e,n,r){r||([e,n]=[n,e]);const d=a.extent(t,(t=>t.x)),i=a.extent(t,(t=>t.y));return{width:d[1]-d[0]+e,height:i[1]-i[0]+n,x_off:-d[0]+e/2,y_off:-i[0]+n/2}}(u,d,i,n);return{data:u,data_stash:t,dim:p};function _(e,n,r){const s="children"===n?function(e){return[...e.rels.children||[]].map((e=>t.find((t=>t.id===e))))}:function(e){return[e.rels.father,e.rels.mother].filter((t=>t)).map((e=>t.find((t=>t.id===e))))},o=a.tree().nodeSize([d,i]).separation((function(t,e){let n=1;r||(l(t,e)||(n+=.25),function(t,e){return u(t)||u(e)}(t,e)&&(n+=function(t,e){return.5*Math.max((t.data.rels.spouses||[]).length,(e.data.rels.spouses||[]).length)+.5}(t,e)),l(t,e)&&!function(t,e){return t.data.rels.father===e.data.rels.father&&t.data.rels.mother===e.data.rels.mother}(t,e)&&(n+=.125));return n})),c=a.hierarchy(e,s);return o(c),c.descendants();function l(t,e){return t.parent==e.parent}function u(t){return t.data.rels.spouses&&t.data.rels.spouses.length>0}}}function w({t:t,svg:e,transition_time:n=2e3}){const r=e.__zoomObj;a.select(e).transition().duration(n||0).delay(n?100:0).call(r.transform,a.zoomIdentity.scale(t.k).translate(t.x,t.y))}function $({svg:t,svg_dim:e,tree_dim:n,with_transition:a,transition_time:r}){w({t:function(t,e){let n=Math.min(t.width/e.width,t.height/e.height),a=e.x_off+(t.width-e.width*n)/n/2,r=e.y_off+(t.height-e.height*n)/n/2;n>1&&(a*=n,r*=n,n=1);return{k:n,x:a,y:r}}(e,n),svg:t,with_transition:a,transition_time:r})}function v(t,e){const n=a.line().curve(a.curveMonotoneY),r=a.line().curve(a.curveBasis),d=e?t._d():t.d;return t.curve?!0===t.curve?r(d):void 0:n(d)}function k({d:t,card_dim:e,card_display:n}){return{template:`\n    <g class="card-body">\n      <rect width="${e.w}" height="${e.h}" class="card-body-rect" />\n      <g transform="translate(${e.text_x}, ${e.text_y})">\n        <text clip-path="url(#card_text_clip)">\n          <tspan x="0" dy="14">${n[0](t.data)}</tspan>\n          <tspan x="0" dy="14" font-size="10">${n[1](t.data)}</tspan>\n        </text>\n        <rect width="${e.w-e.text_x-10}" height="${e.h-20}" style="mask: url(#fade)" class="text-overflow-mask" /> \n      </g>\n    </g>\n  `}}function b({d:t,card_dim:e,card_add:n,label:a}){return{template:`\n    <g class="card-body ${n?"card_add":"card-unknown"}">\n      <rect class="card-body-rect" width="${e.w}" height="${e.h}" fill="rgb(59, 85, 96)" />\n      <text transform="translate(${e.w/2}, ${e.h/2})" text-anchor="middle" fill="#fff">\n        <tspan font-size="18" dy="8">${a}</tspan>\n      </text>\n    </g>\n  `}}function M({d:t,card_dim:e,is_new:n}){return{template:`\n    <rect width="${e.w}" height="${e.h}" rx="4" ry="4" class="card-outline ${t.data.main&&!n?"card-main-outline":""} ${n?"card-new-outline":""}" />\n  `}}function E({d:t,card_dim:e,x:n,y:a}){return{template:`\n    <g transform="translate(${n||e.w-20},${a||e.h-20})scale(.6)" style="cursor: pointer" class="card_edit pencil_icon">\n      <circle fill="rgba(0,0,0,0)" r="17" cx="8.5" cy="8.5" />\n      <path fill="currentColor" transform="translate(-1.5, -1.5)"\n         d="M19.082,2.123L17.749,0.79c-1.052-1.052-2.766-1.054-3.819,0L1.925,12.794c-0.06,0.06-0.104,0.135-0.127,0.216\n          l-1.778,6.224c-0.05,0.175-0.001,0.363,0.127,0.491c0.095,0.095,0.223,0.146,0.354,0.146c0.046,0,0.092-0.006,0.137-0.02\n          l6.224-1.778c0.082-0.023,0.156-0.066,0.216-0.127L19.082,5.942C20.134,4.89,20.134,3.176,19.082,2.123z M3.076,13.057l9.428-9.428\n          l3.738,3.739l-9.428,9.428L3.076,13.057z M2.566,13.961l3.345,3.344l-4.683,1.339L2.566,13.961z M18.375,5.235L16.95,6.66\n          l-3.738-3.739l1.425-1.425c0.664-0.663,1.741-0.664,2.405,0l1.333,1.333C19.038,3.493,19.038,4.572,18.375,5.235z"/>\n    </g>\n  `}}function C({d:t,card_dim:e}){return{template:`\n    <g class="card_family_tree" style="cursor: pointer">\n      <rect x="-31" y="-25" width="72" height="15" fill="rgba(0,0,0,0)"></rect>\n      <g transform="translate(${.8*e.w},6)scale(.9)">\n        <rect x="-31" y="-25" width="72" height="15" fill="rgba(0,0,0,0)"></rect>\n        <line y2="-17.5" stroke="#fff" />\n        <line x1="-20" x2="20" y1="-17.5" y2="-17.5" stroke="#fff" />\n        <rect x="-31" y="-25" width="25" height="15" rx="5" ry="5" class="card-male" />\n        <rect x="6" y="-25" width="25" height="15" rx="5" ry="5" class="card-female" />\n      </g>\n    </g>\n  `}}function L({d:t,card_dim:e,x:n,y:a}){return{template:`\n    <g class="card_add_relative">\n      <g transform="translate(${n||e.w/2},${a||e.h})scale(.13)">\n        <circle r="80" cx="40" cy="40" fill="rgba(0,0,0,0)" />\n        <g transform="translate(-10, -8)">\n          <line\n            x1="10" x2="90" y1="50" y2="50"\n            stroke="currentColor" stroke-width="15" stroke-linecap="round"\n          />\n          <line\n            x1="50" x2="50" y1="10" y2="90"\n            stroke="currentColor" stroke-width="15" stroke-linecap="round"\n          />\n        </g>\n      </g>\n    </g>\n  `}}function z({x:t,y:e,rt:n,closed:a}){return{template:`\n    <g style="\n          transform: translate(-12.2px, -.5px);\n          cursor: pointer;\n        " \n        fill="currentColor" class="card_break_link${a?" closed":""}"\n      >\n      <g style="transform: translate(${t}px,${e}px)scale(.02)rotate(${n+"deg"})">\n        <rect width="1000" height="700" y="150" style="opacity: 0" />\n        <g class="link_upper">\n          <g>\n            <path d="M616.3,426.4c19,4.5,38.1-7.4,42.6-26.4c4.4-19-7.4-38-26.5-42.5L522.5,332c-18,11.1-53.9,33.4-53.9,33.4l80.4,18.6c-7.8,4.9-19.5,12.1-31.3,19.4L616.3,426.4L616.3,426.4z"/>\n            <path d="M727.4,244.2c-50.2-11.6-100.3,3.3-135.7,35.4c28.6,22.6,64.5,30.2,116.4,51.3l141,32.6c23.9,5.6,56.6,47.2,51.1,71l-4.1,17c-5.6,23.7-47.3,56.4-71.2,51l-143.4-33.2c-66.8-8.6-104.1-16.6-132.9-7.5c17.4,44.9,55.9,80.8,106.5,92.4L800.9,588c81.3,18.8,162.3-31.5,181.2-112.4l4-17c18.8-81.1-31.7-161.8-112.9-180.6L727.4,244.2z"/>\n          </g>\n        </g>\n        <g class="link_lower">\n          <path d="M421.2,384.9l-128,127.6c-13.9,13.8-13.9,36.2,0,50s36.3,13.8,50.2,0.1l136.2-135.8v-36.7l-58.4,58.1V384.9L421.2,384.9z"/>\n          <path d="M204.6,742.8c-17.4,17.3-63.3,17.2-80.6,0.1l-12.3-12.3c-17.3-17.3,0.6-81.2,17.9-98.5l100.2-99.9c12.5-14.9,45.8-40.8,66.1-103.7c-47.7-9.4-98.9,4.2-135.8,40.9L54.2,575c-58.9,58.8-58.9,154,0,212.8L66.6,800c58.9,58.8,154.5,58.8,213.4,0l105.8-105.6c38.4-38.3,51.3-91.9,39.7-141c-44,22.7-89,62.3-116,84.8L204.6,742.8z"/>\n        </g>\n        <g class="link_particles">\n          <path d="M351.9,248.4l-26.5,63.4l80.6,30.1L351.9,248.4z"/>\n          <path d="M529.3,208l-43,26.6l35.4,52.3L529.3,208z"/>\n          <path d="M426.6,158.8l-44-2.9l61.7,134.6L426.6,158.8z"/>\n        </g>\n      </g>\n    </g>\n  `}}function P({d:t,card_dim:e}){let n="",a=t.data.rels,r=t.data._rels||{},d=t.data.hide_rels,i=t=>t.father||t.mother,s=t=>t.children&&t.children.length>0;if((t.is_ancestry||t.data.main)&&(i(a)||i(r))&&(n+=z({x:e.w/2,y:0,rt:-45,closed:d}).template),!t.is_ancestry&&t.added){const i=t.spouse,o=i.data.rels,c=i.data._rels||{};(s(a)||s(r))&&(s(o)||s(c))&&(n+=z({x:t.sx-t.x+e.w/2+24.4,y:(t.x!==t.sx?e.h/2:e.h)+1,rt:135,closed:d}).template)}return n}function F({d:t,image:e,card_dim:n,maleIcon:a,femaleIcon:r}){return{template:`\n    <g style="transform: translate(${n.img_x}px,${n.img_y}px);" class="card_image" clip-path="url(#card_image_clip)">\n      ${e?`<image href="${e}" height="${n.img_h}" width="${n.img_w}" preserveAspectRatio="xMidYMin slice" />`:"F"===t.data.data.gender&&r?r({card_dim:n}):"M"===t.data.data.gender&&a?a({card_dim:n}):`\n      <g class="genderless-icon">\n        <rect height="${n.img_h}" width="${n.img_w}" fill="rgb(59, 85, 96)" />\n        <g transform="scale(${.001616*n.img_w})">\n         <path transform="translate(50,40)" fill="lightgrey" d="M256 288c79.5 0 144-64.5 144-144S335.5 0 256 0 112 \n            64.5 112 144s64.5 144 144 144zm128 32h-55.1c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16H128C57.3 320 0 377.3 \n            0 448v16c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48v-16c0-70.7-57.3-128-128-128z" />\n        </g>\n      </g>\n    `}      \n    </g>\n  `}}function O({datum:t,data_stash:e,card_dim:n,labels:a}){const r=n.w+40,d=n.h+50,i=a||{};return{data:[{x:0,y:0,data:t=t||{id:"0",data:{fn:"FN",ln:"LN",gender:"M"}}},{x:-100,y:-d,data:{rel_type:"father",data:{label:i.father||"Add father",gender:"M"}}},{x:100,y:-d,data:{rel_type:"mother",data:{label:i.mother||"Add mother",gender:"F"}}},{x:r,y:0,data:{rel_type:"spouse",data:{label:i.spouse||"Add spouse",gender:"F"}}},{x:-100,y:d,data:{rel_type:"son",data:{label:i.son||"Add son",gender:"M"}}},{x:100,y:d,data:{rel_type:"daughter",data:{label:i.daughter||"Add daughter",gender:"F"}}}].filter((n=>{return"father"===(a=n.data.rel_type)?!t.rels.father||e.find((e=>e.id===t.rels.father)).to_add:"mother"!==a||!t.rels.mother||e.find((e=>e.id===t.rels.mother)).to_add;var a}))}}function A(t,{store:e,data_stash:n,cont:a,datum:r,card_dim:d,cardEditForm:i,scale:s}){const o=a.getBoundingClientRect(),c=function(t){return{k:s||1,x:t.width/2,y:t.height/2}}(o);return{template:`\n      <svg id="family-tree-svg" style="width: 100%; height: 100%">\n        <rect width="${o.width}" height="${o.height}" fill="transparent" />\n        <g class="view">\n          <g transform="translate(${c.x}, ${c.y})scale(${c.k})">\n            ${t.data.slice(1).map(((t,e)=>function({d:t,is_vertical:e}){return{template:`\n      <path d="${n()}" fill="none" stroke="#fff" />\n    `};function n(){const{w:n,h:a}=d;let r=e&&t.y<0?{x:0,y:-a/2}:e&&t.y>0?{x:0,y:a/2}:!e&&t.x<0?{x:-n/2,y:0}:!e&&t.x>0?{x:n/2,y:0}:{x:0,y:0};if(e)return"M"+t.x+","+t.y+"C"+t.x+","+(t.y+(t.y<0?50:-50))+" "+r.x+","+(r.y+(t.y<0?-50:50))+" "+r.x+","+r.y;{const e=t.x>0?1:-1;return"M"+t.x+","+t.y+"C"+(r.x+50*e)+","+t.y+" "+(r.x+150*e)+","+r.y+" "+r.x+","+r.y}}}({d:t,is_vertical:!["spouse"].includes(t.data.rel_type)}).template))}\n            ${t.data.slice(1).map(((t,e)=>function({d:t,is_main:e}){const[n,a]=e?[160,60]:[160,40],r={x:t.x,y:t.y};return{template:`\n      <g transform="translate(${r.x}, ${r.y})" class="card" data-rel_type="${t.data.rel_type}" style="cursor: pointer">\n        <g transform="translate(${-n/2}, ${-a/2})">\n          ${d({d:t,w:n,h:a}).template}\n        </g>\n      </g>\n    `};function d({d:t,w:e,h:n}){const a="M"===t.data.data.gender?"card-male":"F"===t.data.data.gender?"card-female":"card-genderless";return{template:`\n        <g>\n          <rect width="${e}" height="${n}" fill="#fff" rx="10" ${t.data.main?'stroke="#000"':""} class="${a}" />\n          <text transform="translate(0, ${n/4})">\n            <tspan x="10" dy="14">${t.data.data.label}</tspan>\n          </text>\n        </g>\n      `}}}({d:t}).template))}\n          </g>\n        </g>\n      </svg>\n    `,mounted:t=>{!function(t){function a(a){if(!a.closest(".card"))return;const d=a.closest(".card").getAttribute("data-rel_type"),s=r,o=_({rel_datum:s,rel_type:d});return i({datum:o,rel_datum:s,rel_type:d,postSubmit:()=>{t.remove(),g({data_stash:n,datum:o}),p({datum:o,data_stash:n,rel_datum:s,rel_type:d}),e.update.tree()},store:e}),!0}t.addEventListener("click",(e=>{a(e.target)||t.remove()}))}(t)}}}function I(t,{card:e,d:n}){return s(t.getTree().data,!1),t.update.mainId(n.data.id),t.update.tree({tree_position:"inherit"}),!0}function T(t,{card:e,d:n,cardEditForm:a}){const r=n.data;a({datum:r,postSubmit:e=>{r.to_add&&c(r,t.getData()),e&&e.delete&&(r.main&&t.update.mainId(null),u(r,t.getData())),t.update.tree()},store:t})}function j(t,{card:e,d:n}){n.data.hide_rels=!n.data.hide_rels,i(n,n.data.hide_rels),t.update.tree({tree_position:"inherit"})}function H(t){const e=(t=function(t){const e={mini_tree:!0,link_break:!0,card_dim:{w:220,h:70,text_x:75,text_y:15,img_w:60,img_h:60,img_x:5,img_y:5}};t||(t={});for(const n in e)void 0===t[n]&&(t[n]=e[n]);return t}(t)).store;return function(){if(t.svg.querySelector("defs#f3CardDef"))return;const e=t.card_dim;function n(t,e,n){const{w:a,h:r}=t,d=e,i=n||[],s=t=>i.includes(t);return`${s("lx")?"M0,0":`M0,${d} Q 0,0 5,0`} ${s("rx")?`H${a}`:`H${a-d} Q ${a},0 ${a},5`} ${s("ry")?`V${r}`:`V${r-d} Q ${a},${r} ${a-d},${r}`} ${s("ly")?"H0":`H${d} Q 0,${r} 0,${r-d}`} z`}t.svg.insertAdjacentHTML("afterbegin",`\n      <defs id="f3CardDef">\n        <linearGradient id="fadeGrad">\n          <stop offset="0.9" stop-color="white" stop-opacity="0"/>\n          <stop offset=".91" stop-color="white" stop-opacity=".5"/>\n          <stop offset="1" stop-color="white" stop-opacity="1"/>\n        </linearGradient>\n        <mask id="fade" maskContentUnits="objectBoundingBox"><rect width="1" height="1" fill="url(#fadeGrad)"/></mask>\n        <clipPath id="card_clip"><path d="${n({w:e.w,h:e.h},5)}"></clipPath>\n        <clipPath id="card_text_clip"><rect width="${e.w-e.text_x-10}" height="${e.h-10}"></rect></clipPath>\n        <clipPath id="card_image_clip"><path d="M0,0 Q 0,0 0,0 H${e.img_w} V${e.img_h} H0 Q 0,${e.img_h} 0,${e.img_h} z"></clipPath>\n        <clipPath id="card_image_clip_curved"><path d="${n({w:e.img_w,h:e.img_h},5,["rx","ry"])}"></clipPath>\n      </defs>\n    `)}(),function({node:n,d:a}){const r=document.createElementNS("http://www.w3.org/2000/svg","g"),d="M"===a.data.data.gender?"card-male":"F"===a.data.data.gender?"card-female":"card-genderless",i=t.card_dim,s=!h(a,e.state.tree.data),o=t.cardEditForm?"ADD":"UNKNOWN";return r.innerHTML=`\n      <g class="card ${d}" data-id="${a.data.id}" data-cy="card">\n        <g transform="translate(${-i.w/2}, ${-i.h/2})">\n          ${t.mini_tree&&!a.data.to_add&&s?C({d:a,card_dim:i}).template:""}\n          ${M({d:a,card_dim:i,is_new:a.data.to_add}).template}\n          <g clip-path="url(#card_clip)">\n            ${a.data.to_add?b({d:a,card_dim:i,card_add:t.cardEditForm,label:o}).template:k({d:a,card_dim:i,card_display:t.card_display}).template}\n            ${a.data.to_add?"":F({d:a,image:a.data.data.avatar||null,card_dim:i,maleIcon:null,femaleIcon:null}).template}\n            ${!a.data.to_add&&t.cardEditForm?E({card_dim:i,x:i.w-46,y:i.h-20}).template:""}\n            ${!a.data.to_add&&t.cardEditForm?L({card_dim:i,x:i.w-26,y:i.h-20}).template:""}\n          </g>\n          ${t.link_break?P({d:a,card_dim:i}):""}\n        </g>\n      </g>\n    `,function(e,n,a){let r;r=e.querySelector(".card"),r&&r.addEventListener("click",(t=>{t.stopPropagation(),I(a,{card:e,d:n})}));r=e.querySelector(".card_edit"),r&&t.cardEditForm&&r.addEventListener("click",(r=>{r.stopPropagation(),T(a,{card:e,d:n,cardEditForm:t.cardEditForm})}));r=e.querySelector(".card_add"),r&&t.cardEditForm&&r.addEventListener("click",(r=>{r.stopPropagation(),T(a,{card:e,d:n,cardEditForm:t.cardEditForm})}));r=e.querySelector(".card_add_relative"),r&&r.addEventListener("click",(e=>{e.stopPropagation(),t.addRelative({d:n})}));r=e.querySelector(".card_family_tree"),r&&r.addEventListener("click",(t=>{t.stopPropagation(),I(a,{card:e,d:n})}));r=e.querySelector(".card_break_link"),r&&r.addEventListener("click",(t=>{t.stopPropagation(),j(a,{card:e,d:n})}))}(r,a,e),r}}return{CalculateTree:x,createStore:function(t){let e;const n=t,a={tree:t=>{n.tree=x({data_stash:n.data,main_id:n.main_id,node_separation:n.node_separation,level_separation:n.level_separation}),e&&e(t)},mainId:t=>n.main_id=t,data:t=>n.data=t};return{state:n,update:a,getData:()=>n.data,getTree:()=>n.tree,setOnUpdate:t=>e=t,methods:{}}},d3AnimationView:function({store:t,cont:e,Card:n}){const r=function(){const t=e.getBoundingClientRect(),n=`\n        <svg class="main_svg">\n          <rect width="${t.width}" height="${t.height}" fill="transparent" />\n          <g class="view">\n            <g class="links_view"></g>\n            <g class="cards_view"></g>\n          </g>\n          <g style="transform: translate(100%, 100%)">\n            <g class="fit_screen_icon cursor-pointer" style="transform: translate(-50px, -50px); display: none">\n              <rect width="27" height="27" stroke-dasharray="13.5" stroke-dashoffset="6.75" \n                style="stroke:#fff;stroke-width:4px;fill:transparent;"/>\n              <circle r="5" cx="13.5" cy="13.5" style="fill:#fff" />          \n            </g>\n          </g>\n        </svg>\n      `,a=document.createElement("div");a.innerHTML=n;const r=a.firstElementChild;return e.innerHTML="",e.appendChild(r),r}();return function(t,e){!function(){if(t.__zoom)return;const n=t.querySelector(".view"),r=a.zoom().on("zoom",(function(t){a.select(n).attr("transform",t.transform)}));a.select(t).call(r),t.__zoomObj=r,e&&r.filter((function(t){return!("wheel"===t.type&&!t.ctrlKey||t.touches&&t.touches.length<2)}))}()}(r,t.state.zoom_polite),{update:function(e){e||(e={});const i=t.state.tree,s=a.select(r).select(".view"),o=e.tree_position||"fit",c=e.hasOwnProperty("transition_time")?e.transition_time:2e3;(function(){const e=s.select(".cards_view").selectAll("g.card_cont").data(i.data,(t=>t.data.id)),o=e.exit(),u=e.enter().append("g").attr("class","card_cont"),h=u.merge(e);function f(t){a.select(this).attr("transform",`translate(${t._x}, ${t._y})`).style("opacity",0).node().appendChild(g(this,t))}function p(t){}function m(t){this.innerHTML="",this.appendChild(g(this,t));const e=l(t);a.select(this).transition().duration(c).delay(e).attr("transform",`translate(${t.x}, ${t.y})`).style("opacity",1)}function _(t){const e=a.select(this);e.transition().duration(c).style("opacity",0).attr("transform",`translate(${t._x}, ${t._y})`).on("end",(()=>e.remove()))}function g(e,a){return n?n({node:e,d:a}):H({store:t,svg:r})({node:e,d:a})}o.each((t=>d(t,!1,!0))),u.each((t=>d(t,!0,!1))),o.each(_),e.each(p),u.each(f),h.each(m)})(),function(){const t=i.data.reduce(((t,e)=>t.concat(function({d:t,tree:e,is_vertical:n}){const a=[];return t.data.rels.spouses&&t.data.rels.spouses.length>0&&function({d:t}){t.data.rels.spouses.forEach((n=>{const r=e.find((t=>t.data.id===n));r&&!t.spouse&&a.push({d:[[t.x,t.y],[r.x,r.y]],_d:()=>[t.is_ancestry?[d(t,"x")-1e-4,d(t,"y")]:[t.x,t.y],t.is_ancestry?[d(r,"x"),d(r,"y")]:[t.x-1e-4,t.y]],curve:!1,id:[t.data.id,r.data.id].join(", "),depth:t.depth,spouse:!0,is_ancestry:r.is_ancestry})}))}({d:t}),function({d:t}){if(!t.parents||0===t.parents.length)return;const e=t.parents[0],n=t.parents[1],d={x:r(e,n,"x"),y:r(e,n,"y")};a.push({d:i(t,d),_d:()=>i({x:t.x,y:t.y},{x:t.x,y:t.y}),curve:!0,id:s(t,t.parents[0],t.parents[1]),depth:t.depth+1,is_ancestry:!0})}({d:t}),function({d:t}){t.children&&0!==t.children.length&&t.children.forEach(((n,r)=>{const o=function(t,e,n){return n.find((n=>n.data.id!==e.data.id&&(n.data.id===t.data.rels.mother||n.data.id===t.data.rels.father)))}(n,t,e),c=o.sx;a.push({d:i(n,{x:c,y:t.y}),_d:()=>i({x:c,y:t.y},{x:d(n,"x"),y:d(n,"y")}),curve:!0,id:s(n,t,o),depth:t.depth+1})}))}({d:t}),a;function r(t,e,n,a){return a?d(t,n)-(d(t,n)-d(e,n))/2:t[n]-(t[n]-e[n])/2}function d(t,e){return t.hasOwnProperty("_"+e)?t["_"+e]:t[e]}function i(t,e){const n=t.y+(e.y-t.y)/2;return[[t.x,t.y],[t.x,n],[t.x,n],[e.x,n],[e.x,n],[e.x,e.y]]}function s(...t){return t.map((t=>t.data.id)).sort().join(", ")}}({d:e,tree:i.data}))),[]),e=s.select(".links_view").selectAll("path.link").data(t,(t=>t.id)),n=e.exit(),r=e.enter().append("path").attr("class","link"),d=r.merge(e);function o(t){a.select(this).attr("fill","none").attr("stroke","#fff").style("opacity",0).attr("d",v(t,!0))}function u(t){const e=a.select(this),n=l(t);e.transition("path").duration(c).delay(n).attr("d",v(t)).style("opacity",1)}function h(t){const e=a.select(this);e.transition("op").duration(800).style("opacity",0),e.transition("path").duration(c).attr("d",v(t,!0)).on("end",(()=>e.remove()))}n.each(h),r.each(o),d.each(u)}(),e.initial?$({svg:r,svg_dim:r.getBoundingClientRect(),tree_dim:i.dim,transition_time:0}):"fit"===o?$({svg:r,svg_dim:r.getBoundingClientRect(),tree_dim:i.dim,transition_time:c}):"main_to_middle"===o&&function({datum:t,svg:e,svg_dim:n,scale:a,transition_time:r}){const d=a||1;w({t:{k:d,x:(n.width/2-t.x*d)/d,y:(n.height/2-t.y)/d},svg:e,with_transition:!0,transition_time:r})}({datum:i.data[0],svg:r,svg_dim:r.getBoundingClientRect(),scale:e.scale,transition_time:c});return!0;function l(t){if(!e.initial)return 0;const n=800,a=Math.max(...i.data.map((t=>t.is_ancestry?t.depth:0)));let r=t.depth*n;return 0===t.depth&&!t.spouse||t.is_ancestry||(r+=a*n,t.spouse&&(r+=n),r+=t.depth*n),r}},svg:r,setCard:t=>n=t}},handlers:Object.freeze({__proto__:null,moveToAddToAdded:c,removeToAdd:l,deletePerson:u,manualZoom:function({amount:t,svg:e,transition_time:n=500}){const r=e.__zoomObj;a.select(e).transition().duration(n||0).delay(n?100:0).call(r.scaleBy,t)},isAllRelativeDisplayed:h,generateUUID:f,cardChangeMain:I,cardEdit:T,cardShowHideRels:j,handleRelsOfNewDatum:p,createNewPerson:m,createNewPersonWithGenderFromRel:_,addNewPerson:g,createTreeDataWithMainNode:y,addNewPersonAndHandleRels:function({datum:t,data_stash:e,rel_type:n,rel_datum:a}){g({data_stash:e,datum:t}),p({datum:t,data_stash:e,rel_type:n,rel_datum:a})},checkIfRelativesConnectedWithoutPerson:o,AddRelative:function({store:t,cont:e,card_dim:n,cardEditForm:r,labels:d}){return function({d:i,scale:o}){!o&&window.innerWidth<650&&(o=window.innerWidth/650),s(t.getTree().data,!1),t.update.mainId(i.data.id),t.update.tree({tree_position:"main_to_middle",transition_time:1e3,scale:o});!function(t){const e=A(O(t),t),n=document.createElement("div");n.style.cssText="width: 100%; height: 100%; position: absolute; top: 0; left: 0;background-color: rgba(0,0,0,.3);opacity: 0",n.innerHTML=e.template,t.cont.appendChild(n),e.mounted(n),a.select(n).transition().duration(t.transition_time).delay(t.transition_time/4).style("opacity",1)}({store:t,data_stash:t.getData(),cont:e,datum:i.data,transition_time:1e3,scale:o,card_dim:n,cardEditForm:r,labels:d})}}}),elements:Object.freeze({__proto__:null,CardBody:k,CardBodyAddNew:b,CardBodyOutline:M,PencilIcon:E,HideIcon:function({d:t,card_dim:e}){return{template:`\n    <g transform="translate(${e.w-50},${e.h-20})scale(.035)" style="cursor: pointer" class="card_hide_rels hide_rels_icon">\n      <circle fill="rgba(0,0,0,0)" r="256" cx="256" cy="256" />\n      <g fill="currentColor">\n        <path d="m34,256l26.2,26.2c108,108 283.7,108 391.7,0l26.1-26.2-26.2-26.2c-108-108-283.7-108-391.7,0l-26.1,\n          26.2zm222,126.2c-75.8,0-151.6-28.9-209.3-86.6l-32.9-32.9c-3.7-3.7-3.7-9.7 0-13.5l32.9-32.9c115.4-115.4 303.2-115.4 418.6,\n          0l32.9,32.9c3.7,3.7 3.7,9.7 0,13.5l-32.9,32.9c-57.7,57.7-133.5,86.6-209.3,86.6z"/>\n        <path d="m256,183.5c-40,0-72.5,32.5-72.5,72.5s32.5,72.5 72.5,72.5c40,0 72.5-32.5 72.5-72.5s-32.5-72.5-72.5-72.5zm0,\n          164c-50.5,0-91.5-41.1-91.5-91.5 0-50.5 41.1-91.5 91.5-91.5s91.5,41.1 91.5,91.5c0,50.5-41,91.5-91.5,91.5z"/>\n      </g>\n    </g>\n  `}},MiniTree:C,PlusIcon:L,LinkBreakIcon:z,LinkBreakIconWrapper:P,CardImage:F,Card:H})}}));