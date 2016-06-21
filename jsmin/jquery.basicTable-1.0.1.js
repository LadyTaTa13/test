function createThead(e){var t=$("<thead></thead>").addClass("ui-thead");return t}function createTbody(e){var t=$("<tbody></tbody>").addClass("ui-tbody");return t}function createTr(e){var t=$("<tr></tr>").addClass("ui-tr");return t}function globalColSpan(){return global_colspan}function setGlobalColSpan(e){global_colspan=e}function createTh(e){if(globalColSpan()==0){var t=undefined2Space(e.txt);var n=$("<th><span>"+t+"</span></th>");if(e.colspan>1){n.attr("colspan",e.colspan);setGlobalColSpan(parseFloat(e.colspan)-1)}return n}else{setGlobalColSpan(parseFloat(globalColSpan())-1);return""}}function createTd(e){if(!(e.obj===undefined)){var t=$("<span></span>").append(e.obj);var n=$("<td field='"+e.field+"'></td>").append(t)}else if(e.img===undefined||e.img==""){txt=undefined2Space(e.txt);var n=$("<td field='"+e.field+"'>"+txt+"</td>")}else{var n=$("<td field='"+e.field+"'><span><img src='"+e.img+"' /></span></td>")}return n}function undefined2Space(e){if(e===undefined||e==""){e=""}else{e="<span>"+e+"</span>"}return e}function createBt(e){var t=$("<div></div>");var n=t.clone();if(!(e.img===undefined)){var r=t.clone();r.append("<img src='"+e.img+"'/>").appendTo(t)}if(!(e.title===undefined)){var i=$("<span class='ui-bt-text'></span>");i.append(e.title);n.append(i).appendTo(t)}t.addClass("ui-bt-body").bind("click",e.call);return t}function wrapBt(e){return $("<div class='ui-bt-container'></div>").append(e)}function rowList(e){var t=$("<li></li>");return t.append(e)}(function(e){jQuery.fn.basicTable=function(t){return this.each(function(){var n=e("<table></table>").addClass("ui-tbl");if(!(t.tblId===undefined)){n.attr("id",t.tblId)}var r=createThead(t);var i=createTr(t);var s=createTr(t);var o;var u=createTbody();var a=[];var f=0;setGlobalColSpan(0);e.each(t.tblConfig,function(e,t){var n={};n.txt=t.titleHead;if(t.colspan_h===undefined){n.colspan=1}else{n.colspan=t.colspan_h}i.append(createTh(n));a[f]={};a[f].field=e;a[f].align=t.align;f++});r.append(i);var l=0;e.each(t.data,function(e){_row=this;trBodyX=s.clone();trBodyX.attr("rowId",l);for(k=0;k<a.length;k++){var n={txt:_row[a[k].field],field:a[k].field};if(t.tblConfig[a[k].field].call!=""&&!(t.tblConfig[a[k].field].call===undefined)){delete n.txt;var r={title:_row[a[k].field],call:t.tblConfig[a[k].field].call};if(t.tblConfig[a[k].field].type=="image"){r.img=r.title;delete r.title}n.obj=createBt(r);var i=createTd(n)}else{if(t.tblConfig[a[k].field].type=="image"){n.img=n.txt}else if(t.tblConfig[a[k].field].type=="autoNum"){n.txt=e+1}var i=createTd(n)}i.css("text-align",a[k].align);trBodyX.append(i)}u.append(trBodyX);l++});e(this).append(n.append(r).append(u))})};jQuery.fn.getParent=function(t){jQuery.fn.getParent.defaults={n:1,selector:null};var n=jQuery.extend({},jQuery.fn.getParent.defaults,t);var r=null;_this=e(this);for(i=0;i<n.n;i++){if(i+1==n.n&&!(n.selector===undefined)){r=n.selector}_this=_this.parent(r)}return _this};jQuery.fn.getTblRow=function(t){return e(this).getParent({n:3}).attr("rowid")}})(jQuery);var global_colspan=0;

