/* Copyright  2007 - 2010 YOOtheme GmbH, YOOtheme Proprietary Use License (http://www.yootheme.com/license) */

(function(g){g.fn.matchHeight=function(e){var a=0;this.each(function(){a=Math.max(a,g(this).height())});if(e)a=Math.max(a,e);return this.each(function(){g(this).css("min-height",a)})};g.fn.morph=function(e,a,c,b,d){var f={duration:500,transition:"swing",ignore:null};c=g.extend(f,c);b=g.extend(f,b);var h=c.ignore?g(c.ignore):null;if(h)h=h.toArray();return this.each(function(){var i=g(this);if(!(h&&g.inArray(this,h)!=-1)){var j=d?i.find(d):[i];i.bind({mouseenter:function(){g(j).each(function(){g(this).stop().animate(e,
c.duration,c.transition)})},mouseleave:function(){g(j).each(function(){g(this).stop().animate(a,b.duration,b.transition)})}})}})};g.fn.smoothScroller=function(e){e=g.extend({duration:1E3,transition:"easeOutExpo"},e);return this.each(function(){g(this).bind("click",function(){var a=this.hash,c=g(this.hash).offset().top;if(window.location.href.replace(window.location.hash,"")+a==this){g("html:not(:animated),body:not(:animated)").animate({scrollTop:c},e.duration,e.transition,function(){window.location.hash=
a.replace("#","")});return false}})})};g.fn.backgroundFx=function(e){e=g.extend({duration:9E3,transition:"swing",colors:["#FFFFFF","#999999"]},e);return this.each(function(){var a=g(this),c=0,b=e.colors;window.setInterval(function(){a.stop().animate({"background-color":b[c]},e.duration,e.transition);c=c+1>=b.length?0:c+1},e.duration*2)})}})(jQuery);
(function(g){function e(c){var b;if(c&&c.constructor==Array&&c.length==3)return c;if(b=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(c))return[parseInt(b[1]),parseInt(b[2]),parseInt(b[3])];if(b=/rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(c))return[parseFloat(b[1])*2.55,parseFloat(b[2])*2.55,parseFloat(b[3])*2.55];if(b=/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(c))return[parseInt(b[1],16),parseInt(b[2],
16),parseInt(b[3],16)];if(b=/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(c))return[parseInt(b[1]+b[1],16),parseInt(b[2]+b[2],16),parseInt(b[3]+b[3],16)];if(/rgba\(0, 0, 0, 0\)/.exec(c))return a.transparent;return a[g.trim(c).toLowerCase()]}g.each(["backgroundColor","borderBottomColor","borderLeftColor","borderRightColor","borderTopColor","color","outlineColor"],function(c,b){g.fx.step[b]=function(d){if(!d.colorInit){var f;f=d.elem;var h=b,i;do{i=g.curCSS(f,h);if(i!=""&&i!="transparent"||g.nodeName(f,
"body"))break;h="backgroundColor"}while(f=f.parentNode);f=e(i);d.start=f;d.end=e(d.end);d.colorInit=true}d.elem.style[b]="rgb("+[Math.max(Math.min(parseInt(d.pos*(d.end[0]-d.start[0])+d.start[0]),255),0),Math.max(Math.min(parseInt(d.pos*(d.end[1]-d.start[1])+d.start[1]),255),0),Math.max(Math.min(parseInt(d.pos*(d.end[2]-d.start[2])+d.start[2]),255),0)].join(",")+")"}});var a={aqua:[0,255,255],azure:[240,255,255],beige:[245,245,220],black:[0,0,0],blue:[0,0,255],brown:[165,42,42],cyan:[0,255,255],darkblue:[0,
0,139],darkcyan:[0,139,139],darkgrey:[169,169,169],darkgreen:[0,100,0],darkkhaki:[189,183,107],darkmagenta:[139,0,139],darkolivegreen:[85,107,47],darkorange:[255,140,0],darkorchid:[153,50,204],darkred:[139,0,0],darksalmon:[233,150,122],darkviolet:[148,0,211],fuchsia:[255,0,255],gold:[255,215,0],green:[0,128,0],indigo:[75,0,130],khaki:[240,230,140],lightblue:[173,216,230],lightcyan:[224,255,255],lightgreen:[144,238,144],lightgrey:[211,211,211],lightpink:[255,182,193],lightyellow:[255,255,224],lime:[0,
255,0],magenta:[255,0,255],maroon:[128,0,0],navy:[0,0,128],olive:[128,128,0],orange:[255,165,0],pink:[255,192,203],purple:[128,0,128],violet:[128,0,128],red:[255,0,0],silver:[192,192,192],white:[255,255,255],yellow:[255,255,0],transparent:[255,255,255]}})(jQuery);
(function(g){g.easing.jswing=g.easing.swing;g.extend(g.easing,{def:"easeOutQuad",swing:function(e,a,c,b,d){return g.easing[g.easing.def](e,a,c,b,d)},easeInQuad:function(e,a,c,b,d){return b*(a/=d)*a+c},easeOutQuad:function(e,a,c,b,d){return-b*(a/=d)*(a-2)+c},easeInOutQuad:function(e,a,c,b,d){if((a/=d/2)<1)return b/2*a*a+c;return-b/2*(--a*(a-2)-1)+c},easeInCubic:function(e,a,c,b,d){return b*(a/=d)*a*a+c},easeOutCubic:function(e,a,c,b,d){return b*((a=a/d-1)*a*a+1)+c},easeInOutCubic:function(e,a,c,b,
d){if((a/=d/2)<1)return b/2*a*a*a+c;return b/2*((a-=2)*a*a+2)+c},easeInQuart:function(e,a,c,b,d){return b*(a/=d)*a*a*a+c},easeOutQuart:function(e,a,c,b,d){return-b*((a=a/d-1)*a*a*a-1)+c},easeInOutQuart:function(e,a,c,b,d){if((a/=d/2)<1)return b/2*a*a*a*a+c;return-b/2*((a-=2)*a*a*a-2)+c},easeInQuint:function(e,a,c,b,d){return b*(a/=d)*a*a*a*a+c},easeOutQuint:function(e,a,c,b,d){return b*((a=a/d-1)*a*a*a*a+1)+c},easeInOutQuint:function(e,a,c,b,d){if((a/=d/2)<1)return b/2*a*a*a*a*a+c;return b/2*((a-=
2)*a*a*a*a+2)+c},easeInSine:function(e,a,c,b,d){return-b*Math.cos(a/d*(Math.PI/2))+b+c},easeOutSine:function(e,a,c,b,d){return b*Math.sin(a/d*(Math.PI/2))+c},easeInOutSine:function(e,a,c,b,d){return-b/2*(Math.cos(Math.PI*a/d)-1)+c},easeInExpo:function(e,a,c,b,d){return a==0?c:b*Math.pow(2,10*(a/d-1))+c},easeOutExpo:function(e,a,c,b,d){return a==d?c+b:b*(-Math.pow(2,-10*a/d)+1)+c},easeInOutExpo:function(e,a,c,b,d){if(a==0)return c;if(a==d)return c+b;if((a/=d/2)<1)return b/2*Math.pow(2,10*(a-1))+c;
return b/2*(-Math.pow(2,-10*--a)+2)+c},easeInCirc:function(e,a,c,b,d){return-b*(Math.sqrt(1-(a/=d)*a)-1)+c},easeOutCirc:function(e,a,c,b,d){return b*Math.sqrt(1-(a=a/d-1)*a)+c},easeInOutCirc:function(e,a,c,b,d){if((a/=d/2)<1)return-b/2*(Math.sqrt(1-a*a)-1)+c;return b/2*(Math.sqrt(1-(a-=2)*a)+1)+c},easeInElastic:function(e,a,c,b,d){e=1.70158;var f=0,h=b;if(a==0)return c;if((a/=d)==1)return c+b;f||(f=d*0.3);if(h<Math.abs(b)){h=b;e=f/4}else e=f/(2*Math.PI)*Math.asin(b/h);return-(h*Math.pow(2,10*(a-=
1))*Math.sin((a*d-e)*2*Math.PI/f))+c},easeOutElastic:function(e,a,c,b,d){e=1.70158;var f=0,h=b;if(a==0)return c;if((a/=d)==1)return c+b;f||(f=d*0.3);if(h<Math.abs(b)){h=b;e=f/4}else e=f/(2*Math.PI)*Math.asin(b/h);return h*Math.pow(2,-10*a)*Math.sin((a*d-e)*2*Math.PI/f)+b+c},easeInOutElastic:function(e,a,c,b,d){e=1.70158;var f=0,h=b;if(a==0)return c;if((a/=d/2)==2)return c+b;f||(f=d*0.3*1.5);if(h<Math.abs(b)){h=b;e=f/4}else e=f/(2*Math.PI)*Math.asin(b/h);if(a<1)return-0.5*h*Math.pow(2,10*(a-=1))*Math.sin((a*
d-e)*2*Math.PI/f)+c;return h*Math.pow(2,-10*(a-=1))*Math.sin((a*d-e)*2*Math.PI/f)*0.5+b+c},easeInBack:function(e,a,c,b,d,f){if(f==undefined)f=1.70158;return b*(a/=d)*a*((f+1)*a-f)+c},easeOutBack:function(e,a,c,b,d,f){if(f==undefined)f=1.70158;return b*((a=a/d-1)*a*((f+1)*a+f)+1)+c},easeInOutBack:function(e,a,c,b,d,f){if(f==undefined)f=1.70158;if((a/=d/2)<1)return b/2*a*a*(((f*=1.525)+1)*a-f)+c;return b/2*((a-=2)*a*(((f*=1.525)+1)*a+f)+2)+c},easeInBounce:function(e,a,c,b,d){return b-g.easing.easeOutBounce(e,
d-a,0,b,d)+c},easeOutBounce:function(e,a,c,b,d){return(a/=d)<1/2.75?b*7.5625*a*a+c:a<2/2.75?b*(7.5625*(a-=1.5/2.75)*a+0.75)+c:a<2.5/2.75?b*(7.5625*(a-=2.25/2.75)*a+0.9375)+c:b*(7.5625*(a-=2.625/2.75)*a+0.984375)+c},easeInOutBounce:function(e,a,c,b,d){if(a<d/2)return g.easing.easeInBounce(e,a*2,0,b,d)*0.5+c;return g.easing.easeOutBounce(e,a*2-d,0,b,d)*0.5+b*0.5+c}})})(jQuery);
