(() => {
'use strict';
const data=window.BAS_ENV_DATA,bar=document.getElementById('wpadminbar');
if(!data||!bar||!window.BAS_ENV_COLORS)return;
function update(){const badge=document.getElementById('wp-admin-bar-bas-environment');if(!badge)return;const background=getComputedStyle(bar).backgroundColor;const parts=background.match(/[\d.]+/g);const toolbar=parts&&parts.length>=3?'#'+parts.slice(0,3).map(n=>Math.min(255,Math.round(Number(n))).toString(16).padStart(2,'0')).join(''):'#1d2327';const tone=window.BAS_ENV_COLORS.resolve(data.type,data.colors[data.type],toolbar);badge.style.setProperty('--bas-env-bg',tone.background);badge.style.setProperty('--bas-env-text',tone.text);badge.style.setProperty('--bas-env-icon-filter',tone.text!=='#ffffff'?'brightness(0) saturate(100%)':'none')}
window.BAS_ENV_UPDATE=update;
update();
})();
