/* Shared color calculation for the settings preview and the toolbar. */
(() => {
'use strict';
const defaults={local:185,development:39,staging:270,production:132};
const valid=c=>/^#[0-9a-f]{6}$/i.test(c||'');
const rgb=c=>(valid(c)?c:'#1d2327').slice(1).match(/../g).map(x=>parseInt(x,16));
const hex=v=>'#'+v.map(n=>Math.round(Math.max(0,Math.min(255,n))).toString(16).padStart(2,'0')).join('');
function hsl(c){const [r,g,b]=rgb(c).map(x=>x/255),hi=Math.max(r,g,b),lo=Math.min(r,g,b),d=hi-lo,l=(hi+lo)/2;let h=0,s=0;if(d){s=d/(1-Math.abs(2*l-1));switch(hi){case r:h=((g-b)/d)%6;break;case g:h=(b-r)/d+2;break;default:h=(r-g)/d+4}h=(h*60+360)%360}return [h,s,l]}
function fromHsl(h,s,l){h=((h%360)+360)%360;const c=(1-Math.abs(2*l-1))*s,x=c*(1-Math.abs((h/60)%2-1)),m=l-c/2;let v;if(h<60)v=[c,x,0];else if(h<120)v=[x,c,0];else if(h<180)v=[0,c,x];else if(h<240)v=[0,x,c];else if(h<300)v=[x,0,c];else v=[c,0,x];return hex(v.map(n=>(n+m)*255))}
function luminance(c){const [r,g,b]=rgb(c).map(n=>{n/=255;return n<=.04045?n/12.92:((n+.055)/1.055)**2.4});return .2126*r+.7152*g+.0722*b}
const contrast=(a,b)=>{const x=luminance(a),y=luminance(b);return (Math.max(x,y)+.05)/(Math.min(x,y)+.05)};
function resolve(type,custom,toolbar){toolbar=valid(toolbar)?toolbar:'#1d2327';let tone;if(valid(custom)){tone=custom.toLowerCase()}else{const barHue=hsl(toolbar)[0],base=defaults[type]??185,opposite=(barHue+180)%360;let delta=((opposite-base+540)%360)-180;delta=Math.max(-22,Math.min(22,delta*.25));tone=fromHsl(base+delta,.65,.58)}
 // Preserve custom hue: change only lightness when adjacent colors merge.
 if(contrast(tone,toolbar)<3){const [h,s,l]=hsl(tone);for(let step=1;step<=100;step++){const choices=[l-step/100,l+step/100].filter(x=>x>=0&&x<=1);const match=choices.map(x=>fromHsl(h,s,x)).find(c=>contrast(c,toolbar)>=3);if(match){tone=match;break}}}
 const text=contrast(tone,'#17202b')>=4.5?'#17202b':contrast(tone,'#ffffff')>=4.5?'#ffffff':'#000000';return {background:tone,text,contrast:contrast(tone,toolbar)};
}
window.BAS_ENV_COLORS={resolve,defaults};
})();
