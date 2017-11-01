(function(){

	var sections;
	var popup;
	var clipContainer;
	var clipText;

	$(function(){
		$(".idean-styleguide-collapse").on("click", toggleCollapse);
		$(".idean-styleguide-collapse.all").on("click", toggleCollapseAll);
		$(".idean-styleguide-fullscreen").on("click", openFullScreen);
		$(".idean-styleguide-popup-close").on("click", closeFullScreen);

		sections = $('.idean-styleguide-page');
		sections.hide();

		var currentHash = $(".idean-styleguide-menu a[href="+window.location.hash+"]");
		if(currentHash.length > 0){
			var section = sections.filter("#"+currentHash.data("page")).show();
			$(window).scrollTop(section.position().top);
			currentHash.addClass("active");
		}
		else{
			sections.eq(0).show();
			$(".idean-styleguide-menu a[href=#"+sections.eq(0).attr("id")+"]").addClass("active");
		}

		window.onhashchange = setHashChange;

		$(".idean-styleguide-menu ul").on("click", "a", testPage);
		$(".idean-styleguide-menu .idean-styleguide-menu-button").on("click", toggleMenu);

		popup = $(".idean-styleguide-popup");

		$("body").on("scroll click", bodyClick);

		clipContainer = $("#idean-styleguide-clipboard-container");
		if(clipContainer.length === 0){
			clipContainer = $('<div id="idean-styleguide-clipboard-container"></div>');
			$("body").append(clipContainer);
		}
		$(".idean-styleguide-code").on("click", selectCode);

		$("body").on('keydown', testCopyDown);
		$("body").on('keyup', testCopyUp);
	});
	
	function setHashChange(){
		var currentHash = $(".idean-styleguide-menu a[href="+window.location.hash+"]");
		if(currentHash.length > 0){
			$(".idean-styleguide-menu a").removeClass("active");
			currentHash.addClass("active");
		}
	}

	function toggleCollapse(ev){
		ev.preventDefault();
		$(this).siblings("pre").slideToggle();
		ev.stopPropagation();
		closeMenu();
		cancelCodeSelection();
	}
	function toggleCollapseAll(ev){
		ev.preventDefault();
		var pre = $(this).parent().find("pre");
		if(pre.filter(":visible").length > 0){
			pre.slideUp();
		}
		else{
			pre.slideDown();
		}
	}
	function testPage(ev){
		var currentPage = sections.filter("#"+$(this).data("page"));
		if(currentPage.filter(":visible").length === 0){
			sections.hide();
			currentPage.show();
		}
	}
	function toggleMenu(ev){
		ev.preventDefault();
		ev.stopPropagation();
		$(".idean-styleguide-menu-button").toggleClass("close");
		$(".idean-styleguide-menu").toggleClass("open");
		cancelCodeSelection();
	}
	function closeMenu(){
		$(".idean-styleguide-menu-button").removeClass("close");
		$(".idean-styleguide-menu").removeClass("open");
	}
	function bodyClick(ev){
		closeMenu();
		cancelCodeSelection();
	}

	function openFullScreen(ev){
		ev.preventDefault();
		var example = $(this).siblings(".idean-styleguide-demo-example").clone();
		popup.find(".idean-styleguide-popup-code").empty().append(example);
		popup.show();
	}
	function closeFullScreen(ev){
		ev.preventDefault();
		popup.find(".idean-styleguide-popup-code").empty();
		popup.hide();
	}

	var createTextarea = function (val) {
		clipText = $('<textarea id="idean-styleguide-clipboard-text">'+val+'</textarea>')
		clipContainer.empty().append(clipText).addClass("open");
		//clipText.focus(); //This messes with the scrolling for some reason.
		clipText.select();
	}

	function cancelCodeSelection(){
		$(".idean-styleguide-code.selected").removeClass("selected");
	}
	var selectCode = function(ev){
		cancelCodeSelection();
		closeMenu();
		if (window.getSelection && window.getSelection() && window.getSelection().toString()) {
		    return
		}
		if (document.selection && document.selection.createRange().text) {
		    return
		}
		$(this).addClass("selected");
		ev.stopPropagation();
	}

	var testCopyDown = function(ev){
		var code = ev.keyCode || ev.which;
		if (!(ev.ctrlKey || ev.metaKey)) {
		    return
		}
		var selectedText = $(".idean-styleguide-code.selected");
		if(selectedText.length === 0){
			return;
		}
		if(!clipContainer.hasClass("open")){
			var text = selectedText.siblings(".idean-styleguide-demo-block").find(".idean-styleguide-demo-example").html();
			setTimeout(function(){ createTextarea(text) }, 0)
		}
	}
	var testCopyUp = function(ev){
		clipContainer.removeClass("open");
	}

	/* http://prismjs.com/download.html?themes=prism&languages=markup */
	self="undefined"!=typeof window?window:"undefined"!=typeof WorkerGlobalScope&&self instanceof WorkerGlobalScope?self:{};var Prism=function(){var e=/\blang(?:uage)?-(?!\*)(\w+)\b/i,t=self.Prism={util:{encode:function(e){return e instanceof n?new n(e.type,t.util.encode(e.content),e.alias):"Array"===t.util.type(e)?e.map(t.util.encode):e.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/\u00a0/g," ")},type:function(e){return Object.prototype.toString.call(e).match(/\[object (\w+)\]/)[1]},clone:function(e){var n=t.util.type(e);switch(n){case"Object":var a={};for(var r in e)e.hasOwnProperty(r)&&(a[r]=t.util.clone(e[r]));return a;case"Array":return e.map(function(e){return t.util.clone(e)})}return e}},languages:{extend:function(e,n){var a=t.util.clone(t.languages[e]);for(var r in n)a[r]=n[r];return a},insertBefore:function(e,n,a,r){r=r||t.languages;var i=r[e];if(2==arguments.length){a=arguments[1];for(var l in a)a.hasOwnProperty(l)&&(i[l]=a[l]);return i}var o={};for(var s in i)if(i.hasOwnProperty(s)){if(s==n)for(var l in a)a.hasOwnProperty(l)&&(o[l]=a[l]);o[s]=i[s]}return t.languages.DFS(t.languages,function(t,n){n===r[e]&&t!=e&&(this[t]=o)}),r[e]=o},DFS:function(e,n,a){for(var r in e)e.hasOwnProperty(r)&&(n.call(e,r,e[r],a||r),"Object"===t.util.type(e[r])?t.languages.DFS(e[r],n):"Array"===t.util.type(e[r])&&t.languages.DFS(e[r],n,r))}},highlightAll:function(e,n){for(var a,r=document.querySelectorAll('code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code'),i=0;a=r[i++];)t.highlightElement(a,e===!0,n)},highlightElement:function(a,r,i){for(var l,o,s=a;s&&!e.test(s.className);)s=s.parentNode;if(s&&(l=(s.className.match(e)||[,""])[1],o=t.languages[l]),o){a.className=a.className.replace(e,"").replace(/\s+/g," ")+" language-"+l,s=a.parentNode,/pre/i.test(s.nodeName)&&(s.className=s.className.replace(e,"").replace(/\s+/g," ")+" language-"+l);var g=a.textContent;if(g){g=g.replace(/^(?:\r?\n|\r)/,"");var u={element:a,language:l,grammar:o,code:g};if(t.hooks.run("before-highlight",u),r&&self.Worker){var c=new Worker(t.filename);c.onmessage=function(e){u.highlightedCode=n.stringify(JSON.parse(e.data),l),t.hooks.run("before-insert",u),u.element.innerHTML=u.highlightedCode,i&&i.call(u.element),t.hooks.run("after-highlight",u)},c.postMessage(JSON.stringify({language:u.language,code:u.code}))}else u.highlightedCode=t.highlight(u.code,u.grammar,u.language),t.hooks.run("before-insert",u),u.element.innerHTML=u.highlightedCode,i&&i.call(a),t.hooks.run("after-highlight",u)}}},highlight:function(e,a,r){var i=t.tokenize(e,a);return n.stringify(t.util.encode(i),r)},tokenize:function(e,n){var a=t.Token,r=[e],i=n.rest;if(i){for(var l in i)n[l]=i[l];delete n.rest}e:for(var l in n)if(n.hasOwnProperty(l)&&n[l]){var o=n[l];o="Array"===t.util.type(o)?o:[o];for(var s=0;s<o.length;++s){var g=o[s],u=g.inside,c=!!g.lookbehind,f=0,h=g.alias;g=g.pattern||g;for(var p=0;p<r.length;p++){var d=r[p];if(r.length>e.length)break e;if(!(d instanceof a)){g.lastIndex=0;var m=g.exec(d);if(m){c&&(f=m[1].length);var y=m.index-1+f,m=m[0].slice(f),v=m.length,k=y+v,b=d.slice(0,y+1),w=d.slice(k+1),O=[p,1];b&&O.push(b);var N=new a(l,u?t.tokenize(m,u):m,h);O.push(N),w&&O.push(w),Array.prototype.splice.apply(r,O)}}}}}return r},hooks:{all:{},add:function(e,n){var a=t.hooks.all;a[e]=a[e]||[],a[e].push(n)},run:function(e,n){var a=t.hooks.all[e];if(a&&a.length)for(var r,i=0;r=a[i++];)r(n)}}},n=t.Token=function(e,t,n){this.type=e,this.content=t,this.alias=n};if(n.stringify=function(e,a,r){if("string"==typeof e)return e;if("[object Array]"==Object.prototype.toString.call(e))return e.map(function(t){return n.stringify(t,a,e)}).join("");var i={type:e.type,content:n.stringify(e.content,a,r),tag:"span",classes:["token",e.type],attributes:{},language:a,parent:r};if("comment"==i.type&&(i.attributes.spellcheck="true"),e.alias){var l="Array"===t.util.type(e.alias)?e.alias:[e.alias];Array.prototype.push.apply(i.classes,l)}t.hooks.run("wrap",i);var o="";for(var s in i.attributes)o+=s+'="'+(i.attributes[s]||"")+'"';return"<"+i.tag+' class="'+i.classes.join(" ")+'" '+o+">"+i.content+"</"+i.tag+">"},!self.document)return self.addEventListener?(self.addEventListener("message",function(e){var n=JSON.parse(e.data),a=n.language,r=n.code;self.postMessage(JSON.stringify(t.util.encode(t.tokenize(r,t.languages[a])))),self.close()},!1),self.Prism):self.Prism;var a=document.getElementsByTagName("script");return a=a[a.length-1],a&&(t.filename=a.src,document.addEventListener&&!a.hasAttribute("data-manual")&&document.addEventListener("DOMContentLoaded",t.highlightAll)),self.Prism}();"undefined"!=typeof module&&module.exports&&(module.exports=Prism);;
	Prism.languages.markup={comment:/<!--[\w\W]*?-->/g,prolog:/<\?.+?\?>/,doctype:/<!DOCTYPE.+?>/,cdata:/<!\[CDATA\[[\w\W]*?]]>/i,tag:{pattern:/<\/?[\w:-]+\s*(?:\s+[\w:-]+(?:=(?:("|')(\\?[\w\W])*?\1|[^\s'">=]+))?\s*)*\/?>/gi,inside:{tag:{pattern:/^<\/?[\w:-]+/i,inside:{punctuation:/^<\/?/,namespace:/^[\w-]+?:/}},"attr-value":{pattern:/=(?:('|")[\w\W]*?(\1)|[^\s>]+)/gi,inside:{punctuation:/=|>|"/g}},punctuation:/\/?>/g,"attr-name":{pattern:/[\w:-]+/g,inside:{namespace:/^[\w-]+?:/}}}},entity:/&#?[\da-z]{1,8};/gi},Prism.hooks.add("wrap",function(t){"entity"===t.type&&(t.attributes.title=t.content.replace(/&amp;/,"&"))});;

})();