/*

Copyright (c) 2009 Dimas Begunoff, http://www.farinspace.com

Licensed under the MIT license
http://en.wikipedia.org/wiki/MIT_License

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/

;(function($){

	var scrollbarWidth = 0;

	// http://jdsharp.us/jQuery/minute/calculate-scrollbar-width.php
	function getScrollbarWidth() 
	{
		if (scrollbarWidth) return scrollbarWidth;
		var div = $('<div style="width:50px;height:50px;overflow:hidden;position:absolute;top:-200px;left:-200px;"><div style="height:100px;"></div></div>'); 
		$('body').append(div); 
		var w1 = $('div', div).innerWidth(); 
		div.css('overflow-y', 'auto'); 
		var w2 = $('div', div).innerWidth(); 
		$(div).remove(); 
		scrollbarWidth = (w1 - w2);
		return scrollbarWidth;
	}
	
	$.fn.tableScroll = function(options)
	{
		if (options == 'undo')
		{
			var container = $(this).parent().parent();
			if (container.hasClass('tablescroll_wrapper')) 
			{
				container.find('.tablescroll_head thead').prependTo(this);
				container.find('.tablescroll_foot tfoot').appendTo(this);
				container.before(this);
				container.empty();
			}
			return;
		}

		var settings = $.extend({},$.fn.tableScroll.defaults,options);
		
		// Bail out if there's no vertical overflow
		//if ($(this).height() <= settings.height)
		//{
		//  return this;
		//}

		settings.scrollbarWidth = getScrollbarWidth();

		this.each(function()
		{
			var flush = settings.flush;
			
			var tb = $(this).addClass('tablescroll_body');

            // find or create the wrapper div (allows tableScroll to be re-applied)
            var wrapper;
            if (tb.parent().hasClass('tablescroll_wrapper')) {
                wrapper = tb.parent();
            }
            else {
                wrapper = $('<div class="tablescroll_wrapper"></div>').insertBefore(tb).append(tb);
            }

			// check for a predefined container
			if (!wrapper.parent('div').hasClass(settings.containerClass))
			{
				$('<div></div>').addClass(settings.containerClass).insertBefore(wrapper).append(wrapper);
			}

			var width = settings.width ? settings.width : tb.outerWidth();

			wrapper.css
			({
				'width': width+'px',
				'height': settings.height+'px',
				'overflow': 'auto'
			});

			tb.css('width',width+'px');

			// with border difference
			var wrapper_width = wrapper.outerWidth();
			var diff = wrapper_width-width;

			// assume table will scroll
			wrapper.css({width:((width-diff)+settings.scrollbarWidth)+'px'});
			tb.css('width',(width-diff)+'px');

			if (tb.outerHeight() <= settings.height)
			{
				wrapper.css({height:'auto',width:(width-diff)+'px'});
				flush = false;
			}

			// using wrap does not put wrapper in the DOM right 
			// away making it unavailable for use during runtime
			// tb.wrap(wrapper);

			// possible speed enhancements
			var has_thead = $('thead',tb).length ? true : false ;
			var has_tfoot = $('tfoot',tb).length ? true : false ;
			var thead_tr_first = $('thead tr:first',tb);
			var tbody_tr_first = $('tbody tr:first',tb);
			var tfoot_tr_first = $('tfoot tr:first',tb);

			// remember width of last cell
			var w = 0;

			$('th, td',thead_tr_first).each(function(i)
			{
				w = $(this).width();

				$('th:eq('+i+'), td:eq('+i+')',thead_tr_first).css('width',w+'px');
				$('th:eq('+i+'), td:eq('+i+')',tbody_tr_first).css('width',w+'px');
				if (has_tfoot) $('th:eq('+i+'), td:eq('+i+')',tfoot_tr_first).css('width',w+'px');
			});

			if (has_thead) 
			{
				var tbh = $('<table class="tablescroll_head" cellspacing="0"></table>').insertBefore(wrapper).prepend($('thead',tb));
			}

			if (has_tfoot) 
			{
				var tbf = $('<table class="tablescroll_foot" cellspacing="0"></table>').insertAfter(wrapper).prepend($('tfoot',tb));
			}

			if (tbh != undefined)
			{
				tbh.css('width',width+'px');
				
				if (flush)
				{
					$('tr:first th:last, tr:first td:last',tbh).css('width',(w+settings.scrollbarWidth)+'px');
					tbh.css('width',wrapper.outerWidth() + 'px');
				}
			}

			if (tbf != undefined)
			{
				tbf.css('width',width+'px');

				if (flush)
				{
					$('tr:first th:last, tr:first td:last',tbf).css('width',(w+settings.scrollbarWidth)+'px');
					tbf.css('width',wrapper.outerWidth() + 'px');
				}
			}
		});

		return this;
	};

	// public
	$.fn.tableScroll.defaults =
	{
		flush: true, // makes the last thead and tbody column flush with the scrollbar
		width: null, // width of the table (head, body and foot), null defaults to the tables natural width
		height: 100, // height of the scrollable area
		containerClass: 'tablescroll' // the plugin wraps the table in a div with this css class
	};

})(jQuery);